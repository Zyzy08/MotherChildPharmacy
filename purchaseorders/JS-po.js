function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[1, 'desc']], // Sort by the first column (OrderID) in descending order
            "pageLength": 5,
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
            ],
            "layout": {
                "topStart": {
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            pageSize: 'A4', // Set the page size
                            title: 'Purchase Orders of Mother and Child Pharmacy and Medical Supplies', // Set a custom title
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            },
                            customize: function (doc) {
                                // Set font size for the whole document
                                doc.defaultStyle.fontSize = 10;

                                // Add custom margins
                                doc.pageMargins = [40, 60, 40, 60];

                                // Set column widths to make them equal
                                const columnCount = doc.content[1].table.body[0].length;
                                doc.content[1].table.widths = Array(columnCount).fill('*');

                                // Customize the table header
                                doc.styles.tableHeader = {
                                    alignment: 'left',
                                    fontSize: 12,
                                };

                                // Add additional elements such as a footer
                                doc['footer'] = (currentPage, pageCount) => {
                                    return {
                                        columns: [
                                            {
                                                text: `Page ${currentPage} of ${pageCount}`,
                                                alignment: 'right',
                                                fontSize: 8,
                                                margin: [0, 10, 40, 0],
                                            }
                                        ]
                                    };
                                };
                            }
                        }
                    ]
                }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetch('getPendingPOs.php')
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
        } else if (row.Status === "Back Order") {
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
                } else if (data.Status === "Back Order") {
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


// PO form export

document.getElementById('exportPO').addEventListener('click', () => {
    exportOverlayToPDF();
});

function exportOverlayToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add the centered title
    const title = "Mother & Child Pharmacy and Medical Supplies";
    doc.setFontSize(18);
    const pageWidth = doc.internal.pageSize.getWidth();
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 20);

    // Add a horizontal rule beneath the title
    doc.setLineWidth(0.5);
    doc.line(10, 25, pageWidth - 10, 25);

    // Move down to start main content
    doc.setFontSize(16);
    doc.text("Purchase Order Details", 10, 35);

    // Capture Main Details Table
    doc.setFontSize(12);
    const mainDetails = [
        { label: "Order ID", value: document.getElementById('identifierID').textContent },
        { label: "Supplier Name", value: document.getElementById('supplierName').textContent },
        { label: "Purchaser", value: document.getElementById('cashierID').textContent },
        { label: "Date", value: document.getElementById('datetimeID').textContent },
        { label: "Status", value: document.getElementById('Status').textContent },
    ];

    let y = 45; // Start position for main details
    mainDetails.forEach((detail) => {
        doc.text(`${detail.label}: ${detail.value}`, 10, y);
        y += 10;
    });

    // List of Items Table
    const itemTable = [];
    document.querySelectorAll('#listTable tbody tr').forEach((row) => {
        const columns = row.querySelectorAll('td, th');
        itemTable.push([columns[0].textContent, columns[1].textContent, columns[2].textContent]);
    });

    doc.autoTable({
        startY: y + 1,
        head: [['#', 'Item Description', 'Qty. Ordered']],
        body: itemTable,
        theme: 'grid',
        headStyles: {
            fillColor: [64, 64, 64], // Dark gray color for header
            textColor: [255, 255, 255], // White text color for contrast
            fontStyle: 'bold'
        },
        styles: {
            fontSize: 10 // Adjust font size if needed
        }
    });

    // Footer with date and page number
    const pageCount = doc.getNumberOfPages();
    const currentDate = new Date().toLocaleDateString();

    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(10);

        // Date on the left
        doc.text(`Date Generated: ${currentDate}`, 10, doc.internal.pageSize.getHeight() - 10);

        // Page number on the right
        doc.text(`Page ${i} of ${pageCount}`, pageWidth - 30, doc.internal.pageSize.getHeight() - 10);
    }

    // Dynamically set the PDF file name based on identifierID
    const identifierID = document.getElementById('identifierID').textContent;
    const pdfFileName = `${identifierID}_Purchase_Order_Details.pdf`;

    // Save the PDF with the dynamic filename
    doc.save(pdfFileName);
}

