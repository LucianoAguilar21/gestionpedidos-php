<?php
require('../database/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el nombre de usuario o correo electrónico ya existen
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    //$stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "El nombre de usuario o correo electrónico ya están en uso";
    } else {
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        echo "¡Usuario registrado exitosamente!";
    }
}
?>