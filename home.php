<?php
require 'database/db_conn.php';
$todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


// Comprobar si hay un mensaje de éxito en la sesión
if(isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    // Limpiar el mensaje de éxito después de mostrarlo
    unset($_SESSION['success_message']);
}
if(isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    // Limpiar el mensaje de error después de mostrarlo
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require('resources/partials/head.php'); ?>
<body >


<nav class="navbar navbar-expand-lg  navbar-light bg-danger p-2" >
  <div class="container-fluid ">
    <a class="navbar-brand text-light" href="#">Gestion </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-light " aria-current="page" href="#">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light " href="#">Productos</a>
        </li>

      </ul>
      <span class="navbar-text dropdown px-3" >

              <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['username']; ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="app/logout.php">Salir</a></li>
              </ul>

      </span>
    </div>
  </div>
</nav>

    <div class="container-fluid">
    
    <div class="main-section ">
        <div class="add-section border">
            <form action="app/add.php" method="POST" autocomplete="off">

                <?php if(isset($error_message)){?>

                    <div class="alert alert-danger text-center" role="alert"> <?php echo $error_message;?></div>
                    
                    <input type="text" name="title" placeholder="Add to do item" style="border-color:rgba(255, 0, 0, 0.302)" autofocus>
                    <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar <i class="fa-solid fa-plus"></i></button>

                <?php }else{ ?>

                    <input type="text" name="title" placeholder="Add to do item" autofocus>
                    <button type="submit" data-bs-toggle="modal" data-bs-target="exampleModalLabel" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar <i class="fa-solid fa-plus"></i></button>

                <?php } ?>

            </form>
            
            <?php if(isset($success_message)){?>
                <div id="success-modal-trigger" style="display: none;"></div>
            <?php }?>
        </div>

                <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tarea agregada</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¡Tu tarea se ha agregado correctamente!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success mx-auto " data-bs-dismiss="modal"><i class="fa-solid fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>



        <div class="show-list">

            <?php if($todos->rowCount() === 0){?>
                <h2 class="noItems">No hay tareas pendientes</h2>
            <?php }; ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)){; ?>
          
                <div class="item">
                        <span id="<?= $todo['id']?>" class="removeItem"><i class="fa-solid fa-x"></i></span>

                        <?php if($todo['checked']){?>

                            <input type="checkbox" class="check-box" checked data-todo-id ="<?php echo $todo['id']; ?>">
                           
                            <h2 class="checked"><?= $todo['title']; ?></h2>
                            <small>Agregado: <?= $todo['date_time']; ?></small>

                        <?php }else{?>

                            <input type="checkbox" class="check-box" data-todo-id ="<?php echo $todo['id']; ?>">
                            <h2><?= $todo['title']; ?></h2>
                            <small> Agregado: <?= $todo['date_time']; ?></small>
                            
                        <?php };?>
                        
                </div>

            <?php }; ?>
        </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

    <script>
          $(document).ready(function(){
            $('.removeItem').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>

    <!--  para mostrar el modal automáticamente -->
<script>
    // Espera a que el documento esté completamente cargado
    document.addEventListener("DOMContentLoaded", function() {
        // Verifica si el div con ID "success-modal-trigger" está presente
        if (document.getElementById('success-modal-trigger')) {
            // Si está presente, muestra el modal automáticamente
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
</script>
</body>
</html>