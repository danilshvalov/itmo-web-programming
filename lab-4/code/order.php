<?php

require 'database.php';

$email = $_POST["email"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$patronymic = $_POST["patronymic"];
$phone = $_POST["phone"];
$course_type = $_POST["course_type"];
$address = $_POST["address"];
$comment = $_POST["comment"];

$user_id = create_user(
    $mysqli,
    $email,
    "",
    $first_name,
    $last_name,
    $patronymic,
    $phone
);

echo $user_id;
create_order($mysqli, $user_id, $course_type, $address, $comment);

header("Location: order-success.html");
