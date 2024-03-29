<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array(); 

if($productos !=null){
    foreach($productos as $clave => $cantidad){

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

//session_destroy();
//print_r($_SESSION);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!--HEADER-->

    <nav class="navbar navbar-expand-lg navbar-light bg-light position-fixed top-0 start-0 w-100">
        <div class="container">
            <a href="index.php" class="navbar-brand d-lg-none ">
                E-commerce
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse p-2 flex-column" id="navbarHeader">
                <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row w-100">
                    <form class="d-flex">
                                <input type="search" class="form-control me-2" placeholder="Search"/>
                                <button class="btn btn-outline-dark" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16"><path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/><path d="M13 6.5a6.471 6.471 0 0 1-1.258 3.844c.04.03.078.062.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1.007 1.007 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5ZM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11Z"/></svg>
                                </button>
                    </form>
                    <a class="navbar-brand d-none d-lg-block" href="index.php">E-commerce</a>

                    <ul class="navbar-nav">
                                <li class="nav-item d-flex align-items-center">
                                    <a class="nav-link mx-2" aria-current="page" href="index.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16"><path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/></svg>
                                        My Account</a>
                                </li>
                                <li class="nav-item d-flex align-items-center">
                                    <a class="nav-link mx-2" href="checkout.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-heart" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5Zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0ZM14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/></svg>
                                        Bag
                                    </a>
                                    <span id="num_cart" class="badge rounded-pill bg-secondary"><?php echo $num_cart; ?></span>
                                </li>
                    </ul>
                </div>
                <div class="d-block w-100">
                            <ul class="navbar-nav d-flex justify-content-center align-items-center pt-3">
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">Muebles</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">Mesas</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">Sillas</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">Sillones</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                            </ul>
                </div>
            </div>
        </div>
    </nav>

    <!--MAIN-->
    <div class="container mt-5 text-white">
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                
                <thead>
                    <tr>
                        <th class="text-white">Producto</th>
                        <th class="text-white">Precio</th>
                        <th class="text-white">Cantidad</th>
                        <th class="text-white">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="text-white">
                    <?php if($lista_carrito == null){
                        echo '<tr>
                                <td colspan="5" class="text-center">
                                    <b class="text-white">Lista vacia</b>
                                </td>
                              </tr>';
                    } else {
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['id'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $descuento = $producto['descuento'];                            
                            $cantidad = $producto['cantidad'];
                            $precio_desc = $precio - (($precio * $descuento) / 100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal;
                        
                        ?>
                    <tr">
                        <td class="text-white">
                            <?php echo $nombre; ?>
                        </td>
                        <td class="text-white">
                            <?php echo MONEDA . number_format($precio_desc, 2,'.',','); ?>
                        </td>
                        <td class="text-white">
                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?> )">
                        </td>
                        <td class="text-white">
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div>
                        </td>
                        <td class="text-white">
                            <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
                            </a>
                        </td>
                    </tr>

                        <?php } ?>

                    <tr class="text-white">
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3 text-right text-white" id="total"><?php echo MONEDA . number_format($total, 2,'.',','); ?></p>
                            </td>
                    </tr>      
                </tbody>

                <?php } ?>
                
            </table>
        </div>
        
        <?php if ($lista_carrito != null) { ?>
        <div class="row">
            <div class="col-md-5 offset-md-7 d-grid gap-2">
                <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>
            </div>
        </div>
        <?php } ?>

    </div> 

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar el producto de la lista?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
            </div>
            </div>
        </div>
    </div>

    <section class="my-5 mx-auto py-5" style="max-width:25em;">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        <h2>Subscribe To Our Newsletter</h2>
        <form class="d-flex my-4">
            <input type="search" class="form-control me-2" placeholder="Your e-mail"/>
            <button class="btn btn-outline-dark" type="submit">Subscribe</button>
        </form>
    </section>                                                                                                                                                                                                                                                                                                                                        

    <footer class="d-flex justify-content-between my-5 text-start flex-wrap">
        <ul class="nav flex-column">
            <li class="fw-bold nav-item">
                <a href="#" class="nav-link text-dark">Product</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Muebles</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Sillas</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Sillones</a>
            </li>
        </ul>
        <ul class="nav flex-column">
            <li class="fw-bold nav-item">
                <a href="#" class="nav-link text-dark">Help</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Shopping guide</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Product Care</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Contact US</a>
            </li>
        </ul>
        <ul class="nav flex-column">
            <li class="fw-bold nav-item">
                <a href="#" class="nav-link text-dark">Content</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">About</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Blog</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Presroom</a>
            </li>
        </ul>
        <ul class="nav flex-column">
            <li class="fw-bold nav-item">
                <a href="#" class="nav-link text-dark">Terms & Conditions</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Terms Of Use</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Privacy Policy</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-muted">Cookies Policy</a>
            </li>
        </ul>
    </footer>

   

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script>
            let eliminaModal = document.getElementById('eliminaModal')  
            eliminaModal.addEventListener('show.bs.modal', function(event){
                let button = event.relatedTarget
                let id = button.getAttribute('data-bs-id')
                let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
                buttonElimina.value = id
            })          

            function actualizaCantidad(cantidad, id){
                let url = 'clases/actualizar_carrito.php';
                let formData = new FormData();
                formData.append('action','agregar');
                formData.append('id', id);
                formData.append('cantidad', cantidad);

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json()) 
                .then(data =>{
                    if(data.ok){

                        let divsubtotal = document.getElementById('subtotal_' + id);
                        divsubtotal.innerHTML = data.sub;

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for(let i = 0; i<list.length;i++){
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }

                        total = new Intl.NumberFormat('es-US', {
                            minimumractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total 
                    
                        
                    }
                }); 
            }

            function eliminar(){

                let botonElimina = document.getElementById('btn-elimina')
                let id = botonElimina.value

                let url = 'clases/actualizar_carrito.php';
                let formData = new FormData();
                formData.append('action','eliminar');
                formData.append('id', id);
               

                fetch(url, {
                    method: 'POST', 
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json()) 
                .then(data =>{
                    if(data.ok){
                        location.reload()
                    }
                }); 
            }


    </script>

</body>

</html>