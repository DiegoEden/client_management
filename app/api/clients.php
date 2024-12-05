<?php
require_once('../assets/database.php');
require_once('../assets/validator.php');
require_once('../models/clients.php');
require_once('../models/addresses.php');
require_once('../models/documents.php');
require_once('../models/users.php');


if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $client = new Clients;
    $address =  new Addresses;
    $document = new Documents;
    $users = new Users;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'error' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['user_id'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $client->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay clientes registrados';
                    }
                }
                break;

            case 'search':
                $_POST = $client->validateForm($_POST);
                if ($_POST['search'] != '') {
                    if ($result['dataset'] = $client->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $rows = count($result['dataset']);
                        if ($rows > 1) {
                            $result['message'] = 'Se encontraron ' . $rows . ' coincidencias';
                        } else {
                            $result['message'] = 'Solo existe una coincidencia';
                        }
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No hay coincidencias';
                        }
                    }
                } else {
                    $result['exception'] = 'Ingrese un valor para buscar';
                }
                break;

            case 'create':
                $_POST = $client->validateForm($_POST);
                if ($client->setName($_POST['name'])) {
                    if ($client->setLastname($_POST['lastname'])) {
                        if ($client->setEmail($_POST['email'])) {
                            if ($client->setPhoneNumber($_POST['phone_number'])) {
                                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                                    if ($client->setPhoto($_FILES['photo'])) {
                                        if (!$client->checkNewClient()) {
                                            if ($client->create()) {
                                                $result['status'] = 1;
                                                if ($client->saveFile($_FILES['photo'], $client->getRoute(), $client->getPhoto())) {
                                                    $result['message'] = 'Cliente creado correctamente';
                                                } else {
                                                    $result['message'] = 'Cliente creado pero no se guardó la imagen';
                                                }

                                                $users->setId($_SESSION['user_id']);
                                                $action = 'Crear registro';
                                                $details = "El usuario " . $_SESSION['username'] . " agregó un nuevo registro a la tabla clients.";
                                                $users->saveLog($action, $details);
                                            } else {
                                                $result['exception'] = Database::getException();;
                                            }
                                        } else {
                                            $result['exception'] = 'Ya existe un registro con el mismo correo electrónico o número telefónico';
                                        }
                                    } else {
                                        $result['exception'] = $client->getImageError();
                                    }
                                } else {

                                    $result['exception'] = 'Seleccione una imagen';
                                }
                            } else {
                                $result['exception'] = 'El número telefónico debe empezar con los números, 7, 6 o 2';
                            }
                        } else {
                            $result['exception'] = 'Correo electrónico no válido';
                        }
                    } else {
                        $result['exception'] = 'Apellido no válido';
                    }
                } else {

                    $result['exception'] = 'Nombre no válido';
                }

                break;

            case 'readOne':
                if ($client->setId($_POST['client_id'])) {
                    if ($result['dataset'] = $client->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Cliente inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;

            case 'update':
                $_POST = $client->validateForm($_POST);
                if ($client->setId($_POST['client_id'])) {
                    if ($data = $client->readOne()) { // Obtener los datos actuales
                        $changes = []; // Array para almacenar los cambios detectados

                        // Comparar y detectar cambios en cada campo
                        if ($data['name'] !== $_POST['name']) {
                            $changes[] = "Nombre cambiado de '{$data['name']}' a '{$_POST['name']}'";
                        }
                        if ($data['lastname'] !== $_POST['lastname']) {
                            $changes[] = "Apellido cambiado de '{$data['lastname']}' a '{$_POST['lastname']}'";
                        }
                        if ($data['email'] !== $_POST['email']) {
                            $changes[] = "Correo cambiado de '{$data['email']}' a '{$_POST['email']}'";
                        }
                        if ($data['phone_number'] !== $_POST['phone_number']) {
                            $changes[] = "Teléfono cambiado de '{$data['phone_number']}' a '{$_POST['phone_number']}'";
                        }

                        if (!empty($changes) || empty($changes)) {
                            if (
                                $client->setName($_POST['name']) &&
                                $client->setLastname($_POST['lastname']) &&
                                $client->setEmail($_POST['email']) &&
                                $client->setPhoneNumber($_POST['phone_number'])
                            ) {

                                if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
                                    if ($client->setPhoto($_FILES['photo'])) {
                                        if (!$client->checkClientUpdate()) {

                                            if ($client->updateRow($data['photo'])) {
                                                $result['status'] = 1;
                                                $client->saveFile($_FILES['photo'], $client->getRoute(), $client->getPhoto());
                                                $result['message'] = 'Cliente modificado correctamente';


                                                if (!empty($changes)) {
                                                    // Registrar log con los cambios
                                                    $users->setId($_SESSION['user_id']);
                                                    $action = 'Actualizar registro';
                                                    $details = "El usuario " . $_SESSION['username'] . " actualizó el registro de la tabla clients con id: " . $client->getId() . ". Cambios: " . implode(', ', $changes);
                                                    $users->saveLog($action, $details);
                                                }
                                            } else {
                                                $result['exception'] = Database::getException();
                                            }
                                        } else {
                                            $result['exception'] = 'Ya existe un registro con el mismo correo electrónico o número telefónico';
                                        }
                                    } else {
                                        $result['exception'] = $client->getImageError();
                                    }
                                } else {
                                    if (!$client->checkClientUpdate()) {
                                        if ($client->updateRow($data['photo'])) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Cliente modificado correctamente';

                                            if (!empty($changes)) {
                                                // Registrar log con los cambios
                                                $users->setId($_SESSION['user_id']);
                                                $action = 'Actualizar registro';
                                                $details = "El usuario " . $_SESSION['username'] . " actualizó el registro de la tabla clients con id: " . $client->getId() . ". Cambios: " . implode(', ', $changes);
                                                $users->saveLog($action, $details);
                                            }
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
                                    } else {
                                        $result['exception'] = 'Ya existe un registro con el mismo correo electrónico o número telefónico';
                                    }
                                }
                            } else {
                                $result['exception'] = 'Datos inválidos';
                            }
                        } else {
                            $client->updateRow($data['photo']);
                            $result['status'] = 1;
                            $result['message'] = 'Cliente modificado correctamente';
                        }
                    } else {
                        $result['exception'] = 'Cliente inexistente';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;


            case 'delete':
                if ($client->setId($_POST['client_id'])) {
                    if ($data = $client->readOne()) {
                        if ($client->delete()) {
                            $result['status'] = 1;
                            if ($client->deleteFile($client->getRoute(), $data['photo'])) {
                                $result['message'] = 'Cliente eliminado correctamente';
                            } else {
                                $result['message'] = 'Cliente eliminado pero no se borró la imagen';
                            }

                            $users->setId($_SESSION['user_id']);
                            $action = 'Eliminar registro';
                            $details = "El usuario " . $_SESSION['username'] . " eliminó el registro de la tabla clients con el id: " . $client->getId() . " de nombre: " .  $data['name'] . " " .  $data['lastname'];
                            $users->saveLog($action, $details);
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Cliente inexistente';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;

            case 'saveAddress':
                $_POST = $address->validateForm($_POST);
                if ($address->setClientId($_POST['client_id_address'])) {
                    $client->setId($_POST['client_id_address']);
                    if ($data = $client->readOne()) {
                        if ($address->setAddress($_POST['address'])) {
                            if ($address->saveAddress()) {
                                $result['status'] = 1;
                                $result['message'] = 'Dirección agregada correctamente';


                                $users->setId($_SESSION['user_id']);
                                $action = 'Agregar dirección';
                                $details = "El usuario " . $_SESSION['username'] . " agregó una nueva dirección al cliente con el id: " . $data['id'] . " de nombre: " .  $data['name'] . " " .  $data['lastname'];
                                $users->saveLog($action, $details);
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Dirección no válida';
                        }
                    } else {
                        $result['exception'] = 'Cliente no existente';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }

                break;
            case 'saveDocument':
                $_POST = $document->validateForm($_POST);
                if ($document->setClientId($_POST['client_id_document'])) {
                    $client->setId($_POST['client_id_document']);
                    if ($data = $client->readOne()) {
                        if ($document->setDocumentNumber($_POST['document_number'])) {
                            if ($document->setDocumentType($_POST['document_type'])) {
                                if ($document->create()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Documento registrado correctamente';

                                    $users->setId($_SESSION['user_id']);
                                    $action = 'Agregar documento';
                                    $details = "El usuario " . $_SESSION['username'] . " agregó un nuevo documento al cliente con el id: " . $data['id'] . " de nombre: " .  $data['name'] . " " .  $data['lastname'];
                                    $users->saveLog($action, $details);
                                } else {
                                    $result['exception'] = Database::getException();;
                                }
                            } else {
                                $result['exception'] = 'Tipo de documento no válido';
                            }
                        } else {
                            $result['exception'] = 'Número de documento no válido';
                        }
                    } else {
                        $result['exception'] = 'Cliente no existente';
                    }
                } else {

                    $result['exception'] = 'Cliente no válido';
                }

                break;

            case 'generateCSV':

                $client = new Clients();

                $clients = $client->getAllClients(); 

                if ($clients) {

                    
                    $users->setId($_SESSION['user_id']);
                    $action = 'Generar reporte CSV';
                    $details = "El usuario " . $_SESSION['username'] . " generó un reporte CSV para ver los datos de los clientes";
                    $users->saveLog($action, $details);
                    // Nombre del archivo
                    $filename = "reporte_clientes_" . date("Y-m-d-H:i:s") . ".csv";

                    // encabezados para la descarga del archivo
                    header('Content-Type: text/csv; charset=UTF-8');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    echo "\xEF\xBB\xBF";

                    $output = fopen('php://output', 'w');

                    fputcsv($output, ['ID', 'Nombre', 'Apellido', 'Correo', 'Teléfono','Estado']);

                    // llenando csv de datos
                    foreach ($clients as $row) {
                        fputcsv($output, [
                            $row['id'],
                            $row['name'],
                            $row['lastname'],
                            $row['email'],
                            $row['phone_number'],
                            $row['is_deleted'] == 0 ? 'Activo' : 'Inactivo',

                        ]);
                    }


                    fclose($output);
                    exit; 



                } else {
                    echo "No se encontraron datos para generar el reporte.";
                }
                break;

            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {

        $result['exception'] = 'Acción no disponible dentro de la sesión';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
