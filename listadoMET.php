<?php include("cabecera.php"); ?>
<?php list($titulaciones, $contadorTitulaciones) = obtenerTitulaciones($conn, $_SESSION["idUser"]); ?>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ titulaciones",
				"infoEmpty": "Mostrando 0 to 0 of 0 titulaciones",
				"infoFiltered": "(Filtrado de _MAX_ total titulaciones)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ titulaciones",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar contenido en la tabla:  ",
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
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> ><a href="altaMET.php"> MET</a> > Listado de titulaciones
		<hr>
	</div>
	<div class="col-lg-10">
		<h5><i class="far fa-clipboard"></i> Listado de titulaciones</h5>
	</div>
	<div class="col-lg-2">
		<a href="altaMET.php" class="btn btn-success" title="Registrar una nueva titulacion"><i class="fas fa-plus"></i> Nueva titulacion</a>
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
					Titulación eliminada correctamente.
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
					<th>Nombre</th>
					<th>Folio Control</th>
					<th>Responsable</th>
					<th>Carrera</th>
					<th>Estatus</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tfoot style="display: table-header-group;">
				<tr>
					<th>Institución</th>
					<th>Nombre</th>
					<th>Folio Control</th>
					<th>Responsable</th>
					<th>Carrera</th>

				</tr>
			</tfoot>
			<tbody>

				<?php foreach ($titulaciones as $titulo) : ?>
					<?php
					list($institucion, $contadorInstitucion) = obtenerInstucion($conn, $titulo["idInstitucion"]);
					foreach ($institucion as $ins) {
						$nombreInstitucion = $ins["nombre"];
					}
					?>
					<?php
					list($carrera, $contadorCarrera) = obtenerCarrera($conn, $titulo["idCarrera"]);
					foreach ($carrera as $car) {
						$nombreCarrera = $car["nombre"];
					}
					?>
					<?php
					list($responsable, $contadorResponsable) = obtenerResponsable($conn, $titulo["idResponsable"]);
					foreach ($responsable as $resp) {
						$nombreResponsable = $resp["nombre"];
						$nombreResponsable = $resp["apellidoPaterno"];
						$nombreResponsable = $resp["apellidoMaterno"];
					}
					?>
					<?php
					list($estatus, $contadorEstatus) = obtenerEstatusMET($conn, $titulo["idEstatus"]);
					foreach ($estatus as $est) {
						$nombreEstatus = $est["nombre"];
					}
					?>


					<tr>
						<td><?= htmlspecialchars($nombreInstitucion) ?></td>
						<td><?= htmlspecialchars($titulo["nombre"] . " " . $titulo["apellidoPaterno"] . " " . $titulo["apellidoMaterno"]) ?></td>
						<td><?= htmlspecialchars($titulo["folioControl"]) ?></td>
						<td><?= htmlspecialchars($resp["nombre"] . " " . $resp["apellidoPaterno"] . " " . $resp["apellidoMaterno"]) ?></td>
						<td><?= htmlspecialchars($nombreCarrera) ?></td>
						<td><?= nl2br(($nombreEstatus)) ?></td>


						<!--<td><a href="edicionCarrera.php?token=<?= $carrera["idCarrera"] ?>" class="btn btn-warning" title="Editar los datos de la carrera"><i class="fas fa-edit"></i></a> <a href="procesamiento.php?action=eliminarCarrera&token=<?= $carrera["idCarrera"] ?>&seguro=<?= $_SESSION["token"] ?>" class="btn btn-danger" title="Eliminar titulo" onclick="return confirm('¿Se encuentra seguro de eliminar la titulacion?, se eliminarán los titulos cargados')"><i class="far fa-trash-alt"></i></a></td>
						-->

						<!-- <td>
							<a href="editarMET.php?token=<?= $titulo["idMET"] ?>" class="btn btn-primary btn-sm"  title="Editar los datos de la titulación"><i class="fas fa-edit"></i></a><a href="procesamiento.php?action=eliminarMET&token=<?= $titulo["idMET"] ?>&seguro=<?= $_SESSION["token"] ?>" class="btn btn-danger btn-sm" title="Eliminar titulación" onclick="return confirm('¿Se encuentra seguro de eliminar la titulacion?')"><i class="far fa-trash-alt"></i></a>
						</td> -->

						<td>
							<a href="editarMET.php?token=<?= $titulo["idMET"] ?>" class="btn btn-primary btn-sm" title="Editar los datos de la titulación"><i class="fas fa-edit"></i></a><a href="historicoMET.php?token=<?= $titulo["idMET"] ?>" class="btn btn-primary btn-sm" title="Historico de Pruebas"><i class="fa fa-history"></i></a>
							<a href="procesamiento.php?action=eliminarMET&token=<?= $titulo["idMET"] ?>&seguro=<?= $_SESSION["token"] ?>" class="btn btn-danger btn-sm" title="Eliminar titulación" onclick="return confirm('¿Se encuentra seguro de eliminar la titulacion?')"><i class="far fa-trash-alt"></i></a>
							<!-- <a href="subirPruebas.php?token=<?= $titulo["idMET"] ?>" class="btn btn-primary btn-sm" title="Subir a Pruebas"><i class="fa fa-cogs"></i></a><a href="subirProduccion.php?token=<?= $titulo["idMET"] ?>" class="btn btn-primary btn-sm" title="Subir a produccion"><i class="fas fa-file-import"></i></a> -->
						</td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php include("footer.php"); ?>