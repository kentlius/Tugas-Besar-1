<?php
// SQL statement for creating new tables
$statements = [
	'CREATE TABLE IF NOT EXISTS "user" ( 
        user_id     serial PRIMARY KEY,
        email       varchar(256) NOT NULL,
        password    varchar(256) NOT NULL,
        username    varchar(256) NOT NULL,
        isAdmin     boolean NOT NULL
    );',
    'CREATE TABLE IF NOT EXISTS album (
        album_id        integer PRIMARY KEY,
        judul           varchar(64) NOT NULL,
        penyanyi        varchar(128) NOT NULL,
        total_duration  integer NOT NULL,
        image_path      varchar(256) NOT NULL,
        tanggal_terbit  date NOT NULL,
        genre           varchar(64)
    );',
	'CREATE TABLE IF NOT EXISTS song (
        song_id         integer PRIMARY KEY,
        judul           varchar(64) NOT NULL,
        penyanyi        varchar(128),
        tanggal_terbit  date NOT NULL,
        genre           varchar(64),
        duration        integer NOT NULL,
        audio_path      varchar(256) NOT NULL,
        image_path      varchar(256),
        album_id        integer REFERENCES album(album_id)
    );'];

// connect to the database
require 'connect.php';

// execute SQL statements
foreach ($statements as $statement) {
	$conn->exec($statement);
}
