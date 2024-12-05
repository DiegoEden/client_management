<?php
// Se incluye la clase con las plantillas del documento.
require_once('../app/assets/dashboard_layout.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Administrar clientes');
?>

<div class="row">
    <!-- Formulario de búsqueda -->
    <form method="post" id="search-form" class="row g-3" autocomplete="off">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" name="search" class="form-control" placeholder="Buscador" required>
                <button type="submit" class="btn btn-success">Buscar</button>
                <button type="button" id="reset" name="reset" style="margin-left:10px;" class="btn btn-warning">Reiniciar búsqueda</button>


            </div>
        </div>


        <div class="col-md-6 text-end">
            <!-- Botón para abrir el modal al momento de crear un nuevo registro -->
            <button type="button" class="btn btnAdd" onclick="openCreateDialog()">
                Nuevo registro
            </button>

            <button type="button" id="generateReport" name="generateReport" class="btn btn-info">
                Reporte de clientes
            </button>
        </div>
    </form>
</div>

<!-- Tabla para mostrar los registros existentes -->
<div class="table-responsive mt-5">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Correo electrónico</th>
                <th scope="col">Número de teléfono</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="tbody-rows">
            <!-- Aquí se llenarán los registros dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Modal para mostrar el formulario -->
<div class="modal fade" id="save-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="save-form">
                    <!-- Campo oculto para asignar el id del registro al momento de modificar -->
                    <input type="hidden" id="client_id" name="client_id">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="cargarFoto" id="divFoto">

                            </div>
                            <div class="cargarFoto">
                                <button type="submit" class="btn btnAdd" id="botonFoto" name="c"><i class="material-icons">add</i></button>
                            </div>
                            <input type="file" id="photo" name="photo" class="d-none" required>
                        </div>
                        <div class="col-md-6">

                            <label for="name" class="form-label">Nombres</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Apellidos</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Número telefónico</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                        </div>

                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" id="btnGuardar" class="btn btnAdd">Guardar</button>
                        <button type="submit" id="btnActualizar" name="btnActualizar" class="btn btnAdd">Actualizar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="address-modal" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title-address" name="modal-title-address" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="address-form">
                    <!-- Campo oculto para asignar el id del registro al momento de modificar -->
                    <input type="hidden" id="client_id_address" name="client_id_address">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="address">Dirección</label>
                            <textarea name="address" id="address" class="form-control" rows="4" required></textarea>
                        </div>


                    </div>
                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSaveAddress" id="btnSaveAddress" class="btn btnAdd">Guardar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="document-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title-document" name="modal-title-document" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="document-form">
                    <!-- Campo oculto para asignar el id del registro al momento de modificar -->
                    <input type="hidden" id="client_id_document" name="client_id_document">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tipo de documento</label>
                            <input type="text" id="document_type" name="document_type" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Número de documento</label>
                            <input type="text" id="document_number" name="document_number" class="form-control" required>
                        </div>

                    </div>
                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSaveDocument" id="btnSaveDocument" class="btn btnAdd">Guardar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#phone_number").mask("0000-0000");
    });
</script>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('clients.js');
?>