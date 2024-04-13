<?php

if(isset($_POST['id'])){
    require '../database/db_conn.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 0;
    }else {
        $query = $conn->prepare("DELETE FROM products WHERE id=?");
        $res = $query->execute([$id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../views/product.php?mess=error");
}