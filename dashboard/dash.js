document.addEventListener('DOMContentLoaded', function() {
    const salesTotal = document.getElementById('sales-total');
    const percentageChange = document.getElementById('percentage-change');
    const changeText = document.getElementById('change-text');
    const periodText = document.getElementById('period-text');
    const dropdownItems = document.querySelectorAll('.dropdown-item');

    function fetchSalesData(period = 'today') {
        fetch(`fetchSalesData.php?period=${period}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                salesTotal.textContent = data.total;
                percentageChange.textContent = `${data.percentage}%`;
                changeText.textContent = data.changeType;

                // Update the color of the percentage change
                if (data.changeType === 'increase') {
                    percentageChange.className = 'text-success small pt-1 fw-bold';
                } else {
                    percentageChange.className = 'text-danger small pt-1 fw-bold';
                }

                // Update the period text
                periodText.textContent = `| ${period.charAt(0).toUpperCase() + period.slice(1)}`;
            })
            .catch(error => {
                console.error('Error:', error);
                salesTotal.textContent = 'Error loading data';
                percentageChange.textContent = '';
                changeText.textContent = '';
            });
    }

    // Fetch sales data when the page loads
    fetchSalesData();

    // Add event listeners to dropdown items
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const period = this.getAttribute('data-period');
            fetchSalesData(period);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const customerTotal = document.getElementById('customer-total');
    const customerPercentageChange = document.getElementById('customer-percentage-change');
    const customerChangeText = document.getElementById('customer-change-text');
    const customerPeriodText = document.getElementById('customer-period-text');
    const customerDropdownItems = document.querySelectorAll('.customers-card .dropdown-item');

    function fetchCustomerData(period = 'today') {
        fetch(`fetchCustomersData.php?period=${period}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received customer data:', data);
                customerTotal.textContent = data.total;
                customerPercentageChange.textContent = `${data.percentage}%`;
                customerChangeText.textContent = data.changeType;

                // Update the color of the percentage change
                if (data.changeType === 'increase') {
                    customerPercentageChange.className = 'text-success small pt-1 fw-bold';
                } else {
                    customerPercentageChange.className = 'text-danger small pt-1 fw-bold';
                }

                // Update the period text
                customerPeriodText.textContent = `| ${period.charAt(0).toUpperCase() + period.slice(1)}`;
            })
            .catch(error => {
                console.error('Error:', error);
                customerTotal.textContent = 'Error loading data';
                customerPercentageChange.textContent = '';
                customerChangeText.textContent = '';
            });
    }

    // Fetch customer data when the page loads
    fetchCustomerData();

    // Add event listeners to dropdown items
    customerDropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const period = this.getAttribute('data-period');
            fetchCustomerData(period);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const totalStock = document.getElementById('total-stock');

    function fetchInventoryData() {
        fetch('fetchInventoryData.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received inventory data:', data);
                totalStock.textContent = data.totalStock;
            })
            .catch(error => {
                console.error('Error:', error);
                totalStock.textContent = 'Error loading data';
            });
    }

    // Fetch inventory data when the page loads
    fetchInventoryData();
});