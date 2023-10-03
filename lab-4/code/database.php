<?php

function create_user_table($mysqli)
{
    $sql = "
        CREATE TABLE IF NOT EXISTS user_account (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            patronymic VARCHAR(255),
            phone VARCHAR(255)
        )
    ";
    if (!$mysqli->query($sql)) {
        die("Error creating table: " . $mysqli->error);
    }
}

function create_order_table($mysqli)
{
    $sql = "
        CREATE TABLE IF NOT EXISTS order_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            course_type VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            comment VARCHAR(255),
            FOREIGN KEY (user_id) REFERENCES user_account (id)
        )
    ";
    if (!$mysqli->query($sql)) {
        die("Error creating table: " . $mysqli->error);
    }
}

function create_user(
    $mysqli,
    $email,
    $password,
    $first_name = null,
    $last_name = null,
    $patronymic = null,
    $phone = null
) {
    $stmt = $mysqli->prepare(
        "
        INSERT INTO user_account (
            email,
            password,
            first_name,
            last_name,
            patronymic,
            phone
        ) VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            first_name = VALUES(first_name),
            last_name = VALUES(last_name),
            patronymic = VALUES(patronymic),
            phone = VALUES(phone),
            id = LAST_INSERT_ID(id)
    "
    );
    $stmt->bind_param(
        "ssssss",
        $email,
        $password,
        $first_name,
        $last_name,
        $patronymic,
        $phone
    );
    if (!$stmt->execute()) {
        die("Error insert user: " . $mysqli->error);
    }
    return $stmt->insert_id;
}

function create_order(
    $mysqli,
    $user_id,
    $course_type,
    $address,
    $comment
) {
    $stmt = $mysqli->prepare(
        "
        INSERT INTO order_Info (
            user_id,
            course_type,
            address,
            comment
        ) VALUES (?, ?, ?, ?)
    "
    );
    $stmt->bind_param(
        "isss",
        $user_id,
        $course_type,
        $address,
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

create_user_table($mysqli);
create_order_table($mysqli);
