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


function showOverlay() {
    document.getElementById('userForm').reset();
    overlay.style.display = 'flex';
}
function showEditOverlay() {
    selectedUser = row.accountName;
    overlayEdit.style.display = 'flex';
}



function hideOverlay() {
    overlay.style.display = 'none';
}

function closeOverlay() {
    const isFormFilled = companyName.value.trim() !== '' || ContactNo.value.trim() !== '' || Email.value.trim() !== '';

    if (isFormFilled) {
        if (confirm("Are you sure you want to close the form? Any unsaved changes will be lost.")) {
            document.getElementById('userForm').reset();
            hideOverlay();
        }
    } else {
        hideOverlay();
    }
}
// Close the edit overlay
function closeEditOverlay() {
    document.getElementById('userFormEdit').reset(); // Resetting the form
    document.getElementById('overlayEdit').style.display = "none";
}


addUserBtn.addEventListener('click', showOverlay);
closeBtn.addEventListener('click', closeOverlay);
closeBtnEdit.addEventListener('click', closeEditOverlay);


// Function to close the overlay
function closeOverlay() {
    document.getElementById('overlay').style.display = 'none'; // Close add overlay
    document.getElementById('overlayEdit1').style.display = 'none'; // Close edit overlay
}



// Function to close the Add overlay
function closeAddOverlay() {
    document.getElementById('overlay').style.display = 'none'; // Close the add overlay
}

// Function to close the Edit overlay
function closeEditOverlay() {
    document.getElementById('overlayEdit1').style.display = 'none'; // Close the edit overlay
}

// Example function to show the Add overlay (if needed)
function showAddOverlay() {
    document.getElementById('overlay').style.display = 'flex'; // Show the add overlay
}

// Example function to show the Edit overlay (if needed)
function showEditOverlay() {
    document.getElementById('overlayEdit1').style.display = 'flex'; // Show the edit overlay
}


// Get reference to the form element
const form = document.getElementById('userForm');

// Function to clear the form and preview when submitted
function handleFormSubmit1() {
    // Hide overlay and reset the form
    closeOverlayEdit1();
}

// Function to close the overlay for editing supplier
function closeOverlayEdit1() {
    const overlayEdit1 = document.getElementById('overlayEdit1');
    if (overlayEdit1) {
        overlayEdit1.style.display = "none"; // Hides the overlay
    }
    // Reset form fields to their initial values
    document.getElementById('userFormEdit').reset(); // Reset form fields
}

// Function to close the general overlay
function closeOverlay() {
    const overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.style.display = "none"; // Hides the overlay
    }
}

// Add event listener to the Cancel button
document.getElementById('cancelBtn').addEventListener('click', closeOverlayEdit1);

// Handle DOMContentLoaded event to set up close button for editing
document.addEventListener("DOMContentLoaded", function () {
    const closeBtnEdit = document.getElementById('closeBtnEdit');
    if (closeBtnEdit) {
        closeBtnEdit.addEventListener('click', closeOverlayEdit1); // Call the function to close the overlay
    }
});

document.getElementById('userFormEdit').addEventListener('submit', handleFormSubmit1);

//Handles Updating the forms

function handleUpdate(supplierID) {
    console.log('Updating Supplier ID:', supplierID);

    fetch(`getSupplierData.php?supplierID=${supplierID}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched Data:', data);
            if (data.success) {
                // Populate the form fields with the fetched data
                document.getElementById('edit_newID').value = data.supplier.SupplierID; // Populate Supplier ID
                document.getElementById('edit_companyName').value = data.supplier.SupplierName; // Populate Company Name
                document.getElementById('edit_agentName').value = data.supplier.AgentName; // Populate Agent Name
                document.getElementById('edit_ContactNo').value = data.supplier.Phone; // Populate Contact No
                document.getElementById('edit_Email').value = data.supplier.Email; // Populate Email
                document.getElementById('edit_Notes').value = data.supplier.Notes; // Populate Notes

                // Show the overlay for editing
                document.getElementById('overlayEdit1').style.display = 'block';
            } else {
                console.error('Error fetching supplier data:', data.message);
                alert('Error fetching supplier data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
            alert('An error occurred while fetching supplier data.');
        });
}


// Updating THE FORM ////////////////////////////////////////////////////////////////////////////////////


// Updating the form for supplier update

function handleFormSubmit1(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(document.getElementById('userFormEdit'));

    fetch('updateSupplier.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            setTimeout(() => {
                window.location.href = 'suppliers.php'; // Redirect on success
            }, 1000);

        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


// END OF UPDATE


// Attaching the event listener for the edit form submission

// Function to close the overlay (if needed)
function closeEditOverlay() {
    overlayEdit.style.display = 'none'; // Hide the overlay
}


//Adding New Supplier
document.getElementById('userForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('addData.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);

            if (data.success) {
                setTimeout(() => {
                    window.location.href = 'suppliers.php'; // Redirect on success
                }, 1000);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
        });
});



// Example error display function
function showError(message) {
    alert(message); // Simple alert for demonstration
}


// Load the data
function updateTable(data) {
    const table = $('#example').DataTable();
    table.clear();

    data.forEach(row => {
        table.row.add([
            `SP-0${row.SupplierID}`,
            `${row.SupplierName.slice(0, 15)}...`, // Truncate Company Name
            `${row.AgentName.slice(0, 10)}...`, // Truncate Agent Name
            `${row.Phone}`,
            `${row.Email.slice(0, 15)}...`, // Truncate Email
            `<div style="text-align: center;">
                <img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer; margin-left:10px;" onclick="handleUpdate('${row.SupplierID}')" />
                <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer; margin-left:10px;" onclick="showDeleteOptions('${row.SupplierID}')" />
            </div>`
        ]);
    });

    table.draw();
}


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


//Fetch data on DATABASE
document.addEventListener('DOMContentLoaded', () => {
    fetch('getAllData.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => alert('Error fetching users data:', error));
    setDataTables();
});




//Auto increment
let VnewID = 0;
const newID = document.getElementById('newID');
addUserBtn.addEventListener('click', function (event) {
    showOverlay();
    fetch('getNewID.php')
        .then(response => response.json())
        .then(data => {
            if (data.nextAutoIncrement) {
                VnewID = parseInt(data.nextAutoIncrement);
                newID.value = VnewID;
            } else {
                console.error('No nextAutoIncrement found in the response.');
            }
        })
        .catch(error => console.error('Error fetching data:', error));
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
    window.location.href = 'ArchiveSupplier/ArchiveSupplier.php';
});
