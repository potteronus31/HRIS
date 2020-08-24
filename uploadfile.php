<?php
$con = mysqli_connect("localhost", "attendan_testing", "l-8QpV7)p$Vx", "attendan_testing");


if(isset($_POST['Import']))
{
   	    echo $filename=$_FILES["file"]["tmp_name"];
 
 
		 if($_FILES["file"]["size"] > 0)
		 {
 
		  	$file = fopen($filename, "r");
	         while (($data = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
	             $getname = $data[0];
	             $getdate = $data[1];
	             $gettype = $data[2];
 
	          //It wiil insert a row to our subject table from our csv file`
	           $sql = "INSERT into branch(branch_name, created_at, updated_at) values('$getname', '$getdate', '$gettype')";
	         //we are using mysql_query function. it returns a resource on true else False on error
	          $result = mysqli_query($con, $sql);
				if(! $result )
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"uploadfile.php\"
						</script>";
 
				}
 
	         }
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"uploadfile.php\"
					</script>";
 
			 //close of connection
			mysqli_close($con); 
 
		 }
}


?>

<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
    <form class="form-horizontal well" action="uploadfile.php" method="post" name="upload_excel" enctype="multipart/form-data">
					<fieldset>
						<legend>Import CSV/Excel file</legend>
						<div class="control-group">
							<div class="control-label">
								<label>CSV/Excel File:</label>
							</div>
							<div class="controls">
								<input type="file" name="file" id="file" class="input-large">
							</div>
						</div>
 
						<div class="control-group">
							<div class="controls">
							<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
							</div>
						</div>
					</fieldset>
	</form>
	
	<table class="table table-bordered">
			<thead>
				  	<tr>
				  		<th>Name</th>
				  		<th>Expiry Date</th>
				  		<th>Type</th>

				  	</tr>	
				  </thead>
			<?php
				$SQLSELECT = "SELECT * FROM branch";
				$result_set =  mysqli_query($con, $SQLSELECT);
				while($row = mysqli_fetch_array($result_set))
				{
				?>
 
					<tr>
						<td><?php echo $row['branch_name']; ?></td>
						<td><?php echo $row['created_at']; ?></td>
						<td><?php echo $row['updated_at']; ?></td>
					</tr>
				<?php
				}
			?>
		</table>
	
	
    </body>
</html>