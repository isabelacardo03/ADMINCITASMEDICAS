document.addEventListener("DOMContentLoaded", function() {
    // Gráfico de Pastel
    const ctx1 = document.getElementById('chartEstados').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: labelsEstados,
            datasets: [{
                data: datosEstados,
                backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384', '#36a2eb']
            }]
        },
        options: { responsive: true }
    });

    // Gráfico de Barras
    const ctx2 = document.getElementById('chartMedicos').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labelsMedicos,
            datasets: [{
                label: 'Número de Citas',
                data: datosMedicos,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
});