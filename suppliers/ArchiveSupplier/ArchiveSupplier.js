// Existing variables and initializations
const addUserBtn = document.getElementById('addUser');
const overlayAD = document.getElementById('overlayAD');
const closeBtnAD = document.getElementById('closeBtnAD');
const tableBody = document.getElementById('tableBody');
const optUserBtn = document.getElementById('optionsUser');
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

// Placeholders
let currentlySelectedRow = null;
let selectedSupplierID = null; // Variable to store the selected item's ID for unarchiving

// Redirect to inventory page
const toSuppliers = document.getElementById('toSuppliers');
toSuppliers.addEventListener('click', function () {
    window.location.href = '../Suppliers.php';
});

// Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getArchiveSuppliers.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => console.error('Error fetching data:', error)); // Use console instead of alert for better debugging

    setDataTables(); // Ensure this initializes your DataTable properly
});

// Truncate function to limit string length and add ellipsis
function truncateString(str, maxLength) {
    if (str.length > maxLength) {
        return str.substring(0, maxLength) + '...';
    }
    return str;
}

// Set the maximum length for truncation
const maxLength = 15; // Adjust this value as needed

function updateTable(data) {
    const table = $('#example').DataTable();
    table.clear(); // Clear existing data

    data.forEach(row => {
        table.row.add([
            `<div>SP-0${row.SupplierID}</div>`,
            `<div>${row.SupplierName}</div>`,
            `<div>${truncateString(row.AgentName || 'N/A', maxLength)}</div>`,
            `<div>${truncateString(row.Phone || 'N/A', maxLength)}</div>`,
            `<div>${truncateString(row.Email || 'N/A', maxLength)}</div>`,
            `
                <div style="text-align: center;">
                    <img src="../../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showDeleteOptions('${row.SupplierID}')" />
                </div>
            `
        ]);
    });

    table.draw(); // Draw the updated table
}


// Show delete options for unarchiving
function showDeleteOptions(SupplierID) {
    selectedSupplierID = SupplierID; // Set the selected Item ID
    console.log('Selected Item ID for unarchiving:', selectedSupplierID); // Log the selected ID
    overlayAD.style.display = 'flex'; // Show the overlay
}

// Close overlay
function closeADOverlay() {
    overlayAD.style.display = 'none';
}
closeBtnAD.addEventListener('click', closeADOverlay);

// Initialize or reinitialize DataTables
function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [], // Disable initial sorting
            "columnDefs": [
                {
                    "targets": 0, // Supplier ID
                    "width": "10.6%"
                },
                {
                    "targets": 1, // Company Name
                    "width": "20.6%"
                },
                {
                    "targets": 2, // Agent Name
                    "width": "16.6%"
                },
                {
                    "targets": 3, // Contact No.
                    "width": "16.6%"
                },
                {
                    "targets": 4, // Email
                    "width": "12.6%"
                },
                {
                    "targets": 5, // Actions
                    "width": "10.6%",
                    "orderable": false // Disable sorting for Actions column
                }
            ]
        });
    });
}


// Unarchiving Products
const unarchiveUserBtn = document.getElementById('unarchiveUserBtn');
const modalYes = document.getElementById('modalYes');
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');
let modalStatus = '';

// Event listener for the unarchive button
unarchiveUserBtn.addEventListener('click', function () {
    modalVerifyTextAD.textContent = 'Are you sure you want to unarchive this supplier?';
    modalStatus = 'archive';
});

// Confirm unarchive action
modalYes.addEventListener('click', function () {
    if (modalStatus === 'archive') {
        if (!selectedSupplierID || selectedSupplierID.trim() === '') {
            alert('No supplier is selected.');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'UnarchiveSupplier.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handle the response
        xhr.onload = function () {
            console.log('Unarchive response:', xhr.responseText); // Log server response for debugging

            // Try to parse the response as JSON
            try {
                const response = JSON.parse(xhr.responseText);

                if (xhr.status >= 200 && xhr.status < 300) {
                    if (response.success) {
                        modalFooterAD.style.display = 'none';
                        modalVerifyTextAD.textContent = 'The Supplier have been unarchived!';
                        modalVerifyTitleAD.textContent = 'Success';

                        // Remove the corresponding row from the DataTable
                        const table = $('#example').DataTable();
                        const row = table.rows().nodes().toArray().find(row => {
                            const rowData = table.row(row).data();
                            return rowData[0].includes(selectedSupplierID); // Match against ItemID (first column index)
                        });
                        if (row) {
                            table.row(row).remove().draw(); // Remove and redraw the table
                        }

                        // Redirect after a short delay
                        setTimeout(() => {
                            window.location.href = 'ArchiveSupplier.php'; // Adjust URL if necessary
                        }, 1000); // Optional delay for user feedback
                    } else {
                        alert('Failed to unarchive supplier: ' + response.message);
                    }
                } else {
                    alert('Error: ' + xhr.status);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error); // Log parsing error
                alert('Unexpected response from server. Please check the server logs.');
            }
        };

        // Send the request with the itemID
        xhr.send(JSON.stringify({ itemID: selectedSupplierID }));
    }
});
