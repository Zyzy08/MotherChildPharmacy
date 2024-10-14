window.onload = loadProducts;

let currentPage = 1;
const itemsPerPage = 8;
let totalItems = 0;
let totalPages = 0;
let searchQuery = '';
let basket = [];

async function fetchProducts(query = '') {
    try {
        const response = await fetch('fetchProductData.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

function formatUnitOfMeasure(unit) {
    const unitMap = {
        milligrams: 'mg',
        grams: 'g',
        liters: 'L',
        milliliters: 'mL',
        piece: 'pc'
    };
    return unitMap[unit.toLowerCase()] || unit;
}

async function loadProducts() {
    const products = await fetchProducts(searchQuery);
    const productContainer = document.getElementById('product-list');
    productContainer.innerHTML = '';

    document.querySelectorAll('.clickable-card').forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');

    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedProducts = products.slice(startIndex, startIndex + itemsPerPage);

    paginatedProducts.forEach(product => {
        const formattedUnit = formatUnitOfMeasure(product.UnitOfMeasure);
        let stockBadge = '';
        let cardClass = 'clickable-card';

        if (product.InStock == 0) {
            stockBadge = `<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>Out-of-Stock</span>`;
            cardClass = 'non-clickable-card';
        } else if (product.InStock < 50) {
            stockBadge = `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Low-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
        } else {
            stockBadge = `<span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i>In-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
        }

        const productHTML = `
            <div class="col-lg-3">
                <div class="card ${cardClass}" data-id="${product.BrandName.toLowerCase().replace(/ /g, "-")}" data-product='${JSON.stringify(product)}'>
                    ${stockBadge}
                    <img src="../inventory/${product.ProductIcon}" class="card-img-top" style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
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
    paginationList.innerHTML = '';

    paginationList.insertAdjacentHTML('beforeend', `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}" id="prev-page">
            <a class="page-link" href="#">Previous</a>
        </li>
    `);

    for (let i = 1; i <= totalPages; i++) {
        paginationList.insertAdjacentHTML('beforeend', `
            <li class="page-item ${i === currentPage ? 'active' : ''}" id="page-${i}">
                <a class="page-link" href="#">${i}</a>
            </li>
        `);
    }

    paginationList.insertAdjacentHTML('beforeend', `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}" id="next-page">
            <a class="page-link" href="#">Next</a>
        </li>
    `);

    for (let i = 1; i <= totalPages; i++) {
        document.getElementById(`page-${i}`)?.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = i;
            loadProducts();
        });
    }

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

function attachCardListeners() {
    document.querySelectorAll('.clickable-card').forEach(card => {
        card.addEventListener('click', function() {
            highlightCard(this);
            const productData = JSON.parse(this.dataset.product);
            showQuantityModal(productData);
        });
    });
}

document.head.insertAdjacentHTML('beforeend', `
    <style>
        .non-clickable-card {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
`);

const searchInput = document.querySelector('input[name="query"]');
searchInput.addEventListener('input', function() {
    searchQuery = this.value;
    currentPage = 1;
    loadProducts();
});

searchInput.addEventListener('keypress', async function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        if (this.value.trim() === '') return;
        searchQuery = this.value;
        currentPage = 1;
        await loadProducts();
        const firstClickableCard = document.querySelector('.clickable-card');
        if (firstClickableCard) {
            highlightCard(firstClickableCard);
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
    let stockBadge = product.InStock < 50 ? 
        `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Low-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>` :
        `<span class="badge bg-info text-dark"><i class="bi bi-info-circle me-1"></i>In-Stock <span class="badge bg-white text-primary">${product.InStock}</span></span>`;
    
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

    const quantityInput = document.getElementById('quantity-input');
    quantityInput.value = 1;
    quantityInput.max = product.InStock;

    const addItemButton = document.getElementById('add-item-button');
    addItemButton.onclick = () => {
        const quantity = parseInt(quantityInput.value, 10);
        if (quantity > 0 && quantity <= product.InStock) {
            addItemToBasket(product, quantity);
            bootstrap.Modal.getInstance(document.getElementById('quantity-modal')).hide();
        } else {
            showToast("Please enter a valid quantity.");
        }
    };

    new bootstrap.Modal(document.getElementById('quantity-modal')).show();
}

document.getElementById('quantity-cancel').addEventListener('click', function() {
    document.querySelectorAll('.clickable-card').forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');
});

function highlightCard(card) {
    if (card.querySelector('.badge.bg-danger')) return;
    document.querySelectorAll('.clickable-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    localStorage.setItem('selectedCardId', card.getAttribute('data-id'));
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function showToast(message) {
    const toastBody = document.querySelector('#alert-toast .toast-body');
    toastBody.textContent = message;
    const toast = new bootstrap.Toast(document.getElementById('alert-toast'));
    toast.show();
}

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
    updateBasketDisplay();
    updateCheckoutButtonState();
    deselectCurrentItem();
}

function deselectCurrentItem() {
    document.querySelectorAll('.clickable-card').forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');
}

function updateBasketDisplay() {
    const basketItemsContainer = document.getElementById('basket-items');
    basketItemsContainer.innerHTML = '';
    let basketTotal = 0;

    basket.forEach(item => {
        const itemTotal = item.PricePerUnit * item.quantity;
        basketTotal += itemTotal;

        basketItemsContainer.insertAdjacentHTML('beforeend', `
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
        `);
    });

    const tax = (basketTotal * 0.12).toFixed(2);
    const totalAmount = (basketTotal + parseFloat(tax)).toFixed(2);
    document.getElementById('basket-total').textContent = `₱${totalAmount}`;
    document.getElementById('basket-tax').textContent = `₱${tax}`;
    updateCheckoutButtonState();
}

function removeItemFromBasket(itemId) {
    basket = basket.filter(item => item.id !== itemId);
    updateBasketDisplay();
    updateCheckoutButtonState();
}

function updateCheckoutButtonState() {
    const checkoutButton = document.querySelector('button[data-bs-target="#verticalycentered"]');
    checkoutButton.disabled = basket.length === 0;
    checkoutButton.classList.toggle('btn-secondary', basket.length === 0);
    checkoutButton.classList.toggle('btn-primary', basket.length > 0);
}

document.addEventListener('DOMContentLoaded', updateCheckoutButtonState);

document.getElementById('clear-search').addEventListener('click', function(event) {
    event.preventDefault();
    clearSearch();
});

function clearSearch() {
    const searchInput = document.querySelector('input[name="query"]');
    searchInput.value = '';
    searchQuery = '';
    currentPage = 1;
    loadProducts();
    searchInput.focus();
    document.querySelectorAll('.clickable-card').forEach(card => card.classList.remove('active'));
    localStorage.removeItem('selectedCardId');
}

document.getElementById('verticalycentered').addEventListener('show.bs.modal', updateModalTotal);

document.querySelectorAll('#verticalycentered .form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', updateModalTotal);
});

function updateModalTotal() {
    const subtotal = basket.reduce((total, item) => total + (item.PricePerUnit * item.quantity), 0);
    const tax = subtotal * 0.12;
    let discountPercentage = 0;

    if (document.getElementById('seniorCitizenCheckbox').checked) discountPercentage += 20;
    if (document.getElementById('promoCheckbox').checked) discountPercentage += 10;

    const discountAmount = subtotal * (discountPercentage / 100);
    const discountedTotal = subtotal + tax - discountAmount;

    document.getElementById('total-display').textContent = `Total: ₱${discountedTotal.toFixed(2)}`;
}

let receiptItems = [];

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

function updateTotalItemsDisplay() {
    const totalQuantity = receiptItems.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('total-items').textContent = totalQuantity;
}

function updateSubtotalDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0).toFixed(2);
    document.getElementById('sub-total').textContent = `₱${subtotal}`;
}

function updateTaxDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0);
    const tax = (subtotal * 0.12).toFixed(2);
    document.getElementById('tax').textContent = `₱${tax}`;
}

function updateAmountDueDisplay() {
    const subtotal = receiptItems.reduce((total, item) => total + parseFloat(item.total_item_price), 0);
    const tax = subtotal * 0.12;
    const amountDue = (subtotal + tax).toFixed(2);
    document.getElementById('amount-due').textContent = `₱${amountDue}`;
}

function displayReceiptItems() {
    const receiptContainer = document.getElementById('receiptItems');
    receiptContainer.innerHTML = '';
    
    const headerHTML = `
        <div class="row text-center mb-2">
            <div class="col-4"><small><strong>Quantity</strong></small></div>
            <div class="col-4"><small><strong>Item</strong></small></div>
            <div class="col-3"><small><strong>Price</strong></small></div>
        </div>
    `;
    receiptContainer.insertAdjacentHTML('beforeend', headerHTML);
    
    receiptItems.forEach(item => {
        const itemHTML = `
            <div class="row text-center">
                <div class="col-4"><small>${item.quantity}</small></div>
                <div class="col-4"><small>${item.item_name}</small></div>
                <div class="col-3"><small>₱${item.total_item_price}</small></div>
            </div>
        `;
        receiptContainer.insertAdjacentHTML('beforeend', itemHTML);
    });
}

function updatePaymentDisplay() {
    const payment = parseFloat(document.getElementById("paymentInput").value) || 0;
    document.getElementById("payment").textContent = `₱${payment.toFixed(2)}`;
}

function updateChangeDisplay() {
    const payment = parseFloat(document.getElementById("paymentInput").value) || 0;
    const amountDue = parseFloat(document.getElementById('amount-due').textContent.replace(/[^0-9.-]+/g,""));
    const change = Math.max(0, payment - amountDue);
    document.getElementById("change").textContent = `₱${change.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('checkout');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function() {
            if (basket.length === 0) {
                showToast("Your basket is empty. Please add items before checking out.");
                return;
            }
            generateReceiptItems();
            displayReceiptItems();
            updatePaymentDisplay();
            updateChangeDisplay();
            updateModalTotal();

            const checkoutModal = new bootstrap.Modal(document.getElementById('verticalycentered'));
            checkoutModal.show();
        });
    }
});

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
    
    updatePaymentDisplay();
    updateChangeDisplay();
});

