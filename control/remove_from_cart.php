<?php
require 'classes/Account.php';
require 'AccountMgnt.php';
require '../includes/session.php';
$pro_id = $_POST['pro_id'];
$account = $_SESSION['ACC'];
if ($pro_id === "") {
    //redirect
} else {
    if(AccountMgnt::removeFromMyCart($account, $pro_id)){
        echo "<script language=\"JavaScript\">";
        echo "alert('remove success!!')";
        echo "</script>";
    }else{
        echo "<script language=\"JavaScript\">";
        echo "alert('remove fail!!')";
        echo "</script>";
    }
    echo "<script> document.location.href=\"../cart.php\";</script>";
}
?>