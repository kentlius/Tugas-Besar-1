<?php
    function navbar() {
        echo "<div class='navbar'>
                <div class='navbar-left'>
                    <a href='/'><img src='img/Spotify_Logo_RGB_White.png' alt='logo' width='128'></a>
                </div>
                <div class='navbar-rightend'>
                    <div class='navbar-middle'>
                        <a href='/index.php'>
                            Home
                        </a>
                        <form action='search.php' method='get'>
                            <input class='searchbar' type='text' name='search' placeholder='What do you want to search?'>
                        </form>
                        <a href='/daftaralbum.php'>
                            Albums
                        </a>
                    </div>
                    <div class='navbar-right'>
                        <a href='signup.php'>
                            <button class='signup-btn'>Sign Up</button>
                        </a>
                        <a href='login.php'>
                            <button class='login-btn'>Login</button>
                        </a>
                    </div>
                </div>
            </div>";
    }
