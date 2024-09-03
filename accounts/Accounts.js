document.addEventListener("DOMContentLoaded", function() {
    const sidebarMenuItems = document.querySelectorAll(".sidebar-menu-item");

    sidebarMenuItems.forEach(item => {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            const target = event.currentTarget;

            if (target.innerText.includes("Dashboard")) {
                window.location.href = "../dashboard/dashboard.html";
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
            } else if (target.innerText.includes("Accounts")) {
                window.location.href = "../accounts/accounts.html";
            } else {
                window.location.href = "../index.html";
            }
        });
    });
});

const addUserBtn = document.getElementById('addUser');
const overlay = document.getElementById('overlay');
const closeBtn = document.getElementById('closeBtn');
const username = document.getElementById('username');
const accname = document.getElementById('accname');
const pass = document.getElementById('pass');

function refreshTable(){

}
function showOverlay() {
    document.getElementById('userForm').reset();
    document.getElementById('preview').style.display = 'none';
    overlay.style.display = 'flex';
}

function hideOverlay() {
  overlay.style.display = 'none';
}

function closeOverlay() {
    const isFormFilled = username.value.trim() !== '' || accname.value.trim() !== '' || pass.value.trim() !== '';

    if (isFormFilled) {
        if (confirm("Are you sure you want to close the form? Any unsaved changes will be lost.")) {
            document.getElementById('userForm').reset();
            document.getElementById('preview').style.display = 'none';
            hideOverlay();
        }
    } else {
        hideOverlay();
    }
}

addUserBtn.addEventListener('click', showOverlay);
closeBtn.addEventListener('click', closeOverlay);

// Optional: Hide overlay if clicking outside the form container
// overlay.addEventListener('click', (event) => {
//   if (event.target === overlay) {
//     hideOverlay();
//   }
// });

const fileInput = document.getElementById('profilePicture');
const previewImg = document.getElementById('preview');

// Function to handle file selection and image preview
fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const reader = new FileReader(); // Create a FileReader object

        // Set up the FileReader to read the file as a data URL
        reader.onload = function(e) {
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

// Get reference to the form element
const form = document.getElementById('userForm');

// Function to clear the image preview when the form is reset
form.addEventListener('reset', function() {
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
    fetch('getAccounts.php')
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => console.error('Error fetching data:', error));
});

function updateTable(data) {
    const tableBody = document.querySelector('table').getElementsByTagName('tbody')[0];
    
    // Clear existing rows (excluding the header)
    tableBody.innerHTML = '';

    data.forEach(row => {
        const tr = document.createElement('tr');
        // tr.className = 'highlight-row';
        
        // Create and append cells
        const selectCell = document.createElement('td');
        selectCell.className = 'align-mid';
        const selectCheckbox = document.createElement('input');
        selectCheckbox.type = 'checkbox';
        selectCell.appendChild(selectCheckbox);
        tr.appendChild(selectCell);

        // const emptyCell = document.createElement('td');
        // emptyCell.className = 'avatar2';
        // emptyCell.style.visibility = 'hidden';
        // tr.appendChild(emptyCell);
        
        const avatarCell = document.createElement('td');
        // avatarCell.className = 'align-right';
        const avatarImg = document.createElement('img');
        avatarImg.src = row.picture;
        avatarImg.alt = row.employeeName;
        avatarImg.className = 'avatar2';
        avatarCell.appendChild(avatarImg);
        tr.appendChild(avatarCell);
        
        const nameCell = document.createElement('td');
        nameCell.textContent = row.employeeName;
        nameCell.className = 'align-left';
        tr.appendChild(nameCell);
        
        const roleCell = document.createElement('td');
        roleCell.textContent = row.role;
        tr.appendChild(roleCell);
        
        const accNameCell = document.createElement('td');
        accNameCell.textContent = row.accountName;
        tr.appendChild(accNameCell);
        
        const passCell = document.createElement('td');
        passCell.textContent = row.password; // Be cautious about displaying passwords
        tr.appendChild(passCell);
        
        const updateDateCell = document.createElement('td');
        updateDateCell.textContent = row.updateDate; // Ensure `updateDate` is part of your query if needed
        tr.appendChild(updateDateCell);
        
        const statusCell = document.createElement('td');
        statusCell.textContent = row.status; // Ensure `status` is part of your query if needed
        tr.appendChild(statusCell);

        tableBody.appendChild(tr);
    });
}
