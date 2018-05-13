
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="images\titleimage.jpg" type="image/gif" sizes="16x16">
  <title>GO CARDS</title>
<link rel="stylesheet" href="css/login.css">
</head>
<body style="background-image:url(images/regback.jpg)">

  <div class="centered">
<h1 class="bg">VENDOR LOGIN</h1>
  </div>
<div class="loginform">

<form class="form" method="post" action="<?=$_SERVER['PHP_SELF']?>">

<table cellpadding="5%" align="center" cellspacing="2% ">

<tr >
<td><input type="email" placeholder=" Mail id" name="mailid" required></td>
</tr>

<tr>
<td><input type="password" placeholder=" Password" name="psw" required> </td>
</tr>
<tr>
<td><button type="submit" name="submit">Login</button>
<button onclick="window.location.href='home.html'" style="background-color:red;  border-color: red;float:right;">Cancel</button></td>
</tr>
</table>
    </form>

</div>

<?php
if(isset($_POST["submit"]))
{
  $con = mysqli_connect("localhost","root","123","gocards");
  if (mysqli_connect_errno()) {
    echo"<script type='text/javascript'>
    alert ('An error occured.... We are looking into it..... Please TRY AGAIN LATER". mysqli_connect_error()."');
    </script>";

}

else {

  $mailid=$_POST['mailid'];
  $password = $_POST['psw'];

  $qry="select password from registrationvendor where mailid='$mailid'";
   $result=mysqli_query($con, $qry);
   $x=0;
   $pass="";
  while($row=mysqli_fetch_assoc($result))
  {
    $x=$x+1;
    $pass=$row['password'];
  }
  if($x==1){
      if($password===$pass){

        session_start();
        $_SESSION['mailid'] = $mailid;
        header("Location: dashboardvendor.php");
      }
      else{
        echo"<script type='text/javascript'>
        alert ('INVALID PASSWORD');
        </script>";
      }
  }
  else{
    echo"<script type='text/javascript'>
    alert ('THIS MAIL-ID IS NOT YET REGISTERED !!!!!!!! PLEASE REGISTER !!!!!!!!!!');
    </script>";
    header("Location: home.html");
  }
}
mysqli_close($con);
}
?>
</body>
</html>
