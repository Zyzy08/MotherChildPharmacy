document.addEventListener("DOMContentLoaded", function () {
    const sidebarMenuItems = document.querySelectorAll(".sidebar-menu-item");

    sidebarMenuItems.forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            const target = event.currentTarget;

            if (target.innerText.includes("Dashboard")) {
                window.location.href = "../dashboard/dashboard.php";
            } else if (target.innerText.includes("Products")) {
                window.location.href = "../products/products.html";
            } else if (target.innerText.includes("Suppliers")) {
                window.location.href = "../suppliers/suppliers.html";
            } else if (target.innerText.includes("Transactions")) {
                window.location.href = "../transactions/transactions.html";
            } else if (target.innerText.includes("Inventory")) {
                window.location.href = "../inventory/inventory.html";
            } else if (target.innerText.includes("POS")) {
                window.location.href = "../pos/pos.html";
            } else if (target.innerText.includes("Return / Exchange")) {
                window.location.href = "../returnexchange/return.html";
            } else if (target.innerText.includes("Users")) {
                window.location.href = "../users/users.html";
            } else {
                window.location.href = "../index.php";
            }
        });
    });
});

//Form fields
const addUserBtn = document.getElementById('addUser');
const overlay = document.getElementById('overlay');
const overlayEdit = document.getElementById('overlayEdit');
const overlayAD = document.getElementById('overlayAD');
const closeBtn = document.getElementById('closeBtn');
const closeBtnEdit = document.getElementById('closeBtnEdit');
const closeBtnAD = document.getElementById('closeBtnAD');
const username = document.getElementById('employeeName');
const userlname = document.getElementById('employeeLName');
const accname = document.getElementById('accountName');
const pass = document.getElementById('password');
//EditForm fields
const currentEmployeeID = document.getElementById('currentEmployeeID');
const employeeNameEdit = document.getElementById('employeeNameEdit');
const employeeLNameEdit = document.getElementById('employeeLNameEdit');
const roleEdit = document.getElementById('roleEdit');
const accountNameEdit = document.getElementById('accountNameEdit');
const passwordEdit = document.getElementById('passwordEdit');
const previewEdit = document.getElementById('previewEdit');
const AccountID = document.getElementById('AccountID');
// const deleteUserBtn = document.getElementById('deleteUserBtn');
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
    document.getElementById('preview').style.display = 'none';
    resetPermissions();
    setPAPermissions();
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
    const isFormFilled = username.value.trim() !== '' || accname.value.trim() !== '' || pass.value.trim() !== '';

    if (isFormFilled) {
        // if (confirm("Are you sure you want to close the form? Any unsaved changes will be lost.")) {
        //     document.getElementById('userForm').reset();
        //     document.getElementById('preview').style.display = 'none';
        //     hideOverlay();
        // }
        document.getElementById('userForm').reset();
        document.getElementById('preview').style.display = 'none';
        hideOverlay();
    } else {
        hideOverlay();
    }
}

addUserBtn.addEventListener('click', showOverlay);
closeBtn.addEventListener('click', closeOverlay);
closeBtnEdit.addEventListener('click', closeEditOverlay);


const fileInput = document.getElementById('profilePicture');
const previewImg = document.getElementById('preview');

// Function to handle file selection and image preview
fileInput.addEventListener('change', function (event) {
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const reader = new FileReader(); // Create a FileReader object

        // Set up the FileReader to read the file as a data URL
        reader.onload = function (e) {
            previewImg.src = e.target.result; // Set the image source to the data URL
            previewImg.style.display = 'block'; // Show the image preview
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    } else {
        previewImg.src = '';
        previewImg.style.display = 'none'; // Hide the image preview if no file is selected
    }
});

const fileInputEdit = document.getElementById('profilePictureEdit');
const previewImgEdit = document.getElementById('previewEdit');

// Function to handle file selection and image preview
fileInputEdit.addEventListener('change', function (event) {
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const reader = new FileReader(); // Create a FileReader object

        // Set up the FileReader to read the file as a data URL
        reader.onload = function (e) {
            previewImgEdit.Editsrc = e.target.result; // Set the image source to the data URL
            previewImgEdit.style.display = 'block'; // Show the image preview
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    } else {
        previewImgEdit.src = '';
        previewImgEdit.style.display = 'none'; // Hide the image preview if no file is selected
    }
});

// Get reference to the form element
const form = document.getElementById('userForm');

// Function to clear the image preview when the form is reset
form.addEventListener('reset', function () {
    previewImg.src = ''; // Clear the image source
    previewImg.style.display = 'none'; // Hide the image preview
    fileInput.value = ''; // Clear the file input value
});

