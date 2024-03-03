<?php

require 'database.php';

insert_comment($conn, $_POST['author_name'], $_POST['content']);

header("Location: /");

