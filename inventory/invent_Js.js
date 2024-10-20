// Get the modal
var modal = document.getElementById("PurchaseForm");

// Get the button that opens the modal for new product
var btn = document.querySelector(".Create_PO");


// Get the close button
var closeBtn = document.getElementById("closeBtn");

// Get the notification elements
var notification = document.getElementById("notification");
var notificationMessage = document.getElementById("notificationMessage");
var closeNotification = document.getElementById("closeNotification");

// For tracking if this is an update or a new product
var isEditMode = false;
var currentItemId = null; // Store the ItemID when editing
var formClosedWithoutSubmission = false; // Flag to indicate if form was closed without submission

// When the user clicks the button, open the modal for new product
btn.onclick = function() {
    modal.style.display = "block";
    isEditMode = false; // Indicate that this is a new product
    document.getElementById('PurchaseForm').reset(); // Clear form fields
    document.getElementById('iconPreview').src = '../resources/img/add_icon.png'; // Reset icon preview

    // Fetch the next auto-increment value for ItemID
    fetch('getNextItemId.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('itemID').value = data.nextItemID; // Set the ItemID textbox with the next auto-increment value
            } else {
                console.error('Error fetching next ItemID:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching next ItemID:', error);
        });
};




// Get the Clear button
var clearBtn = document.getElementById("Clear");

// Clear button functionality
var clearBtn = document.getElementById("Clear");
clearBtn.onclick = function() {
    document.getElementById('PurchaseForm').reset(); // Reset the form
    document.getElementById('iconPreview').src = '../resources/default_icon.png'; // Reset icon preview
};
closeBtn.onclick = function() {
    formClosedWithoutSubmission = true; // Set the flag to indicate form was closed without submission
    modal.style.display = "none";
}



// Function to validate required fields

function validateForm() {
    const errors = [];
    
    // Check for required fields
    const itemType = document.getElementById('itemType').value;
    const pricePerUnit = document.getElementById('pricePerUnit').value.trim();
    const brandName = document.getElementById('brandName').value.trim();
    const genericName = document.getElementById('genericName').value.trim();
    const mass = document.getElementById('mass').value.trim();
    const unitOfMeasure = document.getElementById('unitOfMeasure').value;
    const productCode = document.getElementById('productCode').value.trim();
    
    if (!itemType) errors.push("Item Type is required.");
    if (!pricePerUnit) errors.push("Price Per Unit is required.");
    if (!brandName) errors.push("Brand Name is required.");
    if (!genericName) errors.push("Generic Name is required.");
    if (!mass) errors.push("Mass is required.");
    if (!unitOfMeasure) errors.push("Unit of Measure is required.");
    if (!productCode) errors.push("Product Code is required.");
    if (!Discount) errors.push("Discount is required.");

    return errors;
}


// HANDLE BOTH ADDING AND UPDATING


// Handle form submission

// Add event listener for form submission
// Add event listener for "New Product" button
// Disable the InStock field when the New Product button is clicked
document.getElementById('addProductButton').addEventListener('click', function() {
    // Disable the InStock field
    document.getElementById('inStockInput').disabled = true; // Change 'inStockInput' to the correct ID of your InStock input field
    
    // Optional: Reset the InStock input value if needed
    document.getElementById('inStockInput').value = ''; // This will clear the field, uncomment if needed
});


const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

// UPDATE AND ADDING

