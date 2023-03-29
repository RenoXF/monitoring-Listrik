<?php
header("Content-Type: application/json");

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');
$type = get('type');
$rangeDate = get('rangeDate');

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

    // Apabila Range data ada
    if ($rangeDate !== null) {
        $ranges = $rangeDate;
        $month = date('Y-m', strtotime($ranges . '-01 00:00:00'));

        $whereClause = "WHERE ID_Kompor = '$idKompor' AND `Date` BETWEEN '$startDate' AND '$endDate'";
    } else {
        $whereClause = "WHERE ID_Kompor = '$idKompor'";
    }

    try {
        $stmt = $mysqli->prepare("SELECT
                " .  ($rangeDate !== null ? "AVG(`$type`) as `{$type}`" :" `$type`") . ",
                `Date`
            FROM
                `meter`
            WHERE
                `ID_Kompor` = ?
            " . $rangeDate !== null ? "GROUP BY DATE(`Date`)" : "" . "
            ORDER BY `id` DESC");

        $stmt->execute([$idKompor]);

        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    } catch (\Throwable $th) {
        echo $th->getCode() . ' - ' . $th->getMessage();
        exit(1);
    }


    $results = array_reverse($results);

    $values = [];
    $keys = [];
    foreach ($results as $result) {
        array_push(
            $values,
            $result[$type]
        );
        array_push(
            $keys,
            date($rangeDate !== null ? 'd' : 'H:i', strtotime($result['Date']))
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
