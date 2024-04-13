<?php
require '../database/db_conn.php';
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
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
<!-- <?php //require('../resources/partials/head.php'); ?> -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Pedidos</title>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
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
            <h2 class="text-center">PRODUCTOS</h2>
            <div class="add-section border">

                <form action="../app/add-product.php" method="POST" autocomplete="off">

                    <?php if(isset($error_message)){?>

                        <div class="alert alert-danger text-center" role="alert"> <?php echo $error_message;?></div>
                        
                        <input type="text" name="title" placeholder="Nombre de producto" style="border-color:rgba(255, 0, 0, 0.302)" autofocus>
                        <input type="number" name="price" placeholder="Precio:" style="border-color:rgba(255, 0, 0, 0.302)" >
                        <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar <i class="fa-solid fa-plus"></i></button>

                    <?php }else{ ?>

                        <input type="text" name="title" placeholder="Nombre de producto" autofocus>
                        <input type="number" name="price" placeholder="Precio:" >
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
                            ¡Producto agregado correctamente!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success mx-auto " data-bs-dismiss="modal"><i class="fa-solid fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="show-list">

                <?php if($products->rowCount() === 0){?>
                    <h2 class="noItems">No hay productos</h2>
                <?php }; ?>

                <?php while($product = $products->fetch(PDO::FETCH_ASSOC)){; ?>
            
                    <div class="item" id="item<?= $product['id']?>">
                        <span class="removeItem" data-bs-toggle="modal" data-bs-target="#removeProductModal"><i class="fa-solid fa-trash"></i></span>
                        
                        <h2><?= $product['name']; ?></h2>
                        <small> Precio: $<?= $product['price']; ?></small>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="removeProductModal" tabindex="-1" aria-labelledby="removeProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="removeProductModalLabel">Eliminar producto.</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Se eliminara el producto.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button  id="<?= $product['id']?>" type="button" class="btnRemove btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                                </div>
                                </div>
                            </div>
                        </div> 
                        
                        
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
            $('.btnRemove').click(function(){
                const id = $(this).attr('id');
                
                $.post("../app/remove-product.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $('#item'+id).hide(600);
                             
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