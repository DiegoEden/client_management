<?php
require_once('../assets/database.php');
require_once('../assets/validator.php');
require_once('../models/users.php');
require_once('../assets/mailformat.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




require '../../libraries/phpmailer65/src/Exception.php';
require '../../libraries/phpmailer65/src/PHPMailer.php';
require '../../libraries/phpmailer65/src/SMTP.php';

$mail = new PHPMailer(true);


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $user = new Users;
    $mailFormat = new Mailformat();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'error' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['user_id'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'logOut':
                unset($_SESSION['user_id']);
                $result['status'] = 1;
                $result['message'] = 'Sesión eliminada correctamente';
                break;
            case 'readProfile':
                $user->setId($_SESSION['user_id']);
                if ($result['dataset'] = $user->readProfile()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
                }
                break;
            case 'editProfile':
                $_POST = $user->validateForm($_POST);
                if ($user->setId($_SESSION['user_id'])) {

                    if ($data = $user->readProfile()) {
                        $changes = []; // Array para almacenar los cambios detectados

                        if ($data['email'] !== $_POST['user_email']) {
                            $changes[] = "Correo electrónico cambiado de '{$data['email']}' a '{$_POST['user_email']}'";
                        }
                        if ($data['username'] !== $_POST['username']) {
                            $changes[] = "Nombre de usuario cambiado de '{$data['username']}' a '{$_POST['username']}'";
                        }

                        if (!empty($changes) || empty($changes)) {

                            if (
                                $user->setUsername($_POST['username']) &&
                                $user->setEmail($_POST['user_email'])
                            ) {
                                if (!$user->checkUserUpdate()) {
                                    if ($user->editProfile()) {
                                        $result['status'] = 1;
                                        $_SESSION['username'] = $user->getUsername();
                                        $result['message'] = 'Perfil modificado correctamente';

                                        if (!empty($changes)) {
                                            // Registrar log con los cambios
                                            $action = 'Modificar perfil';
                                            $details = "El usuario " . $_SESSION['username'] . " editó su información personal" . ". Cambios: " . implode(', ', $changes);
                                            $user->saveLog($action, $details);
                                        }
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {

                                    $result['exception'] = 'Ya existe un registro con el mismo correo electrónico o nombre de usuario';
                                }
                            } else {
                                $result['exception'] = 'Campos vacíos o datos inválidos';
                            }
                        }
                    }
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }

                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($user->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un usuario registrado';
                } else {
                    if (Database::getException()) {
                        $result['error'] = 1;
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No existen usuarios registrados';
                    }
                }
                break;
            case 'register':
                $_POST = $user->validateForm($_POST);
                if ($user->setUsername($_POST['username'])) {
                    if ($user->setEmail($_POST['email'])) {
                        if ($_POST['password1'] == $_POST['password2']) {
                            if ($user->setPassword($_POST['password2'])) {
                                if ($user->createRow()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Usuario registrado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = $usuario->getPasswordError();
                            }
                        } else {
                            $result['exception'] = 'Contraseñas diferentes';
                        }
                    } else {
                        $result['exception'] = 'El texto ingresado no es un correo electrónico válido';
                    }
                } else {
                    $result['exception'] = 'Nombre de usuario incorrecto';
                }
                break;
            case 'logIn':
                $_POST = $user->validateForm($_POST);
                if ($user->checkUser($_POST['logusername'])) {
                    if ($user->checkPassword($_POST['password'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Autenticación correcta, bienvenido ' . $user->getUsername();
                        $_SESSION['user_id'] = $user->getId();
                        $_SESSION['username'] = $user->getUsername();

                        $user->setId($_SESSION['user_id']);
                        $action = 'Inicio de sesión';
                        $details = "El usuario " . $_SESSION['username'] . " ha iniciado sesión en el sistema";
                        $user->saveLog($action, $details);
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Contraseña incorrecta';
                        }
                    }
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Nombre de usuario incorrecto';
                    }
                }
                break;

            case 'sendMail':
                $_POST = $user->validateForm($_POST);
                // Generamos el codigo de seguridad 
                $code = rand(999999, 111111);
                if ($user->setEmail($_POST['recover_email'])) {
                    if ($user->validateMail()) {
                        $user->setVerificationCode($code);
                        // Ejecutamos funcion para obtener el usuario del correo ingresado\
                        $_SESSION['mail'] = $user->getEmail();

                        $user->getUser($_SESSION['mail']);

                        try {

                            $body = $mailFormat->printMailFormatCode($code, $_SESSION['username_temp']);


                            //Ajustes del servidor
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'asistenciacreditoads@gmail.com';
                            $mail->Password   = 'gqxo ojod ofbw hhvw';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                            $mail->CharSet = 'UTF-8';


                            //Receptores
                            $mail->setFrom('asistenciacreditoads@gmail.com', 'Servicios al Cliente');
                            $mail->addAddress($user->getEmail());

                            //Contenido
                            $mail->isHTML(true);
                            $mail->Subject = 'Recuperación de contraseña';
                            $mail->Body    = $body;

                            if ($mail->send()) {
                                $result['status'] = 1;
                                $result['message'] = 'Código enviado correctamente,';
                                $user->updateCode();
                            }
                        } catch (Exception $e) {
                            $result['exception'] = $mail->ErrorInfo;
                        }
                    } else {

                        $result['exception'] = 'El correo ingresado no está registrado';
                    }
                } else {

                    $result['exception'] = 'Correo incorrecto';
                }

                break;

            case 'verifyCode':
                $_POST = $user->validateForm($_POST);
                // Validmos el formato del mensaje que se enviara en el correo
                if ($user->setVerificationCode($_POST['codigo'])) {
                    // Ejecutamos la funcion para validar el codigo de seguridad
                    if ($user->validateCode($_POST['codigo'], $_SESSION['user_id_temp'])) {
                        $result['status'] = 1;
                        // Colocamos el mensaje de exito 
                        $result['message'] = 'El código ingresado es correcto';
                    } else {
                        // En caso que el correo no se envie mostramos el error
                        $result['exception'] = 'El código ingresado no es correcto';
                    }
                } else {
                    $result['exception'] = 'Mensaje incorrecto';
                }
                break;

            case 'changePass':
                // Obtenemos el form con los inputs para obtener los datos
                $_POST = $user->validateForm($_POST);
                if ($user->setId($_SESSION['user_id_temp'])) {
                    if ($user->setPassword($_POST['txtNewPass'])) {
                        // Ejecutamos la funcion para actualizar al usuario
                        if ($user->changePassword()) {

                            try {

                                $body = $mailFormat->printMailFormatNotification($_SESSION['username_temp']);

                                //Ajustes del servidor
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'asistenciacreditoads@gmail.com';
                                $mail->Password   = 'gqxo ojod ofbw hhvw';
                                $mail->SMTPSecure = 'tls';
                                $mail->Port       = 587;
                                $mail->CharSet = 'UTF-8';


                                //Receptores
                                $mail->setFrom('asistenciacreditoads@gmail.com', 'Servicios al Cliente');
                                $mail->addAddress($_SESSION['mail']);

                                //Contenido
                                $mail->isHTML(true);
                                $mail->Subject = 'Alerta de seguridad';
                                $mail->Body    = $body;
                                $mail->send();
                            } catch (Exception $e) {
                                $result['exception'] = $mail->ErrorInfo;
                            }
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña actualizada correctamente';

                            $user->resetCode($_SESSION['user_id_temp']);
                            unset($_SESSION['user_id_temp']);
                            unset($_SESSION['mail']);
                            unset($_SESSION['username_temp']);
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = $user->getPasswordError();
                    }
                } else {
                    $result['exception'] = 'Correo incorrecto';
                }
                break;

            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
