//Form fields
const addUserBtn = document.getElementById('addUser');
const overlay = document.getElementById('overlay');
const overlayEdit = document.getElementById('overlayEdit');
const overlayAD = document.getElementById('overlayAD');
const closeBtn = document.getElementById('closeBtn');
const closeBtnEdit = document.getElementById('closeBtnEdit');
const closeBtnAD = document.getElementById('closeBtnAD');
const companyName = document.getElementById('companyName');
const agentName = document.getElementById('agentName');
const ContactNo = document.getElementById('ContactNo');
const Email = document.getElementById('Email');
//EditForm fields
const currentEmployeeID = document.getElementById('currentEmployeeID');
const employeeNameEdit = document.getElementById('employeeNameEdit');
const employeeLNameEdit = document.getElementById('employeeLNameEdit');
const roleEdit = document.getElementById('roleEdit');
const accountNameEdit = document.getElementById('accountNameEdit');
const passwordEdit = document.getElementById('passwordEdit');
const AccountID = document.getElementById('AccountID');
const deleteUserBtn = document.getElementById('deleteUserBtn');
//etc
const usersNum = document.getElementById('usersNum');
const tableBody = document.getElementById('tableBody');
const selectedTest = document.getElementById('selectedTest');
const optUserBtn = document.getElementById('optionsUser');
const searchInput = document.getElementById('searchInput');
// const overlayText = document.getElementById('overlayText');
// const headingPopupText = document.getElementById('headingPopupText');
// const popupText = document.getElementById('popupText');
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

let currentlySelectedRow = null;


// Show the Add overlay
function showOverlay() {
    document.getElementById('userForm').reset();
    overlay.style.display = 'flex';
}

// Show the Edit overlay
function showEditOverlay() {
    selectedUser = row.accountName;
    overlayEdit.style.display = 'flex';
}

// Hide the Add overlay
function hideOverlay() {
    overlay.style.display = 'none';
}

// Close the Add overlay with confirmation if fields are filled
function closeOverlay() {
    const isFormFilled = companyName.value.trim() !== '' || ContactNo.value.trim() !== '' || Email.value.trim() !== '';
    if (isFormFilled) {
        document.getElementById('userForm').reset();
        hideOverlay();
    } else {
        hideOverlay();
    }
}

// Close the Edit overlay without clearing the form
function closeEditOverlay() {
    const overlayEdit1 = document.getElementById('overlayEdit1');
    if (overlayEdit1) {
        overlayEdit1.style.display = "none"; // Close edit overlay
    }
}

// Close general overlay function
function closeOverlayEdit1() {
    const overlayEdit1 = document.getElementById('overlayEdit1');
    if (overlayEdit1) {
        overlayEdit1.style.display = "none"; // Hides the overlay
    }
}

// Add event listeners for buttons
document.addEventListener("DOMContentLoaded", function () {
    const closeBtnEdit = document.getElementById('closeBtnEdit');
    if (closeBtnEdit) {
        closeBtnEdit.addEventListener('click', closeOverlayEdit1); // Call the function to close the overlay
    }

    const closeBtn = document.getElementById('closeBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeOverlay); // Call the function to close the overlay
    }

    const cancelBtn = document.getElementById('cancelBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeEditOverlay); // Call the function to close the edit overlay
    }
});

document.getElementById('userFormEdit').addEventListener('submit', handleFormSubmit1);

function updateTable(data) {
    const table = $('#example').DataTable();
    table.clear();

    data.forEach(row => {
        console.log('Adding row:', row); // Log the current row data

        table.row.add([
            `SP-0${row.SupplierID}`,
            // `${row.SupplierName.slice(0, 13)}...`, // Truncate Company Name
            // `${row.AgentName.slice(0, 10)}...`, // Truncate Agent Name
            `${row.SupplierName}`,
            `${row.AgentName}`,
            `${row.Phone}`,
            `${row.Email.slice(0, 10)}...`, // Truncate Email
            `<div style="text-align: center;">
                <img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer; margin-left:10px;" onclick="handleUpdate('${row.SupplierID}'); console.log('Edit clicked for Supplier ID:', '${row.SupplierID}')" />
                <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer; margin-left:10px;" onclick="showDeleteOptions('${row.SupplierID}')" />
            </div>`
        ]);
    });

    table.draw();
}


