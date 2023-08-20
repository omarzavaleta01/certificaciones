<?php include("cabecera.php"); ?>
<?php list($carreras, $contadorCarreras) = obtenerCarreras($conn, $_SESSION["idUser"]); ?>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ carreras",
				"infoEmpty": "Mostrando 0 to 0 of 0 carreras",
				"infoFiltered": "(Filtrado de _MAX_ total carreras)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ carreras",
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
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > Listado de carreras
		<hr>
	</div>
	<div class="col-lg-10">
		<h5><i class="far fa-clipboard"></i> Listado de carreras</h5>
	</div>
	<div class="col-lg-2">
		<a href="nuevaCarrera.php" class="btn btn-success" title="Registrar una nueva carrera"><i class="fas fa-plus"></i> Nueva carrera</a>
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
					Carrera eliminada correctamente.
				</div>

			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="col-lg-12">
		<br>
		<table id="example" class="table-bordered table-responsive">
			<thead>
				<tr>
					<th>Institución</th>
					<th>Carrera</th>
					<th>Tipo de modalidad</th>
					<th>Tipo de periodos</th>
					<th>Clave</th>
					<th>RVOE</th>
					<th>Fecha creación</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot style="display: table-header-group;">
				<tr>
					<th>Institución</th>
					<th>Carrera</th>
					<th>Tipo de modalidad</th>
					<th>Tipo de periodos</th>
					<th>Clave</th>
					<th>RVOE</th>
					<th>Fecha creación</th>
					

				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($carreras as $carrera) : ?>
					<?php
					list($institucion, $contadorInstitucion) = obtenerInstucion($conn, $carrera["idInstitucion"]);
					foreach ($institucion as $ins) {
						$nombreInstitucion = $ins["nombre"];
					}
					?>
					<?php
					list($modalidades, $contadorModalidades) = obtenerModalidad($conn, $carrera["idCatalogoModalidad"]);
					foreach ($modalidades as $mod) {
						$nombreModalidad = $mod["nombreModalidad"];
					}
					?>
					<?php
					list($catalogoCarreras, $contadorCatalogoCarreras) = obtenerCatalogoCarrera($conn, $carrera["idCatalogoCarrera"]);
					foreach ($catalogoCarreras as $catalogoC) {
						$nombreCatalogoCarrera = $catalogoC["nombreCatalogoCarrera"];
					}
					?>
					<?php
					list($catalogoPeriodos, $contadorCatalogoPeriodos) = obtenerCatalogoPeriodo($conn, $carrera["idCatalogoPeriodo"]);
					foreach ($catalogoPeriodos as $catalogoP) {
						$nombreCatalogoPeriodo = $catalogoP["nombrePeriodo"];
					}
					?>
					<tr>
						<td><?= htmlspecialchars($nombreInstitucion) ?></td>
						<td><?= htmlspecialchars($catalogoC["nombreCatalogoCarrera"]." ".$carrera["nombre"]) ?></td>
						<td><?= htmlspecialchars($nombreModalidad) ?></td>
						<td><?= htmlspecialchars($nombreCatalogoPeriodo) ?></td>

						<td><?= htmlspecialchars($carrera["clave"]) ?></td>
						<td><?= htmlspecialchars($carrera["rvoe"]) ?></td>
						<td><?= date("d/m/y", strtotime($carrera["fechaCreacion"])) ?></td>
						<td><a href="nuevoPlanEstudios.php?token=<?= $carrera["idCarrera"] ?>" class="btn btn-warning" title="Cargar plan de estudios de la carrera"><i class="fas fa-plus"></i></a>
						<a href="edicionCarrera.php?token=<?= $carrera["idCarrera"] ?>" class="btn btn-warning" title="Editar los datos de la carrera"><i class="fas fa-edit"></i></a><a href="procesamiento.php?action=eliminarCarrera&token=<?= $carrera["idCarrera"] ?>&seguro=<?= $_SESSION["token"] ?>" class="btn btn-danger" title="Eliminar carrera" onclick="return confirm('¿Se encuentra seguro de eliminar la carrera?, se eliminarán los titulos y certificaciones cargados')"><i class="far fa-trash-alt"></i></a></td>

						
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php include("footer.php"); ?>