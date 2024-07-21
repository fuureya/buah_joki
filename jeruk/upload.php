<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV dan Foto</title>
</head>
<body>
    <form action="proses_upload.php" method="post" enctype="multipart/form-data">
        Pilih file CSV: <input type="file" name="csv_file" accept=".csv"><br>
        Pilih foto bukti: <input type="file" name="photo" accept="image/*"><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
