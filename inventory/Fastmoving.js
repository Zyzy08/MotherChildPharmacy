function loadTopSellingProducts() {
    fetch('checkSales.php') // Fetch data from PHP script
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the JSON from the response
        })
        .then(products => {
            // Check if the response is an array
            if (!Array.isArray(products)) {
                console.error("Expected an array but got:", products);
                return; // Exit the function early
            }

            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = ''; // Clear existing rows

            // Populate table rows with fetched data
            products.forEach(product => {
                const row = document.createElement('tr');

                // Define maximum length for truncation
                const maxLength = 30;

                // Truncate GenericName and BrandName if they exceed maxLength
                const truncatedGenericName = product.GenericName.length > maxLength 
                    ? product.GenericName.substring(0, maxLength) + '...' 
                    : product.GenericName;
                const truncatedBrandName = product.BrandName.length > maxLength 
                    ? product.BrandName.substring(0, maxLength) + '...' 
                    : product.BrandName;

                // Use truncated values in the table cells
                row.innerHTML = `
                    <td style="text-align: center; font-size: 12px;">${product.itemID}</td>
                    <td style="text-align: center; font-size: 12px;" title="${product.GenericName}">${truncatedGenericName}</td>
                    <td style="text-align: center; font-size: 12px;" title="${product.BrandName}">${truncatedBrandName}</td>
                    <td style="text-align: center; font-size: 12px;">${product.Measurement}</td>
                    <td style="text-align: center; font-size: 12px;">${product.PricePerUnit}</td>
                    <td style="text-align: center; font-size: 12px;">${product.totalSold}</td>
                `;

                // Append row to table body
                tableBody.appendChild(row);
            });

            // Reinitialize DataTables with the updated data
            setDataTables();
        })
        .catch(error => {
            console.error("Error loading top-selling products:", error);
        });
}


// Function to initialize or reinitialize DataTables
function setDataTables() {
    if ($.fn.dataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy(); // Destroy the existing instance before reinitializing
    }

    var table = $('#example').DataTable({
        "order": [], // Disable initial sorting
        "autoWidth": false, // Disable automatic column width calculation
        "responsive": true, // Enable responsiveness
        "columnDefs": [
            { "targets": 0, "width": "5%" }, // Item ID
            { "targets": 1, "width": "8%", "orderable": false }, // Generic Name
            { "targets": 2, "width": "8%", "orderable": false }, // Brand Name
            { "targets": 3, "width": "5%", "orderable": false }, // Mass & Unit of Measure
            { "targets": 4, "width": "5%" }, // Price Per Unit
            { "targets": 5, "width": "5%" }, // Total Sold
        ]
    });

    // Adjust table layout on window resize
    $(window).on('resize', function() {
        table.columns.adjust().draw(); // Redraw the DataTable to adjust the columns
    });
}

// Load data and initialize the table when the page loads
window.onload = loadTopSellingProducts;