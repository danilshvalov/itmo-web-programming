<?php

require 'database.php';

function get_optional_param($key)
{
    return isset($_POST[$key]) ? $_POST[$key] : null;
}

print_r($_POST);

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$quality = intval($_POST["quality"]);
$like_service_speed = get_optional_param("like-service-speed") == "on";
$like_interface = get_optional_param("like-interface") == "on";
$like_assortment = get_optional_param("like-assortment") == "on";
$comment = get_optional_param("comment");

create_feedback(
    $mysqli,
    $first_name,
    $last_name,
    $email,
    $quality,
    $like_service_speed,
    $like_interface,
    $like_assortment,
    $comment
);

header("Location: feedback-success.html");
