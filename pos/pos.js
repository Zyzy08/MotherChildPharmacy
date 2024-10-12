let currentPage = 1;
const itemsPerPage = 8; // Number of items per page
let totalItems = 0; // Total number of items
let totalPages = 0; // Total pages
let searchQuery = ''; // Store the current search query
let totalAmount = 0; // This should be updated with the actual total

// Function to fetch products from the server
async function fetchProducts(query = '') {
    try {
        const response = await fetch('fetchProductData.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ query })
        });
        const text = await response.text();

        const jsonMatch = text.match(/<!-- (.*?) -->/);
        const data = jsonMatch ? JSON.parse(jsonMatch[1]) : [];

        totalItems = data.length;
        totalPages = Math.ceil(totalItems / itemsPerPage);

        return data;
    } catch (error) {
        console.error('Error fetching products:', error);
        return [];
    }
}

//Unit of measure format
function formatUnitOfMeasure(unit) {
    switch (unit.toLowerCase()) {
        case 'milligrams':
            return 'mg';
        case 'grams':
            return 'g';
        case 'liters':
            return 'L';
        case 'milliliters':
            return 'mL';
        case 'piece':
                return 'pc';
        default:
            return unit; // Return the original unit if no match
    }
}

// LoadProducts function
async function loadProducts() {
    const products = await fetchProducts(searchQuery);
    const productContainer = document.getElementById('product-list');
    productContainer.innerHTML = '';

    // Clear active highlights from all cards
    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');

    // Calculate start and end indexes for products on the current page
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedProducts = products.slice(startIndex, endIndex);

    // Append products to the product list
    paginatedProducts.forEach(product => {
        const formattedUnit = formatUnitOfMeasure(product.UnitOfMeasure);
        let stockBadge = '';
        let cardClass = 'clickable-card';
    
        // Check the stock level and set the appropriate badge with actual InStock value
        if (product.InStock == 0) {
            stockBadge = `<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>Out-of-Stock</span>`;
            cardClass = 'non-clickable-card'; // New class for out-of-stock items
        } else if (product.InStock < 50 && product.InStock > 0) {
            stockBadge = `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Low-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
        } else {
            stockBadge = `<span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i>In-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
        }
    
        const productHTML = `
            <div class="col-lg-3">
                <div class="card ${cardClass}" data-id="${product.BrandName.toLowerCase().replace(/ /g, "-")}" data-product='${JSON.stringify(product)}'>
                    ${stockBadge}
                    <img src="../inventory/${product.ProductIcon}" class="card-img-top"
                        style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                    <div class="card-body">
                        <div class="row align-items-top">
                            <div class="col-lg-4">
                                <span class="badge rounded-pill bg-light text-dark">${product.Mass}${formattedUnit}</span>
                            </div>
                            <div class="col-lg-3 mx-3">
                                <span class="badge bg-success">₱${product.PricePerUnit}</span>
                            </div>
                        </div>
                        <h5 class="card-title">${product.BrandName}</h5>
                        <p class="card-text">${product.GenericName}</p>
                    </div>
                </div>
            </div>
        `;
        productContainer.insertAdjacentHTML('beforeend', productHTML);
    });

    attachCardListeners();
    updatePaginationControls();

    if (searchQuery && paginatedProducts.length > 0) {
        const firstCard = document.querySelector('.clickable-card');
        if (firstCard) {
            highlightCard(firstCard);
        }
    }
}

function updatePaginationControls() {
    const paginationList = document.querySelector('.pagination');
    paginationList.innerHTML = ''; // Clear existing pagination

    // Previous button
    paginationList.insertAdjacentHTML('beforeend', `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}" id="prev-page">
            <a class="page-link" href="#">Previous</a>
        </li>
    `);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        paginationList.insertAdjacentHTML('beforeend', `
            <li class="page-item ${i === currentPage ? 'active' : ''}" id="page-${i}">
                <a class="page-link" href="#">${i}</a>
            </li>
        `);
    }

    // Next button
    paginationList.insertAdjacentHTML('beforeend', `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}" id="next-page">
            <a class="page-link" href="#">Next</a>
        </li>
    `);

    // Add event listeners to page numbers
    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.getElementById(`page-${i}`);
        if (pageItem) {
            pageItem.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                loadProducts();
            });
        }
    }

    // Re-attach event listeners to the Previous and Next buttons
    document.getElementById('prev-page').addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            loadProducts();
        }
    });

    document.getElementById('next-page').addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            loadProducts();
        }
    });
}