function setDataTables() {
    const table = $('#example').DataTable({
        "order": [], // Disable initial sorting
        "autoWidth": false, // Disable automatic column width calculation
        "responsive": true, // Enable responsiveness
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

    // Adjust table layout on window resize
    $(window).on('resize', function () {
        table.columns.adjust().draw(); // Redraw the DataTable to adjust the columns
    });
}


// Fetch data from the database
document.addEventListener('DOMContentLoaded', () => {
    fetch('getAllData.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => console.log('Error fetching users data:', error));
    setDataTables();
});

// Auto increment
let VnewID = 0;
const newID = document.getElementById('newID');
addUserBtn.addEventListener('click', function (event) {
    const checkboxes = document.querySelectorAll('.product-checkbox:checked'); // Select checked checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.checked = false; // Uncheck the checkbox
    });
    showOverlay();
    fetch('getNewID.php')
        .then(response => response.json())
        .then(data => {
            if (data.nextAutoIncrement) {
                VnewID = parseInt(data.nextAutoIncrement);
                newID.value = 'SP-0' + VnewID;
            } else {
                console.error('No nextAutoIncrement found in the response.');
            }
        })
        .catch(error => console.error('Error fetching new ID:', error));
});

//////////////////////////Archive//////////////////////////////////

const archiveUserBtn = document.getElementById('archiveUserBtn');
const modalYes = document.getElementById('modalYes');
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');

let modalStatus = '';  // To store the status of the modal action
let selectedSupplierID = null;

// Function to show the overlayAD modal
function showDeleteOptions(SupplierID) {
    selectedSupplierID = SupplierID;  // Store the selected item ID
    overlayAD.style.display = 'flex';  // Show the overlay
}

// Event listener for archive button click
archiveUserBtn.addEventListener('click', function () {
    modalVerifyTextAD.textContent = 'Are you sure you want to archive this supplier?';
    modalStatus = 'archive';  // Set the modal status to 'archive'

});

// Event listener for 'Yes' button in the modal
modalYes.addEventListener('click', function () {
    if (modalStatus === 'archive') {
        if (!selectedSupplierID || selectedSupplierID.trim() === '') {
            alert('No supplier selected.');
            return;
        }

        // Sending the archive request via fetch API
        fetch('ArchivingSuppliers.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ SupplierID: selectedSupplierID }) // Sending itemID
        })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Supplier not found.');
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
                modalVerifyTextAD.textContent = 'Supplier has been archived successfully!';
                document.getElementById('modalVerifyTitle-AD').textContent = 'Success';

                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php'; // Adjust URL if necessary
                }, 1000);
            })
            .catch(error => {
                console.error('Error:', error.message);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + error.message;
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
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
    window.location.href = 'ArchiveSupplier/ArchiveSupplier.php';
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////TABLES FOR THE PRODUCT OF THE SUPPLIER //////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

let selectedProducts = []; // Initialize as an empty array
let productList = []; // Array to store all fetched products


let currentPage = 1; // Current page for pagination
const productsPerPage = 10; // Number of products to show per page




// Function to handle form submission
// Debugging function to log detailed error information
function debugError(error) {
    console.error('Debug Information:', {
        message: error.message,
        stack: error.stack,
        time: new Date().toISOString()
    });
}


function handleFormSubmit(event) {
    event.preventDefault(); // Prevent default form submission

    // Collect selected products
    const selectedProducts = []; // Reset the array
    const checkboxes = document.querySelectorAll('.product-checkbox'); // Select all checkboxes
    checkboxes.forEach(checkbox => {
        const productId = checkbox.getAttribute('data-id');
        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Push selected product IDs with value 1 if checked
            selectedProducts.push({ productId: productId, value: 1 });
        } else {

        }
    });

    const formData = new FormData(event.target);
    // Add selected products to formData
    formData.append('selectedProducts', JSON.stringify(selectedProducts)); // Append to form data

    fetch('addData.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok'); // Handle non-2xx responses
            }
            return response.json(); // Attempt to parse as JSON
        })
        .then(data => {
            if (data.success) {
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'Supplier has been added successfully!';
                document.getElementById('modalVerifyTitle').textContent = 'Success';

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 1000);
            } else {
                console.error('Error:', data.message);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + data.message;
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
            // Update modal content
            document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + error.message;
            document.getElementById('modalVerifyTitle').textContent = 'Error';
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            modal.show();

            // Redirect on success after a short delay
            setTimeout(() => {
                window.location.href = 'suppliers.php';
            }, 2000);
        });
}