// Add event listener for form submission
// Add event listener for form submission
document.getElementById('PurchaseForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Validate form fields
    const validationErrors = validateForm();
    if (validationErrors.length > 0) {
        showError(validationErrors.join(" ")); // Show errors in a single message
        return; // Stop submission if there are errors
    }

    const form = document.getElementById('PurchaseForm');
    const formData = new FormData(form);

    // Ensure ItemID is included in the form data if in edit mode
    if (isEditMode) {
        formData.append('itemID', document.getElementById('itemID').value);
        
        // If icon was not changed, remove ProductIcon from FormData
        if (!document.getElementById('iconFile').hasAttribute('data-changed')) {
            formData.delete('ProductIcon');
        }
    } else {
        // For adding a new product, set a default value for InStock to 0
        formData.append('InStock', 0); // Automatically set InStock to 0
    }

    // Get values from input fields for validation
    const mass = parseFloat(document.getElementById('mass').value);
    const pricePerUnit = parseFloat(document.getElementById('pricePerUnit').value.replace('₱ ', '').trim());
    const inStock = parseInt(formData.get('InStock'), 10); // Get the value of InStock from formData
    const discount = parseInt(document.querySelector('select[name="Discount"]').value, 10); // Ensure correct fetching of discount
    const vatExempted = parseInt(document.getElementById('VAT_exempted').value, 10); // Get VAT exempted value

    // Validate mass, pricePerUnit, and InStock for negative values
    if (mass < 0) {
        showError('Mass cannot be negative.');
        return;
    }
    if (pricePerUnit < 0) {
        showError('Price per unit cannot be negative.');
        return;
    }
    if (isNaN(inStock) || inStock < 0) {
        showError('In Stock must be a non-negative number.');
        return;
    }

    // Update discount validation to allow value 0 (Unavailable)
    if (isNaN(discount)) { // Check if discount is not a number (i.e., no option selected)
        showError('Please select a discount option.');
        return;
    }

    // Validate VAT exempted value
    if (isNaN(vatExempted)) {
        showError('Please select a VAT exemption option.');
        return;
    }

    // Prepare to send the request
    const url = isEditMode ? 'updateInventory.php' : 'insertInventory.php'; // Use update script if in edit mode

    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show confirmation modal on success
                const confirmationModal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                document.getElementById('modalVerifyTitle').textContent = 'Success';
                document.getElementById('modalVerifyText').textContent = isEditMode ? 
                    'Product has been updated successfully!' : 'Product has been added successfully!';
                confirmationModal.show();

                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = 'inventory.php'; // Redirect on success
                }, 1000);
            } else {
                showError('Error saving product: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
        });
});





// Function to load form data for editing
function loadFormForEdit(item) {
    isEditMode = true; // Set to edit mode
    currentItemId = item.ItemID;

    document.getElementById('itemID').value = item.ItemID; // Set ItemID field as read-only
    document.getElementById('productCode').value = item.ProductCode;
    document.getElementById('genericName').value = item.GenericName;
    document.getElementById('brandName').value = item.BrandName;
    document.getElementById('itemType').value = item.ItemType;
    document.getElementById('mass').value = item.Mass;
    document.getElementById('unitOfMeasure').value = item.UnitOfMeasure;
    document.getElementById('pricePerUnit').value = item.PricePerUnit;
    document.getElementById('Discount').value = item.Discount;
    document.getElementById('VAT_exempted').value = item.VAT_exempted; // Set VAT_exempted field
    document.getElementById('inStockInput').value = item.InStock; // Use the correct ID for InStock input


    // Enable the In Stock field for editing
    document.getElementById('inStockInput').disabled = false; 

    // Set the icon preview
    document.getElementById('iconPreview').src = item.ProductIcon || '../resources/img/add_icon.png'; // Use default if no icon

    modal.style.display = "block"; // Show the modal
}
















//Handle Image//


// Function to preview the selected image
function previewImage(event) {
    const iconPreview = document.getElementById('iconPreview');
    const file = event.target.files[0]; // Get the selected file

    if (file) {
        const reader = new FileReader();
        
        // Set up the reader to update the image preview
        reader.onload = function(e) {
            iconPreview.src = e.target.result; // Update the image source with the file data
        }

        // Read the file as a Data URL
        reader.readAsDataURL(file);
    } else {
        // If no file is selected, set the default icon
        iconPreview.src = "../resources/img/add_icon.png";
    }
}

// Add event listener to the file input to trigger the image preview
document.getElementById('iconFile').addEventListener('change', previewImage);





//CLOSING FORM

// Function to close the form/modal
document.getElementById('closeBtn').addEventListener('click', function(event) {
    console.log('Close button clicked'); // Check if this logs
    event.preventDefault(); // Prevent any default behavior
    document.getElementById('myForm').style.display = 'none'; // Hide the form/modal
});

