<div style="width: 45%; margin-right: 15px;">
    <h4>Vendas</h4>
    <canvas id="myChart1"></canvas>
</div>
<div style="width: 45%; margin-left: 15px;">
    <h4>Compras</h4>
    <canvas id="myChart2"></canvas>
</div>
<?php
$data2 = json_encode($this->data[1]);
$data1 = json_encode($this->data[0]);
$dataLabels = json_encode($this->data2);
?>

<script>
    const ctx1 = document.getElementById('myChart1');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= $dataLabels ?>,
            datasets: [{
                label: 'Fatura',
                data: <?= $data1 ?>,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const ctx2 = document.getElementById('myChart2');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?= $dataLabels ?>,
            datasets: [{
                label: 'Outro dado',
                data: <?= $data2 ?>,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>