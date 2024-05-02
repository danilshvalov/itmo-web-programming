<?php

require 'database.php';
require '../vendor/autoload.php';

error_reporting(E_ALL ^ E_DEPRECATED);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

$note_id = $_GET['id'];
$note = select_note($conn, $note_id);
$comments = select_comments($conn, $note_id);

$template = $twig->load('note.html');

echo $template->render([
    'note' => $note,
    'comments' => $comments
]);
