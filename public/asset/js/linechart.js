document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('myLineChart').getContext('2d');
    const myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            datasets: [{
                label: 'Revenue',
                data: [60, 50, 70, 65, 60, 75, 85, 100, 80, 40],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Dollars in thousand'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Package Revenue'
                }
            },
            elements: {
                line: {
                    tension: 0.4 // Smooth curve
                }
            }
        }
    });
});
