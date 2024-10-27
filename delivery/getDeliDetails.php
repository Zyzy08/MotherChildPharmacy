<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'DeliveryID' is set in the query string
if (isset($_GET['DeliveryID'])) {
    $DeliveryID = $conn->real_escape_string($_GET['DeliveryID']);

    // SQL query to fetch delivery details along with the supplier and employee names
    $sql = "
    SELECT 
        d.DeliveryID, 
        s.SupplierName, 
        u.employeeName, 
        u.employeeLName, 
        DATE_FORMAT(d.DeliveryDate, '%m/%d/%Y') AS DeliveryDate,
        d.DeliveryStatus, 
        po.OrderDetails
    FROM 
        deliveries d
    JOIN 
        suppliers s ON d.SupplierID = s.SupplierID
    JOIN 
        users u ON d.ReceivedBy = u.AccountID
    JOIN 
        purchaseorders po ON d.PurchaseOrderID = po.PurchaseOrderID
    WHERE 
        d.DeliveryID = '$DeliveryID';
    ";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Parse OrderDetails JSON
        $orderDetails = json_decode($data['OrderDetails'], true);
        $listItems = [];

        // Loop through order details to gather item information
        foreach ($orderDetails as $detail) {
            $itemID = $detail['itemID'];
            $orderedQty = $detail['qty'];

            // Fetch item details from the inventory
            $sqlItem = "
                SELECT GenericName, BrandName, Mass, UnitOfMeasure 
                FROM inventory 
                WHERE ItemID = '$itemID';
            ";
            $itemResult = $conn->query($sqlItem);
            
            if ($itemResult->num_rows > 0) {
                $itemData = $itemResult->fetch_assoc();
                $genericName = $itemData['GenericName'];
                $brandName = $itemData['BrandName'];
                $mass = $itemData['Mass'];
                $unitOfMeasure = $itemData['UnitOfMeasure'];

                // Fetch delivery item details based on DeliveryID and ItemID
                $sqlDeliveryItem = "
                    SELECT 
                        di.LotNumber,
                        DATE_FORMAT(di.ExpiryDate, '%m/%d/%Y') AS ExpiryDate,
                        di.QuantityDelivered, 
                        di.Bonus, 
                        di.NetAmount 
                    FROM 
                        delivery_items di 
                    WHERE 
                        di.DeliveryID = '$DeliveryID' AND di.ItemID = '$itemID';
                ";
                $deliveryItemResult = $conn->query($sqlDeliveryItem);
                
                if ($deliveryItemResult->num_rows > 0) {
                    $deliveryItemData = $deliveryItemResult->fetch_assoc();

                    // Add item to the list with all required information
                    $listItems[] = [
                        'description' => "$brandName $genericName ($mass $unitOfMeasure)",
                        'quantity_ordered' => $orderedQty,
                        'lot_number' => $deliveryItemData['LotNumber'],
                        'expiry_date' => $deliveryItemData['ExpiryDate'],
                        'quantity_delivered' => $deliveryItemData['QuantityDelivered'],
                        'bonus' => $deliveryItemData['Bonus'],
                        'net_amount' => $deliveryItemData['NetAmount']
                    ];
                }
            }
        }

        // Add delivery and supplier details to the data
        $data['listItems'] = $listItems;

        echo json_encode($data);
    } else {
        echo json_encode(null); // No delivery found
    }
} else {
    echo json_encode(null); // No DeliveryID provided
}

$conn->close();
?>
