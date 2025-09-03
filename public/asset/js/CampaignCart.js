document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('campaignRevenueChart').getContext('2d');

    const data = {
        labels: ['2004/05', '2005/06', '2006/07', '2007/08', '2008/09'],
        datasets: [
            {
                label: 'Facebook',
                data: [150, 200, 100, 120, 170],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Insta Followers',
                data: [800, 950, 900, 850, 900],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Tiktok Stories',
                data: [500, 600, 700, 750, 720],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Twitter',
                data: [350, 300, 400, 420, 390],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            },
            {
                label: 'RwSnapchat...',
                data: [400, 450, 350, 300, 380],
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                borderColor: 'rgba(255, 205, 86, 1)',
                borderWidth: 1
            },
            {
                label: 'Youtube Video Views',
                data: [1000, 1200, 1100, 1000, 1250],
                backgroundColor: 'rgba(201, 203, 207, 0.2)',
                borderColor: 'rgba(201, 203, 207, 1)',
                borderWidth: 1
            }
        ]
    };

    const options = {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cups'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            }
        },
        // plugins: {
        //     title: {
        //         display: true,
        //         text: 'Different Campaign Revenue like FB, Instagram, Twitter'
        //     }
        // }
    };

    const campaignRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
});
