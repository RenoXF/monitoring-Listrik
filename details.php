<?php
define('__IN_SCRIPT__', true);

require_once './includes/header.php';
require './helpers/get.php';

$idKompor = get('ID_Kompor');

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

?>
<main class="container">
    <div class="mb-5">
        <div class="d-flex justify-content-evenly align-items-center">
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
                        <td><?php echo '-' ?></td>
                    </tr>
                </table>
                <a href="filter.php?ID_Kompor=<?php echo $result['ID_Kompor'] ?>" class="btn btn-info text-white" role="button">Filter by Date</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="mx-2 form-label my-0 d-inline-block">Status:</span>
                <label class="switch">
                    <input type="checkbox" <?php echo ((string) $relayStatus) === '1' ? 'checked' : '' ?> id="relaySwitch">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
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
                type: type
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
                        break;

                    case 'Current':
                        backgroundColor = '#3DAF63'
                        borderColor = '#3DAF63'
                        color = '#3DAF63'
                        break;

                    case 'Power':
                        backgroundColor = '#FE9008'
                        borderColor = '#FE9008'
                        color = '#FE9008'
                        break;

                    case 'PF':
                        backgroundColor = '#8A5487'
                        borderColor = '#8A5487'
                        color = '#8A5487'
                        break;

                    case 'Energy':
                        backgroundColor = '#3549D1'
                        borderColor = '#3549D1'
                        color = '#3549D1'
                        break;

                    case 'Frequency':
                        backgroundColor = '#25AD92'
                        borderColor = '#25AD92'
                        color = '#25AD92'
                        break;
                }

                chart.data = {
                    labels: res.keys,
                    datasets: [{
                        label: type,
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

    var now = new Date();
    var delay = 30000 - (now.getSeconds() * 1000) - now.getMilliseconds();
    setTimeout(function() {
        getAllData();
        setInterval(function() {
            getAllData()
        }, 30000);
    }, delay);
</script>
<?php require_once './includes/footer.php';
