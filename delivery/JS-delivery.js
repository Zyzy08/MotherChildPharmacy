function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[1, 'desc']], // Sort by the first column (OrderID) in descending order
            "columnDefs": [
                {
                    "targets": 0, // DeliID
                    "width": "14.6%"
                },
                {
                    "targets": 1, // OrderID
                    "width": "14.6%"
                },
                {
                    "targets": 2, // Supplier
                    "width": "15.6%"
                },
                {
                    "targets": 3, // Date
                    "width": "16.6%"
                },
                {
                    "targets": 4, // Totalitems
                    "width": "14%"
                },
                {
                    "targets": 5, // Status
                    "width": "13%"
                },
                {
                    "targets": 6, // Actions
                    "width": "11.6%"
                },
                {
                    "targets": 6, // Index of the column to disable sorting
                    "orderable": false // Disable sorting for column 5 - Actions
                }
            ]
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetch('getDelis.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => alert('Error fetching deliveries data:', error));
    setDataTables();
});

function updateTable(data) {
    const table = $('#example').DataTable();

    // Clear existing data
    table.clear();

    data.forEach(row => {
        let statusColor;
        if (row.DeliveryStatus === "Pending") {
            statusColor = '#B8860B';
        } else if (row.DeliveryStatus === "Returned") {
            statusColor = 'red';
        } else if (row.DeliveryStatus === "Completed") {
            statusColor = 'green';
        } else {
            statusColor = 'black';
        }

        // Add the row to the table
        table.row.add([
            "DE-0" + row.DeliveryID,
            row.PurchaseOrderID,
            row.SupplierName,
            row.DeliveryDate,
            row.TotalItemsDelivered,
            `<span style="color: ${statusColor};">${row.DeliveryStatus}</span>`, // Apply the color to the DeliveryStatus
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:10px;" onclick="fetchDetails('${row.DeliveryID}')"/> 
             <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showOptions('${row.DeliveryID}')"/>`
        ]);
    });


    // Draw the updated table
    table.draw();

}