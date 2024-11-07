document.addEventListener("DOMContentLoaded", () => {
  fetchOrders();
});

async function fetchOrders() {
  try {
    // Replace the URL with your actual endpoint
    const response = await fetch('https://example.com/api/orders');
    const orders = await response.json();

    const accordionContainer = document.getElementById('accordionExample');
    accordionContainer.innerHTML = ''; // Clear any existing content

    orders.forEach((order, index) => {
      const itemsHtml = order.SalesDetails.map(item => `
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div>
            <img src="${item.imageUrl}" alt="${item.name}" width="50">
            <strong>${item.name}</strong>
            <p>${item.quantity} ${item.unit}</p>
            <p>₱${item.price}</p>
          </div>
          <div class="text-end">
            <span>₱${item.totalPrice}</span>
            <input type="checkbox" ${item.returned ? 'checked' : ''}> Return
          </div>
        </div>
      `).join('');

      const orderHtml = `
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading${index}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
              <div style="position: relative; width: 100%;">
                <div style="position: absolute; left: 0;">
                  <strong>Order #${order.InvoiceID}</strong>&nbsp;
                  <span>${order.SaleDate}</span>
                </div>
                <div style="position: absolute; right: 0; margin-right: 50px;">
                  <span style="text-decoration: underline;">${order.TotalItems} item/s</span>&nbsp;
                  <span>|</span>&nbsp;
                  <span style="text-decoration: underline;">₱${order.NetAmount}</span>
                </div>
              </div>
            </button>
          </h2>
          <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              ${itemsHtml}
              <div class="text-end">
                <button class="btn btn-success">Select Order</button>
              </div>
            </div>
          </div>
        </div>
      `;

      accordionContainer.insertAdjacentHTML('beforeend', orderHtml);
    });
  } catch (error) {
    console.error("Error fetching orders:", error);
  }
}