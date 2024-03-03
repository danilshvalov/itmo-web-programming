<?php

function create_connection()
{
    $host = 'localhost';
    $port = 5432;
    $user = 'postgres';
    $pass = 'password';
    $db = 'my_site';

    $conn = pg_connect(
        "host=$host port=$port dbname=$db user=$user password=$pass"
    );

    if ($conn === false) {
        echo 'Connection failed';
        exit;
    }

    return $conn;
}

function create_comment_table($conn)
{
    return pg_query(
        $conn,
        '
        CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

        CREATE TABLE IF NOT EXISTS comment (
            id TEXT PRIMARY KEY DEFAULT uuid_generate_v4(),
            author_name TEXT NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
        );
        '
    );
}

function prepare_queries($conn)
{
    pg_prepare(
        $conn,
        'select_comments_query',
        '
        SELECT id, author_name, content, created_at
        FROM comment
        ORDER BY created_at DESC
        '
    );
    pg_prepare(
        $conn,
        'insert_comment_query',
        '
        INSERT INTO comment (author_name, content) 
        VALUES ($1, $2)
        '
    );
    pg_prepare(
        $conn,
        'delete_comment_query',
        '
        DELETE FROM comment
        WHERE id = $1
        '
    );
}

function select_comments($conn)
{
    $query = pg_execute($conn, 'select_comments_query', array());
    $result = array();
    while ($row = pg_fetch_row($query)) {
        $result[] = [
            'id' => $row[0],
            'author_name' => $row[1],
            'content' => $row[2],
            'created_at' => date('H:m d.m.y', strtotime($row[3]))
        ];
    }
    return $result;
}

function insert_comment($conn, $author_name, $content)
{
    return pg_execute(
        $conn,
        'insert_comment_query',
        array($author_name, $content)
    );
}

function delete_comment($conn, $comment_id)
{
    return pg_execute(
        $conn,
        'delete_comment_query',
        array($comment_id)
    );
}

$conn = create_connection();
create_comment_table($conn);
prepare_queries($conn);
