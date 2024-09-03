// client.js
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const hideIcon = document.getElementById('hide-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        hideIcon.setAttribute('src', 'resources/show.png'); // Replace with your show icon path
    } else {
        passwordInput.type = 'password';
        hideIcon.setAttribute('src', 'resources/hide.png'); // Replace with your hide icon path
    }
}

const data = {
    labels: ['Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'],
    datasets: [{
        label: 'Daily Sales (₱)',
        data: [12000, 15000, 8000, 20000, 18000, 22000, 19000],
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

// Configurations for the chart
const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};

// Render the chart
const myChart = new Chart(
    document.getElementById('myChart'),
    config
);

document.addEventListener("DOMContentLoaded", function() {
    const sidebarMenuItems = document.querySelectorAll(".sidebar-menu-item");

    sidebarMenuItems.forEach(item => {
        item.addEventListener("click", function(event) {
            event.preventDefault();
            const target = event.currentTarget;

            if (target.innerText.includes("Dashboard")) {
                window.location.href = "../dashboard/dashboard.html";
            } else if (target.innerText.includes("Products")) {
                window.location.href = "../products/products.html";
            } else if (target.innerText.includes("Suppliers")) {
                window.location.href = "../suppliers/suppliers.html";
            } else if (target.innerText.includes("Transactions")) {
                window.location.href = "../transactions/transactions.html";
            } else if (target.innerText.includes("POS")) {
                window.location.href = "../pos/pos.html";
            } else if (target.innerText.includes("Return / Exchange")) {
                window.location.href = "../returnexchange/return.html";
            } else if (target.innerText.includes("Accounts")) {
                window.location.href = "../accounts/accounts.html";
            } else if (target.innerText.includes("Reports")) {
                window.location.href = "../reports/reports.html";
            } else if (target.innerText.includes("Backup/Restore")) {
                window.location.href = "../backuprestore/backuprestore.html";
            } else {
                window.location.href = "../index.html";
            }
        });
    });
});
