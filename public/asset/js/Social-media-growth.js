document.addEventListener("DOMContentLoaded", function () {
    const facebookCtx = document.getElementById('facebookChart').getContext('2d');
    const instagramCtx = document.getElementById('instagramChart').getContext('2d');
    const tiktokCtx = document.getElementById('tiktokChart').getContext('2d');

    const createChart = (ctx, bgColor, borderColor) => {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['01/09', '05/09', '10/09', '15/09', '20/09', '25/09', '30/09'],
                datasets: [{
                    label: 'Sales',
                    data: [90, 70, 85, 60, 70, 95, 80], // Adjust this data to match the graph in the image
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.parsed.y}`;
                            }
                        }
                    }
                }
            }
        });
    };

    createChart(facebookCtx, 'rgba(66, 133, 244, 0.2)', 'rgba(66, 133, 244, 1)');
    createChart(instagramCtx, 'rgba(244, 67, 54, 0.2)', 'rgba(244, 67, 54, 1)');
    createChart(tiktokCtx, 'rgba(76, 175, 80, 0.2)', 'rgba(76, 175, 80, 1)');
});
