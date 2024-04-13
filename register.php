<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <?php require('resources/partials/head.php');?>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center text-center">

        <h2>Registro de Usuario</h2>
        <form action="app/register.php" method="post">
            
            <label class="form-label" for="username">Nombre de usuario:</label><br>
            <input class="form-control" type="text" id="username" name="username" required><br>
            
            <label class="form-label" for="email">Correo electrónico:</label><br>
            <input class="form-control" type="email" id="email" name="email" required><br>
            
            <label class="form-label" for="password">Contraseña:</label><br>
            <input class="form-control" type="password" id="password" name="password" required><br>
            
            <input type="submit" value="Registrarse" class="btn btn-warning">
        </form>
        <a href="index.php">Iniciar sesion</a>
    </div>
</body>
</html>
