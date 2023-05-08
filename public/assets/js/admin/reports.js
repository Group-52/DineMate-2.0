document.addEventListener('DOMContentLoaded', () => {

    const select = document.querySelector('select');
    const generate = document.querySelector('#generate-button');
    const start = document.querySelector('[name="start-date"]')
    const end = document.querySelector('[name="end-date"]')
    generate.addEventListener('click', () => {
        const table = select.value;
        downloadDataAsCSV(table,start.value,end.value);
    });


    start.addEventListener('change', () => {
        if (start.value > end.value) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "Start date cannot be after end date", false, 3000);
            end.value = start.value;
        }
    });
    end.addEventListener('change', () => {
        if (start.value > end.value) {
            new Toast("fa-solid fa-times", "#dc3545", "Error", "End date cannot be before start date", false, 3000);
            start.value = end.value;
        }
    });


    async function downloadDataAsCSV(table,start,end) {
        try {
            // Make a fetch request to the API to retrieve the data
            let input = `${ROOT}/api/Stats/download?table=${table}&start=${start}&end=${end}`;
            const response = await fetch(input);
            const data = await response.json();

            if (data['error']) {
                new Toast("fa-solid fa-times", "#dc3545", "Error", data['error'], false, 3000);
                return;
            }
            // console.log(data)

            // Convert the data to CSV format
            const csvData = convertDataToCSV(data['data']);

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
