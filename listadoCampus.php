<?php include("cabecera.php"); ?>
<?php list($campus, $contadorCampus) = obtenerCampus($conn, $_SESSION["idUser"]); ?>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ campus",
				"infoEmpty": "Mostrando 0 to 0 of 0 campus",
				"infoFiltered": "(Filtrado de _MAX_ total campus)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ campus",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar contenido en la tabla: ",
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
<div class="row inicial">
	<div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > Listado de campus
		<hr>
	</div>
	<div class="col-lg-10">
		<h5><i class="far fa-clipboard"></i> Listado de campus</h5>
	</div>
	<div class="col-lg-2">
		<a href="nuevoCampus.php" class="btn btn-success" title="Registrar un nuevo campus"><i class="fas fa-plus"></i> Nuevo campus</a>
	</div>
	<div class="col-lg-12">
		<?php if (isset($_REQUEST["salida"])) : ?>
			<?php if ($_REQUEST["salida"] == "error") : ?>
				<div class="alert alert-danger" role="alert">
					Hubó un error con la comunicación del servidor, por favor vuelva a intentarlo más tarde.
				</div>
			<?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
				<div class="alert alert-danger" role="alert">
					Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
				</div>
			<?php elseif ($_REQUEST["salida"] == "success") : ?>
				<div class="alert alert-success" role="alert">
					Campus eliminado correctamente.
				</div>

			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="col-lg-12">
		<br>
		<table id="example" class="table table-bordered">
			<thead>
				<tr>
					<th>Institución</th>
					<th>Nombre</th>
					<th>Numero</th>
					<th>Entidad</th>
					
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot style="display: table-header-group;">
				<tr>
					<th>Institución</th>
					<th>Nombre</th>
					<th>Numero</th>
					<th>Entidad</th>
					

				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($campus as $campu) : ?>
					<?php
					list($institucion, $contadorInstitucion) = obtenerInstucion($conn, $campu["idInstitucion"]);
					foreach ($institucion as $ins) {
						$nombreInstitucion = $ins["nombre"];
					}
					?>
                    <?php
					list($entidad, $contadorEntidad) = obtenerEntidad($conn, $campu["idEntidad"]);
					foreach ($entidad as $ent) {
						$nombreEntidad = $ent["entidad"];
					}
					?>
					<tr>
						<td><?= htmlspecialchars($nombreInstitucion) ?></td>
						<td><?= htmlspecialchars($campu["nombre"]) ?></td>
						<td><?= htmlspecialchars($campu["numeroCampus"]) ?></td>
						<td><?= htmlspecialchars($nombreEntidad) ?></td>
						
						<td><a href="editarCampus.php?token=<?= $campu["idCampus"] ?>" class="btn btn-warning" title="Editar los datos del campus"><i class="fas fa-edit"></i></a><a href="procesamiento.php?action=eliminarCampus&token=<?= $campu["idCampus"] ?>&seguro=<?= $_SESSION["token"] ?>" class="btn btn-danger" title="Eliminar campus" onclick="return confirm('¿Se encuentra seguro de eliminar la campus?, se eliminarán los campus cargados')"><i class="far fa-trash-alt"></i></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php include("footer.php"); ?>