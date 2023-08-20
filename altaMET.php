<?php include("cabecera.php"); ?>


<script>
	$(document).ready(function() {
		$("#institucion").change(function() {
			var elemento = $("#institucion").val();
			if (elemento != "") {
				$.ajax({
					data: {
						"institucion": elemento
					},
					type: "POST",
					url: "feed.php?action=institucion&csrf=<?= $_SESSION["token"] ?>",
					beforeSend: function() {
						$("#salida1").html('<img src="img/cargando.gif" style="max-width: 100px;" alt="cargando...">');
					},
					success: function(response) {

						$("#salida1").html(response);
					}
				});
			}
		});

		$("#excel").click(function() {
			$("#resultado").html('<br><center><h3><i class="fas fa-arrow-alt-circle-down"></i> Se ha descargado correctamente la plantilla.</h3><label>* Subir plantilla</label><br><input type="file" name="archivo" accept=".xlsx" required></center>');
		});
		$("#manual").click(function() {
			$.ajax({
				type: "POST",
				url: "feed.php?action=manual&csrf=<?= $_SESSION["token"] ?>",
				beforeSend: function() {
					$("#resultado").html('<img src="img/cargando.gif" style="max-width: 100px;" alt="cargando...">');
				},
				success: function(response) {

					$("#resultado").html(response);
				}
			});
		});
	});
</script>
<script>
	function alerta() {
		alert("Al descargar esta plantilla de excel debe de habilitar la edición de la misma para un funcionamiento correcto al subir los datos")
	}
</script>
<form method="post" action="procesamiento.php?action=altaMET" enctype="multipart/form-data" autocomplete="off">
	<div class="row inicial">
		<div class="col-lg-12">
			<hr>
			<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > MET > Alta de titulación
			<hr>
		</div>
		<div class="col-lg-12">
			<?php if (isset($_REQUEST["salida"])) : ?>
				<?php if ($_REQUEST["salida"] == "error") : ?>
					<div class="alert alert-danger" role="alert">
						Error al insertar los datos del alumno rectifique en el archivo excel y vuelva a intentarlo
					</div>
				<?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
					<div class="alert alert-danger" role="alert">
						Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
					</div>
				<?php elseif ($_REQUEST["salida"] == "success") : ?>
					<div class="alert alert-success" role="alert">
						Se registro correctamente los alumnos del archivo excel.
					</div>

				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="col-lg-12">

			<input type="hidden" name="csrf" value="<?= $_SESSION["token"] ?>">
			<label>* Institución.</label>
			<select name="institucion" id="institucion" class="form-control" required>
				<option value="">Seleccione una institución del listado</option>
				<?php list($instituciones, $contadorInstituciones) = obtenerInstituciones($conn, $_SESSION["idUser"]);
				foreach ($instituciones as $institucion) : ?>
					<option value="<?= $institucion["idInstitucion"] ?>"><?= $institucion["clave"] ?> - <?= $institucion["nombre"] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-lg-12" id="salida1">

			<div class="row">
				<div class="col-lg-6">
					<label>* Responsable</label>
					<select class="form-control" disabled>
						<option>Seleccione primero una institución.</option>
					</select>
				</div>
				<div class="col-lg-6">
					<label>* Carrera</label>
					<select class="form-control" disabled>
						<option>Seleccione primero una institución.</option>
					</select>
				</div>



			</div>
		</div>
		<div class="col-lg-12"><br></div>
		<div class="col-lg-6">
			<center>

			</center>

			<div class="card border-success">
				<div class="card-header bg-success text-white">
					Cargar información por documento de excel.
				</div>
				<div class="card-body">

					<p class="card-text">Con esta opción, usted puede cargar la información mediante una plantilla de Excel.</p>

					<center><a href="files/plantilla.xlsx" id="excel" onclick="alerta()" class="btn btn-outline-success"><i class="far fa-file-excel"></i> Cargar por excel.</a></center>
				</div>
			</div>
		</div>
		<!-- comentado de carga manual<div class="col-lg-6">
		
		<div class="card border-info">
		  <div class="card-header bg-info text-white">
		    Cargar manualmente.
		  </div>
		  <div class="card-body">
		    <p class="card-text">Con esta opción, usted puede cargar la información de forma manual mediante la captura de datos.</p>
		    <center><button type="button" id="manual" class="btn btn-outline-info"><i class="fas fa-keyboard"></i> Cargar manualmente.</button></center>
		  </div>
		</div>
	</div>
	<div class="col-lg-12"><br></div>

	<div class="col-lg-12" id="resultado">

	</div>
	<div class="col-lg-12">
		<button type="submit" class="btn btn-success"><i class="fas fa-arrow-circle-up"></i> Subir información</button>
		<br><br><br>
	</div>

</form>

</div>
<?php include("footer.php"); ?>