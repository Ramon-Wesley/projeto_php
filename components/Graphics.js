
const ctx = document.getElementById('myChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels:labels,
        datasets: [{
            label: 'fatura',
            data: [1000, 1900, 3000, 5000, 2000, 3000, 1000, 5000, 7000, 3000, 9000, 2000],
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