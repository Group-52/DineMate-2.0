document.addEventListener('DOMContentLoaded', function () {

    drawBarChart();
    drawLineChart();
    drawPieChart();
    drawStackedLineChart();

<<<<<<< HEAD
=======
    startDateInput.addEventListener('change', () => {
        //check if the start date is greater than the end date
        if (startDateInput.value > endDateInput.value) {
            displayError("Start date cannot be greater than end date",startDateInput.getBoundingClientRect().top,startDateInput.getBoundingClientRect().left);
            return;
        }
        // console.log("start date changed");
        updateData();
        dateRangeSelect.value = 'Custom';
    });
    endDateInput.addEventListener('change', () => {
        //check if the start date is greater than the end date
        if (startDateInput.value > endDateInput.value) {
            displayError("End date cannot be less than start date",endDateInput.getBoundingClientRect().top,endDateInput.getBoundingClientRect().left);
            return;
        }
        // console.log("end date changed");
        updateData();
        dateRangeSelect.value = 'Custom';
    });
    dateRangeSelect.addEventListener('change', () => {
        const selectedOption = dateRangeSelect.value;
        const now = new Date();
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

    /* 
    Takes data from the form and sends it to the websocket 
           */

<<<<<<< HEAD
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
                "table_id":4,
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

=======
    });


    function updateData() {
        let startDate = startDateInput.value;
        let endDate = endDateInput.value;
        get_menustats(startDate, endDate);
        get_orders(startDate, endDate);
        get_stats(startDate, endDate);
    }

    async function get_orders(startd, endd) {
        try {
            const fetchUrl = `${ROOT}/api/Stats/get_orders`;
            const response = await fetch(fetchUrl, {
                method: "POST",
                body: JSON.stringify({start: startd, end: endd})
            });
            const data = await response.json();
            // console.log(data);
            drawLineChart(Object.values(data['data']));
        } catch (error) {
            console.error(error);
        }
    }

    async function get_stats(startd, endd) {
        try {
            const fetchUrl = `${ROOT}/api/Stats/get_stats`;
            const response = await fetch(fetchUrl, {
                method: "POST",
                body: JSON.stringify({start: startd, end: endd})
            });
            const data = await response.json();
            const avg = data['data']['avg'];
            const sum = data['data']['sum'];
            const labels = [];
            const vals = [];
            for (let key in avg) {
                if (key.startsWith("f_")) {
                    labels.push(key);
                    vals.push(avg[key]);
                }
            }
            drawBarChart(vals);
            // console.log(data);
            // Update the order type cards
            document.querySelectorAll('#bulk h2')[1].innerHTML = sum['bulkTotal'];
            document.querySelectorAll('#takeaway h2')[1].innerHTML = sum['takeawayTotal'];
            document.querySelectorAll('#dinein h2')[1].innerHTML = sum['dineinTotal'];
            //update the wait time cards
            document.querySelector('.takeaway-time').innerHTML = Math.ceil(avg['takeawayWaitTime'] / avg['takeawayTotal']) + " minutes";
            let time_val = Math.ceil(avg['dineinWaitTime'] / avg['dineinTotal'])
            //check if the value is a number
            if (isNaN(time_val)) {
                time_val = 0;
            }
            document.querySelector('.dinein-time').innerHTML = time_val + " minutes";
            //update the revenue
            document.querySelectorAll('#revenue h2')[1].innerHTML = sum['revenue'] + " LKR";
            //update the cost
            document.querySelectorAll('#cost h2')[1].innerHTML = sum['foodCost'] + " LKR";

        } catch (error) {
            console.error(error);
        }
    }

    async function get_menustats(startd, endd) {
        try {
            const fetchUrl = `${ROOT}/api/Stats/get_menu_stats`;
            const response = await fetch(fetchUrl, {
                method: "POST",
                body: JSON.stringify({start: startd, end: endd})
            });
            const data = await response.json();
            // console.log(data);
            const md = data['data'];
            const labels = [];
            const vals = [];
            // iterate over objects in md
            for (let key in md) {
                labels.push(md[key]['menu_name']);
                vals.push(md[key]['mcount']);
            }
            drawPieChart(labels, vals);
        } catch (error) {
            console.error(error);
        }
    }

    function drawBarChart(mydata) {
        let ctx = document.getElementById("myBarChart").getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["12am", "", "", "3am", "", "", "6am", "", "", "9am", "", "", "12pm", "", "", "3pm", "", "", "6pm", "", "", "9pm", "", ""],
                datasets: [{
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: mydata,
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

    function drawLineChart(mydata) {
        let ctx = document.getElementById("myLineChart").getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                datasets: [{
                    label: '# of Customers',
                    data: mydata,
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
                        // display: false
                    }]
                }
            }
        });
    }

    function drawPieChart(mylabels, mydata) {
        let ctx = document.getElementById("myPieChart").getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: mylabels,
                datasets: [{
                    borderColor: "rgba(0,0,0,0.1)",
                    backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745", "#17a2b8", "#6c757d"],
                    label: '',
                    data: mydata,
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
            },
        });
    }

>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440

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