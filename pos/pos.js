let currentPage = 1;
const itemsPerPage = 8; // Number of items per page
let totalItems = 0; // Total number of items
let totalPages = 0; // Total pages
let searchQuery = ''; // Store the current search query

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
        const text = await response.text(); // Get the response as text

        // Extract JSON from the comment
        const jsonMatch = text.match(/<!-- (.*?) -->/);
        const data = jsonMatch ? JSON.parse(jsonMatch[1]) : []; // Parse JSON if found

        totalItems = data.length; // Set total items based on fetched data
        totalPages = Math.ceil(totalItems / itemsPerPage); // Calculate total pages

        return data;
    } catch (error) {
        console.error('Error fetching products:', error);
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

async function loadProducts() {
    const products = await fetchProducts(searchQuery);
    const productContainer = document.getElementById('product-list');
    productContainer.innerHTML = ''; // Clear the container

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
        const formattedUnit = formatUnitOfMeasure(product.UnitOfMeasure); // Format the unit
        let stockBadge = ''; // Initialize an empty string for the stock badge
    
       // Check the stock level and set the appropriate badge
        if (product.InStock == 0) {
            stockBadge = `<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>Out-of-Stock</span>`;
        } else if (product.InStock < 50 && product.InStock > 0) {
            stockBadge = `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Low-Stock</span>`;
        }
    
        const productHTML = `
            <div class="col-lg-3">
                <div class="card clickable-card" data-id="${product.BrandName.toLowerCase().replace(/ /g, "-")}" data-in-stock="${product.InStock}">
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

    // Reattach event listeners to the newly loaded cards
    attachCardListeners();
    updatePaginationControls(); // Update pagination after loading products

    // If there's a search query, select the first card
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

function attachCardListeners() {
    const cards = document.querySelectorAll('.clickable-card');
    const selectedCardId = localStorage.getItem('selectedCardId');
    if (selectedCardId) {
        const selectedCard = document.querySelector(`.clickable-card[data-id="${selectedCardId}"]`);
        if (selectedCard) {
            selectedCard.classList.add('active');
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            highlightCard(this);
        });
    });
}

function highlightCard(card) {
    // Check if the card has the "Out-of-Stock" badge (bg-danger)
    const outOfStockBadge = card.querySelector('.badge.bg-danger');
    if (outOfStockBadge) {
        return;
    }

    const selectedCardId = localStorage.getItem('selectedCardId');
    if (card.getAttribute('data-id') === selectedCardId) {
        card.classList.remove('active');
        localStorage.removeItem('selectedCardId');
    } else {
        const cards = document.querySelectorAll('.clickable-card');
        cards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        localStorage.setItem('selectedCardId', card.getAttribute('data-id'));
    }
}    

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
        event.preventDefault(); // Prevent form submission if it's in a form
        const selectedCardId = localStorage.getItem('selectedCardId');
        const firstCard = document.querySelector('.clickable-card');

        if (selectedCardId && firstCard) {
            // Check if the product is already selected (to add to quantity)
            if (selectedCardId === firstCard.getAttribute('data-id')) {
                // Product is already selected, increment the quantity by 1
                const quantityInput = document.getElementById('quantity-input');
                let currentQuantity = parseInt(quantityInput.value, 10) || 0;
                quantityInput.value = currentQuantity + 1; // Increment quantity
            }
        } else {
            // If no product is selected, update the search query and load products
            searchQuery = this.value; 
            currentPage = 1; 
            await loadProducts(); // Await the loadProducts function
            // Highlight the first product and set quantity to 1
            if (firstCard) {
                highlightCard(firstCard);
                const quantityInput = document.getElementById('quantity-input');
                if (quantityInput) {
                    quantityInput.value = 1; // Automatically set the value to 1
                    quantityInput.focus();    // Focus on the quantity input
                }
            }
        }
        
        // Clear the search bar
        this.value = ''; 
        
        // Set focus back to the search input
        searchInput.focus(); 
    }
});


// Load initial products and pagination
loadProducts();

let basket = [];
let basketTotal = 0;

// Function to add item to the basket
function addItemToBasket() {
    const selectedCard = document.querySelector('.clickable-card.active');
    if (!selectedCard) {
        alert("Please select a product first.");
        return;
    }

    const quantityInput = document.getElementById('quantity-input');
    const quantity = parseInt(quantityInput.value, 10);
    
    if (quantity < 1 || isNaN(quantity)) {
        alert("Please enter a valid quantity.");
        return;
    }

    const inStock = parseInt(selectedCard.getAttribute('data-in-stock'), 10);
    
    const existingItemIndex = basket.findIndex(item => item.id === selectedCard.getAttribute('data-id'));

    if (existingItemIndex > -1) {
        // Check if adding the quantity would exceed in-stock amount
        const newQuantity = basket[existingItemIndex].quantity + quantity;
        if (newQuantity > inStock) {
            alert(`Cannot add more. Only ${inStock} items are in stock.`);
            return;
        }
        basket[existingItemIndex].quantity += quantity;
    } else {
        if (quantity > inStock) {
            alert(`Cannot add more. Only ${inStock} items are in stock.`);
            return;
        }
        const product = {
            id: selectedCard.getAttribute('data-id'),
            BrandName: selectedCard.querySelector('.card-title').textContent,
            GenericName: selectedCard.querySelector('.card-text').textContent,
            PricePerUnit: parseFloat(selectedCard.querySelector('.badge.bg-success').textContent.replace('₱', '')),
            quantity: quantity
        };
        basket.push(product);
    }

    updateBasketDisplay();
    // Remove highlight and reset quantity
    selectedCard.classList.remove('active');
    quantityInput.value = ''; // Reset quantity input
}

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
    const totalWithTax = (basketTotal + parseFloat(tax)).toFixed(2); // Calculate total with tax
    document.getElementById('basket-total').textContent = `₱${totalWithTax}`; // Update total
    document.getElementById('basket-tax').textContent = `₱${tax}`; // Update tax display
}

// Function to remove item from the basket
function removeItemFromBasket(itemId) {
    basket = basket.filter(item => item.id !== itemId); // Remove item from basket
    updateBasketDisplay(); // Update display
}

// Add event listener to the "Add Item" button
document.getElementById('add-item-button').addEventListener('click', addItemToBasket);