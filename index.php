<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=apidb','root',''));

//Pais
Flight::route('GET /paises', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `pais`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//Departamentos
Flight::route('GET /departamentos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `departamentos`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});


//Municipios
Flight::route('GET /municipios', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `municipios`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//Roles
Flight::route('GET /roles', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `rol`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//Privilegios
Flight::route('GET /privilegios', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `privilegio`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//RolesAcesso
Flight::route('GET /rolesacceso', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `rolacceso`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//Usuarios
Flight::route('GET /usuarios', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `usuarios`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

Flight::route('GET /usuarios/@correo/@contra', function ($correo, $contra) {
    $sentencia = Flight::db()->prepare("SELECT * FROM `usuarios` WHERE correo=? and contra=?");
    $sentencia->bindParam(1, $correo);
    $sentencia->bindParam(2, $contra);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

Flight::route('POST /usuarios', function () {
    $nombre = (Flight::request()->data->nombre);
    $correo = (Flight::request()->data->correo);
    $contra = (Flight::request()->data->contra);
    $creacion = (Flight::request()->data->creacion);
    $id_pais = (Flight::request()->data->id_pais);
    $id_departamentos = (Flight::request()->data->id_departamentos);
    $id_municipios = (Flight::request()->data->id_municipios);
    $id_rol = (Flight::request()->data->id_rol);
    $isLogued = (Flight::request()->data->isLogued);
    
    $sql="INSERT INTO usuarios(nombre, correo, contra, creacion, id_pais, id_departamentos, id_municipios, id_rol, isLogued) VALUES (?,?,?,?,?,?,?,?,?)";

    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $correo);
    $sentencia->bindParam(3, $contra);
    $sentencia->bindParam(4, $creacion);
    $sentencia->bindParam(5, $id_pais);
    $sentencia->bindParam(6, $id_departamentos);
    $sentencia->bindParam(7, $id_municipios);
    $sentencia->bindParam(8, $id_rol);
    $sentencia->bindParam(9, $isLogued);
    $sentencia->execute();

    Flight::jsonp("Usuario agregado");
});

Flight::route('DELETE /usuarios', function () {
    $id = (Flight::request()->data->id);

    $sql="DELETE FROM `usuarios` WHERE id = ?";

    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);

    $sentencia->execute();

    Flight::jsonp("Usuario eliminado de favoritos");
});

Flight::route('PUT /usuarios', function () {
    $nombre = (Flight::request()->data->nombre);
    $correo = (Flight::request()->data->correo);
    $contra = (Flight::request()->data->contra);
    $creacion = (Flight::request()->data->creacion);
    $id_pais = (Flight::request()->data->id_pais);
    $id_departamentos = (Flight::request()->data->id_departamentos);
    $id_municipios = (Flight::request()->data->id_municipios);
    $id_rol = (Flight::request()->data->id_rol);
    $isLogued = (Flight::request()->data->isLogued);
    $id = (Flight::request()->data->id);

    
    $sql="UPDATE `usuarios` SET `nombre`=?,`correo`=?,`contra`=?,`creacion`=?,`id_pais`=?,`id_departamentos`=?,`id_municipios`=?,`id_rol`=?,`isLogued`=? WHERE id = ?";

    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombre);
    $sentencia->bindParam(2, $correo);
    $sentencia->bindParam(3, $contra);
    $sentencia->bindParam(4, $creacion);
    $sentencia->bindParam(5, $id_pais);
    $sentencia->bindParam(6, $id_departamentos);
    $sentencia->bindParam(7, $id_municipios);
    $sentencia->bindParam(8, $id_rol);
    $sentencia->bindParam(9, $isLogued);
    $sentencia->bindParam(10, $id);
    $sentencia->execute();

    Flight::jsonp("Usuario modificado");
});

//Tiendas
Flight::route('GET /tiendas', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `tienda`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

//Favoritos
Flight::route('GET /favoritos/@idUser', function ($idUser) {
    $sentencia = Flight::db()->prepare("SELECT * FROM `favoritos` WHERE id_usuarios = ?");
    $sentencia->bindParam(1, $idUser);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});

Flight::route('POST /favoritos', function () {
    $id_usuarios = (Flight::request()->data->id_usuarios);
    $requestUrl = (Flight::request()->data->requestUrl);
    $idTienda = (Flight::request()->data->idTienda);
    $imageUrl = (Flight::request()->data->imageUrl);
    
    $sql="INSERT INTO `favoritos`(`id_usuarios`, `requestUrl`, `idTienda`, `imageUrl`) VALUES (?,?,?,?)";

    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id_usuarios);
    $sentencia->bindParam(2, $requestUrl);
    $sentencia->bindParam(3, $idTienda);
    $sentencia->bindParam(4, $imageUrl);

    $sentencia->execute();

    Flight::jsonp("Producto agregado a favoritos");
});

Flight::route('DELETE /favoritos', function () {
    $id_usuarios = (Flight::request()->data->id_usuarios);
    $requestUrl = (Flight::request()->data->requestUrl);

    $sql="DELETE FROM `favoritos` WHERE id_usuarios = ? AND requestUrl = ?";

    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id_usuarios);
    $sentencia->bindParam(2, $requestUrl);

    $sentencia->execute();

    Flight::jsonp("Producto eliminado de favoritos");
});

Flight::route('GET /favoritos/@idUser/@page', function ($idUser, $page) {
    $limit = 5;
    $desde = ($page - 1)*$limit;
    $sentencia = Flight::db()->prepare("SELECT * FROM `favoritos` WHERE id_usuarios = ? LIMIT $desde, $limit");
    $sentencia->bindParam(1, $idUser);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
});


Flight::start();
