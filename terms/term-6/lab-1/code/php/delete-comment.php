<?php

require 'database.php';

delete_comment($conn, $_GET["id"]);

header("Location: /");
