document.addEventListener('DOMContentLoaded', function () {
    const dateRangeSelect = document.querySelector('select');
    const startDateInput = document.querySelector('input[name="start-date"]');
    const endDateInput = document.querySelector('input[name="end-date"]');

    // Call by default past week to today in yyyy-mm-dd format
    let today = new Date().toISOString().split('T')[0];
    let lastWeek = new Date(new Date().getTime() - (7 * 24 * 60 * 60 * 1000)).toISOString().split('T')[0];
    get_menustats(lastWeek, today);
    get_orders(lastWeek, today);
    get_stats(lastWeek, today);

    startDateInput.addEventListener('change', () => {
        console.log("start date changed");
        updateData();
        dateRangeSelect.value = 'Custom';
    });
    endDateInput.addEventListener('change', () => {
        console.log("end date changed");
        updateData();
        dateRangeSelect.value = 'Custom';
    });
    dateRangeSelect.addEventListener('change', () => {
        const selectedOption = dateRangeSelect.value;
        const now = new Date();

        switch (selectedOption) {
            case 'Past Week':
                startDateInput.value = new Date(now.getTime() - (7 * 24 * 60 * 60 * 1000)).toISOString().split('T')[0];
                endDateInput.value = now.toISOString().split('T')[0];
                break;
            case 'Past Month':
                startDateInput.value = new Date(now.getFullYear(), now.getMonth() - 1, 1).toISOString().split('T')[0];
                endDateInput.value = now.toISOString().split('T')[0];
                break;
            case 'Past Year':
                startDateInput.value = new Date(now.getFullYear() - 1, now.getMonth(), now.getDate()).toISOString().split('T')[0];
                endDateInput.value = now.toISOString().split('T')[0];
                break;
        }
        updateData();

    });

    let form = document.getElementById("f2");
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

    let rbutton = document.querySelectorAll('.reports-button')
    let params = {
        '0':'customers',
        '1':'menu_statistics',
        '2':'stats',
        '3':'orders',
        '4':'order_dishes',
        '5':'purchases',
        '6':'feedback',
        '7':'dishes',
    }
    rbutton.forEach((button, index) => {
       button.addEventListener('click', () => {
          downloadDataAsCSV(params[index]);
       });
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
            console.log(data);
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
            if (isNaN(time_val) ) {
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

    async function downloadDataAsCSV(table) {
        try {
            // Make a fetch request to the API to retrieve the data
            const response = await fetch(`${ROOT}/api/Stats/download?table=${table}`);

            const data = await response.json();

            // Convert the data to CSV format
            const csvData = convertDataToCSV(data['data']);
            // console.log(csvData);

            // Create a Blob object from the CSV data
            const blob = new Blob([csvData], {type: 'text/csv'});

            // Create a temporary URL for the Blob object
            const url = window.URL.createObjectURL(blob);

            // Create a temporary <a> element to trigger the download
            const a = document.createElement('a');
            a.href = url;
            a.download = 'data.csv';
            document.body.appendChild(a);

            // Click the <a> element to trigger the download
            a.click();

            // Remove the temporary <a> element and URL
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

        } catch (error) {
            console.error(`Error: ${error.message}`);
        }
    }

    function convertDataToCSV(data) {
        const csvData = [];
        const headers = Object.keys(data[0]);
        csvData.push(headers.join(','));
        data.forEach(row => {
            const values = headers.map(header => {
                const escaped = ('' + row[header]).replace(/"/g, '\\"');
                return `"${escaped}"`;
            });
            csvData.push(values.join(','));
        });
        return csvData.join('\n');
    }

});



