<?php 

include 'condb.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistEmail = '$email' AND artistPassword = '$pass'") or die('query failed');
   

   if(mysqli_num_rows($select) > 0){
   

      $row = mysqli_fetch_assoc($select);
      $catecheck = $row['isFirstTimeUser'];
      $tagscheck = $row['artistSearch'];
      $_SESSION['isActivated'] = $row['isActivated'];
      $_SESSION['user_id'] = $row['artistId'];
      $_SESSION['Name'] = $row['artistName'];
      $_SESSION['profile'] = $row['artistProfile'];

         if($_SESSION['isActivated']=="1"){

            $_SESSION['user_id'] = $row['artistId'];

               if($catecheck == 0 ){
                        $_SESSION['user_id'] = $row['artistId'];
                        echo '<script>
                        window.location.href = "categ_select.php"
                        </script>';
                     }
                  else if($_SESSION['user_id'] == 1){
                     header('location:admin.php');
                  }

               else{
                        header('location:home.php');
               }
         }
         else{
         echo '<script>
               alert("account is not verified yet")
               window.location.href = "otpCheck.php"
               </script>';
         // header("otpCheck.php");
         }
   }
   else{
   $message[] = 'incorrect email or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
   <title>SINING Login</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <link rel="stylesheet" href="CSS/loginregister.css">
</head>
<body background="assets/img/loginbg.jpg">
   
<div class="container log">
   <img src="assets/img/logo.jpg" alt="logo" class="logo">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>LOGIN</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <tr>
         <td colspan="2"><input type="email" name="email" placeholder="Email" class="box" required><br></td>
      </tr>
      <div class="password-toggle">
      <table>
         <tr>
            <td id="password-input"><input type="password" name="password" id="password" placeholder="Enter Password" class="box" required><span class="toggle-btn" onclick="togglePasswordVisibility()"></td>
            <td><img class="login-img" src="assets/img/show.png" alt="Toggle Password"></span></td>
         </tr>
      </table>
      </div>
      <input type="submit" name="submit" value="login" class="btn">
      <p>Don't have an account yet? <a href="register.php">Register Here</a></p>
   </form>

</div>
<script>
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
</script>
</body>
</html>