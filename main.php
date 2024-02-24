<?php

if($_POST['customOn'] == 1){
    if(!empty($_FILES['fileUpload2']['name'])){
        include 'custom_with_merge.php';
    }else{
        include 'custom.php';
    }
}else{
    include 'process.php';
}