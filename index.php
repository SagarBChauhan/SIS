<?php ob_flush(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Page Title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" href="css/main.css" rel="stylesheet">
</head>
<body>

<div class="header">
  <h1>SIS</h1>
  <p>A <b>Student</b> Management System.</p>
</div>

<div class="navbar">
  <a href="#" class="active">Home</a>
  <a href="#" >Allocation</a>
  <a href="#" class="right" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</a>
</div>

<div class="row">
  <div class="side">
    <h2>About Developer</h2>
    <h5>Photo of Developer:</h5>
    <div style="height:300px;" ><img src="img/IMG_20150810_210032.jpg" style="height:300px;border-radius: 150px;" alt=""/></div>
    <h4>Sagar Kumar chauhan</h4>
<!--    <div style="height:60px;"><img src="img/computer-1185626__340.jpg" style="height:100px;" alt=""/></div><br>
    <div style="height:60px;"><img src="img/computer-1185626__340.jpg" style="height:60px;" alt=""/></div><br>
    <div style="height:60px;"><img src="img/computer-1185626__340.jpg" style="height:60px;" alt=""/></div><br>-->

  </div>
  <div class="main">
    <h2>SIS</h2>

    <?PHP
        require_once './Connection.php';
        if(isset($_POST['btn_login']))
        {
           $query="SELECT * FROM `tbl_user` WHERE `Username`='".$_POST['uname']."' AND `Password`=MD5('".$_POST['psw']."')"; 
           $sql_select=  mysqli_query($con,$query);
           while ($rows = $sql_select -> fetch_assoc())
           {
               $Type=$rows['Type'];
               $uid=$rows['uid'];
           }
           if(isset($Type))
           {
               session_start();
               if($Type=="Student")
               {
                   
                   $_SESSION['username']=$_POST['uname'];
                   $_SESSION['usertype']="Student";
                   $_SESSION['userid']=$uid;
                   header("Location:Student.php");
               }
               elseif($Type=="Faculty")
               {
                   $_SESSION['username']=$_POST['uname'];
                   $_SESSION['usertype']="Faculty";
                   $_SESSION['userid']=$uid;
                   header("Location:Faculty.php");                   
               }
                   
           }
        }
    ?>
    <div id="id01" class="modal">

        <form class="modal-content animate" action="" method="Post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <img src="img/IMG_20150810_210032.jpg" style="height:150px; width: 150px;" alt="Avatar" class="avatar">
        </div>

        <div class="container">
          <label for="uname"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="uname" required>

          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" required>

          <button type="submit" name="btn_login">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
      </form>
    </div>
<!--    <h5>Title description, Dec 7, 2017</h5>
    <div class="fakeimg" style="height:200px;">Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    <br>
    <h2>TITLE HEADING</h2>
    <h5>Title description, Sep 2, 2017</h5>
    <div class="fakeimg" style="height:200px;">Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>-->
  </div>
</div>

<div class="footer">
  <h2>Footer</h2>
  <p> &copy; Student Management system <?php echo date('Y'); ?></p>
</div>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
<?php ob_end_flush(); ?>