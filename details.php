<?php
define('__IN_SCRIPT__', true);

require_once './includes/header.php';
require './helpers/get.php';

if (get('ID_Kompor') === null) {
    echo 'ID_Kompor harus disertakan !';
    exit(0);
}

$stmt = $mysqli->prepare("SELECT
        *
    FROM
        `meter`
    WHERE
        `ID_Kompor` = ?
    ORDER BY `id` DESC LIMIT 1");

$stmt->execute([get('ID_Kompor')]);

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
                <a href="" class="btn btn-info text-white" role="button">Filter by Date</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="mx-2 form-label my-0 d-inline-block">Status:</span>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
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
    const Voltage = new Chart(document.getElementById('voltageChart'), {
        type: 'line',
        data: {},
    })
    const Current = new Chart(document.getElementById('currentChart'), {
        type: 'line',
        data: {},
    })
    const Power = new Chart(document.getElementById('powerChart'), {
        type: 'line',
        data: {},
    })
    const PowerFactor = new Chart(document.getElementById('powerFactorChart'), {
        type: 'line',
        data: {},
    })
    const Energy = new Chart(document.getElementById('eneryChart'), {
        type: 'line',
        data: {},
    })
    const Frequency = new Chart(document.getElementById('frequencyChart'), {
        type: 'line',
        data: {},
    })

    function getData(chart, type) {
        $.ajax({
            url: 'ajax.php',
            data: {
                ID_Kompor: '<?php echo get('ID_Kompor'); ?>',
                type: type
            },
            dataType: "json",
            success: function(res, textStatus, jqXHR) {
                chart.data = {
                    labels: res.keys,
                    datasets: [{
                        label: type,
                        data: res.values,
                        borderWidth: 1,
                        fill: false,
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
