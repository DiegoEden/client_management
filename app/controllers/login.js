// Constante para establecer la ruta y parámetros de comunicación con la API.
const ENDPOINT_USERS = 'app/api/users.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {

    // Petición para verificar si existen usuarios.
    fetch(ENDPOINT_USERS + 'readAll', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción
                if (response.status) {
                    //sweetAlert(4, 'Debe autenticarse para ingresar', null);
                } else {
                    // Se verifica si ocurrió un problema en la base de datos, de lo contrario se continua normalmente.
                    if (response.error) {
                        sweetAlert(2, response.exception, null);
                    } else {
                        sweetAlert(3, response.exception, null);
                        openModal('registerModal');
                    }
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
});

// Método manejador de eventos que se ejecuta cuando se envía el formulario de iniciar sesión.
document.getElementById('login-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(ENDPOINT_USERS + 'logIn', {
        method: 'post',
        body: new FormData(document.getElementById('login-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    sweetAlert(1, response.message, 'views/clients.php');
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



// Método manejador de eventos que se ejecuta cuando se envía el formulario de registrar.
document.getElementById('register-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(ENDPOINT_USERS + 'register', {
        method: 'post',
        body: new FormData(document.getElementById('register-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    sweetAlert(1, response.message, null);
                    closeModal('registerModal');
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



document.getElementById('checkMail-form').addEventListener('submit', function (event) {
    const boton = document.getElementById('btnVerificar');
    boton.disabled = true;
    event.preventDefault();
    fetch(ENDPOINT_USERS + 'sendMail', {
        method: 'post',
        body: new FormData(document.getElementById('checkMail-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                document.getElementById('recover_email').disabled = true;

                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Mostramos mensaje de exito
                    closeModal('modalPassword');
                    openModal('verificarCodigoRecuperacion');
                    const boton = document.getElementById('btnVerificar');
                    boton.disabled = false;
                    document.getElementById('recover_email').disabled = false;

                } else {
                    sweetAlert(4, response.exception, null);
                    const boton = document.getElementById('btnVerificar');
                    boton.disabled = false;
                    document.getElementById('recover_email').disabled = false;
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
});


document.getElementById('checkCode-form').addEventListener('submit', function (event) {
    //Se evita que se recargue la pagina
    var uno = document.getElementById('1').value;
    var dos = document.getElementById('2').value;
    var tres = document.getElementById('3').value;
    var cuatro = document.getElementById('4').value;
    var cinco = document.getElementById('5').value;
    var seis = document.getElementById('6').value;
    document.getElementById('codigo').value = uno + dos + tres + cuatro + cinco + seis;

    event.preventDefault();
    fetch(ENDPOINT_USERS + 'verifyCode', {
        method: 'post',
        body: new FormData(document.getElementById('checkCode-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Mostramos mensaje de exito

                    closeModal('verificarCodigoRecuperacion');
                    openModal('cambiarContraseña');



                } else {
                    sweetAlert(4, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
});



//Función para cambiar contraseña   para
document.getElementById('update-form').addEventListener('submit', function (event) {
	//Se evita que se recargue la pagina
	const boton2 = document.getElementById('btnSubmit');
	boton2.disabled = true;

	event.preventDefault();

	// Realizamos peticion a la API de clientes con el caso changePass y method post para dar acceso al valor de los campos del form
	fetch(ENDPOINT_USERS + 'changePass', {
		method: 'post',
		body: new FormData(document.getElementById('update-form'))
	}).then(function (request) {
		// Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
		if (request.ok) {
			request.json().then(function (response) {
				// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
				const input = document.getElementById('txtNewPass');
				input.disabled = true;
				if (response.status) {
					// En caso de iniciar sesion correctamente mostrar mensaje y redirigir al menu
					closeModal('cambiarContraseña');
					sweetAlert(1, response.message, null);
					boton2.disabled = false;
					input.disabled = false;
				} else {
					sweetAlert(3, response.exception, null);
					boton2.disabled = false;
					input.disabled = false;
				}
			});
		} else {
			console.log(request.status + ' ' + request.statusText);
		}
	}).catch(function (error) {
		console.log(error);
	});


});