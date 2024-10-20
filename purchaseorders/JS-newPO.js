const newID = document.getElementById('newID');
const sendButton = document.getElementById('sendButton');
let newPO_ID = '';

function getNextIncrementID() {
    fetch(`getNextIncrementID.php`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);

            } else {
                const nextAutoIncrement = data.nextAutoIncrement;
                newPO_ID = parseInt(nextAutoIncrement).toString()
                newID.value = "PO-0" + newPO_ID;
            }
        })
        .catch(error => console.error('Error fetching next increment ID:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    getNextIncrementID();
});

//Populate Supplier Select Field
document.addEventListener('DOMContentLoaded', () => {
    fetch('../suppliers/getAllData.php')
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

const overlay = document.getElementById('overlay');
const productSelect = document.getElementById('productSelect');
const qtySelect = document.getElementById('qtySelect');
const addProductToListBtn = document.getElementById('addProductToListBtn');

// Array to keep track of added ItemIDs
let addedProductIDs = [];

function triggerAddProducts() {
    const supplierSelect = document.getElementById('supplierSelect');
    let selectedSupplier = supplierSelect.options[supplierSelect.selectedIndex].text;
    overlay.style.display = 'flex';

    fetch(`getProductsBySupplier.php?ID=${selectedSupplier}`)
        .then(response => response.json())
        .then(data => {
            productSelect.innerHTML = ''; // Clear existing options

            if (data.length > 0) {
                data.forEach(product => {
                    // Check if the product has already been added
                    if (!addedProductIDs.includes(product.ItemID)) {
                        const option = document.createElement('option');
                        option.value = product.ItemID; // or any unique identifier
                        option.textContent = `${product.BrandName} - ${product.GenericName} (${product.Mass} ${product.UnitOfMeasure})`;
                        productSelect.appendChild(option);
                    }
                });
                if (data.length == addedProductIDs.length) {
                    productSelect.disabled = true;
                    qtySelect.disabled = true;
                    addProductToListBtn.disabled = true;
                    const option = document.createElement('option');
                    option.textContent = 'No products available.';
                    option.disabled = true;
                    productSelect.appendChild(option);
                    productSelect.value = 'No products available.';
                } else {
                    productSelect.disabled = false;
                    qtySelect.disabled = false;
                    addProductToListBtn.disabled = false;
                }
            }
        })
        .catch(error => console.error('Error fetching products:', error));
}

function closeOverlay() {
    // Get the form element
    const form = document.getElementById('productSelectForm');

    // Reset the form fields
    form.reset();

    // Hide the overlay
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'none'; // or use 'visibility: hidden;' if you prefer
}

// Function to add the selected product to the table
document.getElementById('productSelectForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const selectedProductID = productSelect.value; // Get selected product ID
    const selectedProductText = productSelect.options[productSelect.selectedIndex].text; // Get selected product text
    const quantity = qtySelect.value;

    // Add a new row to the table
    const tableBody = document.querySelector('#listTableNew tbody');

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="remove-icon" style="text-align: center; cursor: pointer;">
            <span class="index">${tableBody.rows.length + 1}</span>
            <img src="../resources/img/s-remove2.png" alt="Remove" style="display: none;" />
        </td>
        <td>${selectedProductText}</td>
        <td>
            <input type="number" value="${quantity}" min="0" step="1" 
                   onkeydown="return event.key >= '0' && event.key <= '9' || event.key === 'Backspace' || event.key === 'Tab';">
        </td>
    `;
    tableBody.insertBefore(newRow, tableBody.lastElementChild); // Insert before the last row

    // Add the product ID to the addedProductIDs array
    addedProductIDs.push(selectedProductID);

    // Update the index in the first column when a new row is added
    updateIndices();
    // Check to enable the Send button
    checkSendButton();

    // Add hover functionality
    newRow.querySelector('.remove-icon').addEventListener('mouseenter', function () {
        const indexElem = newRow.querySelector('.index');
        const removeImg = newRow.querySelector('img');
        indexElem.style.display = 'none'; // Hide the index
        removeImg.style.display = 'block'; // Show the remove icon
    });

    newRow.querySelector('.remove-icon').addEventListener('mouseleave', function () {
        const indexElem = newRow.querySelector('.index');
        const removeImg = newRow.querySelector('img');
        indexElem.style.display = 'block'; // Show the index
        removeImg.style.display = 'none'; // Hide the remove icon
    });

    // Add click event listener for removing the row
    newRow.querySelector('.remove-icon').addEventListener('click', function () {
        const index = Array.from(tableBody.rows).indexOf(newRow);
        addedProductIDs.splice(index, 1); // Remove the product ID from the array
        newRow.remove(); // Remove the row from the table
        updateIndices(); // Update indices after removal
        // Check to enable the Send button
        checkSendButton();
    });

    // Reset the form and close the overlay
    closeOverlay();

    function updateIndices() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const indexElem = row.querySelector('.index');
            if (indexElem) {
                indexElem.textContent = index + 1; // Update index number to be 1-based
            }
        });
    }

    function checkSendButton() {
        const hasProducts = tableBody.querySelectorAll('tr').length > 1; // Adjust based on your table structure
        sendButton.disabled = !hasProducts; // Enable if there's at least one product
    }
});




//onSupplierChange
const supplierSelect = document.getElementById('supplierSelect');
const listTableNew = document.getElementById('listTableNew');
addedProductIDs = [];

supplierSelect.addEventListener('change', function () {
    // Reset the table to default
    const tbody = listTableNew.querySelector('tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="3" id="addNewRow" style="font-size: 13px; text-align: center; vertical-align: middle;">
                <div id="addNewRowClick" style="cursor:pointer; display: inline-block;" onclick="triggerAddProducts()">
                    <i class="bi bi-plus-square"></i> Add Product
                </div>
            </td>
        </tr>
    `;

    // Clear addedProductIDs array
    addedProductIDs = [];

    sendButton.disabled = true;
});

function goBack() {
    window.location.href = 'purchaseorders.php';
}

//sending PO to Supplier and storing to database

const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

const userForm = document.getElementById('userForm');
userForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const supplierSelect = document.getElementById('supplierSelect');
    const totalItems = calculateTotalItems(); // Function to calculate total quantity

    // Call createOrderDetails and handle the promise
    createOrderDetails().then(orderDetails => {
        const formData = new FormData();
        formData.append('supplierSelect', supplierSelect.options[supplierSelect.selectedIndex].text);
        formData.append('orderDetails', JSON.stringify(orderDetails)); // Ensure this is correctly stringified
        console.log(JSON.stringify(orderDetails));
        formData.append('totalItems', totalItems);
        formData.append('newOrderID', newPO_ID);

        // Submit the form via Fetch API
        return fetch('sendPOForm.php', {
            method: 'POST',
            body: formData
        });
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Success';
                modalVerifyTextFront.textContent = 'Purchase order was placed succesfully!';
                confirmationModalFront.show();
                setTimeout(() => {
                    window.location.href = 'purchaseorders.php'; // Redirect on success
                }, 1000);
        } else {
            const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Error';
                modalVerifyTextFront.textContent = 'Purchase order was added due to an error!';
                confirmationModalFront.show();
                setTimeout(() => {
                    window.location.href = 'purchaseorders.php'; // Redirect on success
                }, 1000);
        }
    })
    .catch(error => {
        console.error('Error Yikes:', error);
    });
});