$(document).ready(function () {
    fetchProductData(); // Fetch product data on page load
});

function fetchProductData() {
    fetch('FetchProducts.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                const products = data.products;

                // Destroy existing DataTable instance before reinitializing
                if ($.fn.DataTable.isDataTable('#productTable')) {
                    $('#productTable').DataTable().clear().destroy();
                }

                // Initialize DataTable with product data
                $('#productTable').DataTable({
                    "data": products,
                    "columns": [
                        {
                            "data": "ItemID",
                            "render": function (data) {
                                return `<input type="checkbox" class="product-checkbox" data-id="${data}" />`;
                            }
                        }, // Checkbox
                        { "data": "BrandName", render: data => data.length > 20 ? data.substring(0, 20) + '...' : data },
                        { "data": "GenericName", render: data => data.length > 20 ? data.substring(0, 20) + '...' : data },
                        { "data": "PricePerUnit", render: data => data.toFixed(2) }
                    ],
                    "order": [],
                    "responsive": true,
                    "paging": true,
                    "lengthChange": false,
                    "pageLength": 3,
                    "searching": true,
                    "info": true,
                    "language": {
                        "info": "Showing _TOTAL_ entries",
                        "infoEmpty": "No entries available",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "dom": 'lfrtip',
                    "pagingType": "full_numbers"
                });
            } else {
                console.error('Error:', data.message);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'Error fetching products: ' + data.message;
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
            // Update modal content
            document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + error.message;
            document.getElementById('modalVerifyTitle').textContent = 'Error';
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            modal.show();

            // Redirect on success after a short delay
            setTimeout(() => {
                window.location.href = 'suppliers.php';
            }, 2000);
        });
}