// Stop form submission if the close button is clicked
document.getElementById('closeBtn').addEventListener('click', function(event) {
    event.stopPropagation(); // Stop the click event from bubbling up to the form
});


// CLOSING FORM









// Function to show errors
function showError(message) {
    console.error(message);
    const notificationMessage = document.getElementById("notificationMessage");
    const notification = document.getElementById("notification");
    
    notificationMessage.textContent = message; // Set the error message
    notification.style.display = "block"; // Show the notification

    // Add event listener to the close button
    document.getElementById("closeNotification").addEventListener("click", closeError);
}


function closeError() {
    const notification = document.getElementById("notification");
    notification.style.display = "none"; // Hide the notification
}



// Function to handle update button click
function handleUpdate(itemId) {
    if (!itemId) {
        showError('Error: ItemID is missing.');
        return;
    }

    // Log the itemId for debugging
    console.log('Fetching data for ItemID:', itemId);

    fetch(`getProduct_data.php?itemID=${encodeURIComponent(itemId)}`)
        .then(response => {
            // Check if the response is OK
            if (response.ok) {
                // Check if the response is JSON
                const contentType = response.headers.get('Content-Type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error(`Unexpected response: ${text}`);
                    });
                }
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .then(data => {
            // Log the data for debugging
            console.log('Fetched data:', data);

            if (data.success) {
                loadFormForEdit(data.data); // Load item data into the form
            } else {
                showError('Error fetching product data: ' + data.message);
            }
        })
        .catch(error => {
            showError('An error occurred while fetching the product data.');
        });
}


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

// Function to update the table with new data
function updateTable(items) {
    var tableBody = document.getElementById('tableBody');
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
                <td class="text-center text-truncate">₱ ${item.PricePerUnit}</td>
                <td class="text-center text-truncate">${item.InStock}</td>
                <td class="text-center text-truncate">${item.Ordered}</td>
                <td class="text-center">
                <img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer; display: inline-block; width: 15px;" onclick="handleUpdate('${item.ItemID}')" />
                <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer; display: inline-block; width: 15px; margin-left: 10px;" onclick="showDeleteOptions('${item.ItemID}')" />
    </td>
        `;

        tableBody.appendChild(row);
    });
        //<td style="text-align: center;">${item.Status}</td>
        //img class="update-btn" onclick="handleUpdate(${item.ItemID})">Update</button>
        //<img class="delete-btn" onclick="handleDelete(${item.ItemID})">Delete</button>
    setDataTables(); // Reinitialize DataTables
}

// Function to handle delete operation
function handleDelete(itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
        fetch(`deleteProduct.php?itemID=${encodeURIComponent(itemId)}`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    loadInventory(); // Reload the inventory table
                    location.reload();
                } else {
                    showError('Error deleting product: ' + data.message);
                }
            })
            .catch(error => {
                showError('An error occurred while deleting the product.');
            });
    }
}

// Function to load inventory data and refresh the table
function loadInventory() {
    console.log("Loading inventory..."); // Debugging line to check if this function is called
    fetch('getProduct_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTable(data.data); // Update the table with fetched data
            } else {
                showError('Error fetching inventory data: ' + data.message);
            }
        })
        .catch(error => {
            showError('An error occurred while loading inventory data.');
        });
}

// Load inventory when the page loads
window.onload = loadInventory;


//////////////////////////Archive//////////////////////////////////
const overlayAD = document.getElementById('overlayAD');
const closeBtnAD = document.getElementById('closeBtnAD');
const archiveUserBtn = document.getElementById('archiveUserBtn');
const modalYes = document.getElementById('modalYes');
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');

let selectedItemID = '';  // Store the selected product ID
let modalStatus = '';  // To store the status of the modal action

// Function to show the overlayAD modal
function showDeleteOptions(ItemID) {
    selectedItemID = ItemID;  // Store the selected item ID
    overlayAD.style.display = 'flex';  // Show the overlay
}

// Event listener for archive button click
archiveUserBtn.addEventListener('click', function () {
    modalVerifyTextAD.textContent = 'Are you sure you want to archive this product?';
    modalStatus = 'archive';  // Set the modal status to 'archive'
    
});

// Event listener for 'Yes' button in the modal
modalYes.addEventListener('click', function () {
    if (modalStatus === 'archive') {
        if (!selectedItemID || selectedItemID.trim() === '') {
            alert('No product selected.');
            return;
        }

        // Sending the archive request via fetch API
        fetch('ArchivingProd.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ itemID: selectedItemID }) // Sending itemID
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Product not found.');
                } else if (response.status === 500) {
                    throw new Error('Server error. Please try again later.');
                } else {
                    throw new Error('Error: ' + response.statusText);
                }
            }
            return response.json();
        })
        .then(data => {
            modalVerifyTextAD.textContent = data.message; // Display the response message
            modalFooterAD.style.display = 'none';
            modalCloseAD.style.display = 'none';
            modalVerifyTextAD.textContent = 'Product has been archived successfully!';
            document.getElementById('modalVerifyTitle-AD').textContent = 'Success';

            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = '../inventory/ArchiveProduct/ArchiveProd.php'; // Adjust URL if necessary
            }, 1000);
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
});


// Event listener for close button (x) inside the modal
closeBtnAD.addEventListener('click', function () {
    overlayAD.style.display = 'none'; // Hide the overlay when the close button is clicked
    document.getElementById('disablebackdrop-AD').style.display = 'none'; // Hide the modal
});

// Optional: Click anywhere outside the modal to close it
window.addEventListener('click', function (event) {
    if (event.target === overlayAD) {
        overlayAD.style.display = 'none'; // Hide the modal if clicked outside of it
        document.getElementById('disablebackdrop-AD').style.display = 'none'; // Hide the modal
    }
});

// Redirect to archived users page
const toArchivedUsers = document.getElementById('toArchivedUsers');
toArchivedUsers.addEventListener('click', function () {
    window.location.href = 'ArchiveProduct/ArchiveProd.php';
});

// End of Archive


// ECONOMIC ORDER QUANTITY //


// Function to truncate text
function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...'; // Append ellipsis
    }
    return text; // Return the original text if it's short enough
}

function checkLowStock() {
    $.ajax({
        url: 'checkLowStock.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error("Error: " + data.error);
                displayMessage('Error retrieving low stock items.');
                return;
            }

            const lowStockItemsBody = document.getElementById('lowStockItemsBody');
            lowStockItemsBody.innerHTML = ''; // Clear previous messages

            // Filter to find low stock items
            const lowStockItems = data.filter(item => {
                const inStock = parseInt(item.InStock, 10);
                const ordered = parseInt(item.Ordered, 10);
                const reorderLevel = ordered * 0.5;
                return inStock <= reorderLevel;
            });

            if (lowStockItems.length > 0) {
                lowStockItems.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="table-row">${truncateText(item.BrandName, 20)}</td>
                        <td class="table-row">${truncateText(item.GenericName, 20)}</td>
                        <td class="table-row low-stock">${item.InStock}</td>
                        <td class="table-row">${item.Ordered}</td>
                    `;
                    lowStockItemsBody.appendChild(row);
                });
                openModal(); // Open the modal to display the messages
            } else {
                displayMessage('All items are sufficiently stocked.');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + error);
            displayMessage('Error connecting to server.');
        }
    });
}

// Function to open the modal
function openModal() {
    document.getElementById('lowStockModal').style.display = 'block';
}

// Function to close the modal
function closeModal() {
    document.getElementById('lowStockModal').style.display = 'none';
}

// Add event listener to the button to check low stock
document.getElementById('checkLowStockButton').addEventListener('click', function() {
    console.log('Check Low Stock Button Clicked'); // Add this line
    checkLowStock();
});

// Get the <span> element that closes the modal
const closeModalButton = document.getElementsByClassName("closeAlert")[0];

// When the user clicks on <span> (x), close the modal
closeModalButton.onclick = function() {
    closeModal();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    const modal = document.getElementById('lowStockModal');
    if (event.target === modal) {
        closeModal();
    }
}