// Update the card click event in attachCardListeners
function attachCardListeners() {
    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(card => {
        card.addEventListener('click', function() {
            highlightCard(this);
            const productData = JSON.parse(this.dataset.product);
            showQuantityModal(productData);
        });
    });
}

// Add this CSS to your stylesheet
const style = document.createElement('style');
style.textContent = `
    .non-clickable-card {
        opacity: 0.6;
        cursor: not-allowed;
    }
`;
document.head.appendChild(style);

// Add event listener for the search input
const searchInput = document.querySelector('input[name="query"]');
searchInput.addEventListener('input', function() {
    searchQuery = this.value; // Update the search query
    currentPage = 1; // Reset to the first page
    loadProducts(); // Load products based on the new query
});

// Add event listener for the Enter key on the search input
searchInput.addEventListener('keypress', async function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        
        if (this.value.trim() === '') {
            return;
        }

        searchQuery = this.value;
        currentPage = 1;
        await loadProducts();

        // Find the first clickable (in-stock) card
        const firstClickableCard = document.querySelector('.clickable-card');
        if (firstClickableCard) {
            // Highlight the card
            highlightCard(firstClickableCard);
            
            // Simulate a click on the card
            firstClickableCard.click();
        } else {
            showToast("No in-stock products found for your search.");
        }

        this.value = '';
        this.focus();
    }
});

