
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla.
    readRows2(ENDPOINT_USERS, 'getLogs');
});


function fillTable(dataset) {
    let content = '';
    dataset.map(function (row) {
        // Se establece un icono para el estado del producto.
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
             <tr>
                <td>${row.username}</td>
                <td>${row.action}</td>
                <td>${row.created_at}</td>
                <td>
                    <button onclick="ShowLogInfo(${row.id})" data-bs-toggle="modal" data-bs-target="#logModal" class="btn btn-warning marginButton"><i class="material-icons">info</i></button>
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

function ShowLogInfo(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('log_id', id);

    fetch(ENDPOINT_USERS + 'readOneLog', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se colocan los datos en la tarjeta de acuerdo al producto seleccionado previamente.
                    document.getElementById('action').textContent ="Acción: "+response.dataset.action;
                    document.getElementById('details').textContent ="Detalles: "+ response.dataset.details;
                    document.getElementById('created_at').textContent ="Fecha: "+ response.dataset.created_at;
                    document.getElementById('loguser').textContent ="Usuario: "+ response.dataset.username;



                } else {
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}