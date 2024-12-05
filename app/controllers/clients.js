const ENDPOINT_CLIENTS = '../app/api/clients.php?action=';


document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla.
    readRows(ENDPOINT_CLIENTS);
});


function fillTable(dataset) {
    let content = '';
    dataset.map(function (row) {
        // Se establece un icono para el estado del producto.
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
             <tr>
                <td><img src="../resources/img/clients/${row.photo}" class=" rounded-circle" height="100"></td>
                <td>${row.name}</td>
                <td>${row.lastname}</td>
                <td>${row.email}</td>
                <td>${row.phone_number}</td>
                <td>
                    <button onclick="openUpdateDialog(${row.id})" class="btn btn-warning marginButton"><i class="material-icons">mode_edit</i></button>
                    <button onclick="openAddressDialog(${row.id})" class="btn btn-primary marginButton"><i class="material-icons">location_on</i></button>
                    <button onclick="openDocumentDialog(${row.id})" class="btn btn-secondary marginButton"><i class="material-icons">description</i></button>
                    <button onclick="openDeleteDialog(${row.id})" class="btn btn-danger marginButton"><i class="material-icons">delete</i></button>
                </td>
            </tr>
        `;
    });
    document.getElementById('tbody-rows').innerHTML = content;

    $('#data-table').DataTable({
        retrieve: true,
        searching: false,
        language:
            {
                "decimal":        "",
                "emptyTable":     "No hay información disponible en la tabla.",
                "info":           "Mostrando _START_ de _END_ de _TOTAL_ registros.",
                "infoEmpty":      "Mostrando 0 de 0 de 0 registros",
                "infoFiltered":   "(filtered from _MAX_ total entries)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Loading...",
                "processing":     "Processing...",
                "search":         "Search:",
                "zeroRecords":    "No matching records found",
                "paginate": {
                    "first":      "AAA",
                    "last":       "Ultimo",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
    });
}


document.getElementById('search-form').addEventListener('submit', function (event) {
    event.preventDefault();
    searchRows(ENDPOINT_CLIENTS, 'search-form');
});

function openCreateDialog() {
    document.getElementById('client_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('lastname').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phone_number').value = '';
    document.getElementById('photo').value = '';

    document.getElementById('btnGuardar').className = "btn btnAdd";
    document.getElementById('btnActualizar').className = "d-none";

    previewSavePicture('divFoto', 'user.png');

    const modal = new bootstrap.Modal(document.getElementById('save-modal'));
    modal.show();
    document.getElementById('modal-title').textContent = 'Agregar nuevo cliente';

}


function openAddressDialog(id) {

    const modal = new bootstrap.Modal(document.getElementById('address-modal'));
    modal.show();

    const data = new FormData();
    data.append('client_id', id);

    fetch(ENDPOINT_CLIENTS + 'readOne', {
        method: 'post',
        body: data
    })
        .then(function (request) {
            if (request.ok) {
                return request.json();
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        })
        .then(function (response) {
            if (response.status) {
                document.getElementById('client_id_address').value = response.dataset.id;
                document.getElementById('modal-title-address').textContent = "Agregar nueva dirección al cliente " + response.dataset.name + " " + response.dataset.lastname;


            } else {
                sweetAlert(2, response.exception, null);
            }
        })
        .catch(function (error) {
            console.log(error);
        });


}


document.getElementById('generateReport').addEventListener('click', function () {
    fetch(ENDPOINT_CLIENTS + 'generateCSV', {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al generar el reporte.');
        }
        return response.blob(); // Convertir la respuesta en un Blob
    })
    .then(blob => {
        // Crear un enlace temporal para descargar el archivo
        const url = window.URL.createObjectURL(blob);

        // Obtener la fecha y hora actual para el nombre del archivo
        const now = new Date();
        const formattedDate = now.toISOString().slice(0, 10); // YYYY-MM-DD
        const formattedTime = now.toTimeString().slice(0, 8).replace(/:/g, '-'); // HH-MM-SS
        const filename = `reporte_clientes_${formattedDate}_${formattedTime}.csv`;

        // Crear enlace temporal y asignar el nombre dinámico
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click(); // Activar la descarga
        a.remove(); // Eliminar el enlace temporal
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

function openDocumentDialog(id) {

    const modal = new bootstrap.Modal(document.getElementById('document-modal'));
    modal.show();

    const data = new FormData();
    data.append('client_id', id);

    fetch(ENDPOINT_CLIENTS + 'readOne', {
        method: 'post',
        body: data
    })
        .then(function (request) {
            if (request.ok) {
                return request.json();
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        })
        .then(function (response) {
            if (response.status) {
                document.getElementById('client_id_document').value = response.dataset.id;
                document.getElementById('modal-title-document').textContent = "Agregar documento al cliente " + response.dataset.name + " " + response.dataset.lastname;


            } else {
                sweetAlert(2, response.exception, null);
            }
        })
        .catch(function (error) {
            console.log(error);
        });


}


document.getElementById('btnSaveDocument').addEventListener('click', function (event) {
    //Evento para evitar que recargue la pagina
    event.preventDefault();
    //Se agrega el nuevo registro
    saveRow(ENDPOINT_CLIENTS, 'saveDocument', 'document-form', 'document-modal');
})


document.getElementById('btnGuardar').addEventListener('click', function (event) {
    //Evento para evitar que recargue la pagina
    event.preventDefault();
    //Se agrega el nuevo registro
    saveRow(ENDPOINT_CLIENTS, 'create', 'save-form', 'save-modal');
})


document.getElementById('btnActualizar').addEventListener('click', function (event) {
    //Evento para evitar que recargue la pagina
    event.preventDefault();
    //Se agrega el nuevo registro
    saveRow(ENDPOINT_CLIENTS, 'update', 'save-form', 'save-modal');
})

document.getElementById('btnSaveAddress').addEventListener('click', function (event) {
    //Evento para evitar que recargue la pagina
    event.preventDefault();
    //Se agrega el nuevo registro
    saveRow(ENDPOINT_CLIENTS, 'saveAddress', 'address-form', 'address-modal');
})



function openUpdateDialog(id) {
    const modal = new bootstrap.Modal(document.getElementById('save-modal'));
    modal.show();
    document.getElementById('modal-title').textContent = 'Actualizar datos del cliente';
    document.getElementById('photo').required = false;

    document.getElementById('btnGuardar').className = "d-none";
    document.getElementById('btnActualizar').className = "btn btnAdd";



    const data = new FormData();
    data.append('client_id', id);

    fetch(ENDPOINT_CLIENTS + 'readOne', {
        method: 'post',
        body: data
    })
        .then(function (request) {
            if (request.ok) {
                return request.json();
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        })
        .then(function (response) {
            if (response.status) {
                document.getElementById('client_id').value = response.dataset.id;
                document.getElementById('name').value = response.dataset.name;
                document.getElementById('lastname').value = response.dataset.lastname;
                document.getElementById('email').value = response.dataset.email;
                document.getElementById('phone_number').value = response.dataset.phone_number;
                previewSavePicture('divFoto', response.dataset.photo);



            } else {
                sweetAlert(2, response.exception, null);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

function openDeleteDialog(id) {
    const data = new FormData();
    data.append('client_id', id);
    confirmDelete(ENDPOINT_CLIENTS, data);
}


document.getElementById('reset').addEventListener('click', function (event) {
    //Evento para evitar que recargue la pagina
    event.preventDefault();
    readRows(ENDPOINT_CLIENTS);

    document.getElementById('search').value = "";
})


botonExaminar('botonFoto', 'photo');

//Metodo para crear una previsualizacion del archivo a cargar en la base de datos
previewPicture('photo', 'divFoto');

function botonExaminar(idBoton, idInputExaminar) {
    document.getElementById(idBoton).addEventListener('click', function (event) {
        //Se evita recargar la pagina
        event.preventDefault();

        //Se hace click al input invisible
        document.getElementById(idInputExaminar).click();
    });
}

function previewPicture(idInputExaminar, idDivFoto) {
    document.getElementById(idInputExaminar).onchange = function (e) {

        //variable creada para obtener la URL del archivo a cargar
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);

        //Se ejecuta al obtener una URL
        reader.onload = function () {
            //Parte de la pagina web en donde se incrustara la imagen
            let preview = document.getElementById(idDivFoto);

            //Se crea el elemento IMG que contendra la preview
            image = document.createElement('img');

            //Se le asigna la ruta al elemento creado
            image.src = reader.result;

            image.style.width = '150px';

            image.style.height = '150px';
            //Se aplican las respectivas clases para que la preview aparezca estilizada
            image.className = 'fit-images rounded-circle';

            //Se quita lo que este dentro del div (en caso de que exista otra imagen)
            preview.innerHTML = ' ';

            //Se agrega el elemento recien creado
            preview.append(image);
        }
    }
}