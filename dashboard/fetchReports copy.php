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
            $periodFormat = "HOUR(SaleDate)";
            break;
        case 'month':
            $dateCondition = "YEAR(SaleDate) = YEAR(CURDATE()) AND MONTH(SaleDate) = MONTH(CURDATE())";
            $compareCondition = "YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(SaleDate) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
            $groupBy = "DATE(SaleDate)";
            $periodFormat = "DAY(SaleDate)";
            break;
        case 'year':
            $dateCondition = "YEAR(SaleDate) = YEAR(CURDATE())";
            $compareCondition = "YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))";
            $groupBy = "MONTH(SaleDate)";
            $periodFormat = "MONTH(SaleDate)";
            break;
        default:
            throw new Exception("Invalid period specified");
    }
    
    // Get current period data with both sales and customer counts
    $query = "
        SELECT 
            $periodFormat as period,
            SUM(NetAmount) as total_sales,
            COUNT(DISTINCT InvoiceID) as total_transactions,
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
            COUNT(DISTINCT InvoiceID) as total_transactions,
            COUNT(DISTINCT AccountID) as unique_customers
        FROM sales
        WHERE $compareCondition
    ";
    
    $stmt = $conn->prepare($compareQuery);
    $stmt->execute();
    $previousData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Calculate totals and percentage changes
    $currentTotalSales = array_sum(array_column($currentData, 'total_sales'));
    $currentTotalTransactions = array_sum(array_column($currentData, 'total_transactions'));
    $currentTotalCustomers = array_sum(array_column($currentData, 'unique_customers'));
    
    $previousTotalSales = $previousData['total_sales'] ?: 0;
    $previousTotalTransactions = $previousData['total_transactions'] ?: 0;
    $previousTotalCustomers = $previousData['unique_customers'] ?: 0;
    
    $salesPercentage = $previousTotalSales > 0 ? (($currentTotalSales - $previousTotalSales) / $previousTotalSales) * 100 : 0;
    $transactionsPercentage = $previousTotalTransactions > 0 ? (($currentTotalTransactions - $previousTotalTransactions) / $previousTotalTransactions) * 100 : 0;
    $customersPercentage = $previousTotalCustomers > 0 ? (($currentTotalCustomers - $previousTotalCustomers) / $previousTotalCustomers) * 100 : 0;
    
    // Fill in any missing periods with zero values
    $filledData = [];
    switch($period) {
        case 'today':
            for($i = 0; $i < 24; $i++) {
                $found = false;
                foreach($currentData as $row) {
                    if((int)$row['period'] === $i) {
                        $filledData[] = $row;
                        $found = true;
                        break;
                    }
                }
                if(!$found) {
                    $filledData[] = [
                        'period' => $i,
                        'total_sales' => 0,
                        'total_transactions' => 0,
                        'unique_customers' => 0
                    ];
                }
            }
            break;
            
        case 'month':
            $daysInMonth = date('t');
            for($i = 1; $i <= $daysInMonth; $i++) {
                $found = false;
                foreach($currentData as $row) {
                    if((int)$row['period'] === $i) {
                        $filledData[] = $row;
                        $found = true;
                        break;
                    }
                }
                if(!$found) {
                    $filledData[] = [
                        'period' => $i,
                        'total_sales' => 0,
                        'total_transactions' => 0,
                        'unique_customers' => 0
                    ];
                }
            }
            break;
            
        case 'year':
            for($i = 1; $i <= 12; $i++) {
                $found = false;
                foreach($currentData as $row) {
                    if((int)$row['period'] === $i) {
                        $filledData[] = $row;
                        $found = true;
                        break;
                    }
                }
                if(!$found) {
                    $filledData[] = [
                        'period' => $i,
                        'total_sales' => 0,
                        'total_transactions' => 0,
                        'unique_customers' => 0
                    ];
                }
            }
            break;
    }
    
    echo json_encode([
        'chart_data' => $filledData,
        'totals' => [
            'sales' => $currentTotalSales,
            'sales_change' => $salesPercentage,
            'transactions' => $currentTotalTransactions,
            'transactions_change' => $transactionsPercentage,
            'customers' => $currentTotalCustomers,
            'customers_change' => $customersPercentage
        ]
    ]);
    
} catch(Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

$conn = null;
?>