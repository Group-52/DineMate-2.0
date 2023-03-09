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
                "type": form.elements["type"].value,
                "table_id": 4,
                "order_dishes":
                    [
                        {
                            "dish_name": "Burger",
                            "quantity": 2,
                        },
                        {
                            "dish_name": "Chillie Parata",
                            "quantity": 3
                        },
                        {
                            "dish_name": "Salad",
                            "quantity": 1
                        }
                    ]


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
            labels: ["6am", "", "", "9am", "", "", "12pm", "", "", "3pm", "", "", "6pm", "", "", "9pm", "", "", "12am", "", "", "3am", "", "", "6am"],
            datasets: [{
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: [12, 19, 3, 5, 2, 4, 3, 12, 19, 3, 5, 2, 4, 3, 12, 19, 3, 5, 2, 4, 3, 12, 19, 3, 5, 2, 4, 3],
                borderWidth: 1
            }]
        },
        options: {
            layout: {
                padding: {
                    top: 10,
                    bottom: -20,
                    left: 10,
                    right: 10
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        display: false
                    },
                    gridLines: {
                        drawBorder: false,
                        display: false
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
            legend: {
                display: false
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: -15,
                    left: 10,
                    right: 10
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    display: false
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
            labels: ["Indian","European","Savoury", "Dessert", "Beverage"],
            datasets: [{
                borderColor: "rgba(0,0,0,0.1)",
                backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745", "#17a2b8"],
                label: 'My First Dataset',
                data: [200, 50, 100, 40, 120],
                hoverOffset: 4
            }]
        },
        options: {
            layout: {
                padding: {
                    top: 10,
                }
            },
            legend: {
                'position': 'right'
            }
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