function showQuantityModal(product) {
    const modalBody = document.getElementById('quantity-modal-body');
    const formattedUnit = formatUnitOfMeasure(product.UnitOfMeasure);
    let stockBadge = '';

    // Check the stock level and set the appropriate badge with actual InStock value
    if (product.InStock < 50 && product.InStock > 0) {
        stockBadge = `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Low-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
    } else {
        stockBadge = `<span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i>In-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
    }
    
    modalBody.innerHTML = `
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="../inventory/${product.ProductIcon}" class="img-fluid rounded-start" alt="Product Icon">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        ${stockBadge}
                        <small class="card-text">₱${product.PricePerUnit}</small>
                        <h5 class="card-title">${product.BrandName} ${product.Mass}${formattedUnit}</h5>
                        <p class="card-text">${product.GenericName}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    const quantityInput = document.getElementById('modal-quantity-input');
    quantityInput.value = 1;
    quantityInput.max = product.InStock;

    const addItemButton = document.getElementById('modal-add-item-button');
    addItemButton.onclick = () => {
        const quantity = parseInt(quantityInput.value, 10);
        if (quantity > 0 && quantity <= product.InStock) {
            addItemToBasket(product, quantity);
            bootstrap.Modal.getInstance(document.getElementById('quantity-modal')).hide();
        } else {
            showToast("Please enter a valid quantity.");
        }
    };

    const modal = new bootstrap.Modal(document.getElementById('quantity-modal'));
    modal.show();
}

// Find the cancel button in the quantity modal
const cancelButton = document.getElementById('quantity-cancel');

// Add click event listener to the cancel button
cancelButton.addEventListener('click', function() {
    // Remove the 'active' class from all cards
    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(card => {
        card.classList.remove('active');
    });

    // Remove the selected card ID from localStorage
    localStorage.removeItem('selectedCardId');
});

// Update the highlightCard function to work with the new behavior
function highlightCard(card) {
    // Check if the card has the "Out-of-Stock" badge (bg-danger)
    const outOfStockBadge = card.querySelector('.badge.bg-danger');
    if (outOfStockBadge) {
        return;
    }

    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(c => {
        c.classList.remove('active');
    });
    card.classList.add('active');
    localStorage.setItem('selectedCardId', card.getAttribute('data-id'));

    // Scroll the card into view
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function showToast(message) {
    const toast = new bootstrap.Toast(document.getElementById('alert-toast'));
    document.querySelector('#alert-toast .toast-body').textContent = message;
    toast.show();
}

// Load initial products and pagination
loadProducts();

let basket = [];
let basketTotal = 0;


function showToast(message) {
    const toastBody = document.querySelector('#alert-toast .toast-body');
    toastBody.textContent = message; // Set the custom message

    const toast = new bootstrap.Toast(document.getElementById('alert-toast'));
    toast.show(); // Show the toast
}

// Function to add item to the basket
function addItemToBasket(product, quantity) {
    const existingItemIndex = basket.findIndex(item => item.id === product.BrandName.toLowerCase().replace(/ /g, "-"));

    if (existingItemIndex > -1) {
        basket[existingItemIndex].quantity += quantity;
    } else {
        basket.push({
            id: product.BrandName.toLowerCase().replace(/ /g, "-"),
            BrandName: product.BrandName,
            GenericName: product.GenericName,
            PricePerUnit: product.PricePerUnit,
            quantity: quantity
        });
    }

    console.log('Item added to basket:', product.BrandName, 'Quantity:', quantity);
    updateBasketDisplay();
    updateCheckoutButtonState();

    // Deselect the currently selected item
    deselectCurrentItem();
}

function deselectCurrentItem() {
    // Remove the 'active' class from all cards
    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(card => {
        card.classList.remove('active');
    });

    // Remove the selected card ID from localStorage
    localStorage.removeItem('selectedCardId');
}

// Event listener for the "Add Item" button
document.getElementById('modal-add-item-button').onclick = () => {
    const quantityInput = document.getElementById('modal-quantity-input');
    const quantity = parseInt(quantityInput.value, 10);
    const activeCard = document.querySelector('.clickable-card.active');
    
    if (activeCard) {
        const productData = JSON.parse(activeCard.dataset.product);
        
        if (quantity > 0 && quantity <= productData.InStock) {
            addItemToBasket(productData, quantity);
            bootstrap.Modal.getInstance(document.getElementById('quantity-modal')).hide();
            // The item is automatically deselected in the addItemToBasket function
        } else {
            showToast("Please enter a valid quantity.");
        }
    } else {
        showToast("No item selected. Please select an item before adding to basket.");
    }
};

// Function to update the basket display
function updateBasketDisplay() {
    const basketItemsContainer = document.getElementById('basket-items');
    basketItemsContainer.innerHTML = ''; // Clear previous items
    basketTotal = 0; // Reset total

    basket.forEach(item => {
        const itemTotal = item.PricePerUnit * item.quantity; // Calculate total for the item
        basketTotal += itemTotal; // Add to the overall basket total

        const itemHTML = `
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${item.BrandName}</h5>
                    <button type="button" class="btn btn-danger btn-sm-custom" onclick="removeItemFromBasket('${item.id}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <p class="mb-1">${item.GenericName}</p>
                <div class="d-flex w-100 justify-content-between">
                    <small>₱${itemTotal.toFixed(2)}</small>
                    <small>x${item.quantity}</small>
                </div>
            </a>
        `;
        basketItemsContainer.insertAdjacentHTML('beforeend', itemHTML); // Add item to the display
    });

    const tax = (basketTotal * 0.12).toFixed(2); // Calculate tax
    const totalAmount = (basketTotal + parseFloat(tax)).toFixed(2); // Calculate total with tax
    document.getElementById('basket-total').textContent = `₱${totalAmount}`; // Update total
    document.getElementById('basket-tax').textContent = `₱${tax}`; // Update tax display
    updateCheckoutButtonState();

    console.log('Basket updated. Total items:', basket.length, 'Total amount:', basketTotal.toFixed(2));
}

// Get the current basket total
function getBasketTotal() {
    const basketTotal = basket.reduce((total, item) => total + (item.PricePerUnit * item.quantity), 0);
    return basketTotal.toFixed(2);
}

// Function to remove item from the basket
function removeItemFromBasket(itemId) {
    basket = basket.filter(item => item.id !== itemId); // Remove item from basket
    updateBasketDisplay(); // Update display
    updateCheckoutButtonState();
}

// Checkout button state
function updateCheckoutButtonState() {
    const checkoutButton = document.querySelector('button[data-bs-target="#verticalycentered"]');
    if (basket.length === 0) {
        checkoutButton.disabled = true;
        checkoutButton.classList.add('btn-secondary');
        checkoutButton.classList.remove('btn-primary');
    } else {
        checkoutButton.disabled = false;
        checkoutButton.classList.add('btn-primary');
        checkoutButton.classList.remove('btn-secondary');
    }
}

// Call this function on page load to set initial state
document.addEventListener('DOMContentLoaded', updateCheckoutButtonState);

// Add event listener to the "Add Item" button
document.getElementById('add-item-button').addEventListener('click', addItemToBasket);

// Add event listener for the Enter key on the quantity input
const quantityInput = document.getElementById('quantity-input');
quantityInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent form submission if it's in a form
        addItemToBasket(); // Call the function to add item to the basket
    }
});

document.getElementById('clear-search').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent any default action
    clearSearch();
});

function clearSearch() {
    const searchInput = document.querySelector('input[name="query"]');
    searchInput.value = ''; // Clear the input field
    searchQuery = ''; // Reset the search query
    currentPage = 1; // Reset to the first page
    loadProducts(); // Load all products
    searchInput.focus(); // Focus back on the input
    // Clear any highlighted cards
    const cards = document.querySelectorAll('.clickable-card');
    cards.forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');
}

// Update the modal total and set charge minimum when it's shown
document.getElementById('verticalycentered').addEventListener('show.bs.modal', function (event) {
    updateModalTotal();
});

function updateModalTotal() {
    const basketTotal = getBasketTotal();
    document.getElementById('total-display').textContent = `Total: ₱${basketTotal}`;
    console.log('Updated total:', basketTotal);
}

// Store for receipt items
let receiptItems = [];

// Function to generate receipt items from basket and update the receipt display
function generateReceiptItems() {
    receiptItems = basket.map(item => ({
        quantity: item.quantity,
        item_name: item.BrandName,
        total_item_price: (item.PricePerUnit * item.quantity).toFixed(2)
    }));

    updateTotalItemsDisplay();
    updateSubtotalDisplay();
    updateTaxDisplay();
    updateAmountDueDisplay();
}

// Function to update total items display
function updateTotalItemsDisplay() {
    const totalQuantity = receiptItems.reduce((total, item) => total + item.quantity, 0); // Calculate total quantity
    document.getElementById('total-items').textContent = totalQuantity; // Update HTML using the ID
}

// Function to update subtotal display
function updateSubtotalDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0).toFixed(2); // Calculate subtotal
    document.getElementById('sub-total').textContent = `₱${subtotal}`; // Update subtotal display
}

// Function to update tax display
function updateTaxDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0); // Calculate subtotal for tax calculation
    const tax = (subtotal * 0.12).toFixed(2); // Calculate 12% tax
    document.getElementById('tax').textContent = `₱${tax}`; // Update tax display
}

// Function to update amount due display
function updateAmountDueDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0); // Calculate subtotal
    const tax = (subtotal * 0.12); // Calculate 12% tax
    const amountDue = (parseFloat(subtotal) + parseFloat(tax)).toFixed(2); // Calculate total amount due
    document.getElementById('amount-due').textContent = `₱${amountDue}`; // Update amount due display
}

// Function to display receipt items
function displayReceiptItems() {
    const receiptContainer = document.getElementById('receiptItems');
    receiptContainer.innerHTML = ''; // Clear existing items
    
    // Create header row
    const headerHTML = `
        <div class="row text-center mb-2">
            <div class="col-4">
                <small><strong>Quantity</strong></small>
            </div>
            <div class="col-4">
                <small><strong>Item</strong></small>
            </div>
            <div class="col-3">
                <small><strong>Price</strong></small>
            </div>
        </div>
    `;
    receiptContainer.insertAdjacentHTML('beforeend', headerHTML);
    
    // Add each item
    receiptItems.forEach(item => {
        const itemHTML = `
            <div class="row text-center">
                <div class="col-4">
                    <small>${item.quantity}</small>
                </div>
                <div class="col-4">
                    <small>${item.item_name}</small>
                </div>
                <div class="col-3">
                    <small>₱${item.total_item_price}</small>
                </div>
            </div>
        `;
        receiptContainer.insertAdjacentHTML('beforeend', itemHTML);
    });
}

// Function to update payment display
function updatePaymentDisplay() {
    const paymentValue = document.getElementById("paymentInput").value;
    const payment = parseFloat(paymentValue) || 0;
    document.getElementById("payment").textContent = `₱${payment.toFixed(2)}`;
}

// Function to update change display
function updateChangeDisplay() {
    const paymentValue = document.getElementById("paymentInput").value;
    const payment = parseFloat(paymentValue) || 0;
    const amountDue = parseFloat(document.getElementById('amount-due').textContent.replace(/[^0-9.-]+/g,""));
    const change = payment - amountDue;
    document.getElementById("change").textContent = `₱${Math.max(0, change).toFixed(2)}`;
}

// Checkout button event listener
/*const checkoutButton = document.querySelector('button[data-bs-target="#verticalycentered"]');
if (checkoutButton) {
    checkoutButton.addEventListener('click', function() {
        // Get the modal element by ID
        const checkoutModalElement = document.getElementById('verticalycentered');

        if (checkoutModalElement) {
            // Show the modal first (optional step for debugging)
            const checkoutModal = new bootstrap.Modal(checkoutModalElement);
            checkoutModal.show();

            // Get the modal body container
            const modalBody = checkoutModalElement.querySelector('.modal-body');
            modalBody.innerHTML = ''; // Clear any existing content

            // Create Senior Citizen / PWD discount checkbox
            const seniorCheckboxDiv = document.createElement('div');
            seniorCheckboxDiv.className = 'form-check form-switch';
            const seniorCheckbox = document.createElement('input');
            seniorCheckbox.className = 'form-check-input';
            seniorCheckbox.type = 'checkbox';
            seniorCheckbox.id = 'seniorCitizenCheckbox';
            const seniorLabel = document.createElement('label');
            seniorLabel.className = 'form-check-label';
            seniorLabel.setAttribute('for', 'seniorCitizenCheckbox');
            seniorLabel.textContent = 'Senior Citizen / PWD (20%)';
            seniorCheckboxDiv.appendChild(seniorCheckbox);
            seniorCheckboxDiv.appendChild(seniorLabel);

            // Create Promotional discount checkbox
            const promoCheckboxDiv = document.createElement('div');
            promoCheckboxDiv.className = 'form-check form-switch';
            const promoCheckbox = document.createElement('input');
            promoCheckbox.className = 'form-check-input';
            promoCheckbox.type = 'checkbox';
            promoCheckbox.id = 'promoCheckbox';
            const promoLabel = document.createElement('label');
            promoLabel.className = 'form-check-label';
            promoLabel.setAttribute('for', 'promoCheckbox');
            promoLabel.textContent = 'Promotional (10%)';
            promoCheckboxDiv.appendChild(promoCheckbox);
            promoCheckboxDiv.appendChild(promoLabel);

            // Create Total display
            const totalDisplay = document.createElement('h2');
            totalDisplay.id = 'total-display';
            totalDisplay.style.fontWeight = 'bold';
            totalDisplay.textContent = 'Total: ₱0.00'; // Placeholder for total amount

            // Create Payment input field
            const paymentRow = document.createElement('div');
            paymentRow.className = 'row mb-0';
            const paymentLabel = document.createElement('h2');
            paymentLabel.className = 'col-sm-5';
            paymentLabel.style.fontWeight = 'bold';
            paymentLabel.textContent = 'Payment: ₱';
            const paymentInputDiv = document.createElement('div');
            paymentInputDiv.className = 'col-sm-6';
            const paymentInput = document.createElement('input');
            paymentInput.type = 'number';
            paymentInput.id = 'paymentInput';
            paymentInput.className = 'form-control no-arrows';
            paymentInput.min = '1';
            paymentInput.placeholder = '0';
            paymentInputDiv.appendChild(paymentInput);
            paymentRow.appendChild(paymentLabel);
            paymentRow.appendChild(paymentInputDiv);

            // Create Change display
            const changeDisplay = document.createElement('h2');
            changeDisplay.id = 'change-display';
            changeDisplay.style.fontWeight = 'bold';
            changeDisplay.textContent = 'Change: ₱0.00';

            // Append all elements to the modal body
            modalBody.appendChild(seniorCheckboxDiv);
            modalBody.appendChild(promoCheckboxDiv);
            modalBody.appendChild(document.createElement('br'));
            modalBody.appendChild(totalDisplay);
            modalBody.appendChild(document.createElement('br'));
            modalBody.appendChild(paymentRow);
            modalBody.appendChild(document.createElement('br'));
            modalBody.appendChild(changeDisplay);

            // Reset payment input and change display (if needed)
            paymentInput.value = '';
            changeDisplay.textContent = 'Change: ₱0.00';
        } else {
            console.error('Checkout modal not found in the DOM');
        }
    });
} else {
    console.error('Checkout button not found in the DOM');
}*/

// Get the checkout button and total display element
const checkoutButton = document.getElementById('checkout');
const totalDisplay = document.getElementById('total-display');

// Add a click event listener to the checkout button
checkoutButton.addEventListener('click', function () {
  // Change the total display text to "Hi"
  totalDisplay.textContent = 'Hi';
});

// Payment input event listener
document.getElementById('paymentInput').addEventListener('input', function() {
    const payment = parseFloat(this.value) || 0;
    const totalAmount = parseFloat(document.getElementById('total-display').textContent.replace(/[^0-9.-]+/g,""));
    const change = payment - totalAmount;
    
    const confirmButton = document.getElementById('confirm-button');
    
    if (payment >= totalAmount) {
        confirmButton.removeAttribute('disabled');
        document.getElementById('change-display').textContent = `Change: ₱${change.toFixed(2)}`;
    } else {
        confirmButton.setAttribute('disabled', 'true');
        document.getElementById('change-display').textContent = 'Change: ₱0.00';
    }
    
    // Update the receipt modal as well
    updatePaymentDisplay();
    updateChangeDisplay();
});

document.getElementById('cancel-receipt').addEventListener('click', function() {
    // After dismissing the current modal, show the Checkout modal again
    setTimeout(() => {
        const checkoutModal = new bootstrap.Modal(document.getElementById('verticalycentered')); // Select the checkout modal
        checkoutModal.show(); // Reopen the checkout modal
    }, 100); // Optional delay for smooth modal transition
});

// Fetch the last InvoiceID from the backend using AJAX
function fetchInvoiceID() {
    fetch('fetchOrderNumber.php')  // Adjust the path to your PHP script
        .then(response => response.json())
        .then(data => {
            const newInvoiceID = data.newInvoiceID;
            // Format the new InvoiceID without leading zeros, but show at least #0
            const formattedInvoiceID = newInvoiceID > 0 ? `#${newInvoiceID}` : '#0';
            // Replace the default with the new InvoiceID
            document.getElementById('order-num').textContent = `Order No.: ${formattedInvoiceID}`;
        })
        .catch(error => console.error('Error fetching InvoiceID:', error));
}

