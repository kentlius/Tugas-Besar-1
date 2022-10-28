# Tugas Besar 1 IF3110

Binotify merupakan aplikasi musik berbasis web yang dibangun menggunakan PHP 8.0 dan Postgres 15.0, lalu dikontainerisasi menggunakan Docker.

## Daftar Requirement

- Docker

## Cara Instalasi

```sh
git clone https://gitlab.informatika.org/if3110-2022-k02-01-06/tugas-besar-1.git
```

```sh
cd tugas-besar-1
```

## Cara Menjalankan Server

```sh
docker compose up -d
```

atau

```sh
bash scripts/run-compose.sh
```

Lalu buka http://localhost:8080/

## Screenshot

![404](screenshots/404.jpg "404")

## Pembagian Tugas

<u>Server-side</u>  
Login : 13520069  
Register : 13520069  
Home : 13520167  
Daftar Album : 13520006, 13520167  
Search : 13520167  
Detail Lagu : 13520006  
Detail Album : 13520006, 13520167  
Tambah Album : 13520069  
Tambah Lagu : 13520069  
List User : 13520069  

<u>Client-side</u>  
Login : 13520069  
Register : 13520069  
Home : 13520006, 13520167  
Daftar Album : 13520006  
Search : 13520167  
Detail Lagu : 13520006  
Detail Album : 13520006  
Tambah Album : 13520069  
Tambah Lagu : 13520069  
List User : 13520069
