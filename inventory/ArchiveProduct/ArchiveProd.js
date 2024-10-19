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
let selectedItemID = null; // Variable to store the selected item's ID for unarchiving

// Redirect to inventory page
const toInventory = document.getElementById('toInventory');
toInventory.addEventListener('click', function () {
    window.location.href = '../inventory.php';
});

// Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getArchiveProd.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('No data available');
            }
            return response.json();
        })
        .then(data => {
            updateTable(data);
            setDataTables(); // Move this inside to ensure table is updated first
        })
        .catch(error => alert('Error fetching data: ' + error));
});


// Update the DataTable with the fetched data
function updateTable(data) {
    const table = $('#example').DataTable(); // Assuming your table has an ID of 'example'

    // Clear existing data
    table.clear();

    data.forEach(item => {
        if (!item.ProductIcon || !item.ItemID) {
            console.warn('Missing item properties:', item);
            return; // Skip this item if essential properties are missing
        }

        // Update the path for the ProductIcon
        const iconPath = `MotherChildPharmacy-main/inventory/products-icon/${item.ProductIcon}`;

        table.row.add([
            `<span class="text-truncate">${item.ItemID}</span>`, // Item ID with truncation
            `<img src="${iconPath}" alt="Icon" style="width: 50px; height: auto;" />`, // Product Icon
            `<span class="text-truncate">${item.GenericName}</span>`, // Generic Name with truncation
            `<span class="text-truncate">${item.BrandName}</span>`, // Brand Name with truncation
            `<span class="text-truncate">${item.ItemType}</span>`, // Item Type with truncation
            `<span class="text-truncate">${item.Mass} ${item.UnitOfMeasure}</span>`, // Mass with Unit of Measure
            `<span class="text-truncate">${item.PricePerUnit}</span>`, // Price Per Unit with truncation
            `<span class="text-truncate">${item.InStock}</span>`, // In Stock with truncation
            `<span class="text-truncate">${item.Ordered}</span>`, // Ordered with truncation

            `<img src="../../resources/img/s-remove.png" alt="Unarchive" style="cursor:pointer; display:block; margin: 0 auto;" onclick="showDeleteOptions('${item.ItemID}')" />` // Action buttons
        ]);
    });

    // Draw the updated table
    table.draw();
}

// Show delete options for unarchiving
function showDeleteOptions(itemID) {
    selectedItemID = itemID; // Set the selected Item ID
    overlayAD.style.display = 'flex'; // Show the overlay
}

// Close overlay
function closeADOverlay() {
    overlayAD.style.display = 'none';
}
closeBtnAD.addEventListener('click', closeADOverlay);

// Function to initialize or reinitialize DataTables
function setDataTables() {
    if ($.fn.dataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy(); // Destroy the existing instance before reinitializing
    }

    var table = $('#example').DataTable({
        "order": [], // Disable initial sorting
        "autoWidth": false, // Disable automatic column width calculation
        "responsive": true, // Enable responsiveness
        "columnDefs": [
            { "targets": 0, "width": "5%" }, // Item ID
            { "targets": 1, "width": "10%", "orderable": false }, // Icon 
            { "targets": 2, "width": "10%" }, // Generic Name
            { "targets": 3, "width": "10%" }, // Brand Name
            { "targets": 4, "width": "10%" }, // Item Type
            { "targets": 5, "width": "5%" }, // Mass & Unit of Measure
            { "targets": 6, "width": "10%" }, // Price Per Unit
            { "targets": 7, "width": "10%" }, // InStock
            { "targets": 8, "width": "10%" }, // Ordered
            { "targets": 9, "width": "100px", "orderable": false, "className": "text-center fixed-width" } // Actions
        ]
    });

    // Adjust table layout on sidebar toggle
    $(window).on('resize', function() {
        table.columns.adjust().draw(); // Redraw the DataTable to adjust the columns
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
    modalVerifyTextAD.textContent = 'Are you sure you want to unarchive this product?';
    modalStatus = 'archive';
});

// Confirm unarchive action
modalYes.addEventListener('click', function () {
    if (modalStatus === 'archive') {
        if (!selectedItemID || selectedItemID.trim() === '') {
            alert('No product selected.');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'UnarchiveProd.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                
                // Update modal with response message
                modalVerifyTextAD.textContent = response.message;

                // Hide modal controls
                modalFooterAD.style.display = 'none'; // Hide footer
                modalCloseAD.style.display = 'none'; // Hide close button

                // If the unarchive is successful
                if (response.success) {
                    modalVerifyTextAD.textContent = 'Product has been unarchived and status is now active!';
                    modalVerifyTitleAD.textContent = 'Success';

                    // Remove the corresponding row from the DataTable
                    const table = $('#example').DataTable();
                    const row = table.rows().nodes().toArray().find(row => {
                        const rowData = table.row(row).data();
                        return rowData[1].includes(selectedItemID); // Match against ItemID
                    });
                    if (row) {
                        table.row(row).remove().draw(); // Remove and redraw the table
                    }

                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = 'ArchiveProd.php'; // Adjust URL if necessary
                    }, 1000); // Optional delay for user feedback
                }
            } else {
                alert('Error: ' + xhr.status);
            }
        };

        // Send the request with the itemID
        xhr.send(JSON.stringify({ itemID: selectedItemID }));

        // Extra feedback (these lines might be redundant)
        modalFooterAD.style.display = 'none'; // Hide footer
        modalCloseAD.style.display = 'none'; // Hide close button
        modalVerifyTextAD.textContent = 'The product has been unarchived and status is now active!';
        modalVerifyTitleAD.textContent = 'Success';
        
        // Optional: You could also include a timeout for redirection here
        setTimeout(() => {
            window.location.href = 'ArchiveProd.php';
        }, 1000);
    }
});

// Additional functions can be added here...
