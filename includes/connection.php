<?php

defined('__IN_SCRIPT__') || exit(1);

require_once 'config/database.php';

try {
    $mysqli = mysqli_connect(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );
} catch (\Throwable $th) {
    echo 'Connection failed: [' . $th->getCode() . '] ' . $th->getMessage();
    exit(1);
}
