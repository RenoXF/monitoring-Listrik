<?php
header("Content-Type: application/json");

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');
$type = get('type');

if ($idKompor === null) {
    header("HTTP/1.1 500 Server Internal Error");
    echo json_encode([
        'status' => false,
        'code' => 500,
        'message' => 'Parameter ID_Kompor is required'
    ]);
    exit(1);
}

if (in_array($type, [
    'Voltage',
    'Current',
    'Power',
    'Energy',
    'Frequency',
    'PF'
]) === false) {
    header("HTTP/1.1 500 Server Internal Error");
    echo json_encode([
        'status' => false,
        'code' => 500,
        'message' => 'Parameter Type is invalid'
    ]);
    exit(1);
}

try {
    $startDate = date('Y-m-d H', strtotime('1 Hours ago')) . ':00:00';
    $endDate = date('Y-m-d H:i:s');
    $stmt = $mysqli->prepare("SELECT
        `$type`,
        `Date`
        FROM
            `meter`
        WHERE
            `ID_Kompor` = ? AND
            `Date` BETWEEN ? AND ?");

    $stmt->execute([$idKompor, $startDate, $endDate]);

    $results = $stmt->get_result()?->fetch_all(MYSQLI_ASSOC) ?? [];

    $values = [];
    $keys = [];
    foreach ($results as $result) {
        array_push(
            $values,
            $result[$type]
        );
        array_push(
            $keys,
            date('H:i', strtotime($result['Date']))
        );
    };

    header("HTTP/1.1 200 OK");
    echo json_encode([
        'status' => true,
        'keys' => $keys,
        'values' => $values
    ]);
    exit(1);
} catch (\Throwable $th) {
    header("HTTP/1.1 500 Server Internal Error");
    echo json_encode([
        'status' => false,
        'code' => $th->getCode(),
        'message' => $th->getMessage()
    ]);
    exit(1);
}
