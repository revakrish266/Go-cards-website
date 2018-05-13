<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images\titleimage.jpg" type="image/gif" sizes="16x16">
  <title>GO CARDS</title>
 <link rel="stylesheet" href="css/home.css">
  </head>
  <body style="background-image:url(images/regback.jpg)">
  <div>
    <div class="centered">
      <h1 id="bg"><center><a href="home.html" style="color:silver;text-decoration: none; ">Thank you</a></center></h1>
    </div>
  </div>

    <?php

function sendMail($to_id,$name,$password){
    require 'PHPMailerAutoload.php';

      $msg="";
      $subject="Confirmation mail from GOCARDS";

      $msg.= "Dear \n ";

      //get customer name from database
      $msg.= "<b>".$name."</b> !!!!! \n";
      $msg.= "<hr> \n";

      $msg.= " \n Use the following credentials for further use:\nMail-id: ".$to_id."\nPassword: ".$password."<hr>";

      $email = 'nanthini1331@gmail.com';
      $password = '1373152111';
      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;
      $mail->Username = $email;
      $mail->Password = $password;
      $mail->addAddress($to_id);
      $mail->Subject = $subject;
      $mail->msgHTML($msg);
      if (!$mail->send()) {
      $error = "Mailer Error: " . $mail->ErrorInfo;
      echo '<p id="para">'.$error.'</p>';
      }
}



  if(isset($_POST["submit"]))
  {
    $con = mysqli_connect("localhost","root","123","gocards");
    if (mysqli_connect_errno()) {
      echo "<html><body>";
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    echo "</body></html>";
  }
  else {
    $username = $_POST['uname'];
    $mailid=$_POST['mailid'];
    $password = $_POST['psw'];
    $address = $_POST['address'];
    $contact=$_POST['cno'];

    $qry="select count(mailid) as cnt from registrationvendor where mailid='$mailid'";
     $result=mysqli_query($con, $qry);
     $x=0;
    while($row=mysqli_fetch_assoc($result))
    {
      $x=$row['cnt'];
    }
    if($x>0){
      echo"<script type='text/javascript'>
      alert ('Existing Mail-id');
      </script>";
    }
  else{
    $qry="select count(contactno) as cnt from registrationvendor where contactno='$contact'";
    $result=mysqli_query($con, $qry);
    $x=0;
   while($row=mysqli_fetch_assoc($result))
   {
     $x=$row['cnt'];
   }
   if($x>0){
      echo"<script type='text/javascript'>
      alert ('Existing Contact Number');
      </script>";
    }
    else{
    $qry="insert into registrationvendor values('$username','$password','$mailid','$contact','$address')";
    $result=mysqli_query($con, $qry);
    echo"<script type='text/javascript'>
    alert ('successfully registered');
    </script>";
    sendMail($mailid,$username,$password);



}

  }
     /*$qry="insert into user values('ragu')";

        $res=mysqli_query($con, $qry);
   $qry="select * from user";


     $res=mysqli_query($con, $qry);

     while($row=mysqli_fetch_array($res))
      {
      $te=$row["name"];
      }
    echo $te;*/
    mysqli_close($con);
  }

  }


  ?>
  </body>
</html>
