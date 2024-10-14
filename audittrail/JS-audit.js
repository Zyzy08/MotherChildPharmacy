const overlay = document.getElementById('overlay');
//etc
const usersNum = document.getElementById('usersNum');
const tableBody = document.getElementById('tableBody');
const selectedTest = document.getElementById('selectedTest');
const optUserBtn = document.getElementById('optionsUser');
const searchInput = document.getElementById('searchInput');

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

function hideOverlay() {
    overlay.style.display = 'none';
}

closeBtn.addEventListener('click', hideOverlay);


//Fetch data
document.addEventListener('DOMContentLoaded', () => {
    fetch('getAudits.php')
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
            "AU-0" + row.auditID,
            row.action,
            row.employeeFullName,
            row.formatted_datetime,
            row.Status == 0 ? '<span class="status-offline">Failed</span>' : '<span class="status-online">Success</span>',
            `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:40px;" onclick="fetchAuditDetails('${row.auditID}')"/>`
        ]);

        counter++;
    });

    // Draw the updated table
    table.draw();

}

// JavaScript function to fetch audit details based on the auditID
function fetchAuditDetails(auditID) {
    fetch(`getData.php?auditID=${auditID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Update the table with the fetched data
                document.getElementById('identifierID').innerText = "AU-0" + data.auditID;
                document.getElementById('column2ID').innerText = data.action;
                document.getElementById('column3ID').innerText = data.employeeFullName;
                document.getElementById('column4ID').innerText = data.formatted_datetime;
                // Update the status with dynamic class
                const statusElement = document.getElementById('column5ID');
                statusElement.innerText = data.Status == 0 ? 'Failed' : 'Success';
                statusElement.className = data.Status == 0 ? 'status-offline' : 'status-online';

                document.getElementById('listQTY').innerText = data.description;

                overlay.style.display = 'flex';
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}


const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

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
                    "targets": 0, // Audit ID
                    "width": "19.4%"
                },
                {
                    "targets": 1, // Actions
                    "width": "18%"
                },
                {
                    "targets": 2, // User
                    "width": "17.4%"
                },
                {
                    "targets": 3, // Date/Time
                    "width": "19.6%"
                },
                {
                    "targets": 4, // Status
                    "width": "12.6%"
                },
                {
                    "targets": 5, // Actions
                    "width": "13.6%"
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
// Resetting to Default Password

const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');

let modalStatus = '';

const modalYes = document.getElementById('modalYes');
modalYes.addEventListener('click', function () {
    //Future reference
});
