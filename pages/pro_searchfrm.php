<?php
include '../includes/connection.php';
include '../includes/sidebar.php';
$query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = ' . $_SESSION['MEMBER_ID'] . '';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
  $Aa = $row['TYPE'];

  if ($Aa == 'User') {
?>
    <script type="text/javascript">
      //then it will be redirected
      alert("Restricted Page! You will be redirected to Store!");
      window.location = "pos.php";
    </script>
<?php
  }
}
?>
<center>
  <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
    <div class="card-header py-3">
      <h4 class="m-2 font-weight-bold text-primary">Product's Detail</h4>
    </div>
    <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back</a>
    <div class="card-body">
      <?php
      // $query = 'SELECT PRODUCT_ID, PRODUCT_CODE, NAME,DESCRIPTION, COUNT(`QTY_STOCK`) AS "QTY_STOCK", COUNT(`ON_HAND`) AS "ON_HAND",PRICE, c.CNAME FROM product p join category c on p.CATEGORY_ID=c.CATEGORY_ID WHERE p.PRODUCT_CODE =' . $_GET['id'];

      $query = 'SELECT p.PRODUCT_ID, p.PRODUCT_CODE, p.NAME, p.DESCRIPTION, 
                 COUNT(p.QTY_STOCK) AS QTY_STOCK, 
                 COUNT(p.ON_HAND) AS ON_HAND, 
                 p.PRICE, 
                 c.CNAME 
          FROM product p 
          JOIN category c ON p.CATEGORY_ID = c.CATEGORY_ID 
          WHERE p.PRODUCT_CODE = ' . $_GET['id'] . '
          GROUP BY p.PRODUCT_ID, p.PRODUCT_CODE, p.NAME, p.DESCRIPTION, p.PRICE, c.CNAME';


      $result = mysqli_query($db, $query) or die(mysqli_error($db));
      while ($row = mysqli_fetch_array($result)) {
        $zz = $row['PRODUCT_ID'];
        $zzz = $row['PRODUCT_CODE'];
        $i = $row['NAME'];
        $a = $row['DESCRIPTION'];
        $c = $row['PRICE'];
        $d = $row['CNAME'];
      }
      $id = $_GET['id'];
      ?>

      <div class="form-group row text-left">
        <div class="col-sm-3 text-primary">
          <h5>
            Product Code<br>
          </h5>
        </div>
        <div class="col-sm-9">
          <h5>
            : <?php echo $zzz; ?><br>
          </h5>
        </div>
      </div>
      <div class="form-group row text-left">
        <div class="col-sm-3 text-primary">
          <h5>
            Product Name<br>
          </h5>
        </div>
        <div class="col-sm-9">
          <h5>
            : <?php echo $i; ?> <br>
          </h5>
        </div>
      </div>
      <div class="form-group row text-left">
        <div class="col-sm-3 text-primary">
          <h5>
            Description<br>
          </h5>
        </div>
        <div class="col-sm-9">
          <h5>
            : <?php echo $a; ?><br>
          </h5>
        </div>
      </div>
      <div class="form-group row text-left">
        <div class="col-sm-3 text-primary">
          <h5>
            Price<br>
          </h5>
        </div>
        <div class="col-sm-9">
          <h5>
            : <?php echo $c; ?><br>
          </h5>
        </div>
      </div>
      <div class="form-group row text-left">
        <div class="col-sm-3 text-primary">
          <h5>
            Category<br>
          </h5>
        </div>
        <div class="col-sm-9">
          <h5>
            : <?php echo $d; ?><br>
          </h5>
        </div>
      </div>
    </div>
  </div>
</center>

<div class="card shadow mb-4 col-xs-12 col-md-15 border-bottom-primary">
  <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Inventory</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Product Code</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>On Hand</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Date Stock In</th>
          </tr>
        </thead>
        <tbody>

          <?php

          // $query = 'SELECT PRODUCT_ID, PRODUCT_CODE, NAME, COUNT("QTY_STOCK") AS QTY_STOCK, COUNT("ON_HAND") AS ON_HAND, CNAME, COMPANY_NAME, p.SUPPLIER_ID, DATE_STOCK_IN FROM product p join category c on p.CATEGORY_ID=c.CATEGORY_ID JOIN supplier s ON p.SUPPLIER_ID=s.SUPPLIER_ID where PRODUCT_CODE =' . $zzz . ' GROUP BY `SUPPLIER_ID`, `DATE_STOCK_IN`';
          $query = 'SELECT p.PRODUCT_ID, p.PRODUCT_CODE, p.NAME, 
                 COUNT(p.QTY_STOCK) AS QTY_STOCK, 
                 COUNT(p.ON_HAND) AS ON_HAND, 
                 c.CNAME AS CATEGORY_NAME, 
                 s.COMPANY_NAME AS SUPPLIER_NAME, 
                 p.SUPPLIER_ID, 
                 p.DATE_STOCK_IN 
          FROM product p 
          JOIN category c ON p.CATEGORY_ID = c.CATEGORY_ID 
          JOIN supplier s ON p.SUPPLIER_ID = s.SUPPLIER_ID 
          WHERE p.PRODUCT_CODE = ' . $zzz . ' 
          GROUP BY p.PRODUCT_ID, p.PRODUCT_CODE, p.NAME, 
                   c.CNAME, s.COMPANY_NAME, p.SUPPLIER_ID, 
                   p.DATE_STOCK_IN';

          $result = mysqli_query($db, $query) or die(mysqli_error($db));
          while ($row = mysqli_fetch_assoc($result)) {


            echo '<tr>';
            echo '<td>' . $row['PRODUCT_CODE'] . '</td>';
            echo '<td>' . $row['NAME'] . '</td>';
            echo '<td>' . $row['QTY_STOCK'] . '</td>';
            echo '<td>' . $row['ON_HAND'] . '</td>';
            echo '<td>' . $row['CATEGORY_NAME'] . '</td>';
            echo '<td>' . $row['SUPPLIER_NAME'] . '</td>';
            echo '<td>' . $row['DATE_STOCK_IN'] . '</td>';
            echo '</tr> ';
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
</div>


<?php
include '../includes/footer.php';
?>