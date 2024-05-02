<?php

require 'vendor/autoload.php';
require 'php/database.php';

error_reporting(E_ALL ^ E_DEPRECATED);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

$notes = select_notes($conn);
$template = $twig->load('notes.html');

echo $template->render([
    'notes' => $notes
]);
