<?php
define('__IN_SCRIPT__', true);

require_once './includes/header.php'; ?>
<main class="container">
    <div class="row">
        <div class="col-md-6">
            <canvas id="voltageChart" height="250px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="currentChart" height="250px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="powerChart" height="250px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="powerFactorChart" height="250px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="eneryChart" height="250px"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="frequencyChart" height="250px"></canvas>
        </div>
    </div>
</main>
<script>
(() => {
    const ctx = document.getElementById('voltageChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('currentChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('powerChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('powerFactorChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('powerFactorChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('eneryChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();

(() => {
    const ctx = document.getElementById('frequencyChart')
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('[\u0022Maret 2022\u0022,\u0022April 2022\u0022,\u0022Mei 2022\u0022,\u0022Juni 2022\u0022,\u0022Juli 2022\u0022,\u0022Agustus 2022\u0022,\u0022September 2022\u0022,\u0022Oktober 2022\u0022,\u0022November 2022\u0022,\u0022Desember 2022\u0022,\u0022Januari 2023\u0022,\u0022Februari 2023\u0022]'),
            datasets: [{
                label: 'Jumlah Pelanggan',
                data: JSON.parse('[1,2,3,4,5,6,7,8,9,9,9,9]'),
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    min: 0,
                    max: 10,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
})();
</script>
<?php require_once './includes/footer.php';
