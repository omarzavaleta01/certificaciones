<?php include("cabecera.php"); ?>
<?php
date_default_timezone_set("America/Mexico_City");
include("conexion.php");
//include("funciones.php");

$token = $_REQUEST["token"];

list($met, $contadorTitulaciones) = obtenerTitulacionesEspecifico($conn, $token);
foreach ($met as $titulo) {
    $nombre = $titulo["nombre"];
    $apellidoPaterno = $titulo["apellidoPaterno"];
    $apellidoMaterno = $titulo["apellidoMaterno"];
    $curp = $titulo["curp"];
}

?>
<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ historiales",
                "infoEmpty": "Mostrando 0 to 0 of 0 historiales",
                "infoFiltered": "(Filtrado de _MAX_ total historiales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ historiales",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "<br>Buscar contenido en la tabla:  ",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "paging": false,

            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
<input type="hidden" value="<?= $_SESSION["token"] ?>" name="csrf">

    <div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > MET > <a href="listadoMET.php"> Listado MET</a> >  Historico MET
		<hr>
	</div>
    <div class="col-lg-12">
                    <hr>
                    <h5>Historico de pruebas del alumn@: </h5>
                </div>

    <div class="card-body">
    
        <div class="row">
            <div class="col-lg-3">
                <label>* Nombre</label>
                <input type="text" onkeyup="mayus(this);" name="" value="<?= $nombre ?>" class="form-control" pattern="[A-Z ]+" maxlength="250" readOnly required>
            </div>
            <div class="col-lg-3">
                <label>* Apellido paterno</label>
                <input type="text" onkeyup="mayus(this);" name="" value="<?= $apellidoPaterno ?>" class="form-control" pattern="[A-Z]+" maxlength="250" readOnly required>
            </div>
            <div class="col-lg-3">
                <label>* Apellido materno</label>
                <input type="text" onkeyup="mayus(this);" name="" value="<?= $apellidoMaterno ?>" class="form-control" readOnly pattern="[A-Z]+" maxlength="250" required>
            </div>
            
            <div class="col-lg-3">
                <label>* CURP</label>
                <input type="text" onkeyup="mayus(this);" name="" value="<?= $curp ?>" class="form-control" readonly pattern="[A-Z0-9]+" minlength="18" maxlength="18" required>
            </div>
            <br>
            <div class="col-lg-12">
                
                
                <table id="example" class="table table-bordered">
                <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Resultado</th>

                        </tr>
                    </thead>
                    <tfoot style="display: table-header-group;">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Resultado</th>

                        </tr>
                    </tfoot>
                    <tbody>

                        <tr>
                            <td>10-20-2021</td>
                            <td>15:00</td>
                            <td>Aprobado</td>
                        </tr>
                        <tr>
                            <td>30-20-2021</td>
                            <td>15:00</td>
                            <td>En proceso</td>
                        </tr>
                        <tr>
                            <td>30-20-2021</td>
                            <td>15:00</td>
                            <td>En proceso</td>
                        </tr>

                    </tbody>
		</table>
        </div>

        </div>
    </div>




<?php include("footer.php"); ?>