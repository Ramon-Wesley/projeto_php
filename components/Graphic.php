<div style="max-width:40rem"> <canvas id="myChart"></canvas>
</div>

<?=
"
<script>
var datas=" . json_encode($this->data2) . "
const ctx = document.getElementById('myChart');
new Chart(ctx, {
type: 'bar',
data: {
labels: datas,
datasets: [{
label: 'fatura',
data: [1000,2000,3000,4000,5000,6000,7000,8000,9000,1000,2000,],
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
</script>";
?>