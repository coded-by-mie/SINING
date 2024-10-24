<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include "condb.php";
    session_start();
    $user_id = $_SESSION['user_id'];

    // echo $user_id;
    
    $sql = "SELECT * FROM sining_seller_approval WHERE artistId = '$user_id'";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM sining_sellers WHERE artistId = '$user_id'";
    $result1 = mysqli_query($conn, $sql1);

    if(mysqli_num_rows($result) > 0) {
        // The user ID exists needs to be approved
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
        popup.style.zIndex = "9999";
      
        // Add some content to the popup
        const content = document.createElement("h3");
        content.textContent = "Your application is being processed";
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
        </script>';
        //header('location: home.php');
    }

    else if(mysqli_num_rows($result1) > 0){
        // The user ID can sell
        header('location: seller.php');
    }
    
    else {
        // The user ID can apply to be a seller
        header('location: sellerform.php');
    }

?>
<style>
    body{
        background-color: #2d2d2d;
    }
</style>
</body>
</html>