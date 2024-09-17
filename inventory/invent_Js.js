// Get the modal
var modal = document.getElementById("PurchaseForm");

// Get the button that opens the modal for new product
var btn = document.querySelector(".Create_PO");

// Get the close button
var closeBtn = document.getElementById("closeBtn");

// Get the update button
var updateBtn = document.getElementById("updateProduct");

// Get the notification elements
var notification = document.getElementById("notification");
var notificationMessage = document.getElementById("notificationMessage");
var closeNotification = document.getElementById("closeNotification");

// For tracking if this is an update or a new product
var isEditMode = false;
var currentItemId = null; // Store the ItemID when editing
var updateModeActive = false; // Flag to indicate if update mode is active
var formClosedWithoutSubmission = false; // Flag to indicate if form was closed without submission

// When the user clicks the button, open the modal for new product
btn.onclick = function() {
    modal.style.display = "block";
    isEditMode = false; // Indicate that this is a new product
    document.getElementById('PurchaseForm').reset(); // Clear form fields
}

// When the user clicks on the close button, close the modal
closeBtn.onclick = function() {
    formClosedWithoutSubmission = true; // Set the flag
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        formClosedWithoutSubmission = true; // Set the flag
        modal.style.display = "none";
    }
    if (event.target == notification) {
        notification.style.display = "none";
    }
}

// Get the Clear button
var clearBtn = document.getElementById("Clear");

// When the user clicks the Clear button, clear all text fields
clearBtn.onclick = function() {
    var textFields = document.querySelectorAll('#PurchaseForm input[type="text"]');
    textFields.forEach(function(field) {
        field.value = "";
    });
}

// Handle form submission (for both adding and updating)
document.getElementById('PurchaseForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    if (formClosedWithoutSubmission) {
        formClosedWithoutSubmission = false; // Reset the flag
        return; // Exit if form was closed without submission
    }

    const form = document.getElementById('PurchaseForm');
    const formData = new FormData(form);

    // Log form data to ensure InStock is included
    for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    const apiUrl = isEditMode ? 'updateInventory.php' : 'getInventory.php';

    fetch(apiUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Show success message
            form.reset(); // Optionally reset the form
            modal.style.display = "none"; // Close the modal
            loadInventory(); // Refresh the inventory table
        } else {
            alert('Error: ' + data.message); // Show error message
        }
    })
    .catch(error => console.error('Error:', error));
});

// Load inventory data when the page loads
document.addEventListener('DOMContentLoaded', loadInventory);

// Function to load inventory data
function loadInventory() {
    fetch('getProduct_data.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTable(data.data);
        } else {
            showError(data.message);
        }
    })
    .catch(error => showError('Failed to load data. Please try again later.'));
}

// Function to update the table
function updateTable(data) {
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = ''; // Clear existing rows

    // Ensure data is an array
    if (Array.isArray(data)) {
        data.forEach(item => {
            const row = document.createElement('tr');
            row.setAttribute('data-id', item.ItemID); // Set data-id attribute

            // Create and append table cells
            row.innerHTML = `
                <td style="text-align: center;">${item.ItemName}</td>
                <td style="text-align: center;">${item.BrandName}</td>
                <td style="text-align: center;">${item.GenericName}</td>
                <td style="text-align: center;">${item.ItemType}</td>
                <td style="text-align: center;">${item.Mass}</td>
                <td style="text-align: center;" class="currency">₱ ${item.PricePerUnit}</td>
                <td style="text-align: center;">${item.InStock}</td>
            `;

            // Add double-click event to load the item data for editing if updateModeActive is true
            row.addEventListener('dblclick', function() {
                if (updateModeActive) {
                    loadFormForEdit(item); // Load item data into the form
                    updateModeActive = false; // Deactivate update mode
                }
            });

            tableBody.appendChild(row);
        });
    } else {
        // Handle the case when data is not in expected format
        showError('Error: Invalid data format received.');
    }
}

