<?php

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor', 0);
$date = date('Y-m-d H:i:s');
$voltage = get('Voltage', 0);
$current = get('Current', 0);
$power = get('Power', 0);
$energy = get('Voltage', 0);
$frequency = get('Frequency', 0);
$pf = get('PF', 0);

header("Content-Type: application/json");
try {
    $stmt = $mysqli->prepare("INSERT INTO `meter`(`ID_Kompor`, `Date`, `Voltage`, `Current`, `Power`, `Energy`, `Frequency`, `PF`) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $idKompor,
        $date,
        $voltage,
        $current,
        $power,
        $energy,
        $frequency,
        $pf
    ]);
    header("HTTP/1.1 200 OK");
    echo json_encode([
        'status' => true
    ]);
    exit(0);
} catch (\Throwable $th) {
    header("HTTP/1.1 500 Server Internal Error");
    echo json_encode([
        'status' => false,
        'code' => $th->getCode(),
        'message' => $th->getMessage()
    ]);
    exit(0);
}
