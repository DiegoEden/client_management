<?php
// Se incluye la clase con las plantillas del documento.
require_once('../app/assets/dashboard_layout.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Actividad reciente');
?>


<!-- Tabla para mostrar los registros existentes -->
<div class="table-responsive mt-5">
    <table class="table" id="data-table">
        <thead>
            <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Acción</th>
                <th scope="col">Fecha y Hora</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="tbody-rows">
            <!-- Aquí se llenarán los registros dinámicamente -->
        </tbody>
    </table>
</div>

<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="ModalBitacora" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Información de la bitácora</h1>
                <button type="button" class="btn-close closeModalButton" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

                <div class="row" style="margin: 10px;">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 id="username"></h1>
                        <br>
                        <h3 id="action"></h3>
                        <br>
                        <h3 id="details"></h3>
                        <br>
                        <h3 id="created_at"></h3>
                        <br>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('dashboard.js');
?>