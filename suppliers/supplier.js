// Function to show the Add Supplier overlay
function addSupplier() {
    document.getElementById('add-supplier-overlay').style.display = 'flex';
}

// Function to close the overlay
function closeOverlay() {
    document.getElementById('add-supplier-overlay').style.display = 'none';
    document.getElementById('edit-supplier-overlay').style.display = 'none';
}

// Function to add a new supplier
document.getElementById('add-supplier-form').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('addsupplier.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Supplier added successfully!');
            closeOverlay();
            loadSuppliers(); // Reload the suppliers table
        } else {
            alert('Error adding supplier: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
};

// Function to load suppliers from the database
function loadSuppliers() {
    fetch('getsuppliers.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('supplier-table-body');
            tableBody.innerHTML = ''; // Clear existing table data

            data.suppliers.forEach(supplier => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${supplier.SupplierID}</td>
                    <td>${supplier.SupplierName}</td>
                    <td>${supplier.AgentName}</td>
                    <td>${supplier.Phone}</td>
                    <td>${supplier.Email}</td>
                    <td>${supplier.Status}</td>
                    <td>
                        <button onclick="editSupplier(${supplier.SupplierID})">Edit</button>
                        <button onclick="deleteSupplier(${supplier.SupplierID})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Function to edit a supplier
function editSupplier(id) {
    // Fetch supplier data and populate the edit form
    fetch(`getsupplier.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const supplier = data.suppliers;
                document.getElementById('supplier-name-edit').value = supplier.name;
                document.getElementById('agent-name-edit').value = supplier.agent;
                document.getElementById('phone-edit').value = supplier.phone;
                document.getElementById('email-edit').value = supplier.email;
                document.getElementById('edit-supplier-overlay').style.display = 'flex';
                
                // Update form submission for editing
                document.getElementById('edit-supplier-form').onsubmit = function(event) {
                    event.preventDefault();
                    const editFormData = new FormData(this);
                    editFormData.append('id', id); // Append the supplier ID

                    fetch('updatesupplier.php', {
                        method: 'POST',
                        body: editFormData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Supplier updated successfully!');
                            closeOverlay();
                            loadSuppliers(); // Reload the suppliers table
                        } else {
                            alert('Error updating supplier: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                };
            } else {
                alert('Error fetching supplier data: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to delete a supplier
function deleteSupplier(id) {
    if (confirm("Are you sure you want to delete this supplier?")) {
        fetch(`deletesupplier.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Supplier deleted successfully!');
                    loadSuppliers(); // Reload the suppliers table
                } else {
                    alert('Error deleting supplier: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

// Load suppliers on page load
window.onload = loadSuppliers;
