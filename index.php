<?php

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1ab94d0eba.js" crossorigin="anonymous"></script>
    <title>Login Monitoring Listrik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <h2>Login</h2>
        <form action="login_check.php" method="post">
            <div class="input-field">
                <input class="input" type="text" name="username" placeholder="user@example.com" autocomplete="username">
                <div class="underline"></div>
            </div>
            <div class="input-field">
                <input class="input" type="password" name="password" placeholder="Password" autocomplete="current-password">
                <div class="underline"></div>
            </div>

            <button type="submit">
                Login
              </button>
        </form>
    </main>
</body>
</html>