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
                    "width": "23.6%"
                },
                {
                    "targets": 2, // Quantity
                    "width": "15.6%"
                },
                {
                    "targets": 3, // Total
                    "width": "16.6%"
                },
                {
                    "targets": 4, // Payment
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
            'IN-0' + row.InvoiceID,
            row.SalesDate,
            row.TotalItems,
            "₱ " + row.NetAmount,
            row.PaymentMethod,
            // `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:20px;" onclick="fetchDetails('${row.InvoiceID}')"/>`
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:10px;" onclick="fetchDetails('${row.InvoiceID}')"/> 
            <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showOptions('${row.InvoiceID}')"/>`
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
const listQTY = document.getElementById('listQTY');
const VATable = document.getElementById('VATable');
const VATAmount = document.getElementById('VATAmount');
const Discount = document.getElementById('Discount');
const NetAmount = document.getElementById('NetAmount');
const modePay = document.getElementById('modePay');
const amtPaid = document.getElementById('amtPaid');
const amtChange = document.getElementById('amtChange');
const transactionType = document.getElementById('transactionType');


function fetchDetails(identifier) {
    fetch(`getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the overlay form with details
                identifierID.value = 'IN-0' + data.InvoiceID;
                cashierID.value = data.employeeName + " " + data.employeeLName;
                datetimeID.value = data.SalesDate;
                VATable.value = "₱ " + data.Subtotal;
                VATAmount.value = "₱ " + data.Tax;
                Discount.value = "₱ " + data.Discount;
                NetAmount.value = "₱ " + data.NetAmount;
                modePay.value = data.PaymentMethod;
                amtPaid.value = "₱ " + data.AmountPaid;
                amtChange.value = "₱ " + data.AmountChange;
                transactionType.value = data.Status;

                // Set listQTY input value
                listQTY.value = data.listQTY; // Update the listQTY input

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
function showOptions(identifier) {
    selectedID = identifier;
    overlayADtitle.textContent = "InvoiceID " + identifier;
    overlayAD.style.display = 'flex';
};

const closeBtnAD = document.getElementById('closeBtnAD');
closeBtnAD.addEventListener('click', function () {
    overlayAD.style.display = 'none';
})

const deleteDataBtn = document.getElementById('deleteDataBtn');
deleteDataBtn.addEventListener('click', function () {
    let confirmationUser = confirm("Are you sure you want to void this transaction?");
    if (confirmationUser === true) {
        if (!selectedID || selectedID.trim() === '') {
            alert('No data selected.');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'deleteData.php', true);
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
        alert("Transaction voided successfully!");
        setTimeout(() => {
            window.location.href = 'transactions.php'; // Redirect on success
        }, 100);
    } else {

    }
});

//Tabs for Types
const tab1 = document.getElementById('1-tab');
const tab2 = document.getElementById('2-tab');
// const tab3 = document.getElementById('3-tab');

function fetchTransactions(tab) {
    fetch(`getTransactions.php?tab=${tab}`)
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => {
            console.error('Error fetching transactions:', error);
        });
}

// Event listeners for tab clicks
tab1.addEventListener('click', () => fetchTransactions('1'));
tab2.addEventListener('click', () => fetchTransactions('2'));
// tab3.addEventListener('click', () => fetchTransactions('3'));

