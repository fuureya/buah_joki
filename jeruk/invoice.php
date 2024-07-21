<?php
require_once('../includes/connection.php');
require_once('../vendor/autoload.php'); // Autoload TCPDF with Composer
require_once('../includes/sidebar.php');

// Fetch user type to restrict access
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID=u.TYPE_ID 
          WHERE ID = '.$_SESSION['MEMBER_ID'].'';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $userType = $row['TYPE'];
    if ($userType == 'User') {
        echo "<script type='text/javascript'>
                alert('Restricted Page! You will be redirected to Store!');
                window.location = 'pos.php';
              </script>";
    }
}

// Fetch transaction details
$query = 'SELECT *, FIRST_NAME, LAST_NAME, PHONE_NUMBER, EMPLOYEE, ROLE
          FROM transaction T
          JOIN customer C ON T.CUST_ID = C.CUST_ID
          JOIN transaction_details TT ON TT.TRANS_D_ID = T.TRANS_D_ID
          WHERE TRANS_ID = ' . $_GET['id'];
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['FIRST_NAME'];
    $lname = $row['LAST_NAME'];
    $phone = $row['PHONE_NUMBER'];
    $date = $row['DATE'];
    $transId = $row['TRANS_D_ID'];
    $cash = $row['CASH'];
    $subtotal = $row['SUBTOTAL'];
    $lessVat = $row['LESSVAT'];
    $netVat = $row['NETVAT'];
    $addVat = $row['ADDVAT'];
    $grandTotal = $row['GRANDTOTAL'];
    $employee = $row['EMPLOYEE'];
    $role = $row['ROLE'];
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('YazaShop');
$pdf->SetTitle('Transaction Invoice');
$pdf->SetSubject('Invoice');

// Set default header data
$pdf->SetHeaderData('', 0, 'Transaction Invoice', 'YazaShop');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a cell
$html = '
<h1>YazaShop</h1>
<h3>Transaction Invoice</h3>
<p><strong>Date:</strong> '.$date.'</p>
<p><strong>Customer Name:</strong> '.$fname.' '.$lname.'</p>
<p><strong>Phone Number:</strong> '.$phone.'</p>
<p><strong>Transaction ID:</strong> '.$transId.'</p>
<p><strong>Encoder:</strong> '.$employee.'</p>
<p><strong>Role:</strong> '.$role.'</p>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>';

$query = 'SELECT * FROM transaction_details WHERE TRANS_D_ID ='.$transId;
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_assoc($result)) {
    $subTotal = $row['QTY'] * $row['PRICE'];
    $html .= '
        <tr>
            <td>'.$row['PRODUCTS'].'</td>
            <td>'.$row['QTY'].'</td>
            <td>'.$row['PRICE'].'</td>
            <td>'.$subTotal.'</td>
        </tr>';
}

$html .= '
    </tbody>
</table>
<h4>Cash Amount: Rp '.number_format($cash, 2).'</h4>
<table>
    <tr>
        <td><strong>Subtotal:</strong></td>
        <td>Rp '.$subtotal.'</td>
    </tr>
    <tr>
        <td><strong>Less VAT:</strong></td>
        <td>Rp '.$lessVat.'</td>
    </tr>
    <tr>
        <td><strong>Net of VAT:</strong></td>
        <td>Rp '.$netVat.'</td>
    </tr>
    <tr>
        <td><strong>Add VAT:</strong></td>
        <td>Rp '.$addVat.'</td>
    </tr>
    <tr>
        <td><strong>Total:</strong></td>
        <td>Rp '.$grandTotal.'</td>
    </tr>
</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('invoice.pdf', 'I');
?>
