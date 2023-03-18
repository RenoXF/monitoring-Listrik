<?php
define('__IN_SCRIPT__', true);

require_once './includes/header.php';
require './helpers/get.php';

if (get('ID_Kompor') === null) {
    echo 'ID_Kompor harus disertakan !';
    exit(0);
}
?>
<main class="container">
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
            }
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
