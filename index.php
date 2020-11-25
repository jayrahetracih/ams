<?php 
session_start();
include 'connect.php';

if(isset($_SESSION['username']))
{
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<link rel="icon" href="images/logo.ico" type="image/ico">
    <title>RLB : Attendance Monitoring System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.4.0.min.js"></script>
	<link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <img src="images/logo_l.png" height="50px" width="200" class="img-thumbnail" style="margin-top:10px;" />
                </li>
				<br />
				<br />
				<?php
				$sql = mysqli_query($conn, "SELECT * FROM `tbl_branch` WHERE `branch_code` = '6'");
				while($res = mysqli_fetch_assoc($sql))
				{
					
					echo "
						
						<li style='color:white;'>
						Head Office
						</li>
						<li>
						<a href='index.php?br=".$res['branch_code']."' style='text-align:right;padding-right:10%;'>".$res['branch_name']."</a>
						</li>
						<li style='color:white;'>
						Site Offices
						</li>
					
					";
					
				}
				$sql = mysqli_query($conn, "SELECT * FROM `tbl_branch` WHERE `branch_code` != '6'");
				while($res = mysqli_fetch_assoc($sql))
				{
					
					echo "
					
						<li>
						<a href='index.php?br=".$res['branch_code']."' style='text-align:right;padding-right:10%;'>".$res['branch_name']."</a>
						</li>
					
					";
					
				}
				
				?>
					<a href="logout.php"><button type="button" class="btn btn-danger btn-block">Exit System <i class="glyphicon glyphicon-log-out pull-right"></i></button></a>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
				<form action="index.php" method="post">
					  <div class="form-group">
						<div class="form-group has-feedback">
							<label class="control-label">Search :</label>
							<i class="glyphicon glyphicon-search form-control-feedback"></i>
							<input type="text" class="form-control" placeholder="Search Employee" name="key" value="<?php echo (isset($_POST['key']) ? $_POST['key'] : "")?>"/>
						</div>
				</form>
                <table class="table table-hover table-bordered table-striped" style="text-align:center;">
					<thead>
						  <tr>
							<th style="text-align:center;" class="col-md-1">Id</th>
							<th style="text-align:center;">Employees</th>
							<th class="col-md-3" style="text-align:center">Delete Employee</th>
						  </tr>
					</thead>
					
					<tbody>
						<?php
						if(isset($_POST['key']))
						{
						  $sql = "SELECT * FROM `tbl_employee` WHERE `status` = 'Y' ".(isset($_GET['br']) ? "AND `branch_code` = '".$_GET['br']."' AND `userid` = '".$_POST['key']."' OR `username` LIKE '%".$_POST['key']."%'" : "AND `branch_code` = '6' AND `userid` = '".$_POST['key']."' OR `username` LIKE '%".$_POST['key']."%'");
						  $sql = mysqli_query($conn, $sql);
						  echo "<form action='index.php' id='frmnm' method='get'>
								<input type='hidden' name='nm' id='empl' value='' />
								<input type='hidden' name='br' id='brid' value='".(isset($_GET['br']) ? $_GET['br'] : "")."' />
								<input type='hidden' name='id' id='emplid' value='' />";
						  while($res = mysqli_fetch_assoc($sql))
						  {
						  echo '
							  <tr>
								<td class="ems" id="'.$res['username'].'" onclick="$(\'#emplid\').val(\''.$res['userid'].'\');$(\'#empl\').val(\''.$res['username'].'\');$(\'#frmnm\').submit();">'.$res['userid'].'</td>
								<td class="ems" id="'.$res['username'].'" onclick="$(\'#emplid\').val(\''.$res['userid'].'\');$(\'#empl\').val(\''.$res['username'].'\');$(\'#frmnm\').submit();">'.$res['username'].'</td>
								<td class="btn-danger" onclick="window.location.href=\'rem.php?id='.$res['userid'].'&nm='.$res['username'].'\'"><span class="glyphicon glyphicon-remove"></span></td>
							  </tr>
							  ';
						  }
						  echo "</form>";
						}
						else
						{
						  $sql = "SELECT * FROM `tbl_employee` WHERE `status` = 'Y' ".(isset($_GET['br']) && $_GET['br'] !== '' ? "AND `branch_code` = '".$_GET['br']."'" : "AND `branch_code` = '6'");
						  $sql = mysqli_query($conn, $sql);
						  echo "<form action='index.php' id='frmnm' method='get'>
								<input type='hidden' name='nm' id='empl' value='' />
								<input type='hidden' name='br' id='brid' value='".(isset($_GET['br']) ? $_GET['br'] : "")."' />
								<input type='hidden' name='id' id='emplid' value='' />";
						  while($res = mysqli_fetch_assoc($sql))
						  {
						  echo '
							  <tr>
								<td class="ems" id="'.$res['username'].'" onclick="$(\'#emplid\').val(\''.$res['userid'].'\');$(\'#empl\').val(\''.$res['username'].'\');$(\'#frmnm\').submit();">'.$res['userid'].'</td>
								<td class="ems" id="'.$res['username'].'" onclick="$(\'#emplid\').val(\''.$res['userid'].'\');$(\'#empl\').val(\''.$res['username'].'\');$(\'#frmnm\').submit();" data-toggle="popover" data-content="View Employee Timestamp" style="float:right;width:100%;">'.$res['username'].'</td>
								<td class="btn-danger" onclick="window.location.href=\'rem.php?id='.$res['userid'].'&nm='.$res['username'].'\'"><span class="glyphicon glyphicon-remove"></span></td>
							  </tr>
							  ';
						  }
						  echo "</form>";
						}
						?>
					</tbody>
			  </table>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="vertical-alignment-helper">
				<div class="modal-dialog vertical-align-center">
					<div class="modal-content" style="width:850px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

							</button>
							 <h4 class="modal-title" id="ename"><?php echo $_GET['nm'];?></h4>
							 <br />
							
								<div class="form-group">
									<label class="col-xs-3 control-label">Date From :</label>
									<div class="col-xs-8 date">
										<div class="input-group input-append date">
											<input type="text" class="form-control" name="datefrm" id="datePicker" value="<?php echo (isset($_GET['datefrm']) ? $_GET['datefrm'] : '');?>"/>
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<label class="col-xs-3 control-label">Date To :</label>
									<div class="col-xs-8 date">
										<div class="input-group input-append date">
											<input type="text" class="form-control" name="dateto" id="datePicker2" value="<?php echo (isset($_GET['dateto']) ? $_GET['dateto'] : '');?>"/>
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<?php
										
										$url = "index.php?g=1";
									    foreach ($_GET AS $key => $value) 
										{
											$url .= ($key != 'datefrm' && $key != 'dateto' ? '&' . $key . '=' . $value : NULL);
										}
									
									?>
									<button type="button" class="btn btn-success btn-block" style="margin-top:10px;" onclick="append();">Submit</button>
								</div>
							 
						</div>
						<div class="modal-body">
						
						<!-- Time Stamps Table -->
								<table id="timestamps" class="table table-bordered table-striped">
									<thead>
										  <tr class="titlerow">
											<th>Date</th>
											<th>Time In</th>
											<th>Time Out</th>
											<th>Actual Hours Worked</th>
											<th>Hours Late</th>
											<th>Hours Overtime</th>
											<th>Hours Undertime</th>
										  </tr>
									</thead>
									
									<tbody id="tblbody">
									<?php
									$sql = mysqli_query($conn, (isset($_GET['datefrm']) ? "SELECT * FROM `tbl_employee_time_log` WHERE `userid` = '".$_GET['id']."' AND `time` BETWEEN '".$_GET['datefrm']."' AND '".$_GET['dateto']."' AND `type` = 'timein'" : "SELECT * FROM `tbl_employee_time_log` WHERE `userid` = '".$_GET['id']."' AND `time` LIKE '".date("m-d-Y")."%' AND `type` = 'timein'"));
									while($res = mysqli_fetch_assoc($sql))
									{
									$dt = explode(" ",$res['time']);
									$date = $dt[0];
									$time_in = $dt[1];
									$sql2 = mysqli_query($conn, "SELECT * FROM `tbl_employee_time_log` WHERE `userid` = '".$_GET['id']."' AND `type` = 'timeout' AND `time` LIKE '".$date."%'");
									while($db_out = mysqli_fetch_assoc($sql2))
									{
									
										$time_out = $db_out['time'];
										$time_out = explode(" ",$time_out);
										$time_out = $time_out[1];
										$time_out = explode(":",$time_out);
										$toh = $time_out[0];
										$tom = $time_out[1];
									}
									
									$time_in = explode(":",$time_in);
									$tih = $time_in[0];
									$tim = $time_in[1];
									
										// Get Hours Late, Undertime, and Overtime
										//Hours Late								
										$latequery = mysqli_query($conn, "SELECT `time_scheme_id` FROM tbl_employee WHERE `userid` = '".$_GET['id']."'");
										while($res = mysqli_fetch_assoc($latequery))
										{
											
											$scheme_id = $res['time_scheme_id'];
													
										}
										
										$lq = mysqli_query($conn, "SELECT * FROM `tbl_employee_time_scheme` WHERE `time_scheme_id` = '".$scheme_id."'");
										$days = array('M','T','W','Th','F','S');
										while($res = mysqli_fetch_assoc($lq))
										{
											$time_scheme = $res['time_scheme'];
											$tmp = explode(' ', $time_scheme);
											$sched = str_replace('(','',$tmp[1]);
											$datetime = DateTime::createFromFormat('m-d-Y', $date);
											$current_day = $datetime->format('D');
											$current_day = $current_day[0];
											$current_day = array_search($current_day, $days);
											echo "<script>alert('".$current_day."');</script>";
										}
									//Hours Late Closing
									
									$hours_worked = $toh - $tih;
									$minutes_worked = $tom;
									if($tim != 0)
									{
										$hours_worked -= 1;
										$minutes_worked = (60 - $tim) + $tom;
									}
									
									if($minutes_worked >= 60)
									{
										$hours_worked = $hours_worked + floor($minutes_worked / 60);
										$minutes_worked = $minutes_worked % 60;
									}
										
									echo '
										  <tr style="text-align:center;">
											<td>'.$date.'</td>
											<td>'.($tih > 12 ? $tih - 12 : $tih) .':'.($tih > 12 ? $tim . " pm" : $tim . " am").'</td>
											<td>'. ($toh > 12 ? $toh - 12 : $toh) .':'.($toh > 12 ? $tom . " pm" : $tom . " am").'</td>
											<td class="hw">'.$hours_worked.':'.($minutes_worked == 0 ? "00" :  $minutes_worked).'</td>
										  </tr>
										 ';
									}
									?>
									</tbody>
							  </table>
						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success btn-block" >Generate Excel Report</button>
							<button type="button" class="btn btn-warning btn-block" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<script src="https://eonasdan.github.io/bootstrap-datetimepicker/js/prettify-1.0.min.js"></script>
	<script src="https://eonasdan.github.io/bootstrap-datetimepicker/js/base.js"></script>
	<script type="text/javascript">
		function append()
		{
			
			var datefrm = $('#datePicker').val();
			var dateto = $('#datePicker2').val();

				
			window.location.href = '<?php echo $url;?>' + '&datefrm=' + datefrm + '&dateto=' + dateto;
		}
		
		$(function () {
			$('#datePicker').datetimepicker({viewMode: 'years', format: 'DD/MM/YYYY'});
			$('#datePicker2').datetimepicker({viewMode: 'years', format: 'DD/MM/YYYY'});
		});
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover({
				placement : 'top',
				trigger : 'hover'
			});
		});
	</script>
	<?php
	
	if(isset($_GET['mod']) || isset($_GET['nm']))
	{

	echo "<script>$(document).ready(
	function(){
				
				$(document).ready(function(){
				var \$dataRows=$('#timestamps tr:not(\'.titlerow\')');
				var col1Total = 0;
				var min = 0;
				\$dataRows.each(function() {
					var col1 = $(this).find('.hw'); 
					var arr = col1.html().split(':');
					min += parseInt(arr[1]);
					col1Total += parseInt(arr[0]);
				});
				
				if(min > 60)
				{
					col1Total = col1Total + (Math.floor(min / 60));
					min = min % 60;
				}
				$('#timestamps tr:last').after('<tr><td colspan=\'5\'>Total Hours Worked :</td><td colspan=\'2\' style=\'text-align:center;\' id=\'thrs\'>'+col1Total+' Hours and '+(min == 0 ? '00' : min)+' minutes</td></tr>');
				});
				
				$('#myModal').modal({show : 'true'});	
				
				});</script>";
	}
	
	?>

</body>

</html>
<?php
}
else
{
	header("Location:login.php");
}
?>