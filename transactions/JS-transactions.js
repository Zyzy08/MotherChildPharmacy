function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [], // Disable initial sorting
            "columnDefs": [
                {
                    "targets": 0, // InvoiceID
                    "width": "17.6%"
                },
                {
                    "targets": 1, // Date
                    "width": "18.6%"
                },
                {
                    "targets": 2, // Quantity
                    "width": "17.6%"
                },
                {
                    "targets": 3, // Total
                    "width": "17.6%"
                },
                {
                    "targets": 4, // Payment
                    "width": "18%"
                },
                {
                    "targets": 5, // Actions
                    "width": "10.6%"
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
    fetch('getTransactions.php')
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
        table.row.add([
            row.InvoiceID,
            row.SalesDate,
            row.TotalItems,
            row.NetAmount,
            row.PaymentMethod,
            `<img src="../resources/img/d-edit.png" alt="View" style="cursor:pointer;margin-left:10px;"/> 
            <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;"/>`
        ]);

        counter++;
    });

    // Draw the updated table
    table.draw();

}