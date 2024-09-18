//Form fields
const addUserBtn = document.getElementById('addUser');
const overlayAD = document.getElementById('overlayAD');
const closeBtnAD = document.getElementById('closeBtnAD');

const AccountID = document.getElementById('AccountID');
const deleteUserBtn = document.getElementById('deleteUserBtn');
//etc
const tableBody = document.getElementById('tableBody');
const optUserBtn = document.getElementById('optionsUser');
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
//placeholders
let currentlySelectedRow = null;
let selectedUser = null;

//Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getArchivedUsers.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => alert('Error fetching users data:', error));
    setDataTables();
});


function updateTable(data) {
    const table = $('#example').DataTable();

    // Clear existing data
    table.clear();

    data.forEach(row => {
        table.row.add([
            `<img src="../uploads/${row.picture}" alt="${row.employeeName}" class="avatar2"/> ${row.employeeName + " " + row.employeeLName}`,
            row.role,
            row.accountName,
            row.dateCreated,
            row.connected == 0 ? '<span class="status-offline">Offline</span>' : '<span class="status-online">Online</span>',
            `<img src="../../resources/img/s-remove.png" alt="Delete" style="cursor:pointer;margin-left:20px;" onclick="showDeleteOptions('${row.accountName}')"/>`
        ]);
    });

    // Draw the updated table
    table.draw();
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
        xhr.open('POST', '../deleteUser.php', true);
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
        alert("User deleted successfully!");
        setTimeout(() => {
            window.location.href = 'archivedusers.php'; // Redirect on success
        }, 100);
    } else {

    }
});

function showDeleteOptions(accountName) {
    selectedUser = accountName;
    overlayAD.style.display = 'flex';
};
function closeADOverlay() {
    overlayAD.style.display = 'none';
}
closeBtnAD.addEventListener('click', closeADOverlay);

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

// Archiving Accounts
const unarchiveUserBtn = document.getElementById('unarchiveUserBtn');
unarchiveUserBtn.addEventListener('click', function () {
    let confirmationUser = confirm("Are you sure you want to unarchive this user?");
    if (confirmationUser === true) {
        if (!selectedUser || selectedUser.trim() === '') {
            alert('No user selected.');
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'unarchiveUser.php', true);
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
        alert("User unarchived successfully!");
        setTimeout(() => {
            window.location.href = 'archivedusers.php';
        }, 100);
    }
});

const toUsers = document.getElementById('toUsers');
toUsers.addEventListener('click', function(){
    window.location.href = '../users.php';
});