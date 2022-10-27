CREATE TABLE IF NOT EXISTS users ( 
    user_id     serial PRIMARY KEY,
    email       varchar(256) NOT NULL UNIQUE,
    password    varchar(256) NOT NULL,
    username    varchar(256) NOT NULL UNIQUE,
    isAdmin     boolean NOT NULL
);

CREATE TABLE IF NOT EXISTS album (
    album_id        serial PRIMARY KEY,
    judul           varchar(64) NOT NULL,
    penyanyi        varchar(128) NOT NULL,
    total_duration  integer NOT NULL,
    image_path      varchar(256) NOT NULL,
    tanggal_terbit  date NOT NULL,
    genre           varchar(64)
);

CREATE TABLE IF NOT EXISTS song (
    song_id         serial PRIMARY KEY,
    judul           varchar(64) NOT NULL,
    penyanyi        varchar(128),
    tanggal_terbit  date NOT NULL,
    genre           varchar(64),
    duration        integer NOT NULL,
    audio_path      varchar(256) NOT NULL,
    image_path      varchar(256),
    album_id        integer REFERENCES album(album_id)
);
