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
    async function graph(type, context) {
        const res = await $.ajax({
            url: 'ajax.php',
            data: {
                ID_Kompor: '<?php echo get('ID_Kompor'); ?>',
                type: type
            },
        });

        new Chart(context, {
            type: 'line',
            data: {
                labels: res.keys,
                datasets: [{
                    label: type,
                    data: res.values,
                    borderWidth: 1,
                    fill: false,
                }]
            },

        })
    }

    $(document).ready(() => {
        const graphs = [
            [
                'Voltage',
                document.getElementById('voltageChart')
            ],
            [
                'Current',
                document.getElementById('currentChart')
            ],
            [
                'Power',
                document.getElementById('powerChart')
            ],
            [
                'PF',
                document.getElementById('powerFactorChart')
            ],
            [
                'Energy',
                document.getElementById('eneryChart')
            ],
            [
                'Frequency',
                document.getElementById('frequencyChart')
            ],
        ];

        graphs.forEach((item) => {
            graph(item[0], item[1]);
        })

    });
</script>
<?php require_once './includes/footer.php';
