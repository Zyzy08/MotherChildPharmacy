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
        const productHTML = `
            <div class="col-lg-3">
                <div class="card clickable-card" data-id="${product.BrandName.toLowerCase().replace(/ /g, "-")}">
                    <img src="../inventory/products-icon/${product.picture}" class="card-img-top"
                        style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                    <div class="card-body">
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

    function highlightCard(card) {
        const selectedCardId = localStorage.getItem('selectedCardId');
        if (card.getAttribute('data-id') === selectedCardId) {
            card.classList.remove('active');
            localStorage.removeItem('selectedCardId');
        } else {
            cards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            localStorage.setItem('selectedCardId', card.getAttribute('data-id'));
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            highlightCard(this);
        });
    });
}

// Add event listener for the search input
document.querySelector('input[name="query"]').addEventListener('input', function() {
    searchQuery = this.value; // Update the search query
    currentPage = 1; // Reset to the first page
    loadProducts(); // Load products based on the new query
});

// Load initial products and pagination
loadProducts();