document.getElementById('cancel-receipt').addEventListener('click', function() {
    setTimeout(() => {
        const checkoutModal = new bootstrap.Modal(document.getElementById('verticalycentered'));
        checkoutModal.show();
    }, 100);
});

function fetchInvoiceID() {
    fetch('fetchOrderNumber.php')
        .then(response => response.json())
        .then(data => {
            const newInvoiceID = data.newInvoiceID;
            const formattedInvoiceID = newInvoiceID > 0 ? `#${newInvoiceID}` : '#0';
            document.getElementById('order-num').textContent = `Order No.: ${formattedInvoiceID}`;
        })
        .catch(error => console.error('Error fetching InvoiceID:', error));
}

document.addEventListener('DOMContentLoaded', fetchInvoiceID);

document.getElementById('print-button').addEventListener('click', function() {
    // Collect all the necessary data
    const invoiceID = parseInt(document.getElementById('order-num').textContent.match(/\d+/)[0]);
    const saleDate = document.getElementById('date').textContent + ' ' + document.getElementById('time').textContent;
    const accountID = parseInt(document.getElementById('staff').textContent.match(/\d+/)[0]);
    
    // Collect sales details
    const salesDetails = [];
    document.querySelectorAll('#receiptItems .row:not(:first-child)').forEach(row => {
        const columns = row.querySelectorAll('small');
        salesDetails.push({
            quantity: parseInt(columns[0].textContent),
            item_name: columns[1].textContent,
            total_item_price: parseFloat(columns[2].textContent.replace('₱', ''))
        });
    });
    
    const totalItems = parseInt(document.getElementById('total-items').textContent);
    const subtotal = parseFloat(document.getElementById('sub-total').textContent.replace('₱', ''));
    const tax = parseFloat(document.getElementById('tax').textContent.replace('₱', ''));
    const discount = parseFloat(document.getElementById('total-display').textContent.match(/Total: ₱([\d.]+)/)[1]) - subtotal - tax;
    const netAmount = parseFloat(document.getElementById('amount-due').textContent.replace('₱', ''));
    const amountPaid = parseFloat(document.getElementById('payment').textContent.replace('₱', ''));
    const amountChange = parseFloat(document.getElementById('change').textContent.replace('₱', ''));

    // Prepare the data object
    const saleData = {
        invoiceID,
        saleDate,
        accountID,
        salesDetails: JSON.stringify(salesDetails),
        totalItems,
        subtotal,
        tax,
        discount,
        netAmount,
        amountPaid,
        amountChange
    };

    console.log('Sale data being sent:', saleData);

    // Send the data to the server
    fetch('update_sales.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(saleData),
    })
    .then(response => {
        console.log('Raw response:', response);
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('Error parsing JSON:', error);
            throw new Error('Invalid JSON response');
        }
    })
    .then(data => {
        if (data.success) {
            console.log('Sale recorded successfully');
            // Proceed with printing logic here
            window.print();
            // Clear the basket and update the UI
            basket = [];
            updateBasketDisplay();
            updateCheckoutButtonState();
            // Close the modal
            bootstrap.Modal.getInstance(document.getElementById('verticalycentered')).hide();
            // Show a success message
            showToast('Sale completed and printed successfully!');
            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            console.error('Error recording sale:', data.error);
            showToast('Error recording sale. Please try again.');
        }
    })
    .catch((error) => {
        console.error('Fetch error:', error);
        showToast('An error occurred. Please try again.');
    });
});