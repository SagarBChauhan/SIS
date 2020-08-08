<?php
ob_start();
session_start();
if(isset($_SESSION['usertype'])=="Student")
{
    $username=$_SESSION['username'];
    $userid=$_SESSION['userid'];
}
else 
{
    echo"<script>window.location.href='index.php?error=invalid_user';</script>";
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Student</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- CSS Files -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/material-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="assets/css/demo.css" rel="stylesheet" />
</head>

<body>
	<div class="image-container set-full-height" style="background-image: url('assets/img/wizard-book.jpg')">
	    <!--   Creative Tim Branding   -->
	    <a href="#">
	         <div class="logo-container">
	            <div class="logo">
                        <img src="img/sis_mark (2).jpg">
	            </div>
	            <div class="brand">
	               SIS
	            </div>
 
	        </div>
	    </a>                   
            <a href="Logout.php" style="cursor: pointer; float: right; margin-right: 10px;" rel='tooltip'  data-placement="left" title='Log out' class="btn btn-round btn-warning">
                <?php echo $username; ?>  <i class="material-icons">logout</i>
            </a>

		<!--  Made With Material Kit  -->
		<a href="#" class="made-with-mk">
			<div class="brand">SIS</div>
                        <div class="made-with">Student Information System <?php echo date('Y'); ?></div>
		</a>

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">
		            <!--      Wizard container        -->
		            <div class="wizard-container">
		                <div class="card wizard-card" data-color="red" id="wizard">
		                <!--        You can switch " data-color="blue" "  with one of the next bright colors: "green", "orange", "red", "purple"             -->
		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">Student</h3>
						<h5>Leave Management</h5>
                                                <?php 
                                                        date_default_timezone_set('Asia/Kolkata');
                                                        $fdate_flag=2;
                                                        $tdate_flag=2;
                                                        require_once './Connection.php';
                                                        if (isset($_POST['btn_submit']))
                                                        {
                                                            $fDate=$_POST['fDate'];
                                                            $fTime=$_POST['fTime'];
                                                            $toDate=$_POST['toDate'];
                                                            $toTime=$_POST['toTime'];
                                                            $reason=$_POST['reason'];
                                                            $From=$fDate." ".$fTime;
                                                            $To=$toDate." ".$toTime;
                                                            //echo "Today: ".  date('Y-m-d H:i')."<br>" ;
                                                            //echo "From: ".$From." <br>TO: ".$To."<br>";
                                                            
                                                            if ($From<date('Y-m-d H:i'))
                                                            {
                                                                //echo('Past Date');
                                                                $fdate_flag=0;
                                                                echo "<script>alert('Can Not Select Past Date');</script>";
                                                            }
                                                            elseif ($From > date('Y-m-d H:i'))
                                                            {
                                                                //echo('Future Date ');
                                                                $fdate_flag=1;
                                                                if($From > $To)
                                                                {
                                                                   // echo('Fail TO date is in Past');
                                                                    $tdate_flag=0;
                                                                    echo "<script>alert('To date Can Not Select less then From date');</script>";
                                                                }
                                                                elseif($From < $To) 
                                                                {
                                                                    $tdate_flag=1;
                                                                    $query="INSERT INTO `tbl_leave`( `Faculty_id`, `student_id`, `Reason`, `from_Date`, `from_Time`, `to_Date`, `to_Time`, `Status`) "
                                                                            . "VALUES ((SELECT tbl_allocation.guide_id FROM tbl_allocation WHERE tbl_allocation.Student_id=$userid),$userid,'$reason','$fDate','$fTime','$toDate','$toTime',0);";
        //                                                            echo $query;
                                                                    $sql_insert=  mysqli_query($con, $query);
                                                                    if ($sql_insert)
                                                                    {
                                                                        $success_id=$con->insert_id;
                                                                        $status_flag=0;
                                                                        //echo 'Success:'.$success_id;
                                                                    }
                                                                    else 
                                                                    { 
                                                                        $status_flag=1;
                                                                        die('Failed');
                                                                    }
                                                                }
                                                                
                                                            }
                                                            elseif ($From == date('Y-m-d H:i'))
                                                            {
                                                                echo('Equal Date ');
                                                            }

                                                        }
                                                        if (isset($_GET['did']))
                                                        {
                                                            $query="DELETE FROM `tbl_leave` WHERE `lid`=".$_GET['did'].";";
//                                                            echo $query;
                                                            $sql_delete=  mysqli_query($con, $query);
                                                            if ($sql_delete)
                                                            {
                                                                header("location:Student.php?status=deleted");
                                                            }
                                                            else 
                                                            { 
                                                                 header("location:Student.php?status=not_deleted");
                                                            }
                                                        }
                                                    ?>
		                    	</div>
					<div class="wizard-navigation">
                                            <ul>
                                                <li><a href="#apply" data-toggle="tab">Apply</a></li>
                                                <li><a href="#history" data-toggle="tab">History</a></li>
			                    </ul>
					</div>
		                        <div class="tab-content">
		                            <div class="tab-pane" id="apply">
		                            	<div class="row">
                                                    <div class="col-sm-12">
                                                        <!--<h4 class="info-text"> Apply Leave</h4>-->
                                                    </div>
                                                    <form action="Student.php" method="Post">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon <?php if($fdate_flag==0){echo 'text-danger'; }  elseif($fdate_flag==1) { echo"text-success"; }?>">
                                                                        <i class="material-icons">date_range</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">From Date</label>
                                                                        <input name="fDate" type="date" class="form-control <?php if($fdate_flag==0){echo 'text-danger'; }  elseif($fdate_flag==1) { echo"text-success"; }?>" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">                                                       
                                                                <div class="input-group">
                                                                <span class="input-group-addon <?php if($fdate_flag==0){echo 'text-danger'; }  elseif($fdate_flag==1) { echo"text-success"; }?>">
                                                                    <i class="material-icons">access_time</i>
                                                                </span>
                                                                <div class="form-group ">
                                                                    <label class="control-label">From Time</label>
                                                                    <input name="fTime" type="time" class="form-control <?php if($fdate_flag==0){echo 'text-danger'; }  elseif($fdate_flag==1) { echo"text-success"; }?>" >
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon <?php if($tdate_flag==0){echo 'text-danger'; }  elseif($tdate_flag==1) { echo"text-success"; }?>">
                                                                        <i class="material-icons">date_range</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">TO Date</label>
                                                                        <input name="toDate" type="date" class="form-control <?php if($tdate_flag==0){echo 'text-danger'; }  elseif($tdate_flag==1) { echo"text-success"; }?>" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">                                                       
                                                                <div class="input-group">
                                                                <span class="input-group-addon  <?php if($tdate_flag==0){echo 'text-danger'; }  elseif($tdate_flag==1) { echo"text-success"; }?>">
                                                                    <i class="material-icons">access_time</i>
                                                                </span>
                                                                <div class="form-group ">
                                                                    <label class="control-label">To Time</label>
                                                                    <input name="toTime" type="time" class="form-control  <?php if($tdate_flag==0){echo 'text-danger'; }  elseif($tdate_flag==1) { echo"text-success"; }?>" >
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-11">
                                                              <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">subject</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Reason</label>
                                                                    <textarea name="reason" class="form-control" ></textarea>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type='submit' class='btn btn-next btn-fill <?php if(isset($success_id)){ if($status_flag==0){echo 'btn-success';}elseif($status_flag==1){echo 'btn-danger';}} else{ echo 'btn-info';} ?> btn-wd' name='btn_submit' value="Apply Now" style="margin-left: 50px;" />
                                                    </form>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="history">
		                                <!--<h4 class="info-text">Applied Leave</h4>-->
		                                <div class="row">
		                                    <div class="col-sm-10 col-sm-offset-1">
                                                        <div class="table-responsive">
                                                            <?php        
                                                            $sql_Fetch_table="SELECT `lid`,(SELECT tbl_user.Username FROM tbl_user WHERE tbl_user.uid=tbl_leave.Faculty_id) as Faculty,"
                                                                    . " `student_id`, `Reason`, `from_Date`, `from_Time`, `to_Date`, `to_Time`, `Status` FROM `tbl_leave` WHERE `student_id`=$userid;";
                                                            $result=  mysqli_query($con, $sql_Fetch_table);
                                                            $count=1;

                                                            ?>
                                                            <table class="table table-hover">
                                                                <thead >
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th>Reason</th>
                                                                        <th>From</th>
                                                                        <th>To</th>
                                                                        <th>Status</th>
                                                                        <th>Faculty</th>
                                                                        <th class="text-center">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php while ($row=$result->fetch_assoc())
                                                                 {          
                                                                 ?> 
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $count;?></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['Reason'];?>"><?php  if(strlen($row['Reason'])>10){echo substr($row['Reason'], 0,10).'..';}else{echo $row['Reason'];} ?></a></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['from_Date'].' '.$row['from_Time'];?>"><?php  echo $row['from_Date'];?></a></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['to_Date'].' '.$row['to_Time'];?>"><?php  echo $row['to_Date'];?></a></td>
                                                                        <td><?php if($row['Status']==0){echo 'Pending';}elseif ($row['Status']==1){echo "<div class=text-success>Accepted</div>";}elseif($row['Status']==2){echo "<div class=text-danger>Rejected</div>";} ?></td>
                                                                        <td><?php echo $row['Faculty']; ?></td>
                                                                        <td class="td-actions text-center">
<!--                                                                            <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                                                                <i class="material-icons">person</i>
                                                                            </button>
                                                                            <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                                <i class="material-icons">edit</i>
                                                                            </button>-->
                                                                            <?php
                                                                            if($row['Status']==0)
                                                                            { ?>
                                                                            <a id="del-l" href="Student.php?did=<?php echo $row['lid']; ?>" style="cursor: pointer;" rel='tooltip' title='Cancel' class="text-danger">
                                                                                <i class="material-icons">backspace</i>
                                                                            </a>
                                                                            <?php 
                                                                            }
                                                                            else
                                                                            { ?>

                                                                                <i class="material-icons">backspace</i>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $count++;
                                                                 }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
<!--	                        	<div class="wizard-footer">
	                            	<div class="pull-right">
	                                    <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
	                                    <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Finish' />
	                                </div>
	                                <div class="pull-left">
	                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
	                                </div>
	                                <div class="clearfix"></div>
	                        	</div>-->
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div> <!-- row -->
		</div> <!--  big container -->

	    <div class="footer">
	        <div class="container text-center">
	             Student Information System Made by <a href="http://www.creative-tim.com"> Sagar Chauhan.</a>
	        </div>
	    </div>
	</div>

</body>
        <script>
            $('#del-l').click(function (){
                swal({
                    title:"Confirmation";
                    text:"Are you sure";
                    buttons:{
                        cancel:true,
                        confirm:"Submit"
                    }                    
                });
            });
        </script>
	<!--   Core JS Files   -->
	<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.bootstrap.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="assets/js/material-bootstrap-wizard.js"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="assets/js/jquery.validate.min.js"></script>
</html>
<?php ob_end_flush(); ?>