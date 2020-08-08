<?php
    ob_start();
    session_start();
    if(isset($_SESSION['usertype'])=="Faculty")
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
	<title>Faculty</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/material-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="assets/css/demo.css" rel="stylesheet" />
        <style>
            .login a p {display:none;}
            .login a:hover p {display:block;}
        </style>
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
		                    	</div>
					<div class="wizard-navigation">
                                            <ul>
                                                <!--<li><a href="#apply" data-toggle="tab">Apply</a></li>-->
                                                <li><a href="#history" data-toggle="tab">History</a></li>
			                    </ul>
					</div>
		                        <div class="tab-content">
                                            <div <!--class="tab-pane" id="apply"-->
		                            	<div class="row">
<!--                                                    <div class="col-sm-12">
                                                        <h4 class="info-text"> Apply Leave</h4>
                                                    </div>-->
                                                    <?php 
                                                        require_once './Connection.php';
                                                        if (isset($_GET['aid']))
                                                        {
                                                            $query="UPDATE `tbl_leave` SET `Status`=1 WHERE lid=".$_GET['aid'].";";
                                                            $sql_insert=  mysqli_query($con, $query);
                                                            if ($sql_insert)
                                                            {
                                                                //echo 'Success:'.$success_id;
                                                            }
                                                            else 
                                                            { 
                                                                die('Failed');
                                                            }
                                                        }
                                                        elseif (isset($_GET['rid'])) 
                                                        {
                                                            $query="UPDATE `tbl_leave` SET `Status`=2 WHERE lid=".$_GET['rid'].";";
                                                            $sql_insert=  mysqli_query($con, $query);
                                                            if ($sql_insert)
                                                            {
                                                                //echo 'Success:'.$success_id;
                                                            }
                                                            else 
                                                            { 
                                                                die('Failed');
                                                            }
                                                        }
                                                    ?>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="history">
		                                <!--<h4 class="info-text">Applied Leave</h4>-->
		                                <div class="row">
		                                    <div class="col-sm-10 col-sm-offset-1">
                                                        <div class="table-responsive">
                                                            <?php        
                                                            $sql_Fetch_table="SELECT *,(SELECT tbl_user.Username FROM tbl_user WHERE tbl_user.uid=tbl_leave.student_id) as Student FROM `tbl_leave` WHERE `Faculty_id`=(SELECT tbl_allocation.guide_id FROM tbl_allocation WHERE tbl_allocation.Student_id=tbl_leave.student_id)";
                                                            $result=  mysqli_query($con, $sql_Fetch_table);
                                                            $count=1;

                                                            ?>
                                                            <table class="table table-hover">
                                                                <thead >
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th>Name</th>
                                                                        <th>Reason</th>
                                                                        <th>From</th>
                                                                        <th>To</th>
                                                                        <th>Status</th>
                                                                        <th class="text-center">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php while ($row=$result->fetch_assoc())
                                                                 {          
                                                                 ?> 
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $count;?></td>
                                                                        <td><?php echo $row['Student']; ?></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['Reason'];?>"><?php  if(strlen($row['Reason'])>10){echo substr($row['Reason'], 0,10).'..';}else{echo $row['Reason'];} ?></a></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['from_Date'].' '.$row['from_Time'];?>"><?php  echo $row['from_Date'];?></a></td>
                                                                        <td><a rel="tooltip" title="<?php echo $row['to_Date'].' '.$row['to_Time'];?>"><?php  echo $row['to_Date'];?></a></td>
                                                                        <td><?php if($row['Status']==0){echo 'Pending';}elseif ($row['Status']==1){echo "<div class=text-success>Accepted</div>";}elseif($row['Status']==2){echo "<div class=text-danger>Rejected</div>";} ?></td>
                                                                        
                                                                        <td class="td-actions text-center">
<!--                                                                            <button type="button" rel="tooltip" class="btn btn-info btn-round">
                                                                                <i class="material-icons">person</i>
                                                                            </button>
                                                                            <button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                                <i class="material-icons">edit</i>
                                                                            </button>-->
                                                                <?php if($row['Status']==0)
                                                                      { ?><a rel="tooltip" title='Accept' href="Faculty.php?aid=<?php echo $row['lid']; ?>" style="cursor: pointer; margin-right: 5PX;"class="text-success">
                                                                                <i class="material-icons">check</i>
                                                                          </a>
                                                                          <a rel="tooltip" title='Reject' href="Faculty.php?rid=<?php echo $row['lid']; ?>" style="cursor: pointer;"class="text-danger">
                                                                                <i class="material-icons">close</i>
                                                                          </a>
                                                                <?php }                                                                                
                                                                      elseif(isset($_GET['eid']))
                                                                      {
                                                                            if ($_GET['eid']==$row['lid'])
                                                                            { ?>
                                                                                <a rel="tooltip" title='Accept' href="Faculty.php?aid=<?php echo $row['lid']; ?>" style="cursor: pointer; margin-right: 5PX;"class="text-success">
                                                                                    <i class="material-icons">check</i>
                                                                                </a>
                                                                                <a rel="tooltip" title='Reject' href="Faculty.php?rid=<?php echo $row['lid']; ?>" style="cursor: pointer;"class="text-danger">
                                                                                    <i class="material-icons">close</i>
                                                                                </a>
                                                                      <?php }
                                                                            elseif($row['Status']!=0)
                                                                            { ?>
                                                                                <a rel="tooltip" title='Edit'  href="Faculty.php?eid=<?php echo $row['lid']; ?>" style="cursor: pointer;"class=" text-warning">
                                                                                    <i class="material-icons">edit</i>
                                                                                </a>
                                                                      <?php }
                                                                       }
                                                                       elseif($row['Status']!=0)
                                                                       { ?>
                                                                            <a rel="tooltip" title='Edit'  href="Faculty.php?eid=<?php echo $row['lid']; ?>" style="cursor: pointer;"class=" text-warning">
                                                                                <i class="material-icons">edit</i>
                                                                            </a>
                                                                 <?php } ?>
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