function displayReceiptItems() {
    const receiptContainer = document.getElementById('receiptItems');
    receiptContainer.innerHTML = '';
    
    const headerHTML = `
        <div class="row text-center mb-2">
            <div class="col-4"><small><strong>Qty</strong></small></div>
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
                <div class="col-3"><small>₱${formatPrice(item.total_item_price)}</small></div>
            </div>
        `;
        receiptContainer.insertAdjacentHTML('beforeend', itemHTML);
    });
}