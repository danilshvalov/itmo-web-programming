<?php

require 'database.php';

insert_comment(
    $conn,
    $_POST['author_name'],
    $_POST['content'],
    $_POST['note_id']
);

header("Location: " . $_SERVER['HTTP_REFERER']);
