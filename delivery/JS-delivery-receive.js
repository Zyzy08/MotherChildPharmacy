const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

// Function to calculate total quantity from the table
function calculateTotalItems() {
    const tableBody = document.querySelector('#listTable tbody');
    let total = 0;
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach(row => {
        const qtyInput = row.querySelector('[data-key="qtyServed"]');
        if (qtyInput) {
            total += parseInt(qtyInput.textContent) || 0; // Add the quantity from each row
            console.log(`Row ${row.rowIndex}: qtyServed = ${qtyInput.textContent}`); // Debug log
        }
    });
    return total;
}

async function createOrderDetails() {
    const tableBody = document.querySelector('#listTable tbody');
    const details = {};
    const rows = tableBody.querySelectorAll('tr'); // Exclude the last "Add Product" row

    for (const [index, row] of rows.entries()) {

        const productDescriptionCell = row.querySelector('td:nth-child(2)');
        const qtyInput = row.querySelector('td:nth-child(6)');
        const lotNo = row.querySelector('td:nth-child(3)');
        const expiryDate = row.querySelector('td:nth-child(4)');
        const bonusCell = row.querySelector('td:nth-child(7)');
        const netAmt = row.querySelector('td:nth-child(8)').textContent.trim();

        const valueAmt = parseFloat(netAmt.replace(/[^\d.-]/g, '')) || 0; // Convert to float
        const bonus = parseInt(bonusCell.textContent.trim(), 10) || 0; // Ensure bonus is a number
        const quantity = parseInt(qtyInput.textContent.trim(), 10) || 0; // Ensure quantity is a number
        const qtyTotal = quantity + bonus; // Calculate total quantity


        if (productDescriptionCell && qtyInput) {
            const selectedProductText = productDescriptionCell.textContent.trim(); // Get the displayed product text
            const quantity = parseInt(qtyInput.textContent.trim()) || 0; // Parse the quantity

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
                            qty: quantity,
                            lotNo: lotNo.textContent.trim(),
                            expiryDate: expiryDate.textContent.trim(),
                            bonus: bonus,
                            netAmt: valueAmt,
                            qtyTotal: qtyTotal
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

const userFormEdit = document.getElementById('userFormEdit');

userFormEdit.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get identifierID
    const identifierID = document.getElementById('identifierID').textContent;
    const totalItems = calculateTotalItems(); // Function to calculate total quantity

    // Call createOrderDetails and handle the promise
    createOrderDetails().then(orderDetails => {
        const formData = new FormData();

        // Append necessary data to formData
        formData.append('identifierID', identifierID);
        formData.append('totalItems', totalItems);
        formData.append('orderDetails', JSON.stringify(orderDetails)); // Ensure this is correctly stringified
        console.log(JSON.stringify(orderDetails));

        // Submit the form via Fetch API
        return fetch('receiveDelivery.php', {
            method: 'POST',
            body: formData
        });
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const confirmationModal = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Success';
                modalVerifyTextFront.textContent = 'Delivery processed successfully!';
                confirmationModal.show();
                setTimeout(() => {
                    window.location.href = 'delivery.php'; // Redirect on success
                }, 2000);
            } else {
                const confirmationModal = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Error';
                modalVerifyTextFront.textContent = 'Error processing delivery: ' + data.message;
                confirmationModal.show();
                setTimeout(() => {
                    window.location.href = 'delivery.php'; // Redirect on success
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const confirmationModal = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
            modalVerifyTitleFront.textContent = 'Error';
            modalVerifyTextFront.textContent = 'An unexpected error occurred. Please try again. ';
            confirmationModal.show();
            setTimeout(() => {
                window.location.href = 'delivery.php'; // Redirect on success
            }, 2000);
        });
});
