<?php
$page = $_GET['page'] ?? 'home';

$view = "views/{$page}/{$page}.php";
$title = ucfirst($page);

if (!file_exists($view)) {
    $view = "views/404.php";
    $title = "Página não encontrada";
}

include 'includes/layout.php';

