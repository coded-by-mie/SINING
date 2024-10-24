<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$getsellerId = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row = mysqli_fetch_assoc($getsellerId);
$seller_id = $row['seller_id'];
$gcash_payment = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'paid'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>
    <link rel="stylesheet" href="css/adminPage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
<div class="header">
  <h1>SELLER PAGE</h1>
  <h3>GCASH PAYMENT</h2>
  
</div>
<div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head hide">ORDER ID</th>
              <th class="head">BUYER NAME</th>
              <th class="head">ART TITLE</th>
              <th class="head">ART PRICE</th>
              <th class="head">GCASH RECEIPT</th>
              <th class="head hide">REFERENCE NUMBER</th>
              <th class="head">BUYER LOCATION</th>
              <th class="head hide"></th>
              <th class="head hide"></th>
            </tr>
          </thead>
<?php
      if(mysqli_num_rows($gcash_payment) > 0){
			    while($row = mysqli_fetch_assoc($gcash_payment)){
                $orderid = $row['product_id'];
                $artid = $row['product_id'];
                $artTitle = $row['product_name'];
                $artPrice = $row['product_price'];
                $fullname = ucfirst(strtolower($row['buyer_name']));
                $location = $row['buyer_address'];
                $gcash = $row['artGcash'];
                $reference = $row['artGcash_ref'];
                echo '
          <thead>
            <tr>
              <th class="hide">'.$artid.'</th>
              <th>'.$fullname.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th><img class="posted-art-img" src="uploaded_img/'.$gcash.'" alt="My Image" onclick="showImage(this)"></th>
              <th>'.$reference.'</th>
              <th>'.$location.'</th>
              <th><button class="btn btn-danger" data-id="'.$orderid.'" onclick="cancel(this)">Cancel</button></th>
              <th><button class="btn btn-success" data-id="'.$orderid.'" onclick="approve(this)">Process</button></th>
            </tr>
          </thead>';
    ?>
<?php
   }    
  }
  else{
      echo "<div class='no_data' id='no_data'>No Data Found</div>";
  }

  ?>
  </table>
  <div></div>
</body>
<script>
  function showImage(img) {
  var overlay = document.getElementById("img-overlay");
  var modal = document.createElement("div");
  var modalImage = document.createElement("img");

  modalImage.src = img.src;
  modalImage.alt = img.alt;
  modalImage.style.maxWidth = "80%";
  modalImage.style.maxHeight = "80%";

  modal.id = "image-modal";
  modal.appendChild(modalImage);
  document.body.appendChild(modal);

  overlay.style.display = "block";
  modal.style.display = "block";
}
    function cancel(event)
{
	var id = $(event).attr("data-id")
	//css
	if(confirm("Are you sure you want to proceed?"))
	{
    $.ajax({
    type: "POST",
    url: "update_status.php",
    data: {"decline": id},
    success: function(result){
      alert("Order Declined");
      location.reload();
    }
});
	}
}

function approve(event)
{
	var id = $(event).attr("data-id")
	if(confirm("Are you sure you want to proceed?"))
	{
			$.ajax({
    type: "POST",
    url: "update_status.php",
    data: {"ship": id},
    success: function(result){
      alert("Product Have Been Proccessed");
      window.location.reload();
    }
});
	}
}

</script>
</html>