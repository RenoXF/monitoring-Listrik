<?php

define('__IN_SCRIPT__', true);

require './includes/connection.php';
require './helpers/get.php';


$idKompor = get('ID_Kompor');

if ($idKompor === null) {
    exit(0);
}

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
    echo '0';
    exit(0);
}

echo $result['Stat'];
