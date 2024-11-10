function displayReceiptItems() {
  const receiptContainer = document.getElementById('receiptItems');
  receiptContainer.innerHTML = '';
  
  const headerHTML = `
      <div class="row text-center mb-2">
          <div class="col-4"><small><strong>Qty</strong></small></div>
          <div class="col-4"><small><strong>Item</strong></small></div>
      </div>
  `;
  receiptContainer.insertAdjacentHTML('beforeend', headerHTML);
  
  receiptItems.forEach(item => {
      const itemHTML = `
          <div class="row text-center">
              <div class="col-4"><small>${item.quantity}</small></div>
              <div class="col-4"><small>${item.item_name}</small></div>
          </div>
      `;
      receiptContainer.insertAdjacentHTML('beforeend', itemHTML);
  });
}

document.getElementById('select-order-button').addEventListener('click', function(event){
    goToReturnExchange();
})

//Selecting Order
function goToReturnExchange() {
    // Get the order number element and its text content
    const orderNumElement = document.getElementById("order-num");
    let orderNum = orderNumElement.textContent;

    // Remove the "#" from the order number
    orderNum = orderNum.replace("#", "");

    // Construct the URL with the order number as a query parameter
    const url = `../returnexchange.php?orderNum=${orderNum}`;

    // Navigate to the new URL
    window.location.href = url;
}
