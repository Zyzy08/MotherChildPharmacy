// Existing variables and initializations
const addUserBtn = document.getElementById('addUser');
const overlayAD = document.getElementById('overlayAD');
const closeBtnAD = document.getElementById('closeBtnAD');
const AccountID = document.getElementById('AccountID');
// etc
const tableBody = document.getElementById('tableBody');
const optUserBtn = document.getElementById('optionsUser');
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

// Placeholders
let currentlySelectedRow = null;
let selectedUser = null;
let selectedItemID = null; // Variable to store the selected item's ID for unarchiving

// Redirect to inventory page
const toInventory = document.getElementById('toInventory');
toInventory.addEventListener('click', function () {
    window.location.href = '../inventory.php';
});

// Show delete options
function showDeleteOptions(accountName) {
    selectedUser = accountName;
    overlayAD.style.display = 'flex';
}

// Close overlay
function closeADOverlay() {
    overlayAD.style.display = 'none';
}
closeBtnAD.addEventListener('click', closeADOverlay);

// Archiving Accounts
const unarchiveUserBtn = document.getElementById('unarchiveUserBtn');
const modalYes = document.getElementById('modalYes');
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');
let modalStatus = '';

// Handle unarchiving action
unarchiveUserBtn.addEventListener('click', function (event) {
    // Get the ID of the product to unarchive from the clicked button
    selectedItemID = event.target.dataset.id; // Assuming the button has a data-id attribute
    modalVerifyTextAD.textContent = 'Are you sure you want to unarchive this product?';
    modalStatus = 'unarchive'; // Update modal status for unarchiving
});

// Event listener for 'Yes' button in the modal
modalYes.addEventListener('click', function () {
    if (modalStatus === 'unarchive') {
        if (!selectedItemID || selectedItemID.trim() === '') {
            alert('No product selected.');
            return;
        }

        // Sending the unarchive request via XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../inventory/ArchiveProduct/unarchiveProduct.php', true); // Adjust the URL to your unarchive script
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handling the response from the server
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                modalVerifyTextAD.textContent = response.message; // Display the response message

                // Hide modal controls
                modalFooterAD.style.display = 'none';
                modalCloseAD.style.display = 'none';

                // If the unarchive is successful, load the archived products
                if (response.success) {
                    setTimeout(() => {
                        window.location.href = '../inventory/ArchiveProduct/ArchiveProd.php'; // Redirect to the archived products page
                    }, 1000); // Optional delay for user feedback
                }
            } else {
                alert('Error: ' + xhr.status);
            }
        };

        // Sending product ID to unarchive
        xhr.send(JSON.stringify({ itemID: selectedItemID })); // Sending itemID
    }
});

// Load item data into the form for editing
function loadFormForEdit(item) {
    isEditMode = true;
    currentItemId = item.ItemID;

    document.getElementById('itemID').value = item.ItemID; // Set ItemID field as read-only
    document.getElementById('genericName').value = item.GenericName;
    document.getElementById('brandName').value = item.BrandName;
    document.getElementById('itemType').value = item.ItemType;
    document.getElementById('mass').value = item.Mass;
    document.getElementById('unitOfMeasure').value = item.UnitOfMeasure;
    document.getElementById('Discount').value = item.Discount;
    document.getElementById('pricePerUnit').value = item.PricePerUnit;
    document.getElementById('Notes').value = item.Notes || ''; // Handle missing Notes

    // Set the icon preview
    document.getElementById('iconPreview').src = item.ProductIcon || '../resources/img/add_icon.png'; // Use default if no icon

    modal.style.display = "block";
}

// Initialize or reinitialize DataTables
function setDataTables() {
    const $dataTable = $('#example');
    if ($.fn.dataTable.isDataTable($dataTable)) {
        $dataTable.DataTable().destroy(); // Destroy existing instance
    }

    $('#example').DataTable({
        "order": [], // Disable initial sorting
        "columnDefs": [
            { "targets": 0, "width": "8%" }, // Item ID
            { "targets": 1, "width": "10%", "orderable": false }, // Icon 
            { "targets": 2, "width": "10%" }, // Generic Name
            { "targets": 3, "width": "10%" }, // Brand Name
            { "targets": 4, "width": "10%" }, // Item Type
            { "targets": 5, "width": "10%" }, // Mass & Unit of Measure
            { "targets": 6, "width": "10%" }, // Price Per Unit
            { "targets": 7, "width": "10%" }, // InStock
            { "targets": 8, "width": "10%" }, // Ordered
            { "targets": 9, "width": "10%" }, // ReOrderLevel
            { "targets": 10, "width": "12%", "orderable": false } // Actions
        ]
    });

    // Adjust column widths dynamically
    const adjustColumns = () => $dataTable.DataTable().columns.adjust().draw();
    $(window).resize(adjustColumns);
    
    // Sidebar toggle event
    $('#bi bi-list toggle-sidebar-btn').on('click', () => {
        setTimeout(adjustColumns, 300);
    });
}

// Update the table with new data
function updateTable(items) {
    tableBody.innerHTML = ''; // Clear existing rows

    items.forEach(item => {
        var row = document.createElement('tr');
        row.setAttribute('data-id', item.ItemID); // Set data-id attribute

        row.innerHTML = `
            <td class="text-center text-truncate">${item.ItemID}</td>
            <td class="text-center"><img src="${item.ProductIcon}" alt="Icon" style="width: 50px; height: auto;"></td>
            <td class="text-center text-truncate">${item.GenericName}</td>
            <td class="text-center text-truncate">${item.BrandName}</td>
            <td class="text-center text-truncate">${item.ItemType}</td>
            <td class="text-center text-truncate">${item.Mass} ${item.UnitOfMeasure}</td>
            <td class="text-center text-truncate">${item.PricePerUnit}</td>
            <td class="text-center text-truncate">${item.InStock}</td>
            <td class="text-center text-truncate">${item.Ordered}</td>
            <td class="text-center text-truncate">${item.ReorderLevel}</td>
            <td class="text-center">
                <img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer;" onclick="handleUpdate('${item.ItemID}')" />
                <img src="../resources/img/s-remove2.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="handleDelete('${item.ItemID}')" />
                <img src="../resources/img/unarchive.png" alt="Unarchive" style="cursor:pointer;margin-left:10px;" onclick="showUnarchiveModal('${item.ItemID}')" /> <!-- Unarchive button -->
            </td>
        `;

        tableBody.appendChild(row);
    });

    setDataTables(); // Reinitialize DataTables
}

// Function to show unarchive modal and set selectedItemID
function showUnarchiveModal(itemID) {
    selectedItemID = itemID; // Set the selected item ID for unarchiving
    modalVerifyTextAD.textContent = 'Are you sure you want to unarchive this product?'; // Update modal text
    modal.style.display = 'block'; // Show modal
}
