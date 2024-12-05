<?php
class Dashboard_Page
{
    public static function headerTemplate($title)
    {
        session_start();
        $filename = basename($_SERVER['PHP_SELF']);


        if ($filename == 'index.php') {

            print('<!DOCTYPE html>
            <html lang="es">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <!--<link rel="icon" href="../../resources/img/icono.ico" />-->
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
                <link rel="stylesheet" type="text/css" href="resources/css/login_styles.css">

                <title>Clients | Iniciar sesión </title>
            </head>

            <body>
            ');
        } else {

            print('
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <title>Dashboard - ' . $title . '</title>
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
                    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="../resources/css/dashboard.css">
                    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                </head>
                <body>
        ');
        }


        if (isset($_SESSION['user_id'])) {
            if ($filename != 'index.php') {
                self::modals();
                print('
                    <header>
                       <nav class="navbar navbar-expand-lg" id="navbar" role="navigation">
                            <div class="container-fluid">
                               
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav ms-auto">
                                        <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
                                        <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>
                                        <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Cuenta: <b>' . $_SESSION['username'] . '</b>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                                <li><a class="dropdown-item" href="#" onclick="openProfileDialog()">Editar perfil</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="logOut()">Salir</a></li>
                                            </ul>
                                        </li>
                                        
                <li class="nav-item">
                    <button type="button" class="btn" id="claro" onclick="modoClaro()"><span class="material-icons margenModo">
                            light_mode
                        </span></button>
                    <button type="button" class="btn" id="oscuro" onclick="modoOscuro()"><span class="material-icons margenModo">
                            dark_mode
                        </span></button>
                </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </header>
                    <main class="container py-5">
                        <h3 class="text-center">' . $title . '</h3>
                ');
            } else {
                header('location: views/clients.php');
            }
        } else {
            if ($filename != 'index.php') {
                header('location: ../index.php');
            } else {
                print('
                       <nav class="navbar navbar-expand-lg fixed-top" id="navbar" role="navigation">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-end" id="navbarNav">
            <ul class="navbar-nav align-items-end">



                <li class="nav-item">
                    <button type="button" class="btn" id="claro" onclick="modoClaro()"><span class="material-icons margenModo">
                            light_mode
                        </span></button>
                    <button type="button" class="btn" id="oscuro" onclick="modoOscuro()"><span class="material-icons margenModo">
                            dark_mode
                        </span></button>
                </li>

            </ul>



        </div>

    </nav>
                ');
            }
        }
    }
    public static function footerTemplate($controller)
    {
        $filename = basename($_SERVER['PHP_SELF']);
        if ($filename == 'index.php') {

            print('

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
            <script src="resources/js/sweetalert.min.js"></script>
            <script src="resources/js/template.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
            <script src="app/assets/components.js"></script>
            <script src="app/controllers/login.js"></script>

        
            ');
        } else {

            if (isset($_SESSION['user_id'])) {
                $scripts = '
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="../resources/js/sweetalert.min.js"></script>
                    <script src="../resources/js/template.js"></script>
                    <script src="../app/assets/components.js"></script>
                    <script src="../app/controllers/account.js"></script>
                    <script src="../app/controllers/' . $controller . '"></script>

                ';
            } else {
                $scripts = '
                   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="../../resources/js/sweetalert.min.js"></script>
                    <script src="../../app/helpers/components.js"></script>
                    <script src="../../app/controllers/dashboard/' . $controller . '"></script>
                ';
            }
            print('
                        </main>
                        <footer>
                           
                        </footer>
                        ' . $scripts . '
                    </body>
                </html>
            ');
        }
    }

    /*
    *   Método para imprimir los modales de editar perfil y cambiar contraseña.
    */
    private static function modals()
    {
        // Se imprime el HTML de los modales utilizando Bootstrap.
        print('
            <!-- Modal para editar perfil -->
            <div class="modal fade" id="profile-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar perfil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" id="profile-form">
                            <div class="modal-body">
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo eletrónico</label>
                                    <input id="user_email" type="mail" name="user_email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nombre de usuario</label>
                                    <input id="username" type="text" name="username" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer" style = "border:none;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
            <!-- Modal para cambiar contraseña -->
            <div class="modal fade" id="password-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cambiar contraseña</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" id="password-form">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="clave_actual" class="form-label">Clave actual</label>
                                    <input id="clave_actual" type="password" name="clave_actual" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="clave_nueva_1" class="form-label">Nueva clave</label>
                                    <input id="clave_nueva_1" type="password" name="clave_nueva_1" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="clave_nueva_2" class="form-label">Confirmar nueva clave</label>
                                    <input id="clave_nueva_2" type="password" name="clave_nueva_2" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        ');
    }
}