// Function to clear the form and preview when submitted
function handleFormSubmit() {
    // document.getElementById('userForm').reset();
    document.getElementById('preview').style.display = 'none';
    hideOverlay();
}

//Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getUsers.php')
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
            `<img src="uploads/${row.picture}" alt="${row.employeeName}" class="avatar2"/> ${row.employeeName + " " + row.employeeLName}`,
            row.role,
            row.accountName,
            row.dateCreated,
            row.connected == 0 ? '<span class="status-offline">Offline</span>' : '<span class="status-online">Online</span>',
            row.connected == 0
                ? `<img src="../resources/img/d-edit.png" alt="Edit" style="cursor:pointer;margin-left:10px;" onclick="fetchUserDetails('${row.accountName}')"/> 
                   <img src="../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:10px;" onclick="showDeleteOptions('${row.accountName}')"/>`
                : `<img src="../resources/img/d-edit-disabled.png" alt="Edit" style="cursor:not-allowed;margin-left:10px; opacity: 0.5;"/> 
                   <img src="../resources/img/s-remove-disabled.png" alt="Delete" style="cursor:not-allowed;margin-left:10px; opacity: 0.5;"/>`
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
                previewEdit.style.display = 'block';
                previewEdit.src = "uploads/" + data.picture;
                AccountID.value = data.AccountID;

                resetPermissionsEdit();

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


// deleteUserBtn.addEventListener('click', function () {
//     let confirmationUser = confirm("Are you sure you want to delete this user?");
//     if (confirmationUser === true) {
//         // if(){

//         // }
//         if (!selectedUser || selectedUser.trim() === '') {
//             alert('No user selected.');
//             return;
//         }

//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', 'deleteUser.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

//         // Handle the response
//         xhr.onload = function () {
//             if (xhr.status >= 200 && xhr.status < 300) {
//                 const response = JSON.parse(xhr.responseText);
//                 document.getElementById('modalMessage').textContent = response.message;
//             } else {
//                 alert('Error: ' + xhr.status);
//             }
//         };


//         xhr.send(JSON.stringify({ accountName: selectedUser }));
//         alert("User deleted successfully!");
//         setTimeout(() => {
//             window.location.href = 'users.php'; // Redirect on success
//         }, 100);
//     } else {

//     }
// });

const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

document.getElementById('userForm').addEventListener('submit', function (event) {
    document.getElementById('accountName').disabled = false;
    document.getElementById('password').disabled = false;
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    const checkboxes = document.querySelectorAll('.permissionsSelect input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            formData.append(checkbox.id, checkbox.value || 'on'); // Append only checked checkboxes
        } else {
            formData.append(checkbox.id, 'off'); // Indicate unchecked state if needed
        }
    });

    fetch('addUser.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Success';
                modalVerifyTextFront.textContent = 'User was added succesfully!';
                confirmationModalFront.show();
                setTimeout(() => {
                    window.location.href = 'users.php'; // Redirect on success
                }, 1000);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
        });
});

