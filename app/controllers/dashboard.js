
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
                    <button onclick="ShowLogInfo(${row.id})" class="btn btn-warning marginButton"><i class="material-icons">info</i></button>
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

