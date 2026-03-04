<?php
/*
 * Creado el 17/10/2025 09:36
 * Autor: gus
 * Archivo: index.php
 */
$page = isset($_GET['page']) ? $_GET['page'] : 'inicio';
// Detectar si la URL es /shop y redirigir a index.php?page=shop

switch ($page) {
    case '404':
        include 'pages/404.php';
        break;
    case 'login':
        // include 'pages/login.php';
        include 'pages/login.html';
        break;
    case "inicio":
        include 'pages/inicio.html';
        break;
    case "logout":
        include 'pages/logout.php';
        break;
    case "dash":
        include 'pages/dash.html';
        break;
    case "pago_exitoso":
        include 'pages/pago_exitoso.html';
        break;
}