// Call the function when the page loads
document.addEventListener('DOMContentLoaded', fetchInvoiceID);

// Add this event listener for the print button
document.getElementById('print-button').addEventListener('click', async function() {
    try {
        // Gather all required data
        const orderNumber = document.getElementById('order-num').textContent.match(/\d+/)[0];
        const saleDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
        
        // Debug log for AccountID
        const accountIdElement = document.getElementById('account-id');
        if (!accountIdElement) {
            console.error('Account ID element not found');
            return;
        }
        const accountID = parseInt(accountIdElement.textContent);
        
        // Verify we have receipt items
        if (!receiptItems || receiptItems.length === 0) {
            console.error('No receipt items found');
            return;
        }
        
        // Get sales details
        const salesDetailsString = receiptItems.map(item => 
            `${item.item_name} - Quantity: ${item.quantity}, Price: ₱${item.total_item_price}`
        ).join('\n');
        
        // Get other required values with error checking
        const totalItems = parseInt(document.getElementById('total-items').textContent) || 0;
        const subtotal = parseFloat(document.getElementById('sub-total').textContent.replace('₱', '')) || 0;
        const tax = parseFloat(document.getElementById('tax').textContent.replace('₱', '')) || 0;
        const amountDue = parseFloat(document.getElementById('amount-due').textContent.replace('₱', '')) || 0;
        const payment = parseFloat(document.getElementById('payment').textContent.replace('₱', '')) || 0;
        const change = parseFloat(document.getElementById('change').textContent.replace('₱', '')) || 0;
        
        // Calculate discount
        let discount = 0.0;
        if (document.getElementById('seniorCitizenCheckbox').checked) discount += 0.20;
        if (document.getElementById('promoCheckbox').checked) discount += 0.10;

        const data = {
            invoiceID: parseInt(orderNumber),
            saleDate: saleDate,
            accountID: accountID,
            salesDetails: salesDetailsString,
            totalItems: totalItems,
            subtotal: subtotal,
            tax: tax,
            discount: discount,
            netAmount: amountDue,
            amountPaid: payment,
            amountChange: change
        };

        console.log('Sending data to server:', data);

        const response = await fetch('update_sales.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        console.log('Server response:', result);

        if (result.success) {
            console.log('Sale recorded successfully');
            basket = [];
            updateBasketDisplay();
            fetchInvoiceID();
            window.location.reload();  // Reloads the current page
        } else {
            console.error('Failed to record sale:', result.error);
            alert('Failed to save sale. Please check the console for details.');
        }
    } catch (error) {
        console.error('Error in print button handler:', error);
        alert('An error occurred while saving the sale. Please check the console for details.');
    }
});

//updated