<?php
define('__IN_SCRIPT__', true);

require_once './helpers/base_url.php';
require_once './includes/connection.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');
$rangeDate = get('rangeDate');

if ($idKompor === null) {
    echo 'ID_Kompor harus disertakan !';
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
    $relayStatus = $result['Stat'] ?? null;

    if (empty($result) || $relayStatus === null) {
        $relayStatus = '1';
        $relayStmt = $mysqli->prepare("INSERT INTO `statusrelay` (`ID_Kompor`, `Stat`) VALUES (?, ?)");
        $relayStmt->execute([$idKompor, $relayStatus]);
    }
} catch (\Throwable $th) {
    $th->getMessage();
    exit(0);
}


$stmt = $mysqli->prepare("SELECT
        *
    FROM
        `meter`
    WHERE
        `ID_Kompor` = ?
    ORDER BY `id` DESC LIMIT 1");

$stmt->execute([$idKompor]);

$result = $stmt->get_result()->fetch_assoc() ?? [];

require_once './includes/header.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<main class="container">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="align-middle">
            <table class="table table-borderless">
                    <tr>
                        <td>ID Kompor</td>
                        <td>:</td>
                        <td><?php echo $result['ID_Kompor'] ?></td>
                    </tr>
                    <tr>
                        <td>Stan</td>
                        <td>:</td>
                        <td><?php echo $result['Energy'] ?> KWh</td>
                    </tr>
                </table>
                <a href="filter.php?ID_Kompor=<?php echo $result['ID_Kompor'] ?>" class="btn btn-info text-white" role="button">Device Database</a>
            </div>
            <div class="col-md-3">
                <form action="" method="get" class="d-block mb-4" target="_blank">
                <span class="mx-2 form-label my-0 d-inline-block">Status:</span>
                <label class="switch">
                    <input type="checkbox" <?php echo ((string) $relayStatus) === '1' ? 'checked' : '' ?> id="relaySwitch">
                    <span class="slider round"></span>
                </label>
                </form>
                <form action="" method="get">
                    <div class="mb-3">
                        <input type="text" name="rangeDate" id="rangeDate" class="form-control" placeholder="Filter by Date" value="<?php echo $rangeDate ?>">
                    </div>
                </form>
                <?php if ($rangeDate ) : ?>
                    <button class="btn btn-danger text-white" id="clearFilter">Clear Filter</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($rangeDate): ?>
    <div class="mb-5">
        <h2>Menampilkan data dari tanggal <?= $rangeDate?></h2>
    </div>

    <?php endif;?>
    <div class="row mb-5">
        <div class="col-md-6">
            <canvas id="voltageChart" height="150px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="currentChart" height="150px"></canvas>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-6">
            <canvas id="powerChart" height="150px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="powerFactorChart" height="150px"></canvas>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-6">
            <canvas id="eneryChart" height="150px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="frequencyChart" height="150px"></canvas>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
    $(document).ready(() => {
        $('#rangeDate').flatpickr({
            locale: 'id',
            altInput: true,
            // dateFormat: "Y-m-d",
            // altFormat: "j F Y",
            plugins: [
                new monthSelectPlugin({
                    shorthand: true, //defaults to false
                    dateFormat: "Y-m", //defaults to "F Y"
                    altFormat: "F Y", //defaults to "F Y"
                })
            ],
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
<script>
    const options = {};

    const Voltage = new Chart(document.getElementById('voltageChart'), {
        type: 'line',
        data: {},
        options: options
    })
    const Current = new Chart(document.getElementById('currentChart'), {
        type: 'line',
        data: {},
        options: options
    })
    const Power = new Chart(document.getElementById('powerChart'), {
        type: 'line',
        data: {},
        options: options
    })
    const PowerFactor = new Chart(document.getElementById('powerFactorChart'), {
        type: 'line',
        data: {},
        options: options
    })
    const Energy = new Chart(document.getElementById('eneryChart'), {
        type: 'line',
        data: {},
        options: options
    })
    const Frequency = new Chart(document.getElementById('frequencyChart'), {
        type: 'line',
        data: {},
        options: options
    })

    function getData(chart, type) {
        $.ajax({
            url: 'ajax.php',
            data: {
                ID_Kompor: '<?php echo $idKompor; ?>',
                type: type,
                rangeDate: "<?= $rangeDate;?>"
            },
            dataType: "json",
            success: function(res, textStatus, jqXHR) {
                let backgroundColor = '#36a2eb'
                let borderColor = '#36a2eb'
                let color = '#36a2eb';

                switch (type) {
                    case 'Voltage':
                        backgroundColor = '#5145A7'
                        borderColor = '#5145A7'
                        color = '#5145A7'
                        label = type + ' (V)'
                        break;

                    case 'Current':
                        backgroundColor = '#3DAF63'
                        borderColor = '#3DAF63'
                        color = '#3DAF63'
                        label = type + ' (A)'
                        break;

                    case 'Power':
                        backgroundColor = '#FE9008'
                        borderColor = '#FE9008'
                        color = '#FE9008'
                        label = type + ' (W)'
                        break;

                    case 'PF':
                        backgroundColor = '#8A5487'
                        borderColor = '#8A5487'
                        color = '#8A5487'
                        label = type
                        break;

                    case 'Energy':
                        backgroundColor = '#3549D1'
                        borderColor = '#3549D1'
                        color = '#3549D1'
                        label = type + ' (KWh)'
                        break;

                    case 'Frequency':
                        backgroundColor = '#25AD92'
                        borderColor = '#25AD92'
                        color = '#25AD92'
                        label = type + ' (Hz)'
                        break;
                }

                chart.data = {
                    labels: res.keys,
                    datasets: [{
                        label: label,
                        data: res.values,
                        borderWidth: 1,
                        fill: false,
                        backgroundColor: backgroundColor,
                        color: color,
                        borderColor: borderColor
                    }]
                };
                chart.update('none');
            },
            timeout: 60000 // sets timeout to 60 seconds
        });
    }

    function getAllData() {
        console.log(1)
        getData(Voltage, 'Voltage')
        getData(Current, 'Current')
        getData(Power, 'Power')
        getData(PowerFactor, 'PF')
        getData(Energy, 'Energy')
        getData(Frequency, 'Frequency')
    }

    $(document).ready(() => {
        getAllData()
        $('#relaySwitch').on('change', (e) => {
            const status = $('#relaySwitch').is(':checked') ? '1' : '0'

            $.ajax({
                url: 'relay.php',
                method: 'post',
                data: {
                    status: status,
                    ID_Kompor: '<?php echo $idKompor; ?>',
                }
            })
        })
    })

    // var now = new Date();
    // var delay = 30000 - (now.getSeconds() * 1000) - now.getMilliseconds();
    // setTimeout(function() {
    //     getAllData();
    //     // setInterval(function() {
    //     //     getAllData()
    //     // }, 30000);
    // }, delay);
</script>
<?php require_once './includes/footer.php';
