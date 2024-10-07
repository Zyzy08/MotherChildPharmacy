const newID = document.getElementById('newID');

function getNextIncrementID() {
    fetch(`getNextIncrementID.php`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                
            } else {
                const nextAutoIncrement = data.nextAutoIncrement;
                newID.value = "PO-0" + parseInt(nextAutoIncrement).toString();
            }
        })
        .catch(error => console.error('Error fetching next increment ID:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    getNextIncrementID();
});

//Populate Supplier Select Field
document.addEventListener('DOMContentLoaded', () => {
    fetch('../suppliers2/getAllData.php')
        .then(response => response.json())
        .then(data => {
            const supplierSelect = document.getElementById('supplierSelect');
            supplierSelect.innerHTML = ''; // Default is now empty

            // Sort the suppliers alphabetically by SupplierName
            data.sort((a, b) => a.SupplierName.localeCompare(b.SupplierName));

            // Populate the dropdown with sorted supplier names
            data.forEach(supplier => {
                const option = document.createElement('option');
                option.value = supplier.SupplierID; 
                option.textContent = supplier.SupplierName; 
                supplierSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching suppliers:', error));
});
