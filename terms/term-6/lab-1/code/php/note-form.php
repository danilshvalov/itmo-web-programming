<?php

require 'database.php';

$note = insert_note($conn, $_POST['title'], $_POST['content']);
$note_id = $note['id'];
header("Location: /php/note.php?id=$note_id");

