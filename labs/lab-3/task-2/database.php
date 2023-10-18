<?php

function create_feedback_table($mysqli)
{
    $sql = "
        CREATE TABLE IF NOT EXISTS user_feedback (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            quality INT NOT NULL CHECK(quality BETWEEN 1 AND 5),
            like_service_speed BOOLEAN NOT NULL DEFAULT 0,
            like_interface BOOLEAN NOT NULL DEFAULT 0,
            like_assortment BOOLEAN NOT NULL DEFAULT 0,
            comment VARCHAR(255)
        )
    ";
    if (!$mysqli->query($sql)) {
        die("Error creating table: " . $mysqli->error);
    }
}

function create_feedback(
    $mysqli,
    $first_name,
    $last_name,
    $email,
    $quality,
    $like_service_speed = false,
    $like_interface = false,
    $like_assortment = false,
    $comment = null
) {
    $stmt = $mysqli->prepare(
        "
        INSERT INTO user_feedback (
            first_name,
            last_name,
            email,
            quality,
            like_service_speed,
            like_interface,
            like_assortment,
            comment
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    "
    );
    $stmt->bind_param(
        "sssdddds",
        $first_name,
        $last_name,
        $email,
        $quality,
        $like_service_speed,
        $like_interface,
        $like_assortment,
        $comment
    );
    if (!$stmt->execute()) {
        die("Error insert user: " . $mysqli->error);
    }
    return $stmt->insert_id;
}

$mysqli = new mysqli("localhost", "username", "password", "store");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

create_feedback_table($mysqli);
