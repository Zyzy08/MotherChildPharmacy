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
let selectedUser = null;

function showOverlay() {
    document.getElementById('userForm').reset();
    overlay.style.display = 'flex';
}
function showEditOverlay() {
    selectedUser = row.accountName;
    overlayEdit.style.display = 'flex';
}

function closeEditOverlay() {
    overlayEdit.style.display = 'none';
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

addUserBtn.addEventListener('click', showOverlay);
closeBtn.addEventListener('click', closeOverlay);
closeBtnEdit.addEventListener('click', closeEditOverlay);


// Get reference to the form element
const form = document.getElementById('userForm');

// Function to clear the form and preview when submitted
function handleFormSubmit() {
    // document.getElementById('userForm').reset();
    hideOverlay();
}

//Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getAllData.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => alert('Error fetching users data:', error));
    setDataTables();
});

function updateTable(data) {
    let counter = 0;
    const table = $('#example').DataTable();

    // Clear existing data
    table.clear();

    data.forEach(row => {
        table.row.add([
            row.SupplierName,
            row.AgentName,
            row.Phone,
            row.Email,
            `<img src="../resources/img/d-edit.png" alt="View" style="cursor:pointer;margin-left:10px;"/> 
            <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;"/>`
        ]);

        counter++;
    });

    // Draw the updated table
    table.draw();

}


function fetchUserDetails(accountName) {
    fetch(`getUserData.php?accountName=${encodeURIComponent(accountName)}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the overlay form with user details
                currentEmployeeID.value = data.AccountID;
                employeeNameEdit.value = data.employeeName;
                employeeLNameEdit.value = data.employeeLName;
                roleEdit.value = data.role;
                accountNameEdit.value = data.accountName;
                passwordEdit.value = data.password;
                AccountID.value = data.AccountID;

                // Update checkboxes based on the permissions data
                SuppliersPermsEdit.checked = data.SuppliersPerms === 'on';
                TransactionsPermsEdit.checked = data.TransactionsPerms === 'on';
                InventoryPermsEdit.checked = data.InventoryPerms === 'on';
                POSPermsEdit.checked = data.POSPerms === 'on';
                REPermsEdit.checked = data.REPerms === 'on';
                POPermsEdit.checked = data.POPerms === 'on';
                UsersPermsEdit.checked = data.UsersPerms === 'on';


                // Show the overlay
                overlayEdit.style.display = 'flex';
            } else {
                console.error('No data found for the given account name.');
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
        });
}


deleteUserBtn.addEventListener('click', function () {
    let confirmationUser = confirm("Are you sure you want to delete this user?");
    if (confirmationUser === true) {
        // if(){

        // }
        if (!selectedUser || selectedUser.trim() === '') {
            alert('No user selected.');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'deleteUser.php', true);
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


        xhr.send(JSON.stringify({ accountName: selectedUser }));
        alert("User deleted successfully!");
        setTimeout(() => {
            window.location.href = 'users.php'; // Redirect on success
        }, 100);
    } else {

    }
});

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

document.getElementById('userFormEdit').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData2 = new FormData(this);

    const checkboxesEdit = document.querySelectorAll('.permissionsSelectEdit input[type="checkbox"]');
    checkboxesEdit.forEach(checkbox => {
        if (checkbox.checked) {
            formData2.append(checkbox.id, checkbox.value || 'on'); // Append only checked checkboxes
        } else {
            formData2.append(checkbox.id, 'off'); // Indicate unchecked state if needed
        }
    });

    fetch('updateUser.php', {
        method: 'POST',
        body: formData2
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);

            if (data.success) {
                setTimeout(() => {
                    window.location.href = 'users.php'; // Redirect on success
                }, 100);
            }
        })
        .catch(error => {

            alert('An error occurred: ' + error.message);
        });
});


function fetchData(query) {
    fetch('searchUser.php', {
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
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Error:', error);
            alert("There was an error with your request.");
        });
}

function showDeleteOptions(accountName) {
    selectedUser = accountName;
    overlayAD.style.display = 'flex';
};
function closeADOverlay() {
    overlayAD.style.display = 'none';
}
closeBtnAD.addEventListener('click', closeADOverlay);


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




function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [], // Disable initial sorting
            "columnDefs": [
                {
                    "targets": 0, // Employee Name
                    "width": "20%"
                },
                {
                    "targets": 1, // Role
                    "width": "20%"
                },
                {
                    "targets": 2, // Account Name
                    "width": "20%"
                },
                {
                    "targets": 3, // Date
                    "width": "20%"
                },
                {
                    "targets": 4, // Actions
                    "width": "20%"
                },
                {
                    "targets": 4, // Index of the column to disable sorting
                    "orderable": false // Disable sorting for column 5 - Actions
                }
            ]
        });
    });
}


// Archiving Accounts
const archiveUserBtn = document.getElementById('archiveUserBtn');
archiveUserBtn.addEventListener('click', function () {
    let confirmationUser = confirm("Are you sure you want to archive this user?");
    if (confirmationUser === true) {
        if (!selectedUser || selectedUser.trim() === '') {
            alert('No user selected.');
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'archiveUser.php', true);
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

        xhr.send(JSON.stringify({ accountName: selectedUser }));
        alert("User archived successfully!");
        setTimeout(() => {
            window.location.href = 'users.php';
        }, 100);
    }
});