<?php
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- jQuery library -->
<script src="js/jquery.js"></script>

<!-- Latest compiled JavaScript -->
<script src="js/bootstrap.min.js"></script>

<?php

if(isset($_POST['submit']) && isset($_POST['pwd']))
{
	$sql = mysqli_query($conn, "SELECT * FROM `tbl_admin` WHERE `admin_password` = '".$_POST['pwd']."'");
	if(mysqli_num_rows($sql) != 0)
	{
		
		$sql = mysqli_query($conn, "UPDATE `tbl_users` SET `status` = 'N' WHERE `userid` = '".$_GET['id']."'");
		if($sql)
		{
			echo "<script>alert('".$_GET['nm']." was successfully removed from the list');window.location.href = 'index.php'</script>";
		}
	}
	else
	{
		echo "
			<script>
			alert('Invalid Password');
			location.href = location.href;
			</script>
			";
	}
	
}else
{
	echo "
<script>
$(document).ready(function(){

	$('#login').click();

})
</script>
";
}
?>

</head>
<body>

<button type="button" id="login" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none"></button>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-warning">Administrator password is required to continue</h4>
		<small class="text-danger">Are you sure you want to delete <?php echo $_GET['nm'];?> from the list of employees?</small>
      </div>
      <div class="modal-body">
		<form action="rem.php?<?php echo "id=".$_GET['id']."&nm=".$_GET['nm']; ?>" method="post">
		  
			  <div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" name="pwd" class="form-control" id="pwd">
			  </div>
			  <button type="submit" name="submit" class="btn btn-default btn-block btn-primary">Submit</button>
		</form>
			  <button class="btn btn-block btn-warning" style="margin-top:10px;" onclick="window.location.href = 'index.php'">Cancel</button>
      </div>
        
    </div>

  </div>
</div>

</body>
</html>