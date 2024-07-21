<!doctype html>
<html lang="en">
<head>
<title>How to generate PDF in PHP dynamically by using TCPDF</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width" />
<!-- *Note: You must have internet connection on your laptop or pc other wise below code is not working -->
<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- bootstrap css and js -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-12" align="center">
			<br>
			<h5 align="center">How to generate PDF in PHP dynamically by using TCPDF</h5>
			<br>
			<table class="table table-striped">
			<thead>
			  <tr>
				<th>Invoice #</th>
				<th>Customer name</th>
				<th>Contact #</th>
				<th>Address</th>
				<th>Action</th>
			  </tr>
			</thead>
			<tbody>
			<?php                
			require '../includes/connection.php'; 
			$display_query = "SELECT * FROM transaction_details";             
			$results = mysqli_query($con,$display_query);   
			$count = mysqli_num_rows($results);			
			if($count>0) 
			{
				while($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC))
				{
					?>
				 <tr>
				 	<td><?php echo $data_row['TRANS_D_ID']; ?></td>
				 	<td><?php echo $data_row['PRODUCTS']; ?></td>
				 	<td><?php echo $data_row['QTY']; ?></td>
				 	<td><?php echo $data_row['PRICE']; ?></td>
					<td><?php echo $data_row['EMPLOYEE']; ?></td>
					<td><?php echo $data_row['ROLE']; ?></td>
				 	<td>
				 		<a href="topdf.php?ID=<?php echo $data_row['ID']; ?>&ACTION=VIEW" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> View PDF</a> &nbsp;&nbsp; 
				 		<a href="topdf.php?ID=<?php echo $data_row['ID']; ?>&ACTION=DOWNLOAD" class="btn btn-danger"><i class="fa fa-download"></i> Download PDF</a>
						&nbsp;&nbsp; 
				 		<a href="pdf_maker.php?MST_ID=<?php echo $data_row['MST_ID']; ?>&ACTION=UPLOAD" class="btn btn-warning"><i class="fa fa-upload"></i> Upload PDF</a>
					</td>
				 </tr>
				 <?php
				}
			}
			?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<!-- <br>
<center>Developed by <a href="https://shinerweb.com/">Shinerweb</a></center> -->
</body>
</html> 