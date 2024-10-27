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
        } else if (row.DeliveryStatus === "Partial") {
            statusColor = 'blue';
        } else if (row.DeliveryStatus === "Completed") {
            statusColor = 'green';
        } else {
            statusColor = 'black';
        }

        // Add the row to the table
        table.row.add([
            "DE-0" + row.DeliveryID,
            "PO-0" + row.PurchaseOrderID,
            row.SupplierName,
            row.DeliveryDate,
            parseInt(row.TotalItemsDelivered) + parseInt(row.TotalItemsBonus),
            `<span style="color: ${statusColor};">${row.DeliveryStatus}</span>`, // Apply the color to the DeliveryStatus
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:20px;" onclick="fetchDetails('${row.DeliveryID}')"/>`
        ]);
    });


    // Draw the updated table
    table.draw();

}

const overlayEdit = document.getElementById('overlayEdit');
const closeBtnEdit = document.getElementById('closeBtnEdit');
const identifierID = document.getElementById('identifierID');
const cashierID = document.getElementById('cashierID');
const datetimeID = document.getElementById('datetimeID');
const Status = document.getElementById('Status');
const Discount = document.getElementById('Discount');
const NetAmount = document.getElementById('NetAmount');
const modePay = document.getElementById('modePay');
const amtPaid = document.getElementById('amtPaid');
const amtChange = document.getElementById('amtChange');
const supplierName = document.getElementById('supplierName');

function fetchDetails(identifier) {
    fetch(`getDeliDetails.php?DeliveryID=${encodeURIComponent(identifier)}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the overlay form with details
                identifierID.textContent = "DE-0" + data.DeliveryID;
                supplierName.textContent = data.SupplierName;
                cashierID.textContent = data.employeeName + " " + data.employeeLName;
                datetimeID.textContent = data.DeliveryDate;
                Status.textContent = data.DeliveryStatus;

                if (data.DeliveryStatus === "Pending") {
                    Status.style.color = '#B8860B'; // Yellow
                } else if (data.DeliveryStatus === "Partial") {
                    Status.style.color = 'blue';
                } else if (data.DeliveryStatus === "Cancelled") {
                    Status.style.color = 'red'; // Red
                } else if (data.DeliveryStatus === "Received") {
                    Status.style.color = 'green'; // Green
                } else {
                    Status.style.color = 'black'; // Default
                }

                // Populate table rows
                if (data && data.listItems) {
                    const tableBody = document.querySelector('#listTable tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    data.listItems.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <th scope="row">${index + 1}</th>
                            <td>${item.description}</td>
                            <td class="editable" data-key="lotNo" id="lotNo">${item.lot_number}</td>
                            <td class="editable" data-key="expiryDate" id="expiryDate">${item.expiry_date}</td>
                            <td>${item.quantity_ordered}</td>
                            <td class="editable" data-key="qtyServed" id="qtyServed">${item.quantity_delivered}</td>
                            <td class="editable" data-key="bonus" id="bonus">${item.bonus}</td>
                            <td class="editable" data-key="netAmt" id="netAmt">₱${item.net_amount}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                }

                // Show the overlay
                overlayEdit.style.display = 'flex';
            } else {
                console.error('No data found for the given id.');
            }
        })
        .catch(error => {
            console.error('Error fetching details:', error);
        });
}


closeBtnEdit.addEventListener('click', function () {
    overlayEdit.style.display = 'none';
})