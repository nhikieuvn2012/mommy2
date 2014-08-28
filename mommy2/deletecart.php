<?php
    include_once("wp-load.php");
    $pid=$_GET['pid'];
    wp_delete_post($pid);
?>