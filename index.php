<!DOCTYPE html>
<html lang="en">
<?php require('resources/partials/head.php')?>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center text-center">
        <form action="app/login.php" method="POST" class="d-flex flex-column ">
            <label class="form-label" for="username">Usuario:</label>
            <input class="form-control" type="text" id="username" name="username" required>
            
            <label class="form-label" for="password">Contraseña:</label>
            <input class="form-control" type="password" id="password" name="password" required>

            <button type="submit" class="btn btn-primary mt-2 m-auto">INICIAR SESION</button>
        </form>
        <a href="register.php">Registrarse</a>
    </div>
</body>
</html>


