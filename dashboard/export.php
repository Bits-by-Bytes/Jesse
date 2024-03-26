<?php
require('fpdf/fpdf.php');

// Include necessary files and functions
session_start();
include("../common/checkconnection.php");
include("../common/functions.php");

// Function to get order details by order ID
function getOrderById($conn, $orderId) {
    $query = "SELECT * FROM `order` WHERE ORDER_ID = '$orderId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
        return $order;
    } else {
        return null; // Return null if no order found
    }
}

// Function to get product orders by order ID
function getProductOrdersByOrderId($conn, $orderId) {
    $query = "SELECT * FROM prod_order WHERE ORDER_ID = '$orderId'";
    $result = mysqli_query($conn, $query);
    $productOrders = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productOrders[] = $row;
        }
    }
    return $productOrders;
}

// Function to get specs by specs ID
function getSpecsById($conn, $specsId) {
    $query = "SELECT * FROM specs WHERE SPECS_ID = '$specsId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $specs = mysqli_fetch_assoc($result);
        return $specs;
    } else {
        return null; // Return null if no specs found
    }
}

// Function to get customer details by customer ID
function getCustomerById($conn, $customerId) {
    $query = "SELECT * FROM customer WHERE CUST_ID = '$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $customer = mysqli_fetch_assoc($result);
        return $customer;
    } else {
        return null; // Return null if no customer found
    }
}

// Function to get login information by customer ID
function getLoginInfoByCustomerId($conn, $customerId) {
    $query = "SELECT * FROM login WHERE CUST_ID = '$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $loginInfo = mysqli_fetch_assoc($result);
        return $loginInfo;
    } else {
        return null; // Return null if no login information found
    }
}

// Get order ID from GET request
$orderId = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

// Get order details
$order = getOrderById($conn, $orderId);

// Get product orders for the order
$productOrders = getProductOrdersByOrderId($conn, $orderId);

// Get customer details
$customer = getCustomerById($conn, $order['CUST_ID']);

// Get login information
$loginInfo = getLoginInfoByCustomerId($conn, $order['CUST_ID']);

// Create new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 12);

// Title
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 10, 'Bearded Ox', 0, 10, 'C');
$pdf->Ln(10);

// Logo
$pdf->Image('../images/logos/bearded-ox.png', 160, 10, 30);

// Output customer details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 5, 'Name: ' . $customer['FNAME'] . ' ' . $customer['LNAME'], 0, 1);
$pdf->Cell(0, 5, 'Address: ' . $customer['ADDRESS'], 0, 1);
$pdf->Cell(0, 5, 'Phone: ' . $customer['PHONE'], 0, 1);
$pdf->Cell(0, 5, 'Email: ' . $loginInfo['EMAIL'], 0, 1);
$pdf->Ln(10);

// Output order details
$pdf->Cell(0, 5, 'Order ID: ' . $order['ORDER_ID'], 0, 1);
$pdf->Cell(0, 5, 'Order Date: ' . $order['ORD_DATE'], 0, 1);
$pdf->Cell(0, 5, 'Total: ' . $order['TOTAL'], 0, 1);
$pdf->Cell(10, 5, 'Status: ' . $order['STATUS'], 0, 1);
$pdf->Ln(10);

// Output product orders
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Product Details', 0, 1);

$pdf->SetFont('Arial', '', 12);
foreach ($productOrders as $prodOrder) {
    $specs = getSpecsById($conn, $prodOrder['SPECS_ID']);
    if ($specs) {       
        $pdf->Cell(50, 10, 'Furniture Type', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['FURNI_TYPE'], 1, 1);
        
        $pdf->Cell(50, 10, 'Species', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['SPECIES'], 1, 1);
        
        $pdf->Cell(50, 10, 'Edge Type', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['EDGE_TYPE'], 1, 1);
        
        $pdf->Cell(50, 10, 'Table Shape', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['TABLE_SHAPE'], 1, 1);
        
        $pdf->Cell(50, 10, 'Base Styles', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['BASE_STYLES'], 1, 1);
        
        $pdf->Cell(50, 10, 'Epoxy Option', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['EPOXY_OPTION'], 1, 1);
        
        $pdf->Cell(50, 10, 'Epoxy Color', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['EPOXY_COLOR'], 1, 1);
        
        $pdf->Cell(50, 10, 'Epoxy Style', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['EPOXY_STYLE'], 1, 1);
        
        $pdf->Cell(50, 10, 'Epoxy Type', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['EPOXY_TYPE'], 1, 1);
        
        $pdf->Cell(50, 10, 'Dimensions (LxWxH)', 1, 0, 'C');
        $pdf->Cell(140, 10, $specs['LENGTH'] . ' x ' . $specs['WIDTH'] . ' x ' . $specs['HEIGHT'], 1, 1);
        
        $pdf->Cell(50, 10, 'Additional Details', 1, 0, 'C');
        $pdf->MultiCell(140, 10, $specs['ADD_DETAILS'], 1, 'L');

        $pdf->SetY($pdf->GetY() + 10);

        // Fetching image data from the images table
        $imageQuery = "SELECT * FROM images WHERE SPECS_ID = '{$specs['SPECS_ID']}' LIMIT 1";
        $imageResult = mysqli_query($conn, $imageQuery);
        $imageData = mysqli_fetch_assoc($imageResult);

        if ($imageData) {
            // Display Image
            $pdf->Cell(0, 10, 'Product Image', 0, 1, 'C');
            $pdf->Image($imageData['IMG_PATH'], 60, $pdf->GetY(), 90, 0); // Adjust image path and size as needed
        } else {
            $pdf->Cell(0, 10, 'No image found', 0, 1);
        }

        $pdf->Ln(5);
    } else {
        $pdf->Cell(0, 10, 'No specs found', 0, 1);
    }
}


// Output PDF
$pdf->Output('order_details.pdf', 'D');
?>
