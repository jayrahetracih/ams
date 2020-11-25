<?php
include "connect.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<link rel="icon" href="images/logo.ico" type="image/ico">
<title>RLB : Attendance Monitoring System</title>

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
		while($res = mysqli_fetch_assoc($sql))
		{
			$_SESSION['username'] = $res['admin_username'];
			echo "<script>alert('Welcome, ".$_SESSION['username']."');location.href='index.php'</script>";
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

	$('#mymodal').modal('show');
	$('#myModal').modal({backdrop: 'static', keyboard: false});

})
</script>
";
}
?>

</head>
<body>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-warning">Administrator password is required to continue</h4>
      </div>
      <div class="modal-body">
		<form action="login.php" method="post">
		  
			  <div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" name="pwd" class="form-control" id="pwd">
			  </div>
			  <button type="submit" name="submit" class="btn btn-default btn-block btn-primary">Submit</button>
		</form>
      </div>
        
    </div>

  </div>
</div>

</body>
</html>