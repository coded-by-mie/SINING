<?php
session_start();
include 'condb.php';

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   require 'phpmailer/src/Exception.php';
   require 'phpmailer/src/PHPMailer.php';
   require 'phpmailer/src/SMTP.php';

   function isStrongPassword($pass) {
      // Minimum length of 8 characters
      if (strlen($pass) < 8) {
          return false;
      }
  
      // Must contain at least one uppercase letter, one lowercase letter, and one digit
      if (!preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/[0-9]/', $pass)) {
          return false;
      }
  
      // Must contain at least one special character
      if (!preg_match('/[!@#$%^&*()-_=+[\]{}<>:;,./?]/', $pass)) {
          return false;
      }
  
      // Passed all checks, it's a strong password
      return true;
  }

  function checkPasswordStrength($password) {
   $length = strlen($password);
   $uppercase = preg_match('@[A-Z]@', $password);
   $lowercase = preg_match('@[a-z]@', $password);
   $number = preg_match('@[0-9]@', $password);
   $specialChar = preg_match('/[^\w]/', $password);

   if ($length < 8 || !$uppercase || !$lowercase || !$number || !$specialChar) {
       return 'weak';
   } else {
       return 'strong';
   }
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $strength = checkPasswordStrength($password);
   $password1 = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   // $image = $_FILES['image']['name'];
   // $image_size = $_FILES['image']['size'];
   // $image_tmp_name = $_FILES['image']['tmp_name'];
   // $image_folder = 'img/'.$image;
   $time = time();

   $otp = rand(1111, 9999);

   $select = mysqli_query($conn, "SELECT * FROM sining_artists WHERE artistEmail = '$email' AND artistPassword = '$password1'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{

      if ($strength === 'weak') {
         echo '<script>
            alert("Password must be minimum of 8 characters, has a number, symbol and capitalize letter");
            window.location.href = "register.php";
            </script>';
     } else {
      if($password1 != $cpass){
         $message[] = 'confirm password not matched!';
      }
      //elseif($image_size > 20000000){
      //    $message[] = 'image size is too large!';
      // }
      else{
         $insert = mysqli_query($conn, "INSERT INTO `sining_artists`(artistName, artistPassword,  artistEmail, otp_code, regAtime) VALUES('$name', '$password1', '$email', '$otp', '$time')") or die('query failed');

         if($insert){
            $select = mysqli_query($conn, "SELECT artistId FROM sining_artists WHERE artistEmail = '$email' AND artistPassword = '$password1'") or die('query failed');
            while($row = mysqli_fetch_assoc($select)){
               $_SESSION['user_id'] = $row['artistId'];
            }
            //move_uploaded_file($image_tmp_name, $image_folder);
            $message1[] = 'registered successfully!';

            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail -> Host = 'smtp.gmail.com';
            $mail -> SMTPAuth = true;
            $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
            $mail -> Password = 'ubagorbqalazafob';
            $mail -> SMTPSecure = 'ssl';
            $mail -> Port = 465;

            $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

            $mail -> addAddress($email);

            $mail -> isHTML(true);

            $mail -> Subject = "Account Verification Code";
            $message = "Here's the code to activate your account: " . $otp;
      
            $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
            $mail->Body = "<p>$message</p>$signature";

            $mail -> send();

            header('location:otpCheck.php');
         }else{
            $message[] = 'registration failed!';
         }
      }

     }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
  .password-toggle {
    position: relative;
  }

  .password-toggle .toggle-btn {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    background-image: url('eye-icon.png');
    background-repeat: no-repeat;
    width: 20px;
    height: 20px;
  }

  .password-toggle .toggle-btn.show-password {
    background-image: url('eye-icon-crossed.png');
  }
</style>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SINING Register</title>
   <link rel="stylesheet" href="css/loginregister.css">
</head>
<body background="assets/img/loginbg.jpg">
   
<div class="container reg">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register</h3>
      <?php
      if(isset($message1)){
         foreach($message1 as $message1){
            echo '<div class="message">'.$message1.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="Enter Username" class="box" required><br>
      <input type="email" name="email" placeholder="Enter Email" class="box" required><br>
      <div class="password-toggle">
      <input type="password" name="password" id="password" placeholder="Enter Password" class="box" required><br>
      <span class="toggle-btn" onclick="togglePasswordVisibility()">
      <img class="reg-img" src="assets/img/show.png" alt="Toggle Password">
      </span>
      </div>
      <div class="password-toggle">
      <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="box" required><br>
      <span class="toggle-btn" onclick="togglePasswordVisibility1()">
      <img class="reg-img" src="assets/img/show.png" alt="Toggle Password">
      </span>
      </div>
      <!-- <table>
         <tr>
            <td class="profile">Profile:</td>
            <td class="input"><input type="file" name="image" id ="images" accept=".jpg, .jpeg, .png" value="" required/></td>
         </tr>
         <tr>
            <td colspan="2">
            <div id="imagePreviewContainer">
               <img id="imagePreview" src="assets/img/image4.png" alt="Preview">
            </div>
         </td>
         </tr>
      </table> --> <br>
      <label><input type="checkbox" name="terms_checkbox" required> I agree to the <a href="#" id="myLink">Terms and Conditions</a></label>
      <input type="submit" name="submit" value="Register" class="btn">
      <p>Already have an account? <a href="login.php">Login here</a></p>
   </form>

</div>
<div id="myPopup">
<p>
    <center class="head">Terms and Conditions</center><br><br>

    These terms and conditions govern your use of our website. By accessing or using the website, you agree to be bound by these terms and conditions. If you do not agree with any part of these terms and conditions, please do not use the website. <br><br>

    <strong>1. Intellectual Property</strong><br><br>

        All content on this website, including but not limited to text, graphics, logos, images, and software, is the property of the website owner and is protected by applicable copyright and intellectual property laws.
        You may not reproduce, distribute, modify, display, or exploit any content from this website without prior written permission from the website owner. <br><br>

    <strong>2.	Website Use</strong><br><br>

        You agree to use this website only for lawful purposes and in a manner that does not infringe or restrict the rights of others. You shall not engage in any activity that may impair the 
        performance or functionality of thewebsite or interfere with other users' ability to access or use the website. <br><br>

    <strong>3.	Disclaimer of Warranties</strong><br><br>

        The information provided on this website is for general informational purposes only. While we strive to keep the information accurate and up to date, we make no warranties or representations of any kind, express or implied,
        about the completeness, accuracy, reliability, suitability, or availability of the website or the information, products, services, or related graphics contained on the website. Any reliance you place on such information is
        therefore strictly at your own risk. <br><br>

    <strong>4.	Limitation of Liability</strong><br><br>
    
        In no event shall we be liable for any direct, indirect, incidental, special, or consequential damages, including but not limited to loss of profits, data, or business interruption, arising out of the use or inability to
        use the website, even if we have been advised of the possibility of such damages. <br><br>

    <strong>5.	Third-Party Websites</strong><br><br>

        This website may contain links to third-party websites that are not owned or controlled by us. We have no control over the content, privacy policies, or practices of any third-party websites. We assume no responsibility for the
        content or practices of any third-party websites and shall not be liable for any loss or damage that may arise from your use of them. <br><br>

    <strong>6.	Modifications</strong><br><br>

        We reserve the right to modify or amend these terms and conditions at any time without prior notice. Any changes to these terms and conditions will be effective immediately upon posting. Your continued use of the website after
        any modifications or amendments will signify your acceptance of such changes. <br><br>

    Please read these terms and conditions carefully before using our website. If you have any questions or concerns regarding these terms and conditions, please contact us at sining@gmail.com 

    </p><br>
</div>
<script>
  var link = document.getElementById('myLink');
  var popup = document.getElementById('myPopup');
  var closeBtn = document.createElement('button');
  closeBtn.innerText = "Close";

  link.onclick = function() {
    popup.style.display = "block";
    popup.appendChild(closeBtn);
  }

  closeBtn.onclick = function() {
    popup.style.display = "none";
  }
</script>
<script>
   document.getElementById("images").addEventListener("change", function(event) {
    var input = event.target;
    var previewContainer = document.getElementById("imagePreviewContainer");
    var preview = document.getElementById("imagePreview");

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function() {
            preview.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
        previewContainer.style.display = "block";
    } else {
        preview.src = "assets/img/image4.png";
        previewContainer.style.display = "none";
    }
});

function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleButton = document.querySelector(".toggle-btn");
    
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleButton.classList.add("show-password");
    } else {
      passwordInput.type = "password";
      toggleButton.classList.remove("show-password");
    }
  }
  function togglePasswordVisibility1() {
    var passwordInput = document.getElementById("cpassword");
    var toggleButton = document.querySelector(".toggle-btn");
    
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleButton.classList.add("show-password");
    } else {
      passwordInput.type = "password";
      toggleButton.classList.remove("show-password");
    }
  }
</script>
</body>
</html>