<?php
require('fpdf/fpdf.php');

// Include necessary files and functions
session_start();
include("../common/checkconnection.php");
include("../common/functions.php");

// Function to get order details by order ID
function getOrderById($conn, $orderId) {
    $query = "SELECT * FROM `ORDER` WHERE ORDER_ID = '$orderId' LIMIT 1";
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
    $query = "SELECT * FROM PROD_ORDER WHERE ORDER_ID = '$orderId'";
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
    $query = "SELECT * FROM SPECS WHERE SPECS_ID = '$specsId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $specs = mysqli_fetch_assoc($result);
        return $specs;
    } else {
        return null; // Return null if no specs found
    }
}

// Get order ID from GET request
$orderId = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

// Get order details
$order = getOrderById($conn, $orderId);

// Get product orders for the order
$productOrders = getProductOrdersByOrderId($conn, $orderId);

// Create new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 12);

// Output order details
$pdf->Cell(0, 10, 'Order ID: ' . $order['ORDER_ID'], 0, 1);
$pdf->Cell(0, 10, 'Order Date: ' . $order['ORD_DATE'], 0, 1);
$pdf->Cell(0, 10, 'Total: ' . $order['TOTAL'], 0, 1);
$pdf->Cell(0, 10, 'Status: ' . $order['STATUS'], 0, 1);

// Output product orders
$pdf->Ln(10); // Add some space
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Product ID', 1, 0);
$pdf->Cell(140, 10, 'Specs', 1, 1);

$pdf->SetFont('Arial', '', 12);
foreach ($productOrders as $prodOrder) {
    $pdf->Cell(50, 10, $prodOrder['PROD_ID'], 1, 0);
    $specs = getSpecsById($conn, $prodOrder['SPECS_ID']);
    if ($specs) {
        $specsText = "Furniture Type: " . $specs['FURNI_TYPE'] . "\n";
        $specsText .= "Species: " . $specs['SPECIES'] . "\n";
        $specsText .= "Live Edge: " . $specs['LIVE_EDGE']  . "\n";
        $specsText .= "Base Styles: " . $specs['BASE_STYLES']  . "\n";
        $specsText .= "Epoxy Option: " . $specs['EPOXY_OPTION']  . "\n";
        $specsText .= "Epoxy Style: " . $specs['EPOXY_STYLE']  . "\n";
        $specsText .= "Epoxy Type: " . $specs['EPOXY_TYPE']  . "\n";
        $specsText .= "Epoxy Color: " . $specs['EPOXY_COLOR']  . "\n";
        $specsText .= "Additional Details: " . $specs['ADD_DETAILS'] . "\n";
        $pdf->MultiCell(140, 10, $specsText, 1);
    } else {
        $pdf->Cell(140, 10, 'No specs found', 1, 1);
    }
}

// Output PDF
$pdf->Output('order_details.pdf', 'D');
?>
