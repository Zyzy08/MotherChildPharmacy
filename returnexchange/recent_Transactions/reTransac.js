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

document.getElementById('select-order-button').addEventListener('click', function (event) {
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

const modalVerifyTextAD = document.getElementById('modalVerifyText-AD');
const modalVerifyTitleAD = document.getElementById('modalVerifyTitle-AD');
const modalFooterAD = document.getElementById('modal-footer-AD');
const modalCloseAD = document.getElementById('modalClose-AD');
const modalYes = document.getElementById('modalYes');

modalYes.addEventListener('click', function (event) {
    // Create a form data object to send the content to PHP
    const formData = new FormData();
    formData.append('selectedOrder', selectedOrder);

    // Send the content to a PHP script that will create and print the file
    fetch('../returnInventory.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //Extra
                modalFooterAD.style.display = 'none'; // Set display to none to hide it
                modalCloseAD.style.display = 'none';
                modalVerifyTextAD.textContent = 'Order details has been returned successfully!';
                modalVerifyTitleAD.textContent = 'Success';
                setTimeout(() => {
                    window.location.href = '../returnexchange.php'; // Redirect on success
                }, 1000);
            } else {
                modalFooterAD.style.display = 'none'; // Set display to none to hide it
                modalCloseAD.style.display = 'none';
                modalVerifyTextAD.textContent = 'Order details were not returned due to an error!';
                modalVerifyTitleAD.textContent = 'Error';
                setTimeout(() => {
                    window.location.href = 'reTransac.php'; // Redirect on success
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalFooterAD.style.display = 'none'; // Set display to none to hide it
            modalCloseAD.style.display = 'none';
            modalVerifyTextAD.textContent = 'Order details were not returned due to an error!\n' + error;
            modalVerifyTitleAD.textContent = 'Error';
            setTimeout(() => {
                window.location.href = 'reTransac.php'; // Redirect on success
            }, 1000);
        });
})