<?php

require 'vendor/autoload.php';
require 'php/database.php';

error_reporting(E_ALL ^ E_DEPRECATED);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

$comments = select_comments($conn);
$template = $twig->load('comments.html');

echo $template->render([
    'comments' => $comments
]);
