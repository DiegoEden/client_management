/*
*   Este archivo es de uso general en todas las páginas web. Se importa en las plantillas del pie del documento.
*/

/*
*   Función para obtener todos los registros disponibles en los mantenimientos de tablas (operación read).
*
*   Parámetros: api (ruta del servidor para obtener los datos).
*
*   Retorno: ninguno.
*/
function readRows(api) {
    fetch(api + 'readAll', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                let data = [];
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    data = response.dataset;
                } else {
                    sweetAlert(4, response.exception, null);
                }
                // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                fillTable(data);
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

/*
*   Función para obtener los resultados de una búsqueda en los mantenimientos de tablas (operación search).
*
*   Parámetros: api (ruta del servidor para obtener los datos) y form (identificador del formulario de búsqueda).
*
*   Retorno: ninguno.
*/
function searchRows(api, form) {
    fetch(api + 'search', {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                    fillTable(response.dataset);
                    sweetAlert(1, response.message, null);
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


function searchRows2(api, form, method) {
    fetch(api + method, {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                    fillTable(response.dataset);
                    //sweetAlert(1, response.message, null);
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


function readRows2(api, method) {
    fetch(api + method, {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                let data = [];
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    data = response.dataset;
                } else {
                    sweetAlert(4, response.exception, null);
                }
                // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                fillTable(data);
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


/*
*   Función para crear o actualizar un registro en los mantenimientos de tablas (operación create y update).
*
*   Parámetros: api (ruta del servidor para enviar los datos), form (identificador del formulario) y modal (identificador de la caja de dialogo).
*
*   Retorno: ninguno.
*/
function saveRow(api, action, form, modal) {
    fetch(api + action, {
        method: 'post',
        body: new FormData(document.getElementById(form))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se cierra la caja de dialogo (modal) del formulario.
                    closeModal(modal)
                    // Se cargan nuevamente las filas en la tabla de la vista después de agregar o modificar un registro.
                    readRows(api);
                    sweetAlert(1, response.message, null);
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

/*
*   Función para eliminar un registro seleccionado en los mantenimientos de tablas (operación delete). Requiere el archivo sweetalert.min.js para funcionar.
*
*   Parámetros: api (ruta del servidor para enviar los datos) y data (objeto con los datos del registro a eliminar).
*
*   Retorno: ninguno.
*/
function confirmDelete(api, data) {
    swal({
        title: 'Advertencia',
        text: '¿Desea eliminar el registro?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            fetch(api + 'delete', {
                method: 'post',
                body: data
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cargan nuevamente las filas en la tabla de la vista después de borrar un registro.
                            readRows(api);
                            sweetAlert(1, response.message, null);
                        } else {
                            sweetAlert(2, response.exception, null);
                        }
                    });
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    });
}

/*
*   Función para manejar los mensajes de notificación al usuario. Requiere el archivo sweetalert.min.js para funcionar.
*
*   Parámetros: type (tipo de mensaje), text (texto a mostrar) y url (ubicación a direccionar al cerrar el mensaje).
*
*   Retorno: ninguno.
*/
function sweetAlert(type, text, url) {
    // Se compara el tipo de mensaje a mostrar.
    switch (type) {
        case 1:
            title = 'Éxito';
            icon = 'success';
            break;
        case 2:
            title = 'Error';
            icon = 'error';
            break;
        case 3:
            title = 'Advertencia';
            icon = 'warning';
            break;
        case 4:
            title = 'Aviso';
            icon = 'info';
    }
    // Si existe una ruta definida, se muestra el mensaje y se direcciona a dicha ubicación, de lo contrario solo se muestra el mensaje.
    if (url) {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: 'Aceptar',
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then(function () {
            location.href = url
        });
    } else {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: 'Aceptar',
            closeOnClickOutside: false,
            closeOnEsc: false
        });
    }
}

/*
*   Función para cargar las opciones en un select de formulario.
*
*   Parámetros: endpoint (ruta del servidor para obtener los datos), select (identificador del select en el formulario) y selected (valor seleccionado).
*
*   Retorno: ninguno.
*/
function fillSelect(endpoint, select, selected) {
    fetch(endpoint, {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                let content = '';
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Si no existe un valor para seleccionar, se muestra una opción para indicarlo.
                    if (!selected) {
                        content += '<option disabled selected>Seleccione una opción</option>';
                    }
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se obtiene el dato del primer campo de la sentencia SQL (valor para cada opción).
                        value = Object.values(row)[0];
                        // Se obtiene el dato del segundo campo de la sentencia SQL (texto para cada opción).
                        text = Object.values(row)[1];
                        // Se verifica si el valor de la API es diferente al valor seleccionado para enlistar una opción, de lo contrario se establece la opción como seleccionada.
                        if (value != selected) {
                            content += `<option value="${value}">${text}</option>`;
                        } else {
                            content += `<option value="${value}" selected>${text}</option>`;
                        }
                    });
                } else {
                    content += '<option>No hay opciones disponibles</option>';
                }
                // Se agregan las opciones a la etiqueta select mediante su id.
                document.getElementById(select).innerHTML = content;
                // Se inicializa el componente Select del formulario para que muestre las opciones.
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


function closeModal(form) {
    $(document.getElementById(form)).modal('hide');
}


function openModal(form) {
    $(document.getElementById(form)).modal('show');
}


function autotab(current, to, prev) {
    if (current.getAttribute &&
        current.value.length == current.getAttribute("maxlength")) {
        to.focus()

    } else {
        prev.focus()


    }


}


function previewSavePicture(idDivFoto, name) {
    //Parte de la pagina web en donde se incrustara la imagen
    let preview = document.getElementById(idDivFoto);

    image = document.createElement('img');

    //Se le asigna la ruta al elemento creado
    image.src = '../resources/img/clients/' + name;

    
    image.style.width = '150px';

    image.style.height = '150px';
    //Se aplican las respectivas clases para que la preview aparezca estilizada
    image.className = 'fit-images rounded-circle';

    //Se quita lo que este dentro del div (en caso de que exista otra imagen)
    preview.innerHTML = ' ';

    //Se agrega el elemento recien creado
    preview.append(image);

}