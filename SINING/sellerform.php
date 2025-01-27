<?php
// Initialize variables
session_start();
$user_id = $_SESSION['user_id'];

$fullname = "";
$username = "";
$address = "";
$contact = "";
$email = "";
$profile = "";
$qr = "";
$success = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $fullname = test_input($_POST["fullname"]);
  $username = test_input($_POST["username"]);
  $address = test_input($_POST["address"]);
  $contact = test_input($_POST["contact"]);
  $email = test_input($_POST["email"]);
  $profile = $_FILES["profile"];
  $qr = $_FILES["qr"];


  //profile
  if ($profile["error"] > 0) {
    echo "Error uploading file: " . $profile["error"];
  } else {
    $new_name_profile = $username . ".jpg";
    $target_dir = "seller_file/profile/";
    $target_file = $target_dir . basename($profile["name"]);

    if (move_uploaded_file($profile["tmp_name"], $target_dir . $new_name_profile)) {
      // echo "File uploaded and renamed successfully.";
    } else {
      echo "Error uploading file.";
    }
  }


  //qr
  if ($qr["error"] > 0) {
    echo "Error uploading file: " . $qr["error"];
  } else {
    $new_name = $username . ".jpg";
    $target_dir = "seller_file/gcash_qr/";
    $target_file = $target_dir . basename($qr["name"]);

    if (move_uploaded_file($qr["tmp_name"], $target_dir . $new_name)) {
      // echo "File uploaded and renamed successfully.";
    } else {
      echo "Error uploading file.";
    }
  }

  // Validate form data
  if (!empty($user_id) && !empty($fullname) && !empty($username) && !empty($address) && !empty($contact) && !empty($email) && !empty($profile) && !empty($qr)) {
    // Connect to the database
    include "condb.php";

    // Insert data into database
    $sql = "INSERT INTO sining_seller_approval (artistId, seller_name, seller_username, seller_address, seller_contact, seller_email, seller_profile, seller_gcash) VALUES ('$user_id', '$fullname', '$username', '$address', '$contact', '$email', '$new_name_profile', '$new_name')";

    if (mysqli_query($conn, $sql)) {
      $success = "Data inserted successfully";
      $user_id = "";
      $fullname = "";
      $username = "";
      $address = "";
      $contact = "";
      $email = "";
      $profile = "";
      $qr = "";
    } else {
      $success = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
  } else {
    $success = "Please fill in all fields";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
  <title>SINING | SELLER FORM</title>
  <link rel="stylesheet" href="css/sellerform.css">
  <?php
      include("navbar.php");
  ?>
</head>
<body>
  
  <?php if (!empty($success)) {
    echo '<script>
    const popup = document.createElement("div");

    // Set the styles for the popup
    popup.style.position = "fixed";
    popup.style.top = "50%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.width = "300px";
    popup.style.height = "200px";
    popup.style.backgroundColor = "#191919";
    popup.style.boxShadow = "0px 0px 10px rgba(0, 0, 0, 0.5)";
    popup.style.border = "1px solid #fff";
    popup.style.zIndex = "9999";
  
    // Add some content to the popup
    const content = document.createElement("h3");
    content.textContent = "Application Successful!";
    content.style.textAlign = "center";
    content.style.marginTop = "50px";
    content.style.color = "#fff";
    popup.appendChild(content);
  
    // Add a button to the popup
    const button = document.createElement("button");
    button.textContent = "Close";
    button.style.display = "block";
    button.style.margin = "auto";
    button.style.marginTop = "20px";
    button.style.padding = "10px 20px";
    button.style.border = "none";
    button.style.borderRadius = "4px";
    button.style.backgroundColor = "#ffc800";
    button.style.color = "#ffffff";
    button.style.cursor = "pointer";
    button.addEventListener("click", function() {
      window.location.href = "home.php";
    });
    popup.appendChild(button);

    // Add the popup to the body
    document.body.appendChild(popup);
    </script>
  ';} 
  ?>
  <div class="seller-con">
    <table>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <tr>
      <td colspan="2"><div><hr></hr><h2>Seller Form</h2><hr></hr></div></td>
    </tr>
  <tr>
    <td><label for="fullname">Fullname:</label></td>
    <td><input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" required></td>
  </tr>
  <tr>
    <td><label for="username">Username:</label></td>
    <td><input type="text" name="username" id="username" value="<?php echo $username; ?>" required></td>
    </tr>
    <tr>
    <td><label for="address">Address:</label></td>
    <td><input type="text" name="address" id="address" value="<?php echo $address; ?>" required></td>
    </tr>
    <tr>
    <td><label for="contact">Contact:</label></td>
    <td><input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" required></td>
    </tr>
    <tr>
    <td><label for="email">Email:</label></td>
    <td><input type="email" name="email" id="email" value="<?php echo $email; ?>" required></td>
    </tr>
    <tr>
    <td><label for="profile">Profile:</label></td>
    <td><input type="file" name="profile" id="profile" required></td>
    </tr>
    <tr>
    <td><label for="qr">Gcash:</label></td>
    <td><input type="file" name="qr" id="qr" required></td>
    </tr>
    <tr>
    <td colspan="2"><button data-open-modal type="submit">Submit</button></td>
    </tr></form></table>
  </div>
  <style>
   header{
      background-color: #212529;
   }
</style>
<script>
  function showAlert(message) {
  // Set message in custom alert box
  document.getElementById('message').innerHTML = message;
  
  // Show custom alert box
  document.getElementById('custom-alert').style.display = 'block';
  
  // Disable scrolling on body
  document.body.style.overflow = 'hidden';
}

document.getElementById('close-btn').addEventListener('click', function() {
  // Hide custom alert box
  document.getElementById('custom-alert').style.display = 'none';
  
  // Enable scrolling on body
  document.body.style.overflow = 'auto';
});
</script>
<script>
  const openButton = document.querySelector("[data-open-modal]")
  const modal = document.querySelector("[data-modal]")

  openButton.addEventListener("click", () => {
      modal.showModal()
  })
</script>
</body>
</html>