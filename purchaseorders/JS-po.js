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
                    "width": "17.6%"
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
                    "width": "18%"
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
        } else if (row.Status === "Partially Received") {
            statusColor = 'blue';
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
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left: ${row.Status === 'Pending' ? '10px' : '20px'};" onclick="fetchDetails('${row.PurchaseOrderID}')"/>` +
            (row.Status === 'Pending' ?
                `<img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showOptions('${row.PurchaseOrderID}')"/>`
                : '')
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
    fetch(`getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the overlay form with details
                identifierID.textContent = "PO-0" + data.PurchaseOrderID;
                supplierName.textContent = data.SupplierName;
                cashierID.textContent = data.employeeName + " " + data.employeeLName;
                datetimeID.textContent = data.OrderDate;
                Status.textContent = data.Status;
                if (data.Status === "Pending") {
                    Status.style.color = '#B8860B'; // Change text color to yellow
                } else if (data.Status === "Cancelled") {
                    Status.style.color = 'red'; // Change text color to red
                } else if (data.Status === "Partially Received") {
                    Status.style.color = 'blue';
                } else if (data.Status === "Received") {
                    Status.style.color = 'green'; // Change text color to green
                } else {
                    Status.style.color = 'black'; // Default color (optional)
                }

                // Set table rows
                if (data && data.listItems) {
                    const tableBody = document.querySelector('#listTable tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    data.listItems.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <th scope="row">${index + 1}</th>
                            <td>${item.description}</td>
                            <td>${item.quantity}</td>
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

//Show Options Section

const overlayAD = document.getElementById('overlayAD');
const overlayADtitle = document.getElementById('overlayADtitle');

let selectedID = '';
const deleteDataBtn = document.getElementById('deleteDataBtn');
function showOptions(identifier) {
    selectedID = identifier;
    overlayADtitle.textContent = "OrderID " + identifier;

    fetch(`getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                const orderDate = new Date(data.OrderDateOrig);
                const currentDate = new Date();
                console.log("Order's date: " + orderDate);
                console.log("Current date: " + currentDate);

                const oneHourInMillis = 60 * 60 * 1000; // 1 hour in milliseconds
                const timeDifference = currentDate - orderDate; // Time difference in milliseconds

                // Enable or disable the delete button
                //if (timeDifference <= oneHourInMillis) {
                if (timeDifference > 0) {
                    deleteDataBtn.disabled = false; // Enable the button
                } else {
                    deleteDataBtn.disabled = true; // Disable the button
                }
            } else {
                console.error('No data found for the given id.');
            }
        })
        .catch(error => {
            console.error('Error fetching details:', error);
        });

    overlayAD.style.display = 'flex';
};

const closeBtnAD = document.getElementById('closeBtnAD');
closeBtnAD.addEventListener('click', function () {
    overlayAD.style.display = 'none';
})

//Main modal
const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');


//Cancel Order
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');
let modalStatus = 'cancel';

const modalYes = document.getElementById('modalYes');
modalYes.addEventListener('click', function () {
    if (modalStatus === 'cancel') {
        if (!selectedID || selectedID.trim() === '') {
            alert('No ID selected.');
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'cancelOrder.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                document.getElementById('modalMessage').textContent = response.message;
            } else {
                alert('Error: ' + xhr.status);
            }
        };

        xhr.send(JSON.stringify({ selectedID: selectedID }));
        //Extra
        overlayAD.style.display = 'none';
        const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
        modalVerifyTitleFront.textContent = 'Success';
        modalVerifyTextFront.textContent = 'Purchase order was cancelled succesfully!';
        confirmationModalFront.show();
        setTimeout(() => {
            window.location.href = 'purchaseorders.php';
        }, 1000);
    }
});

function closeEditOverlay() {
    overlayEdit.style.display = 'none';
}
