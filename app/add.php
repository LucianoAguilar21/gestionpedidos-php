<?php 

if(isset($_POST['title'])){
    require '../database/db_conn.php';

    $title = $_POST['title'];

    echo $title;

    if(empty($title)){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Establecer un mensaje de error en la sesión
        $_SESSION['error_message'] = "Debe ingresar la tarea";
        header("Location: ../home.php"); 
    }else {
        $query = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        $res = $query->execute([$title]);

        if($res){

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = "Tarea agregada correctamente";
            header("Location: ../home.php"); 
        }

        $conn = null;
        exit();
    }
}else {
    header("Location: ../home.php?mess=error");
}