<?php

require '../vendor/autoload.php';

error_reporting(E_ALL ^ E_DEPRECATED);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

$template = $twig->load('create-note.html');

echo $template->render();
