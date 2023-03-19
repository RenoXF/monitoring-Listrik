<?php

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');

if (isset($_POST['status']) && isset($_POST['ID_Kompor'])) {
    header("Content-Type: application/json");

    try {
        $stmt = $mysqli->prepare("REPLACE INTO `statusrelay` (`ID_Kompor`, `Stat`) VALUES (?, ?)");
        $stmt->execute([
            $_POST['ID_Kompor'],
            $_POST['status'],
        ]);

    } catch (\Throwable $th) {
        echo json_encode([
            'message' => $th->getMessage()
        ]);
        exit(1);
    }

    echo json_encode([
        'Stat' => $_POST['status'],
    ]);
    exit(0);
}

if ($idKompor === null) {
    exit(0);
}


try {
    $stmt = $mysqli->prepare("SELECT
        *
    FROM
        `statusrelay`
    WHERE
        `ID_Kompor` = ?
    ORDER BY `id` DESC LIMIT 1");

    $stmt->execute([$idKompor]);

    $result = $stmt->get_result()->fetch_assoc() ?? [];

    if (empty($result)) {
        $relayStmt = $mysqli->prepare("INSERT INTO `statusrelay` (`ID_Kompor`, `Stat`) VALUES (?, ?)");
        $relayStmt->execute([$idKompor, 1]);
        echo '1';
        exit(0);
    }

    echo $result['Stat'];
} catch (\Throwable $th) {
    echo '1';
    exit(0);
}
