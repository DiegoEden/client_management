
<?php
// Se incluye la clase con las plantillas del documento.
require_once('app/assets/dashboard_layout.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Iniciar sesión');
?>



 



    <main>
        <section class="seccion">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <h2 class="heading-section">Bienvenido</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="login-wrap p-0">
                            <form method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <input type="text" class="form-control login-input" placeholder="Nombre de usuario" required id="logusername" name="logusername">
                                </div>


                                <div class="form-group">
                                    <div style="position: relative;">
                                        <div style="position: relative;">
                                            <input id="password" name="password" type="password" class="form-control login-input" placeholder="Contraseña" autocomplete="current-password" required>
                                            <button type="button" class="btnPass" onclick="togglePassword('password', 'Pass1')"><span id="Pass1" class="material-symbols-outlined">
                                                    visibility
                                                </span></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn submit px-3">Ingresar</button>
                                </div>
                            </form>
                            <br>
                            <div class="form-group">
                                <a data-bs-toggle="modal" data-bs-target="#modalPassword" class="form-control btn forgotPassword px-3">He olvidado mi contraseña</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer></footer>
    </main>

    <!-- Modal -->

    <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="justify-content: flex-end; flex-direction: row-reverse;">

                    <h1 style="margin-left: 10px;" class="modal-title fs-5">Registrarse</h1>
                    <span class="material-symbols-rounded">
                        add
                    </span>
                </div>

                <div class="modal-body">

                    <form method="post" id="register-form" autocomplete="off" class="formDatos">
                        <div class="page">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="username">Nombre de usuario</label>
                                        <input type="text" name="username" id="username" class="form-control inputRecovery" required maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtApellido">Correo electrónico</label>
                                        <input type="email" name="email" id="email" class="form-control inputRecovery" required maxlength="50">
                                    </div>


                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <div style="position: relative;">
                                            <label for="password1">Contraseña</label>
                                            <div style="position: relative;">
                                                <input id="password1" name="password1" type="password" class="form-control inputRecovery" required maxlength="16">
                                                <button type="button" style="padding-top: 10px !important;" class="btnPass2 " onclick="togglePassword('password1', 'Pass3')"><span id="Pass3" class="material-symbols-outlined eye">
                                                        visibility
                                                    </span></button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div style="position: relative;">
                                            <label for="password2">Comprobar contraseña</label>
                                            <div style="position: relative;">
                                                <input id="password2" name="password2" type="password" class="form-control inputRecovery" required maxlength="16">
                                                <button type="button" style="padding-top: 10px !important;" class="btnPass2" onclick="togglePassword('password2', 'Pass5')"><span id="Pass5" class="material-symbols-outlined eye">
                                                        visibility
                                                    </span></button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                            <br>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn submit btnVerify">Registrarme</button>
                            </div>

                        </div>

                    </form>


                </div>



            </div>

        </div>

    </div>
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPassword" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="material-symbols-rounded">
                        info
                    </span>
                    <h1 style="margin-left: 10px;" class="modal-title fs-5">Restaurar contraseña</h1>
                    <button type="button" class="btn-close closeModalButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center flex-column">
                            <form autocomplete="off" action="/form" id="checkMail-form">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 14px;">
                                        <strong>Importante.</strong> Ingresa tu correo electrónico para poder restaurar
                                        tu contraseña. <br>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <!-- Input Correo -->
                                    <div class="form-group mb-4" style="width: 300px;">
                                        <h6 class="fs-6">Correo Electrónico:</h6>
                                        <input type="email" autocomplete="off" class="form-control inputRecovery" id="recover_email" name="recover_email" aria-describedby="emailHelp" Required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" id="btnVerificar" name="btnVerificar" class="btn btnVerify mr-2"></span>Verificar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal para verificar el codigo de verificación en la recuperación de contraseña -->
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="verificarCodigoRecuperacion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
            <div class="modal-content justify-content-center px-3 py-2">
                <!-- Cabecera del Modal -->
                <div class="modal-header" style="justify-content: flex-end; flex-direction: row-reverse;">

                    <h1 style="margin-left: 10px;" class="modal-title fs-5">Restaurar contraseña</h1>
                    <span class="material-symbols-rounded">
                        info
                    </span>
                </div>

                <!-- Contenido del Modal -->
                <div class="modal-body textoModal px-3 pb-4 mt-2">
                    <div class="row">

                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center flex-column">
                            <form autocomplete="off" action="/form" id="checkCode-form">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 14px;">
                                        <strong>Importante.</strong> Ingresa el código de verificación enviado a tu
                                        correo.<br>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <!-- Input Correo -->
                                    <div class="form-group mb-4" style="width: 300px;">
                                        <h6 class="fs-6">Código de verificación:</h6>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <input type="text" id="1" name="1" onKeyup="autotab(this, document.getElementById('2'),document.getElementById('1'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" id="2" name="2" onKeyup="autotab(this, document.getElementById('3'),document.getElementById('1'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" id="3" name="3" onKeyup="autotab(this, document.getElementById('4'),document.getElementById('2'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" id="4" name="4" onKeyup="autotab(this, document.getElementById('5'),document.getElementById('3'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" id="5" name="5" onKeyup="autotab(this, document.getElementById('6'),document.getElementById('4'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" id="6" name="6" onKeyup="autotab(this, document.getElementById('6'),document.getElementById('5'))" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" Required maxlength="1" class="form-control cajaCodigo" Required>
                                            <input type="text" class="d-none" id="codigo" name="codigo">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btnVerify mr-2">Verificar
                                        Código</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Fin del Contenido del Modal -->
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del Modal -->

    <!-- Modal -->
    <div class="modal fade" id="cambiarContraseña" tabindex="-1" aria-labelledby="cambiarContraseña" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="material-symbols-rounded">
                        info
                    </span>
                    <h1 style="margin-left: 10px;" class="modal-title fs-5">Restaurar contraseña</h1>
                    <button type="button" class="btn-close closeModalButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center flex-column">
                            <form autocomplete="off" action="/form" id="update-form">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 14px;">
                                        <strong>Importante.</strong> Tu contraseña debe de cumplir con los siguientes
                                        requisitos: <br>
                                        <br>
                                        - Mínimo 8 caracteres <br>
                                        - Máximo 50 caracteres<br>
                                        - Al menos una letra mayúscula <br>
                                        - Al menos una letra minúscula <br>
                                        - Al menos un dígito <br>
                                        - No espacios en blanco <br>
                                        - Al menos 1 carácter especial

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <!-- Input Correo -->
                                    <div class="form-group mb-4" style="width: 300px;">
                                        <h6 class="fs-6">Ingresa tu nueva contraseña:</h6>
                                        <div style="position: relative;">
                                            <input type="password" autocomplete="off" class="form-control inputRecovery" id="txtNewPass" name="txtNewPass" Required>
                                            <button type="button" class="btnPass" style="color:black !important;" onclick="togglePassword('txtNewPass', 'Pass3')"><span id="Pass3" class="material-symbols-outlined">
                                                    visibility
                                                </span></button>

                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btnVerify mr-2"></span>Finalizar
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>





    

    <script>
        function togglePassword(input, icon) {
            var passwordInput = document.getElementById(input);
            var iconButton = document.getElementById(icon);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                iconButton.textContent = "visibility_off"

            } else {
                passwordInput.type = "password";
                iconButton.textContent = "visibility"

            }
        }

        $(document).ready(function() {
            $("#dui_cliente").mask("00000000-0");
        });

        $(document).ready(function() {
            $("#telefono_cliente").mask("0000-0000");
        });
    </script>

</body>

</html>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('register.js');
?>
