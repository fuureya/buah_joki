<?php
include '../includes/connection.php';
?>
<!-- Page Content -->
<div class="col-lg-12">
  <?php
  $pc = $_POST['prodcode'];
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $qty = $_POST['quantity'];
  $oh = $_POST['onhand'];
  $pr = $_POST['price'];
  $cat = $_POST['category'];
  $supp = $_POST['supplier'];
  $dats = $_POST['datestock'];


  // Cek apakah file telah diunggah
  if (isset($_FILES['gambar'])) {
    $namaFile = $_FILES['gambar']['name'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $size = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tipeFile = $_FILES['gambar']['type'];

    // Validasi jenis file
    $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));

    if (!in_array($ekstensiFile, $ekstensiDiizinkan)) {
      echo "Tipe file tidak diizinkan.";
      exit;
    }

    // Validasi ukuran file
    if ($size > 1048576) { // 1MB
      echo "Ukuran file melebihi batas.";
      exit;
    }

    // Memindahkan file yang diunggah
    if ($error === 0) {
      $namaBaru = uniqid() . "." . $ekstensiFile;
      $lokasiFile = "../img/upload/" . $namaBaru;

      if (move_uploaded_file($tmpName, $lokasiFile)) {
        echo "Gambar berhasil diunggah. Nama file: " . $namaBaru;
      } else {
        echo "Gagal mengunggah gambar.";
      }
    } else {
      echo "Terjadi kesalahan saat mengunggah gambar.";
    }
  }


  switch ($_GET['action']) {
    case 'add':
      for ($i = 0; $i < $qty; $i++) {


        $query = "INSERT INTO product
                              (PRODUCT_ID, PRODUCT_CODE, NAME, gambar, DESCRIPTION, QTY_STOCK, ON_HAND, PRICE, CATEGORY_ID, SUPPLIER_ID, DATE_STOCK_IN)
                              VALUES (Null,'{$pc}','{$name}', '{$namaBaru}' , '{$desc}',1,1,{$pr},{$cat},{$supp},'{$dats}')";
        mysqli_query($db, $query) or die('Error in updating product in Database ' . $query);
      }
      break;
  }
  ?>
  <script type="text/javascript">
    window.location = "product.php";
  </script>
</div>

<?php
include '../includes/footer.php';
?>