function initializeDataTable() {
    $('#productTable').DataTable({
        "order": [], // Disable initial sorting
        "responsive": true, // Enable responsiveness
        "paging": true, // Enable DataTables default pagination
        "lengthChange": false, // Disable page length changing
        "pageLength": 3, // Set number of entries per page to 3
        "searching": true, // Enable the search bar
        "info": true, // Enable info about records
        "language": {
            "info": "Showing _TOTAL_ entries", // Customize info message
            "infoEmpty": "No entries available", // Message when no entries exist
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "dom": 'lfrtip', // Show table with pagination controls
        "pagingType": "full_numbers", // Show full pagination controls
        "columnDefs": [
            { "targets": 0, "width": "5%", "orderable": false }, // Select column (checkbox)
            { "targets": 1, "width": "30%", "orderable": false }, // Brand Name (sortable)
            { "targets": 2, "width": "25%", "orderable": false }, // Generic Name (sortable)
            { "targets": 3, "width": "20%", "orderable": true }  // Price (sortable)
        ]
    });

    // Adjust table layout on window resize
    $(window).on('resize', function () {
        $('#productTable').DataTable().columns.adjust(); // Adjust the column widths on resize
    });
}

////////////////////////////////////////////////////////////////////////////
////Updating The Suppliers/////////////////////////////////////////////////


function handleFormSubmit1(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(document.getElementById('userFormEdit'));

    // Collect selected products
    const selectedProducts = []; // Reset the array
    const checkboxes = document.querySelectorAll('.product-checkbox'); // Select all checkboxes
    checkboxes.forEach(checkbox => {
        const productId = checkbox.getAttribute('data-id');
        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Push selected product IDs with value 1 if checked
            selectedProducts.push({ productId: productId, value: 1 });
        } else {
            // Push product IDs with value 0 if unchecked
            selectedProducts.push({ productId: productId, value: 0 });
        }
    });

    // Add selected products to formData
    formData.append('selectedProducts', JSON.stringify(selectedProducts)); // Append to form data

    fetch('updateSupplier.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => {
                    // Update modal content
                    document.getElementById('modalVerifyText').textContent = 'Supplier has been updated successfully!';
                    document.getElementById('modalVerifyTitle').textContent = 'Success';

                    // Show the modal if it exists
                    const modalElement = document.getElementById('disablebackdrop');
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();

                        // Redirect after a short delay to allow the modal to be visible
                        setTimeout(() => {
                            window.location.href = 'suppliers.php';
                        }, 1000);
                    } else {
                        // If the modal doesn't exist, fallback to direct redirection
                        window.location.href = 'suppliers.php';
                    }
                }, 1000);
            } else {
                console.error('Error:', data.message);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'An error has occured. Ensure that fields are unique from other suppliers.';
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Update modal content
            document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + error.message;
            document.getElementById('modalVerifyTitle').textContent = 'Error';
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            modal.show();

            // Redirect on success after a short delay
            setTimeout(() => {
                window.location.href = 'suppliers.php';
            }, 2000);
        });
}

let CurrentSupplierID; // Declare the variable globally

// Function to select a supplier
function selectSupplier(supplierID) {
    CurrentSupplierID = supplierID; // Set the current SupplierID
    handleUpdate(CurrentSupplierID); // Call the update function with the selected SupplierID
}


