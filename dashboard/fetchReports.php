<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the period from the request
    $period = isset($_GET['period']) ? $_GET['period'] : 'today';
    
    // Define date conditions based on period
    switch($period) {
        case 'today':
            $dateCondition = "DATE(SaleDate) = CURDATE()";
            $compareCondition = "DATE(SaleDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
            $groupBy = "HOUR(SaleDate)";
            break;
        case 'month':
            $dateCondition = "YEAR(SaleDate) = YEAR(CURDATE()) AND MONTH(SaleDate) = MONTH(CURDATE())";
            $compareCondition = "YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(SaleDate) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
            $groupBy = "DATE(SaleDate)";
            break;
        case 'year':
            $dateCondition = "YEAR(SaleDate) = YEAR(CURDATE())";
            $compareCondition = "YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))";
            $groupBy = "MONTH(SaleDate)";
            break;
        default:
            $dateCondition = "DATE(SaleDate) = CURDATE()";
            $compareCondition = "DATE(SaleDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
            $groupBy = "HOUR(SaleDate)";
    }
    
    // Get current period data
    $query = "
        SELECT 
            $groupBy as period,
            SUM(NetAmount) as total_sales,
            COUNT(DISTINCT AccountID) as unique_customers
        FROM sales
        WHERE $dateCondition
        GROUP BY $groupBy
        ORDER BY period ASC
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $currentData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get previous period data for comparison
    $compareQuery = "
        SELECT 
            SUM(NetAmount) as total_sales,
            COUNT(DISTINCT AccountID) as unique_customers
        FROM sales
        WHERE $compareCondition
    ";
    
    $stmt = $conn->prepare($compareQuery);
    $stmt->execute();
    $previousData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Calculate totals and percentage changes
    $currentTotal = array_sum(array_column($currentData, 'total_sales'));
    $currentCustomers = array_sum(array_column($currentData, 'unique_customers'));
    
    $previousTotal = $previousData['total_sales'] ?: 0;
    $previousCustomers = $previousData['unique_customers'] ?: 0;
    
    $salesPercentage = $previousTotal > 0 ? (($currentTotal - $previousTotal) / $previousTotal) * 100 : 0;
    $customerPercentage = $previousCustomers > 0 ? (($currentCustomers - $previousCustomers) / $previousCustomers) * 100 : 0;
    
    echo json_encode([
        'chart_data' => $currentData,
        'totals' => [
            'sales' => $currentTotal,
            'sales_change' => $salesPercentage,
            'customers' => $currentCustomers,
            'customers_change' => $customerPercentage
        ]
    ]);
    
} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

$conn = null;
?>