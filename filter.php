<?php

define('__IN_SCRIPT__', true);

require_once './helpers/base_url.php';
require_once './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');
$rangeDate = get('rangeDate');
$page = get('page', 1);
$per_page = 50;
$downloadCSV = (bool) get('downloadCSV', false);

if ($idKompor === null) {
    echo 'ID_Kompor harus disertakan !';
    exit(0);
}

// Apabila Range data ada
if ($rangeDate) {
    $ranges = explode(' - ', $rangeDate);
    $startDate = $ranges[0] . ' 00:00:00';
    $endDate = ($ranges[1] ?? $ranges[0]) . ' 23:59:59';

    $whereClause = "WHERE ID_Kompor = '$idKompor' AND `Date` BETWEEN '$startDate' AND '$endDate'";
} else {
    $whereClause = "WHERE ID_Kompor = '$idKompor'";
}

// Hitung jumlah total data
$sql = "SELECT COUNT(*) as `total` FROM `meter` $whereClause";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_meters = $row['total'];

if ($downloadCSV) {
    $per_page = $total_meters;
}

// Hitung jumlah halaman
$total_pages = ceil($total_meters / $per_page);

// Cek halaman yang diminta valid atau tidak
if ($page < 1 || $page > $total_pages) {
    $page = 1;
}

// Hitung offset
$offset = ($page - 1) * $per_page;

try {
    // Ambil data pengguna dari database
    $sql = "SELECT * FROM `meter` $whereClause ORDER BY `id` " . ($downloadCSV ? "ASC" : "DESC") . " LIMIT $per_page OFFSET $offset";
    $result = $mysqli->query($sql);

    $meters = $result->fetch_all(MYSQLI_ASSOC);
    $current_page = $page;
} catch (\Throwable $th) {
    echo '[' . $th->getCode() . ']' . $th->getMessage();
    exit(1);
}

if ($downloadCSV) {
    // menentukan nama file
    $filename = $rangeDate ? 'Laporan meter tanggal ' . $rangeDate . '.csv' : 'Laporan Meter Lengkap.csv';

    // header file CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $filename);

    // membuka file CSV
    $file = fopen('php://output', 'w');

    // menulis header kolom
    fputcsv($file, array('ID', 'Voltage', 'Current', 'Power', 'Energy', 'Frequency', 'PF', 'Timestamp'));

    // menulis data
    foreach ($meters as $row) {
        fputcsv($file, [
            $row['ID'],
            $row['Voltage'],
            $row['Current'],
            $row['Power'],
            $row['Energy'],
            $row['Frequency'],
            $row['PF'],
            $row['Date'],
        ]);
    }

    // menutup file CSV
    fclose($file);
    exit;
}

require_once './includes/header.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
<main class="container">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="align-middle">
                <table class="table table-borderless">
                    <tr>
                        <td>ID Kompor</td>
                        <td>:</td>
                        <td><?php echo $idKompor; ?></td>
                    </tr>
                </table>
                <?php if ($rangeDate || $page > 1) : ?>
                    <button class="btn btn-danger text-white" id="clearFilter">Clear Filter</button>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <form action="" method="get" class="d-block mb-4" target="_blank">
                    <input type="hidden" name="ID_Kompor" value="<?= $idKompor; ?>">
                    <input type="hidden" name="rangeDate" value="<?= $rangeDate;?>">
                    <input type="hidden" name="downloadCSV" value="1">
                    <button type="submit" class="btn btn-info text-white">Download CSV</button>
                </form>
                <form action="" method="get">
                    <div class="mb-3">
                        <input type="string" name="rangeDate" id="rangeDate" class="form-control" placeholder="Filter by Date" value="<?php echo $rangeDate ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-stripped align-middle">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center"><strong>#</strong></th>
                            <th>Voltage</th>
                            <th>Current</th>
                            <th>Power</th>
                            <th>Energy</th>
                            <th>Frequency</th>
                            <th>PF</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meters as $i => $meter) : ?>
                            <tr>
                                <td class="text-center"><strong><?= $i + 1 ?></strong></td>
                                <td>
                                    <?= $meter['Voltage']; ?>
                                </td>
                                <td><?= $meter['Current']; ?></td>
                                <td><?= $meter['Power']; ?></td>
                                <td><?= $meter['Energy']; ?></td>
                                <td><?= $meter['Frequency']; ?></td>
                                <td><?= $meter['PF']; ?></td>
                                <td class="text-end">
                                    <?= $meter['Date']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($total_pages > 1) : ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item<?= ($current_page == 1) ? ' disabled' : '' ?>">
                            <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=<?= $current_page - 1 ?>">Previous</a>
                        </li>
                        <?php
                        if ($total_pages <= 7) {
                            for ($i = 1; $i <= $total_pages; $i++) :
                        ?>
                                <li class="page-item<?= ($i == $current_page) ? ' active' : '' ?>">
                                    <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php } else { ?>
                            <?php if ($current_page > 4) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=1">1</a>
                                </li>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <?php
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($start_page + 4, $total_pages);
                            $start_page = max(1, $end_page - 4);
                            for ($i = $start_page; $i <= $end_page; $i++) :
                            ?>
                                <li class="page-item<?= ($i == $current_page) ? ' active' : '' ?>">
                                    <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($current_page < ($total_pages - 3)) : ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                <li class="page-item">
                                    <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=<?= $total_pages ?>"><?= $total_pages ?></a>
                                </li>
                            <?php endif; ?>
                        <?php } ?>
                        <li class="page-item<?= ($current_page == $total_pages) ? ' disabled' : '' ?>">
                            <a class="page-link" href="?ID_Kompor=<?= $idKompor ?>&rangeDate=<?= $rangeDate ?>&page=<?= $current_page + 1 ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    $(document).ready(() => {
        $('#rangeDate').flatpickr({
            locale: 'id',
            mode: 'range',
            altInput: true,
            dateFormat: "Y-m-d",
            altFormat: "j F Y",
            onClose: (selectedDates, dateStr, instance) => {
                const urlParams = new URLSearchParams(window.location.search)
                urlParams.set('rangeDate', dateStr);
                urlParams.set('page', 1);
                const url = new URL(window.location.origin + window.location.pathname + '?' + urlParams)
                window.location.assign(url.toString());
            }
        });

        $('#clearFilter').click(() => {
            const urlParams = new URLSearchParams(window.location.search)
            urlParams.delete('rangeDate');
            urlParams.delete('page')
            const url = new URL(window.location.origin + window.location.pathname + '?' + urlParams)
            window.location.assign(url.toString());
        })
    })
</script>
<?php
require_once './includes/footer.php'
?>