// Function to calculate total quantity from the table
function calculateTotalItems() {
    const tableBody = document.querySelector('#listTableNew tbody');
    let total = 0;
    const rows = tableBody.querySelectorAll('tr:not(:last-child)'); // Exclude the last "Add Product" row
    rows.forEach(row => {
        const qtyInput = row.querySelector('input[type="number"]');
        if (qtyInput) {
            total += parseInt(qtyInput.value) || 0; // Add the quantity from each row
        }
    });
    return total;
}

async function createOrderDetails() {
    const tableBody = document.querySelector('#listTableNew tbody');
    const details = {};
    const rows = tableBody.querySelectorAll('tr:not(:last-child)'); // Exclude the last "Add Product" row

    for (const [index, row] of rows.entries()) {
        const productDescriptionCell = row.querySelector('td:nth-child(2)'); // Get the product description cell
        const qtyInput = row.querySelector('input[type="number"]');

        if (productDescriptionCell && qtyInput) {
            const selectedProductText = productDescriptionCell.textContent.trim(); // Get the displayed product text
            const quantity = parseInt(qtyInput.value) || 0; // Parse the quantity

            console.log(`Processing row ${index + 1}: ${selectedProductText}, Quantity: ${quantity}`); // Debug log

            // Fetch itemID from the server
            try {
                const response = await fetch(`getItemID.php?description=${encodeURIComponent(selectedProductText)}`);
                const data = await response.json();

                console.log(`Response for ${selectedProductText}:`, data); // Debug log

                if (data.success) {
                    const itemID = data.itemID;

                    if (itemID && quantity > 0) { // Only include if itemID exists and quantity is greater than 0
                        details[index + 1] = { // Use index + 1 as key
                            itemID: itemID.toString(), // Convert itemID to string if necessary
                            qty: quantity
                        };
                        console.log(`Added to details: ${index + 1} -> itemID: ${itemID}, qty: ${quantity}`); // Debug log
                    }
                } else {
                    console.error(data.message); // Log any errors if the item is not found
                }
            } catch (error) {
                console.error('Error fetching item ID:', error);
            }
        } else {
            console.warn(`Row ${index + 1} is missing product description or quantity input.`); // Debug log for missing elements
        }
    }

    const orderDetailsJSON = JSON.stringify(details);
    console.log('Final details JSON:', orderDetailsJSON); // Log the final JSON string
    return orderDetailsJSON; // Return the JSON string
}