// Handle the supplier update
function handleUpdate(supplierID) {
    console.log('Updating Supplier ID:', supplierID);

    fetch(`getSupplierData.php?supplierID=${supplierID}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched Data:', data);
            if (data.success && data.supplier) {
                // Populate form fields with supplier data
                document.getElementById('edit_newID').value = data.supplier.SupplierID || '';
                document.getElementById('edit_companyName').value = data.supplier.SupplierName || '';
                document.getElementById('edit_agentName').value = data.supplier.AgentName || '';
                document.getElementById('edit_ContactNo').value = data.supplier.Phone || '';
                document.getElementById('edit_Email').value = data.supplier.Email || '';

                // Show the overlay for editing
                const overlay = document.getElementById('overlayEdit1');
                if (overlay) {
                    overlay.style.display = 'flex'; // Make the overlay visible
                }

                // Fetch products related to this supplier and update the checkboxes
                fetchProductDataTwo(supplierID); // Directly use the supplierID
            } else {
                console.error('Error:', data.message);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'Error fetching supplier data: ' + data.message;
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
            // Update modal content
            document.getElementById('modalVerifyText').textContent = 'An error has occured while fetching supplier data: ' + error.message;
            document.getElementById('modalVerifyTitle').textContent = 'Error';
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            modal.show();

            // Redirect on success after a short delay
            setTimeout(() => {
                window.location.href = 'suppliers.php';
            }, 2000);
        });
}



function fetchProductDataTwo(supplierID) {
    fetch(`FetchProductUpdate.php?supplierID=${supplierID}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Fetched Products Data:', data); // Log the response data

            if (data.success && Array.isArray(data.products)) {
                const products = data.products;

                // Initialize or clear the DataTable
                let table;
                if ($.fn.DataTable.isDataTable('#productTableUpdate')) {
                    table = $('#productTableUpdate').DataTable();
                    table.clear(); // Clear existing data
                } else {
                    initializeDataTableUpdate();
                    table = $('#productTableUpdate').DataTable();
                }

                // Check if there are any products to display
                if (products.length === 0) {
                    $('#productTableUpdateBody').html(`<tr><td colspan="4" style="text-align: center;">No products available.</td></tr>`);
                } else {
                    // Loop through each product and add to DataTable
                    products.forEach(product => {
                        console.log('Adding product:', product); // Log each product being added
                        console.log('Product object:', product); // Log the entire product object

                        // Determine if the checkbox should be checked based on SupplierID
                        const isChecked = product.SupplierID == supplierID ? 'checked' : ''; // Use loose equality to avoid type issues

                        // Log the comparison
                        console.log(`Comparing SupplierID: ${product.SupplierID} with ${supplierID} => ${isChecked}`);

                        // Truncate function to limit string length and add ellipsis
                        function truncateString(str, maxLength) {
                            if (str.length > maxLength) {
                                return str.substring(0, maxLength) + '...';
                            }
                            return str;
                        }

                        // Usage in your code
                        const maxLength = 20; // Set your desired max length

                        const rowData = [
                            `<input type="checkbox" id="checkbox-${product.ItemID}" class="product-checkbox" data-id="${product.ItemID}" ${isChecked} />`,
                            truncateString(product.BrandName || 'N/A', maxLength),
                            truncateString(product.GenericName || 'N/A', maxLength),
                            product.PricePerUnit || '0.00' // Keep PricePerUnit as it is, no parsing
                        ];

                        // Add new row data to the DataTable
                        table.row.add(rowData);
                    });

                    // Draw the updated DataTable to show the new data
                    table.draw();
                    console.log('DataTable drawn with new data.'); // Log the draw action
                }
            } else {
                console.error('Error: products field is missing or not an array.', data);
                // Update modal content
                document.getElementById('modalVerifyText').textContent = 'Error fetching products: ' + data.message;
                document.getElementById('modalVerifyTitle').textContent = 'Error';
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
                modal.show();

                // Redirect on success after a short delay
                setTimeout(() => {
                    window.location.href = 'suppliers.php';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
            // Update modal content
            document.getElementById('modalVerifyText').textContent = 'An error has occured: ' + error.message;
            document.getElementById('modalVerifyTitle').textContent = 'Error';
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            modal.show();

            // Redirect on success after a short delay
            setTimeout(() => {
                window.location.href = 'suppliers.php';
            }, 2000);
        });
}




function initializeDataTableUpdate() {
    const table = $('#productTableUpdate').DataTable({
        "order": [],
        "responsive": true,
        "paging": true,
        "lengthChange": false,
        "pageLength": 4,
        "searching": true,
        "info": true,
        "language": {
            "info": "Showing _TOTAL_ entries",
            "infoEmpty": "No entries available",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "dom": 'lfrtip',
        "pagingType": "full_numbers",
        "columnDefs": [
            { "targets": 0, "width": "5%", "orderable": false },
            { "targets": 1, "width": "30%", "orderable": false },
            { "targets": 2, "width": "25%", "orderable": false },
            { "targets": 3, "width": "20%", "orderable": true }
        ]
    });

    $(window).on('resize', function () {
        table.columns.adjust(); // Adjust the column widths on resize
    });
}




// Fetch and update products based on the selected supplier
function fetchProductsForSupplier() {
    const supplierID = document.getElementById('supplierSelect').value;
    console.log("Fetching products for Supplier ID:", supplierID);
    if (supplierID) {
        fetchProductDataTwo(supplierID);
    } else {
        // Clear the DataTable if no supplier is selected
        const productTableBody = document.getElementById('productTableUpdateBody');
        productTableBody.innerHTML = '';
        if ($.fn.DataTable.isDataTable('#productTableUpdate')) {
            $('#productTableUpdate').DataTable().clear().destroy();
            console.log("DataTable cleared due to no supplier selected.");
        }
    }
}





//DATATABLES Adding START HERE



// Helper function to truncate text
function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...'; // Truncate and add ellipsis
    }
    return text; // Return original text if it's short enough
}
