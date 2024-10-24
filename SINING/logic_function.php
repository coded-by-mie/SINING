<?php

$function = $_POST["function"];
$function();
function checkout()
{
    $input = $_POST;
    @include "condb.php";
    $id = $input["id"];
    $gcash_ref = $input["gcash_ref"];

    $update_gcash = $_FILES['gcash']['name'];
    $update_gcash_size = $_FILES['gcash']['size'];
    $update_gcash_tmp_name = $_FILES['gcash']['tmp_name'];
    //$update_gcash_folder = 'uploaded_img/'.$update_gcash;

    $getbuyer = mysqli_query($conn, "SELECT * FROM product_status WHERE id = '$id'");
    $row = mysqli_fetch_assoc($getbuyer);
    $buyer = $row['buyer_id'];
    $seller = $row['seller_id'];
    $buyername = $row['buyer_name'];

    if(!empty($update_gcash)){
        if($update_gcash_size > 2000000){
           $message[] = 'image is too large';
        }else{

            
        $notificationBuyer = "You Have Successfully Send your Receipt to the Seller";
        $notificationSeller = $buyername." has Successfully Send his/her GCASH Receipt";

                mysqli_query($conn, "INSERT INTO `notifications`(notification_id, buyer_id, seller_id, notificationSeller, notificationBuyer, date) 
                VALUES ('', '$buyer', '$seller', '$notificationSeller', '$notificationBuyer', NOW())");
                mysqli_query($conn, "UPDATE `product_status` SET `product_status` = 'paid' , `artGcash` = '$update_gcash' , `artGcash_ref` = '$gcash_ref' WHERE id = '$id'");
            
                move_uploaded_file($update_gcash_tmp_name, 'uploaded_img/' . $update_gcash);
            };
        }
     }


function cancel()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $message = $_POST["message"];

    mysqli_query($conn, "update artist_history set cancel_message = '$message', status = -1 where id = $id");
    echo "Success";
}

function cancelSeller()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $message = $_POST["message"];

    mysqli_query($conn, "update artist_history set cancel_message = '$message', status = -2 where id = $id");
    echo "Success";
}
function updateStatus()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $status = $_POST["status"];

    
    mysqli_query($conn, "update artist_history set status = $status where id = $id");
    echo "Success";
}