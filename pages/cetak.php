<!-- <?php
        ob_start();
        include '../includes/connection.php';


        $query = 'SELECT *, FIRST_NAME, LAST_NAME, PHONE_NUMBER, EMPLOYEE, ROLE
              FROM transaction T
              JOIN customer C ON T.`CUST_ID`=C.`CUST_ID`
              JOIN transaction_details tt ON tt.`TRANS_D_ID`=T.`TRANS_D_ID`
              WHERE TRANS_ID =' . $_GET['id'];
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        while ($row = mysqli_fetch_assoc($result)) {
            $fname = $row['FIRST_NAME'];
            $lname = $row['LAST_NAME'];
            $pn = $row['PHONE_NUMBER'];
            $date = $row['DATE'];
            $tid = $row['TRANS_D_ID'];
            $cash = $row['CASH'];
            $sub = $row['SUBTOTAL'];
            $less = $row['LESSVAT'];
            $net = $row['NETVAT'];
            $add = $row['ADDVAT'];
            $grand = $row['GRANDTOTAL'];
            $role = $row['EMPLOYEE'];
            $roles = $row['ROLE'];
        }

        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -0.5rem;
            margin-left: -0.5rem;
        }

        .col-sm-9,
        .col-sm-3,
        .col-sm-4,
        .col-sm-1 {
            position: relative;
            width: 100%;
            padding-right: 0.5rem;
            padding-left: 0.5rem;
        }

        .col-sm-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-sm-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-sm-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .font-weight-bold {
            font-weight: 700;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-primary {
            color: #007bff;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="card shadow mb-4">
        <div class="card-body">

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th width="8%">Jumlah</th>
                        <th width="20%">Harga</th>
                        <th width="20%">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT *
                     FROM transaction_details
                     WHERE TRANS_D_ID =' . $tid;
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));
                    while ($row = mysqli_fetch_assoc($result)) {
                        $Sub =  $row['QTY'] * $row['PRICE'];
                        echo '<tr>';
                        echo '<td>' . $row['PRODUCTS'] . '</td>';
                        echo '<td>' . $row['QTY'] . '</td>';
                        echo '<td>' . $row['PRICE'] . '</td>';
                        echo '<td>' . $Sub . '</td>';
                        echo '</tr> ';
                    }
                    ?>
                </tbody>
            </table>
            <div class="form-group row text-left mb-0 py-2">
                <div class="col-sm-4 py-1"></div>
                <div class="col-sm-3 py-1"></div>
                <div class="col-sm-4 py-1">
                    <h4>
                        Cash Amount: Rp <?php echo number_format($cash, 2); ?>
                    </h4>
                    <table width="100%">
                        <tr>
                            <td class="font-weight-bold">Subtotal</td>
                            <td class="text-right">Rp <?php echo $sub; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Less VAT</td>
                            <td class="text-right">Rp <?php echo $less; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Net of VAT</td>
                            <td class="text-right">Rp <?php echo $net; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Add VAT</td>
                            <td class="text-right">Rp <?php echo $add; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td class="font-weight-bold text-right text-primary">Rp <?php echo $grand; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-1 py-1"></div>
            </div>
        </div>


    </div>

</body>

</html> -->


<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include '../includes/connection.php';

// Fetch data for the PDF
$id = $_GET['id'];

$query = 'SELECT *, FIRST_NAME, LAST_NAME, PHONE_NUMBER, EMPLOYEE, ROLE
          FROM transaction T
          JOIN customer C ON T.CUST_ID=C.CUST_ID
          JOIN transaction_details tt ON tt.TRANS_D_ID=T.TRANS_D_ID
          WHERE TRANS_ID =' . $id;
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['FIRST_NAME'];
    $lname = $row['LAST_NAME'];
    $pn = $row['PHONE_NUMBER'];
    $date = $row['DATE'];
    $tid = $row['TRANS_D_ID'];
    $cash = $row['CASH'];
    $sub = $row['SUBTOTAL'];
    $less = $row['LESSVAT'];
    $net = $row['NETVAT'];
    $add = $row['ADDVAT'];
    $grand = $row['GRANDTOTAL'];
    $role = $row['EMPLOYEE'];
    $roles = $row['ROLE'];
}

// Fetch transaction details
$transaction_details = [];
$query = 'SELECT * FROM transaction_details WHERE TRANS_D_ID =' . $tid;
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_assoc($result)) {
    $transaction_details[] = $row;
}

// Generate HTML content
$html = '<html><head><style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
        padding: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -0.5rem;
        margin-left: -0.5rem;
    }
    .col-sm-9, .col-sm-3, .col-sm-4, .col-sm-1 {
        position: relative;
        width: 100%;
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
    .col-sm-9 {
        flex: 0 0 75%;
        max-width: 75%;
    }
    .col-sm-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-sm-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-sm-1 {
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .font-weight-bold {
        font-weight: 700;
    }
    .text-left {
        text-align: left;
    }
    .text-right {
        text-align: right;
    }
    .text-primary {
        color: #007bff;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody + tbody {
        border-top: 2px solid #dee2e6;
    }
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        cursor: pointer;
        text-decoration: none;
    }
</style></head><body>';

$html .= '<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group row text-left mb-0">
            <div class="col-sm-9">
                <h5 class="font-weight-bold">YazaShop</h5>
            </div>
            <div class="col-sm-3 py-1">
                <h6>Tanggal: ' . $date . '</h6>
            </div>
        </div>
        <hr>
        <div class="form-group row text-left mb-0 py-2">
            <div class="col-sm-4 py-1">
                <h6 class="font-weight-bold">' . $fname . ' ' . $lname . '</h6>
                <h6>Nomor telepon: ' . $pn . '</h6>
            </div>
            <div class="col-sm-4 py-1"></div>
            <div class="col-sm-4 py-1">
                <h6>Transaksi ' . $tid . '</h6>
                <h6 class="font-weight-bold">Encoder: ' . $role . '</h6>
                <h6>' . $roles . '</h6>
            </div>
        </div>
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th width="8%">Jumlah</th>
                    <th width="20%">Harga</th>
                    <th width="20%">Subtotal</th>
                </tr>
            </thead>
            <tbody>';
foreach ($transaction_details as $detail) {
    $Sub =  $detail['QTY'] * $detail['PRICE'];
    $html .= '<tr>';
    $html .= '<td>' . $detail['PRODUCTS'] . '</td>';
    $html .= '<td>' . $detail['QTY'] . '</td>';
    $html .= '<td>' . $detail['PRICE'] . '</td>';
    $html .= '<td>' . $Sub . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody>
        </table>
        <div class="form-group row text-left mb-0 py-2">
            <div class="col-sm-4 py-1"></div>
            <div class="col-sm-3 py-1"></div>
            <div class="col-sm-4 py-1">
                <h4>Cash Amount: Rp ' . number_format($cash, 2) . '</h4>
                <table width="100%">
                    <tr>
                        <td class="font-weight-bold">Subtotal</td>
                        <td class="text-right">Rp ' . $sub . '</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Less VAT</td>
                        <td class="text-right">Rp ' . $less . '</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Net of VAT</td>
                        <td class="text-right">Rp ' . $net . '</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Add VAT</td>
                        <td class="text-right">Rp ' . $add . '</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Total</td>
                        <td class="font-weight-bold text-right text-primary">Rp ' . $grand . '</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-1 py-1"></div>
        </div>
    </div>
</div>';

$html .= '</body></html>';

// Instantiate Dompdf with options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Load HTML content
$dompdf->loadHtml($html);

// (Optional) Set up the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("invoice_" . $id . ".pdf", array("Attachment" => 0));
?>