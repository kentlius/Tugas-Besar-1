<?php
    function navbar() {
        echo "<div class='navbar'>
                <div class='navbar-left'>
                    <a href='/'><img src='img/Spotify_Logo_RGB_White.png' alt='logo' width='128'></a>
                </div>
                <div class='navbar-rightend'>
                    <div class='navbar-middle'>
                        <a href='/'>
                            Home
                        </a>
                        <a href='/'>
                            Search
                        </a>
                        <a href='/'>
                            Lib
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
