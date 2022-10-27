<?php
function navbar()
{
    $admin_link = "";
    $auth = <<<"EOT"
    <a class='signup' href='signup.php'>Sign up</a>
    <a class='login' href='login.php'>Log in</a>
    EOT;

    if (isset($_SESSION["username"])) {
        $auth = <<<"EOT"
        <p class="username">Hi, $_SESSION[username]!</p>
        <a class="logout" href="logout.php">Log out</a>
        EOT;
    }

    if (isset($_SESSION["admin"])) {
        $admin_link = <<<"EOT"
        <a href='add-song.php'>Add Song</a>
        <a href='add-album.php'>Add Album</a>
        <a href='users.php'>Users List</a>
        EOT;
    }

    $html = <<<"EOT"
    <nav class="navbar">
        <a href='/'>
            <img src='img/Spotify_Logo_RGB_White.png' alt='logo' width='128'>
        </a>
        <a href="/">Home</a>
        <a href="albums.php">Albums</a>
        $admin_link
        <form class='form-searchbar' action='search.php' method='get'>
            <input class='search-bar' type='text' name='search' placeholder='What do you want to search?'>
        </form>
        $auth
    </nav>
    EOT;

    echo $html;
}
