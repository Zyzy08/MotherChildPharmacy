function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[1, 'desc']], // Sort by the first column (OrderID) in descending order
            "columnDefs": [
                {
                    "targets": 0, // OrderID
                    "width": "17.6%"
                },
                {
                    "targets": 1, // Date
                    "width": "20.6%"
                },
                {
                    "targets": 2, // Supplier
                    "width": "18.6%"
                },
                {
                    "targets": 3, // Qty
                    "width": "16.6%"
                },
                {
                    "targets": 4, // Status
                    "width": "15%"
                },
                {
                    "targets": 5, // Actions
                    "width": "11.6%"
                },
                {
                    "targets": 5, // Index of the column to disable sorting
                    "orderable": false // Disable sorting for column 5 - Actions
                }
            ]
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetch('getPOs.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => alert('Error fetching transactions data:', error));
    setDataTables();
});

function updateTable(data) {
    const table = $('#example').DataTable();

    // Clear existing data
    table.clear();

    data.forEach(row => {
        let statusColor;
        if (row.Status === "Pending") {
            statusColor = '#B8860B';
        } else if (row.Status === "Cancelled") {
            statusColor = 'red';
        } else if (row.Status === "Received") {
            statusColor = 'green';
        } else {
            statusColor = 'black';
        }

        // Add the row to the table
        table.row.add([
            "PO-0" + row.PurchaseOrderID,
            row.OrderDate,
            row.SupplierName,
            row.TotalItems,
            `<span style="color: ${statusColor};">${row.Status}</span>`, // Apply the color to the Status
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:10px;" onclick="fetchDetails('${row.PurchaseOrderID}')"/> 
             <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showOptions('${row.PurchaseOrderID}')"/>`
        ]);
    });


    // Draw the updated table
    table.draw();

}