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

  
  /*require 'PHPMailerAutoload.php';

  function sendMail($ref,$to_id){
    $email = 'nanthini1331@gmail.com';
    $password = '1373152111';
    $qr='http://api.qrserver.com/v1/create-qr-code/?data='.$ref.'&size=100x100';
    $message ='<html><body><img src='.$qr.' alt='.$qr.'></body></html>';
    $subject = 'Your QR code.... Keep it safe...';
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
    $mail->msgHTML($message);
    if (!$mail->send()) {
    $error = "Mailer Error: " . $mail->ErrorInfo;
    echo '<p id="para">'.$error.'</p>';
    }
  }*/


function sendMail($refid,$to_id,$name){

      include "qrlib.php";
      require 'PHPMailerAutoload.php';

      $msg="";
      $subject="QR code from GOCARDS";

      $msg.= "Dear \n ";

      //get customer name from database
      $msg.= "<b>".$name."</b> !!!!! \n";

      //define a directory in web server to store generated QR Code
      $myBarcodeDir = 'generated_barcode/';

      //Content of the QR Code
      $codeContents = "1523374446";

      //filename of the generated QR Code (value of customer_id field)
      $fileName = $refid .'.png';


      $pngAbsoluteFilePath = $myBarcodeDir.$fileName;
      $urlRelativeFilePath = 'generated_barcode/'.$fileName;

      //QR_ECLEVEL_L is parameter of the generated barcode. Please read the QR Code manual for other parameters
      QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4);

      $msg.= "<hr> \n";
      $msg.= "<hr> \n";

      //send email with generated barcode
      $msg.='<img src="'.$urlRelativeFilePath.'" />';
      $msg.= "<hr> \n Keep it safe...";

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
    $state = $_POST['state'];
    $pincode = $_POST['pcode'];
    $contact=$_POST['cno'];

    $qry="select count(mailid) as cnt from registrationuser where mailid='$mailid'";
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
    $qry="select count(contactno) as cnt from registrationuser where contactno='$contact'";
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

    $refid=time();
    $qry="insert into registrationuser values($refid,'$username','$contact','$address','$state',$pincode,'$mailid','$password')";
    $result=mysqli_query($con, $qry);
    echo"<script type='text/javascript'>
    alert ('successfully registered');
    </script>";
    sendMail($refid,$mailid,$username);



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
