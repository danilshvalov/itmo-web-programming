<?php

require 'database.php';

$email = $_POST["email"];
$password = $_POST["password"];

create_user($mysqli, $email, $password);

header("Location: login-success.html");
