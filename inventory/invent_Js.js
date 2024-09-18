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

// When the user clicks on the close button, close the modal
closeBtn.onclick = function() {
    formClosedWithoutSubmission = true; // Set the flag to indicate form was closed without submission
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         formClosedWithoutSubmission = true; // Set the flag to indicate form was closed without submission
//         modal.style.display = "none";
//     }
//     if (event.target == notification) {
//         notification.style.display = "none";
//     }
// }

// Get the Clear button
var clearBtn = document.getElementById("Clear");

// When the user clicks the Clear button, clear all text fields
clearBtn.onclick = function() {
    document.getElementById('PurchaseForm').reset(); // Reset the form
    document.getElementById('iconPreview').src = '../resources/default_icon.png'; // Reset icon preview
}

// Handle icon file selection
document.getElementById('iconFile').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('iconPreview').src = e.target.result;
            document.getElementById('iconFile').setAttribute('data-changed', 'true'); // Flag to indicate icon was changed
        };
        reader.readAsDataURL(file);
    } else {
        // Set the default icon if no file is selected
        document.getElementById('iconPreview').src = '../resources/default_icon.png';
        document.getElementById('iconFile').removeAttribute('data-changed'); // Remove the flag
    }
});

// Handle form submission (for both adding and updating)
document.getElementById('PurchaseForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    if (formClosedWithoutSubmission) {
        formClosedWithoutSubmission = false; // Reset the flag
        return;
    }

    const form = document.getElementById('PurchaseForm');
    const formData = new FormData(form);

    // Ensure ItemID is included in the form data
    if (isEditMode) {
        formData.append('itemID', document.getElementById('itemID').value);
        
        // If icon was not changed, remove ProductIcon from FormData
        if (!document.getElementById('iconFile').hasAttribute('data-changed')) {
            formData.delete('ProductIcon');
        }
    }

    const url = isEditMode ? 'updateInventory.php' : 'insertInventory.php'; // Use update script if in edit mode
    //if(url == "updateInventory.php" )
    //    {
    //        alert(url);
     //   }
    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
                modal.style.display = "none";
                loadInventory(); // Reload the inventory table
                location.reload();
            } else {
                showError('Error saving product: ' + data.message);
            }
        })
        .catch(error => {
            showError('An error occurred while saving the product.');
        });
});

// Function to show errors
function showError(message) {
    console.error(message);
    notificationMessage.textContent = message; // Set error message in the notification
    notification.style.display = "block";
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

// Function to load item data into the form for editing
function loadFormForEdit(item) {
    isEditMode = true;
    currentItemId = item.ItemID;

    document.getElementById('itemID').value = item.ItemID; // Set ItemID field as read-only
    document.getElementById('productCode').value = item.ProductCode;
    document.getElementById('genericName').value = item.GenericName;
    document.getElementById('brandName').value = item.BrandName;
    document.getElementById('itemType').value = item.ItemType;
    document.getElementById('mass').value = item.Mass;
    document.getElementById('unitOfMeasure').value = item.UnitOfMeasure;
    document.getElementById('pricePerUnit').value = item.PricePerUnit;
    //document.getElementById('status').value = item.Status;
    //document.getElementById('InStock').value = item.InStock;
    document.getElementById('Notes').value = item.Notes || ''; // Handle missing Notes

    // Set the icon preview
    document.getElementById('iconPreview').src = item.ProductIcon || '../resources/img/add_icon.png'; // Use default if no icon

    modal.style.display = "block";
}

// Function to initialize or reinitialize DataTables
function setDataTables() {
    if ($.fn.dataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy(); // Destroy the existing instance before reinitializing
    }

    $('#example').DataTable({
        "order": [], // Disable initial sorting
        "columnDefs": [
            { "targets": 0, "width": "8%" }, // Item ID
            { "targets": 1, "width": "10%", "orderable": false }, // Icon 
            { "targets": 2, "width": "10%" }, // Product Code
            { "targets": 3, "width": "10%" }, // Generic Name
            { "targets": 4, "width": "10%" }, // Brand Name
            { "targets": 5, "width": "10%" }, // Item Type
            { "targets": 6, "width": "10%" }, // Mass & Unit of Measure
            { "targets": 7, "width": "10%" }, // Price Per Unit
            //{ "targets": 8, "width": "10%" }, // Status
            { "targets": 8, "width": "10%" }, // In Stock
            { "targets": 9, "width": "12%", "orderable": false } // Actions
        ]
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
            <td style="text-align: center;">${item.ItemID}</td>
            <td style="text-align: center;"><img src="${item.ProductIcon}" alt="Icon" style="width: 50px; height: auto;"></td>
            <td style="text-align: center;">${item.ProductCode}</td>
            <td style="text-align: center;">${item.BrandName}</td>
            <td style="text-align: center;">${item.GenericName}</td>
            <td style="text-align: center;">${item.ItemType}</td>
            <td style="text-align: center;">${item.Mass} ${item.UnitOfMeasure}</td> <!-- Concatenated Mass and UnitOfMeasure -->
            <td style="text-align: center;">${item.PricePerUnit}</td>
            <td style="text-align: center;">${item.InStock}</td>
            <td style="text-align: center;">
                

            <img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer;margin-left:10px;" onclick="handleUpdate('${item.ItemID}')"/>
             <img src="../resources/img/s-remove2.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="handleDelete('${item.ItemID}')"/>
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