// Function to load form data for editing
function loadFormForEdit(item) {
    modal.style.display = "block"; // Open the modal
    isEditMode = true; // Indicate that this is edit mode
    currentItemId = item.ItemID; // Store the ItemID for the update

    // Fill the form with item data
    document.getElementById('itemName').value = item.ItemName;
    document.getElementById('genericName').value = item.GenericName;
    document.getElementById('brandName').value = item.BrandName;
    document.getElementById('itemType').value = item.ItemType;
    document.getElementById('mass').value = item.Mass;
    document.getElementById('unitOfMeasure').value = item.UnitOfMeasure;
    document.getElementById('pricePerUnit').value = item.PricePerUnit;
    document.getElementById('notes').value = item.Notes;
    document.getElementById('status').value = item.Status;
    document.getElementById('InStock').value = item.InStock; // Ensure this field is updated
}

// When the user clicks the Update button, activate update mode
updateBtn.onclick = function() {
    updateModeActive = true; // Activate update mode
    notificationMessage.textContent = 'Double-click the row that you want to edit.'; // Set the message
    notification.style.display = "block"; // Show the notification
}

// Function to show error messages
function showError(message) {
    const errorContainer = document.getElementById('errorContainer');
    errorContainer.innerHTML = `<p class="error-message">${message}</p>`;
}

// Function to search and update table based on the search query
function fetchData(query) {
    fetch('searchProduct.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            searchQuery: query
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTable(data.results);
        } else {
            console.error('Search error:', data.message);
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error: There was an issue with your request.');
    });
}

// Search input listener to handle real-time search
var searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function(event) {
    const query = event.target.value.trim();
    if (query.length === 0) {
        fetch('getProduct_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTable(data.results);
            } else {
                console.error('Fetch error:', data.message);
                alert('Error fetching product data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error fetching product data: ' + error);
        });
    } else {
        fetchData(query);
    }
});

// When the user clicks the Close button on the notification, hide the notification
closeNotification.onclick = function() {
    notification.style.display = "none"; // Hide the notification
}

// When the user clicks anywhere outside the notification, hide it
window.onclick = function(event) {
    if (event.target == notification) {
        notification.style.display = "none";
    }
}

// DELETE PRODUCT FUNCTIONALITY
document.addEventListener('DOMContentLoaded', () => {
    let deleteMode = false;
    let selectedRow = null;
    let selectedRowId = null;

    const deleteButton = document.getElementById('deleteProduct');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const closeDeleteBtn = document.getElementById('closeDeleteBtn');
    const tableBody = document.getElementById('tableBody');

    deleteButton.addEventListener('click', () => {
        // Check if there are any rows in the table
        const rows = tableBody.querySelectorAll('tr');
        if (rows.length === 0) {
            showNotification('There are no products in the table to delete.');
            return; // Exit the function if no rows are present
        }

        deleteMode = true;
        showNotification('Double-click the row that you want to delete.');
    });

    tableBody.addEventListener('dblclick', function(event) {
        if (!deleteMode) return;

        const row = event.target.closest('tr');
        if (!row) return;

        selectedRowId = row.getAttribute('data-id');
        selectedRow = row;
        deleteModal.style.display = 'block'; // Show the delete confirmation modal
        deleteMode = false; // Deactivate delete mode
    });

    confirmDeleteBtn.addEventListener('click', () => {
        if (selectedRowId) {
            fetch('deleteProduct.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    itemId: selectedRowId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selectedRow.remove(); // Remove the row from the table
                    showNotification('Product deleted successfully.');
                } else {
                    showNotification('Error deleting product: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                showNotification('Error deleting product: ' + error);
            });
        }
        deleteModal.style.display = 'none'; // Close the delete confirmation modal
    });

    cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none'; // Close the delete confirmation modal
        deleteMode = false; // Deactivate delete mode
    });

    closeDeleteBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none'; // Close the delete confirmation modal
        deleteMode = false; // Deactivate delete mode
    });
});

function showNotification(message) {
    notificationMessage.textContent = message;
    notification.style.display = "block";
}
