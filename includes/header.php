<?php

defined('__IN_SCRIPT__') || exit(1);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kompor</title>

    <!-- Bootstrap style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <header class="mb-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom border-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">Monitoring PLN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                    <form class="d-flex">
                        <div class="border-end border-dark border-1 p-2 me-4 pe-4">
                            <?php echo date('l, dS  F o'); ?>
                        </div>
                        <div class="border-end border-dark border-1 p-2 me-4 pe-4">
                            <i class="bi bi-clock me-2 "></i>
                            <span id="time"></span>
                        </div>
                        <div class="">
                            <img src="./assets/img/Logo_PLN.svg" alt="Logo PLN" srcset="" height="40px">
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </header>
