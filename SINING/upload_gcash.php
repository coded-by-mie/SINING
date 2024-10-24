<?php
include 'condb.php';

$getOrderID = mysqli_query($conn, "SELECT * FROM getgcash");
$row = mysqli_fetch_assoc($getOrderID);
$order_id = $row['order_id'];

$getorder = mysqli_query($conn, "SELECT * FROM product_status WHERE id = '$order_id'");
$row1 = mysqli_fetch_assoc($getorder);
$seller_id = $row1['seller_id'];
$buyer_id = $row1['buyer_id'];

$getsellerinfo = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE seller_id = '$seller_id'");
$row2 = mysqli_fetch_assoc($getsellerinfo);
$seller_name = $row2['seller_name'];
$seller_gcash = $row2['seller_gcash'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/upload_gcash.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Document</title>
    <?php
      include("navbar.php");
   ?>
   <style>
   header{
      background-color: #212529;
   }
   </style>
</head>
<body>
    <div class="container cont">
    <input type="hidden" id="id" value="<?= $order_id ?>">
    <h1>SCAN</h1>
    <img src="seller_file/gcash_qr/<?php echo $seller_gcash;?>" height = 100 width = 100>

            <h3>Upload Receipt :</h3>

            <input type="file"  id="update_gcash" accept="image/jpg, image/jpeg, image/png" class="box" required><BR>
      <br>
            <h3>Reference No.:</h3>

            <input type="text"  style="width: 50%; color: black" id="gcash_ref" class="box" placeholder="Enter Reference Number" maxlength="13" required >

   <div class="ch">
   <br>
	<button type="submit" class="dlt" onclick="myFunction()">Confirm</button>
   </div>
   </div>
</body>
<script>
    function myFunction() {
  if(confirm("Are you sure you want to proceed?"))
  {
         var id = $("#id").val();
         var gcash_ref = $("#gcash_ref").val();
         var formData = new FormData();
         formData.append('gcash', $('#update_gcash')[0].files[0]);
         formData.append('function', "checkout");
         formData.append('gcash_ref', gcash_ref);
         formData.append('id', id);
         $.ajax({
            url:"logic_function.php",
            method:"POST",
            processData: false,
            contentType: false,
            data:formData,

            success:function(data){
               alert("Success")
               location.href = "userhistory.php"
            }
        });
  }
}
</script>
</html>