document.getElementById('userFormEdit').addEventListener('submit', function (event) {
    document.getElementById('accountNameEdit').disabled = false;
    document.getElementById('passwordEdit').disabled = false;
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
            const confirmationModal = new bootstrap.Modal(document.getElementById('disablebackdrop'));
            confirmationModal.show();

            if (data.success) {
                setTimeout(() => {
                    window.location.href = 'users.php'; // Redirect on success
                }, 1000);
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

// resetEdit.addEventListener('click', function(event){
//     fetchUserDetails(selectedUser);
// });

let newID = 0;
const newEmployeeID = document.getElementById('newEmployeeID');
addUserBtn.addEventListener('click', function (event) {
    showOverlay();
    fetch('getNewAccountID.php')
        .then(response => response.json())
        .then(data => {
            if (data.nextAutoIncrement) {
                newID = parseInt(data.nextAutoIncrement);
                newEmployeeID.value = newID;
            } else {
                console.error('No nextAutoIncrement found in the response.');
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});

username.addEventListener('input', function (event) {
    let firstName = username.value;
    let firstLetter = firstName.charAt(0).toLowerCase();
    let lastName = userlname.value.toLowerCase();
    let code = '';
    if (newID < 10) {
        code = 'E00' + newID + '_';
    } else if (newID < 100) {
        code = 'E0' + newID + '_';
    } else {
        code = 'E' + newID + '_';
    }

    accountName.value = code + firstLetter + lastName;
});

userlname.addEventListener('input', function (event) {
    let firstName = username.value;
    let firstLetter = firstName.charAt(0).toLowerCase();
    let lastName = userlname.value.toLowerCase();
    let code = '';
    let code2 = '';
    if (newID < 10) {
        code = '-e00' + newID;
        code2 = 'E00' + newID + '_';
    } else if (newID < 100) {
        code = '-e0' + newID;
        code2 = 'E0' + newID + '_';
    } else {
        code = '-e' + newID;
        code2 = 'E' + newID + '_';
    }

    accountName.value = code2 + firstLetter + lastName;
    pass.value = lastName + code;
});

function setDataTables() {
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [], // Disable initial sorting
            "columnDefs": [
                {
                    "targets": 0, // Employee Name
                    "width": "23.6%"
                },
                {
                    "targets": 1, // Role
                    "width": "20.6%"
                },
                {
                    "targets": 2, // Account Name
                    "width": "16.6%"
                },
                {
                    "targets": 3, // Date
                    "width": "16.6%"
                },
                {
                    "targets": 4, // Status
                    "width": "12.6%"
                },
                {
                    "targets": 5, // Actions
                    "width": "10.6%"
                },
                {
                    "targets": 5, // Index of the column to disable sorting
                    "orderable": false // Disable sorting for column 5 - Actions
                }
            ]
        });
    });
}

//PermissionsToggle JS
const permsToggle = document.getElementById("permsToggle");
const checkboxes = document.querySelectorAll(".permissionsSelect input[type='checkbox']");
const permissionsSelectContainer = document.querySelector(".permissionsSelect");
let permsToggleStatus = 0;

const SuppliersPerms = document.getElementById('SuppliersPerms');
const TransactionsPerms = document.getElementById('TransactionsPerms');
const InventoryPerms = document.getElementById('InventoryPerms');
const UsersPerms = document.getElementById('UsersPerms');
const POSPerms = document.getElementById('POSPerms');
const REPerms = document.getElementById('REPerms');
const POPerms = document.getElementById('POPerms');

permsToggle.addEventListener('click', function () {
    if (permsToggleStatus === 1) {
        permsToggle.src = '../resources/img/toggle-off.png';
        permsToggleStatus = 0;
        setCheckboxesDisabled(true); // Disable checkboxes
        permissionsSelectContainer.classList.remove('enabled'); // Remove enabled class
    } else {
        permsToggleStatus = 1;
        permsToggle.src = '../resources/img/toggle-on.png';
        setCheckboxesDisabled(false); // Enable checkboxes
        permissionsSelectContainer.classList.add('enabled'); // Add enabled class
    }
});

// Function to enable or disable checkboxes
function setCheckboxesDisabled(disabled) {
    checkboxes.forEach(checkbox => {
        checkbox.disabled = disabled;
    });
}

function setPAPermissions() {
    TransactionsPerms.checked = true;
    POSPerms.checked = true;
    REPerms.checked = true;
}

function setAdminPermissions() {
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function resetPermissions() {
    if (permsToggleStatus == 1) {
        permissionsSelectContainer.classList.remove('enabled');
        permsToggle.src = '../resources/img/toggle-off.png';
        setCheckboxesDisabled(true);
        permsToggleStatus = 0;
    }
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Function to handle the change event
function handleSelectChange(event) {
    resetPermissions();
    const selectedValue = event.target.value; // Get the selected value
    if (selectedValue === "Pharmacy Assistant") {
        setPAPermissions();
    } else if (selectedValue === "Admin") {
        setAdminPermissions();
    } else if (selectedValue === "Purchaser") {
        setAdminPermissions();
        UsersPerms.checked = false;
    }
}

// Add event listener to the select element
const roleSelect = document.getElementById('role');
roleSelect.addEventListener('change', handleSelectChange);

//PermissionsToggle on EditUser JS
const permsToggleEdit = document.getElementById("permsToggleEdit");
const checkboxesEdit = document.querySelectorAll(".permissionsSelectEdit input[type='checkbox']");
const permissionsSelectContainerEdit = document.querySelector(".permissionsSelectEdit");
let permsToggleStatusEdit = 0;

const SuppliersPermsEdit = document.getElementById('SuppliersPermsEdit');
const TransactionsPermsEdit = document.getElementById('TransactionsPermsEdit');
const InventoryPermsEdit = document.getElementById('InventoryPermsEdit');
const UsersPermsEdit = document.getElementById('UsersPermsEdit');
const POSPermsEdit = document.getElementById('POSPermsEdit');
const REPermsEdit = document.getElementById('REPermsEdit');
const POPermsEdit = document.getElementById('POPermsEdit');

permsToggleEdit.addEventListener('click', function () {
    if (permsToggleStatusEdit === 1) {
        permsToggleEdit.src = '../resources/img/toggle-off.png';
        permsToggleStatusEdit = 0;
        setCheckboxesEditDisabled(true); // Disable checkboxes
        permissionsSelectContainerEdit.classList.remove('enabled'); // Remove enabled class
    } else {
        permsToggleStatusEdit = 1;
        permsToggleEdit.src = '../resources/img/toggle-on.png';
        setCheckboxesEditDisabled(false); // Enable checkboxes
        permissionsSelectContainerEdit.classList.add('enabled'); // Add enabled class
    }
});

function setCheckboxesEditDisabled(disabled) {
    checkboxesEdit.forEach(checkbox => {
        checkbox.disabled = disabled;
    });
}

function setPAPermissionsEdit() {
    TransactionsPermsEdit.checked = true;
    POSPermsEdit.checked = true;
    REPermsEdit.checked = true;
}

function setAdminPermissionsEdit() {
    checkboxesEdit.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function resetPermissionsEdit() {
    if (permsToggleStatusEdit == 1) {
        permissionsSelectContainerEdit.classList.remove('enabled');
        permsToggleEdit.src = '../resources/img/toggle-off.png';
        setCheckboxesEditDisabled(true);
        permsToggleStatusEdit = 0;
    }
    checkboxesEdit.forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Function to handle the change event
function handleSelectChangeEdit(event) {
    resetPermissionsEdit();
    const selectedValueEdit = event.target.value; // Get the selected value
    if (selectedValueEdit === "Pharmacy Assistant") {
        setPAPermissionsEdit();
    } else if (selectedValueEdit === "Admin") {
        setAdminPermissionsEdit();
    } else if (selectedValueEdit === "Purchaser") {
        setAdminPermissionsEdit();
        UsersPermsEdit.checked = false;
    }
}

roleEdit.addEventListener('change', handleSelectChangeEdit);

// Archiving Accounts
// Resetting to Default Password
const resetPasswordBtn = document.getElementById('resetPasswordBtn');
const archiveUserBtn = document.getElementById('archiveUserBtn');
const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');

let modalStatus = '';

archiveUserBtn.addEventListener('click', function () {
    modalVerifyTextAD.textContent = 'Are you sure you want to archive this user?'
    modalStatus = 'archive';
})

resetPasswordBtn.addEventListener('click', function () {
    modalVerifyTextAD.textContent = 'Are you sure you want to reset the password of this user?'
    modalStatus = 'resetPass';
})

const modalYes = document.getElementById('modalYes');
modalYes.addEventListener('click', function () {
    if (modalStatus === 'archive') {
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
        //Extra
        modalFooterAD.style.display = 'none'; // Set display to none to hide it
        modalCloseAD.style.display = 'none';
        modalVerifyTextAD.textContent = 'User has been archived successfully!';
        modalVerifyTitleAD.textContent = 'Success';
        setTimeout(() => {
            window.location.href = 'users.php';
        }, 1000);
    }
    else if (modalStatus === 'resetPass') {
        if (!selectedUser || selectedUser.trim() === '') {
            alert('No user selected.');
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'resetPassword.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
            } else {
                alert('Error: ' + xhr.status);
            }
        };

        xhr.send(JSON.stringify({ accountName: selectedUser }));
        //Extra
        modalFooterAD.style.display = 'none'; // Set display to none to hide it
        modalCloseAD.style.display = 'none';
        modalVerifyTextAD.textContent = 'User password has been reset successfully!';
        modalVerifyTitleAD.textContent = 'Success';
        setTimeout(() => {
            window.location.href = 'users.php';
        }, 1000);
    }
});

const toArchivedUsers = document.getElementById('toArchivedUsers');
toArchivedUsers.addEventListener('click', function () {
    window.location.href = 'users-archive/archivedusers.php';
});

employeeNameEdit.addEventListener('input', function (event) {
    updateAccountNameEditField();
});

employeeLNameEdit.addEventListener('input', function (event) {
    updateAccountNameEditField();
});

function updateAccountNameEditField() {
    let code = '';
    if (currentEmployeeID.value < 10) {
        code = 'E00';
    } else if (currentEmployeeID.value < 100) {
        code = 'E0';
    } else {
        code = 'E';
    }

    let firstNameEdit = employeeNameEdit.value;
    let firstLetterEdit = firstNameEdit.charAt(0).toLowerCase();
    let lastNameEdit = employeeLNameEdit.value.toLowerCase();

    accountNameEdit.value = code + currentEmployeeID.value + '_' + firstLetterEdit + lastNameEdit;
}