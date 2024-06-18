<?php

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';

$idListrik = get('ID_Listrik');

if (isset($_POST['status']) && isset($_POST['ID_Listrik'])) {
    header("Content-Type: application/json");

    try {
        $stmt = $mysqli->prepare("REPLACE INTO `statusrelay` (`ID_Listrik`, `Stat`) VALUES (?, ?)");
        $stmt->execute([
            $_POST['ID_Listrik'],
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

if ($idListrik === null) {
    exit(0);
}


try {
    $stmt = $mysqli->prepare("SELECT
        *
    FROM
        `statusrelay`
    WHERE
        `ID_Listrik` = ?
    ORDER BY `id` DESC LIMIT 1");

    $stmt->execute([$idListrik]);

    $result = $stmt->get_result()->fetch_assoc() ?? [];

    if (empty($result)) {
        $relayStmt = $mysqli->prepare("INSERT INTO `statusrelay` (`ID_Listrik`, `Stat`) VALUES (?, ?)");
        $relayStmt->execute([$idListrik, 1]);
        echo '1';
        exit(0);
    }

    echo $result['Stat'];
} catch (\Throwable $th) {
    echo '1';
    exit(0);
}
