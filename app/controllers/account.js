/*
*   Este controlador es de uso general en las páginas web del sitio privado. 
*   Sirve para manejar todo lo que tiene que ver con la cuenta del usuario.
*/

// Constante para establecer la ruta y parámetros de comunicación con la API.
const ENDPOINT_USERS = '../app/api/users.php?action=';

// Función para mostrar el formulario de editar perfil con los datos del usuario que ha iniciado sesión.
function openProfileDialog() {
    // Se abre el modal para editar perfil.
    const modal = new bootstrap.Modal(document.getElementById('profile-modal'));
    modal.show();

    fetch(ENDPOINT_USERS + 'readProfile', {
        method: 'get'
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del usuario.
                    document.getElementById('username').value = response.dataset.username;
                    document.getElementById('user_email').value = response.dataset.email;
                   
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

// Método manejador de eventos que se ejecuta cuando se envía el formulario de editar perfil.
document.getElementById('profile-form').addEventListener('submit', function (event) {
    event.preventDefault();

    fetch(ENDPOINT_USERS + 'editProfile', {
        method: 'post',
        body: new FormData(document.getElementById('profile-form'))
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    // Se cierra el modal.
                    const modal = bootstrap.Modal.getInstance(document.getElementById('profile-modal'));
                    modal.hide();
                    // Se muestra un mensaje y se redirige al menú principal.
                    sweetAlert(1, response.message, 'clients.php');
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
});


// Función para mostrar un mensaje de confirmación al momento de cerrar sesión.
function logOut() {
    swal({
        title: 'Advertencia',
        text: '¿Quiere cerrar la sesión?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        if (value) {
            fetch(ENDPOINT_USERS + 'logOut', {
                method: 'get'
            }).then(function (request) {
                if (request.ok) {
                    request.json().then(function (response) {
                        if (response.status) {
                            sweetAlert(1, response.message, '../index.php');
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
        } else {
            sweetAlert(4, 'Puede continuar con la sesión', null);
        }
    });
}
