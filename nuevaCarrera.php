<?php include("cabecera.php"); ?>
<script>
	function mayus(e) {
		e.value = e.value.toUpperCase();
	}
</script>
<script>
	function alerta() {
		alert("Para realizar el alta del plan de estudios debe buscar la carrea de su preferencia y debe de dar clic en el boton con el signo + de color amarillo que se encuentra en las acciones de cada carrera")
	}
</script>
<div class="row inicial">
	<div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > Alta de carrera
		<hr>
	</div>
	<div class="col-lg-12">
		<form method="post" action="procesamiento.php?action=altaCarrera" enctype="multipart/form-data">
			<h5><i class="fas fa-plus-square"></i> Alta de carrera</h5>
			<strong>* Campos requeridos</strong>
	</div>
	<div class="col-lg-12">
		<?php if (isset($_REQUEST["salida"])) : ?>
			<?php if ($_REQUEST["salida"] == "error") : ?>
				<div class="alert alert-danger" role="alert">
					Hubó un error con la comunicación del servidor, por favor vuelva a intentarlo más tarde.
				</div>
			<?php elseif ($_REQUEST["salida"] == "repetido") : ?>
				<div class="alert alert-danger" role="alert">
					La carrera ya se encuentra registrada en su cuenta.
				</div>
			<?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
				<div class="alert alert-danger" role="alert">
					Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
				</div>
			<?php elseif ($_REQUEST["salida"] == "success") : ?>
				<div class="alert alert-success" role="alert">
					Carrera registrada correctamente.
				</div>

			<?php endif; ?>
		<?php endif; ?>
	</div>

	<input type="hidden" value="<?= $_SESSION["token"] ?>" name="csrf">
	<div class="col-lg-4">
		<label>Institución</label>
		<select name="institucion" id="institucion" class="form-control" required>
			<option value="">Seleccione una institución del listado</option>
			<?php list($instituciones, $contadorInstituciones) = obtenerInstituciones($conn, $_SESSION["idUser"]);
			foreach ($instituciones as $institucion) : ?>
				<option value="<?= $institucion["idInstitucion"] ?>"><?= $institucion["clave"] ?> - <?= $institucion["nombre"] ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Tipo de carrera</label>
		<select name="tipoCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($carreras, $contadorCarreras) = obtenerCatalogoCarreras($conn);
			foreach ($carreras as $carr) : ?>
				<option value="<?= $carr["idCatalogoCarrera"] ?>"><?= utf8_encode($carr["nombreCatalogoCarrera"]) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Nombre carrera</label>
		<input type="text" name="nombreCarrera" onkeyup="mayus(this);" maxlength="200" class="form-control" required autofocus>
	</div>
	<div class="col-lg-4">
		<label>* Periodo</label>
		<select name="periodoCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($periodos, $contadorPeriodos) = obtenerCatalogoPeriodos($conn);
			foreach ($periodos as $periodo) : ?>
				<option value="<?= $periodo["idCatalogoPeriodo"] ?>"><?= utf8_encode($periodo["nombrePeriodo"]) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Modalidad</label>
		<select name="modalidadCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($modalidades, $contadorModalidades) = obtenerCatalogoModalidades($conn);
			foreach ($modalidades as $modalidad) : ?>
				<option value="<?= $modalidad["idCatalogoModalidad"] ?>"><?= utf8_encode($modalidad["nombreModalidad"]) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Clave carrera (Asignado por DGP)</label>
		<input type="number" name="claveCarrera" min="1" max="999999999" class="form-control" required>
	</div>
	<div class="col-lg-4">
		<label>* Autorización reconocimiento</label>
		<select name="autorizacion" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($autorizaciones, $contadorAutorizaciones) = obtenerCatalogoAutorizacion($conn);
			foreach ($autorizaciones as $autorizacion) : ?>
				<option value="<?= $autorizacion["idAutorizacion"] ?>"><?= utf8_encode($autorizacion["autorizacion"]) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* RVOE</label>
		<input type="number" class="form-control" name="rvoe" min="1" max="9999999999" required>
	</div>
	<div class="col-lg-4">
		<label>* Fecha expedición revoe</label>
		<input type="date" class="form-control" name="fechaExpedicionRvoe" required>
	</div>
	<div class="col-lg-12">
		<br>
		<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
	</div>
	<div class="col-lg-12">
		<br>
		<a href="listadoCarreras.php" class="btn btn-warning" onclick="alerta()" title="Cargar plan de estudios"><i class="fas fa-plus"></i> Cargar plan de estudios</a>
	</div>
</div>

<?php include("footer.php"); ?>