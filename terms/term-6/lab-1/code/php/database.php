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

function create_note_table($conn)
{
    return pg_query(
        $conn,
        '
        CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

        CREATE TABLE IF NOT EXISTS note (
            id TEXT PRIMARY KEY DEFAULT uuid_generate_v4(),
            title TEXT NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
        );
        '
    );
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
            created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
            note_id TEXT NOT NULL,
            FOREIGN KEY (note_id) REFERENCES note (id)
        );
        '
    );
}

function prepare_queries($conn)
{
    pg_prepare(
        $conn,
        'select_notes_query',
        '
        SELECT id, title, content, created_at
        FROM note
        ORDER BY created_at DESC
        '
    );
    pg_prepare(
        $conn,
        'select_note_query',
        '
        SELECT id, title, content, created_at
        FROM note
        WHERE id = $1
        ORDER BY created_at DESC
        '
    );
    pg_prepare(
        $conn,
        'insert_note_query',
        '
        INSERT INTO note (title, content) 
        VALUES ($1, $2)
        RETURNING *
        '
    );
    pg_prepare(
        $conn,
        'select_comments_query',
        '
        SELECT id, author_name, content, created_at
        FROM comment
        WHERE note_id = $1
        ORDER BY created_at DESC
        '
    );
    pg_prepare(
        $conn,
        'insert_comment_query',
        '
        INSERT INTO comment (author_name, content, note_id) 
        VALUES ($1, $2, $3)
        RETURNING *
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

function select_notes($conn)
{
    $query = pg_execute($conn, 'select_notes_query', array());
    $result = array();
    while ($row = pg_fetch_row($query)) {
        $result[] = [
            'id' => $row[0],
            'title' => $row[1],
            'content' => $row[2],
            'created_at' => date('H:i d.m.y', strtotime($row[3]))
        ];
    }
    return $result;
}

function select_note($conn, $note_id)
{
    $query = pg_execute($conn, 'select_note_query', array($note_id));
    $row = pg_fetch_row($query);
    return [
        'id' => $row[0],
        'title' => $row[1],
        'content' => $row[2],
        'created_at' => date('H:i d.m.y', strtotime($row[3]))
    ];
}

function insert_note($conn, $title, $content)
{
    $query = pg_execute(
        $conn,
        'insert_note_query',
        array($title, $content)
    );
    $row = pg_fetch_row($query);
    return [
        'id' => $row[0],
        'title' => $row[1],
        'content' => $row[2],
        'created_at' => date('H:i d.m.y', strtotime($row[3]))
    ];
}

function select_comments($conn, $note_id)
{
    $query = pg_execute($conn, 'select_comments_query', array($note_id));
    $result = array();
    while ($row = pg_fetch_row($query)) {
        $result[] = [
            'id' => $row[0],
            'author_name' => $row[1],
            'content' => $row[2],
            'created_at' => date('H:i d.m.y', strtotime($row[3]))
        ];
    }
    return $result;
}

function insert_comment($conn, $author_name, $content, $note_id)
{
    $query = pg_execute(
        $conn,
        'insert_comment_query',
        array($author_name, $content, $note_id)
    );
    $row = pg_fetch_row($query);
    return [
        'id' => $row[0],
        'author_name' => $row[1],
        'content' => $row[2],
        'created_at' => date('H:i d.m.y', strtotime($row[3]))
    ];
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
create_note_table($conn);
create_comment_table($conn);
prepare_queries($conn);
