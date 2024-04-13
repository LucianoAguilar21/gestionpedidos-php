<?php 

if(isset($_POST['title'])){
    require '../database/db_conn.php';

    $title = $_POST['title'];
    $price = $_POST['price'];

    if(empty($title) || empty($price)){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Establecer un mensaje de error en la sesión
        $_SESSION['error_message'] = "Debe ingresar el nombre y precio";
        header("Location: ../views/product.php"); 
    }else {
        $query = $conn->prepare("INSERT INTO products(name,price) VALUE(?,?)");
        $res = $query->execute([$title,$price]);

        if($res){

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = "Product agregado correctamente";
            header("Location: ../views/product.php"); 
        }

        $conn = null;
        exit();
    }
}else {
    header("Location: ../views/product.php?mess=error");
}