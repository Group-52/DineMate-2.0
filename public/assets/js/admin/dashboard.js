document.addEventListener('DOMContentLoaded', function () {

    drawBarChart();
    drawLineChart();
    drawPieChart();
    drawStackedLineChart();


    /* 
    Takes data from the form and sends it to the websocket 
           */

    var form = document.getElementById("f2");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var socket = new WebSocket("ws://localhost:8080");
        socket.onopen = function () {
            var n = {
                "event_type": "new_order",
                "order_id": form.elements["order_id"].value,
                "status": form.elements["status"].value,
                "time_placed": form.elements["time_placed"].value,
                "request": form.elements["request"].value,
                "reg_customer_id": form.elements["reg_customer_id"].value,
                "type": form.elements["type"].value
            };
            socket.send(JSON.stringify(n));
        };
    });


});

function drawBarChart() {
    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: '',
                data: [12, 19, 3, 5, 2, 3, 15],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function drawLineChart() {
    var ctx = document.getElementById("myLineChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: '# of Customers',
                data: [12, 19, 3, 5, 2, 4, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
function drawPieChart() {
    var ctx = document.getElementById("myPieChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
                'Chillie Parata',
                'Burger',
                'Salad'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        }
    });
}

function drawStackedLineChart() {

    var ctx = document.getElementById("myStackedLineChart").getContext("2d");

    // Random data
    var RevenueData = []
    var ProfitData = []
    var CostData = []
    for (var i = 0; i < 12; i++) {
        RevenueData.push(Math.floor(Math.random() * 100) + 1);
        CostData.push(Math.floor(Math.random() * 100) + 1);
        ProfitData.push(RevenueData[i] - CostData[i]);
    }


    // Define the data
    var data = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
            {
                label: "Revenue",
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                borderColor: "rgba(255, 99, 132, 1)",
                data: RevenueData,
                stack: "Stack 1"
            },
            {
                label: "Profit",
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgba(54, 162, 235, 1)",
                data: ProfitData,
                stack: "Stack 1"
            },
            {
                label: "Cost",
                backgroundColor: "rgba(255, 206, 86, 0.2)",
                borderColor: "rgba(255, 206, 86, 1)",
                data: CostData,
                stack: "Stack 1"
            }
        ]
    };

    // Define chart options
    var options = {
        scales: {
            yAxes: [{
                stacked: true
            }]
        }
    };

    // Create the chart
    var myStackedLineChart = new Chart(ctx, {
        type: "line",
        data: data,
        options: options
    });
}