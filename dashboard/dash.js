document.addEventListener('DOMContentLoaded', function () {
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
        if (item.id !== 'myprofiledropdownselect') {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const period = this.getAttribute('data-period');
                fetchSalesData(period);
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
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
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const period = this.getAttribute('data-period');
            fetchCustomerData(period);
        });
    });
});

let inventoryLink = "../inventory/inventory.php";

document.addEventListener('DOMContentLoaded', function () {
    const inventoryCount = document.getElementById('inventory-count');
    const statusText = document.getElementById('status-text');
    const statusIcon = document.getElementById('status-icon');
    const statusDescription = document.getElementById('status-description');
    let currentStatus = 'in-stock';

    const statusConfigs = {
        'in-stock': {
            icon: 'bi-box-seam',
            iconClass: 'text-primary',
            bgClass: 'bg-primary-light',
            textClass: 'text-primary',
            description: 'In-Stock Items'
        },
        'low-stock': {
            icon: 'bi-exclamation-triangle',
            iconClass: 'text-warning',
            bgClass: 'bg-warning-light',
            textClass: 'text-warning',
            description: 'Low-Stock Items'
        },
        'overstock': {
            icon: 'bi-arrow-up-circle',
            iconClass: 'text-info',
            bgClass: 'bg-info-light',
            textClass: 'text-info',
            description: 'Overstock Items'
        },
        'out-of-stock': {
            icon: 'bi-x-circle',
            iconClass: 'text-danger',
            bgClass: 'bg-danger-light',
            textClass: 'text-danger',
            description: 'Out-of-Stock Items'
        },
        'near-expiry': {
            icon: 'bi-clock',
            iconClass: 'text-secondary',
            bgClass: 'bg-secondary-light',
            textClass: 'text-secondary',
            description: 'Near Expiry Items'
        }
    };

    function updateCardAppearance(status) {
        const config = statusConfigs[status];
        let inventoryLink = "../inventory/inventory.php";

        if (status === 'low-stock') {
            inventoryLink = "../inventory/inventory.php?trigger=lowStock";
        }

        // Update icon
        statusIcon.innerHTML = `<a href="${inventoryLink}" class="card-icon rounded-circle d-flex align-items-center justify-content-center ${config.bgClass}" style="text-decoration: none;">
                                    <i style="cursor: pointer;" class="bi ${config.icon} ${config.iconClass}"></i>
                                </a>`;

        // Update text
        statusDescription.className = `${config.textClass} small pt-1 fw-bold`;
        statusDescription.textContent = config.description;
    }

    function fetchInventoryData(status = 'in-stock') {
        fetch(`fetchInventoryData.php?status=${status}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received inventory stats:', data);
                inventoryCount.textContent = data.count;
                updateCardAppearance(data.status);
            })
            .catch(error => {
                console.error('Error:', error);
                inventoryCount.textContent = 'Error';
            });
    }

    // Add click event listeners to filter dropdown items
    document.querySelectorAll('.dropdown-item-inv').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const status = this.dataset.status;
            currentStatus = status;
            fetchInventoryData(status);
        });
    });

    // Initial fetch of inventory stats
    fetchInventoryData(currentStatus);

    // Optional: Refresh data periodically (every 5 minutes)
    setInterval(() => fetchInventoryData(currentStatus), 300000);
});

document.addEventListener("DOMContentLoaded", function () {
    fetch("fetchTodaySales.php")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector(".recent-sales tbody");
            tableBody.innerHTML = ""; // Clear existing rows

            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">No sales found for today</td>
                    </tr>
                `;
                return;
            }

            // Populate the table with today's sales data
            data.forEach((sale) => {
                // Format the date to show only time
                const saleTime = new Date(sale.SaleDate).toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                // Split sale.Items by commas (assuming items are comma-separated), truncate each item, and join them back
                const truncatedItems = sale.Items.split("<br /><br />").map(item =>
                    item.length > 25 ? item.substring(0, 25) + "..." : item
                ).join("<br /><br />");

                // Display items and quantities in separate columns
                const row = `
                    <tr>
                        <th scope="row">#${sale.InvoiceID}</th>
                        <td>${saleTime}</td>
                        <td>${truncatedItems}</td>
                        <td>${sale.Quantities}</td>
                        <td>₱${sale.NetAmount.toFixed(2)}</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch(error => {
            console.error("Error fetching sales data:", error);
            const tableBody = document.querySelector(".recent-sales tbody");
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">Error loading sales data</td>
                </tr>
            `;
        });
});

document.addEventListener("DOMContentLoaded", function () {
    fetch("fetchDeliveries.php")
        .then(response => response.json())
        .then(data => {
            const activityContent = document.getElementById("activity-content");
            activityContent.innerHTML = ""; // Clear existing content

            if (data.length > 0) {
                data.forEach(delivery => {
                    // Set color based on status
                    let statusColor;
                    switch (delivery.Status) {
                        case 'Delivered':
                            statusColor = "text-success"; // Green
                            break;
                        case 'Pending':
                            statusColor = "text-warning"; // Yellow
                            break;
                        case 'Cancelled':
                            statusColor = "text-danger"; // Red
                            break;
                        case 'Back Order':
                            statusColor = "text-primary"; // Blue
                            break;
                        default:
                            statusColor = "text-muted"; // Gray for unknown status
                    }

                    // Format OrderDate for display
                    const orderDate = new Date(delivery.OrderDate);
                    const month = orderDate.toLocaleDateString('en-US', { month: 'short' }) + '.';
                    const day = orderDate.toLocaleDateString('en-US', { day: 'numeric' });
                    const dateLabel = `${month} ${day}`;



                    // Create the HTML for each delivery item
                    const activityItem = document.createElement("div");
                    activityItem.classList.add("activity-item", "d-flex");

                    activityItem.innerHTML = `
                        <div class="activite-label">${dateLabel}</div>
                        <i class="bi bi-circle-fill activity-badge ${statusColor} align-self-start"></i>
                        <div class="activity-content">
                            Order #PO-0${delivery.PurchaseOrderID} - <span class="fw-bold">${delivery.Status}</span>
                        </div>
                    `;

                    activityContent.appendChild(activityItem);
                });
            } else {
                activityContent.innerHTML = "<p>No deliveries to display.</p>";
            }
        })
        .catch(error => console.error("Error fetching deliveries data:", error));
});

document.addEventListener('DOMContentLoaded', function () {
    fetch('../inventory/setReorderLevel.php', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
        .catch(error => {
            console.error('Error calling PHP script:', error);
        });
});

document.getElementById("export_PDF").addEventListener("click", function() {
    // Create a temporary container to hold all the tables
    const container = document.createElement('div');
    
    // Grab all the tables inside the container
    const tables = document.querySelectorAll('.datatable_report table');
    
    // Define custom titles for each section
    const titles = [
        "Today's Sales",  // Title for the first table (Today's Sales)
        "This Month's Sales",  // Title for the second table (This Month's Sales)
        "This Year's Sales"  // Title for the third table (This Year's Sales)
    ];

    // Add a title for each table
    tables.forEach(function(table, index) {
        // Create a title for each table (using the defined titles array)
        const title = document.createElement('h2');
        title.textContent = titles[index];  // Use the title from the array
        title.style.textAlign = 'center';  // Center align the title
        title.style.marginBottom = '10px';  // Space below the title
        container.appendChild(title);
        
        // Clone the table to avoid affecting the DOM and append it
        const clone = table.cloneNode(true);
        
        // Apply table styling to shrink it slightly
        clone.style.width = '90%';  // Reduce the width to 90% of the container
        clone.style.margin = '0 auto';  // Center the table horizontally
        clone.style.fontSize = '0.9em';  // Reduce the font size slightly
        clone.style.borderCollapse = 'collapse';  // Collapse borders for a more compact look
        
        // Apply padding to cells to reduce spacing
        const cells = clone.querySelectorAll('td, th');
        cells.forEach(cell => {
            cell.style.padding = '8px';  // Reduce padding for a smaller table
        });

        container.appendChild(clone);
        
        // Add a separator after each table, except the last one
        if (index < tables.length - 1) {
            const separator = document.createElement('hr');
            separator.style.border = '1px solid #ccc';  // Style the separator
            separator.style.margin = '20px 0';  // Space above and below the separator
            container.appendChild(separator);
        }
    });

    // Get today's date in the format YYYY-MM-DD
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0]; // Formats date as YYYY-MM-DD

    // Use html2pdf to generate the PDF from the temporary container
    html2pdf()
        .from(container)
        .save(`Sales_Report_${formattedDate}.pdf`);  // File name with today's date

});

document.getElementById("export_PDF_inv").addEventListener("click", function() {
    // Create a temporary container to hold all the tables
    const container = document.createElement('div');
    
    // Grab all the tables inside the container
    const tables = document.querySelectorAll('.datatable_report_inv table');
    
    // Define custom titles for each section
    const titles = [
        "In Stock Items",
        "Low Stock Items",  
        "Overstock Items", 
        "Out of Stock Items",
        "Near Expiry Items"
    ];

    // Add a title for each table
    tables.forEach(function(table, index) {
        // Create a title for each table (using the defined titles array)
        const title = document.createElement('h2');
        title.textContent = titles[index];  // Use the title from the array
        title.style.textAlign = 'center';  // Center align the title
        title.style.marginBottom = '10px';  // Space below the title
        container.appendChild(title);
        
        // Clone the table to avoid affecting the DOM and append it
        const clone = table.cloneNode(true);
        
        // Apply table styling to shrink it slightly
        clone.style.width = '90%';  // Reduce the width to 90% of the container
        clone.style.margin = '0 auto';  // Center the table horizontally
        clone.style.fontSize = '0.9em';  // Reduce the font size slightly
        clone.style.borderCollapse = 'collapse';  // Collapse borders for a more compact look
        
        // Apply padding to cells to reduce spacing
        const cells = clone.querySelectorAll('td, th');
        cells.forEach(cell => {
            cell.style.padding = '8px';  // Reduce padding for a smaller table
        });

        container.appendChild(clone);
        
        // Add a separator after each table, except the last one
        if (index < tables.length - 1) {
            const separator = document.createElement('hr');
            separator.style.border = '1px solid #ccc';  // Style the separator
            separator.style.margin = '20px 0';  // Space above and below the separator
            container.appendChild(separator);
        }
    });

    // Get today's date in the format YYYY-MM-DD
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0]; // Formats date as YYYY-MM-DD

    // Use html2pdf to generate the PDF from the temporary container
    html2pdf()
        .from(container)
        .save(`Inventory_Report_${formattedDate}.pdf`);  // File name with today's date
});