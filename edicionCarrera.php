<?php include("cabecera.php"); ?>
<?php
$token = $_REQUEST["token"];
list($carrera, $contadorCarrera) = obtenerCarrera($conn, $token);
foreach ($carrera as $carrera) {
	list($institucion, $contadorInstitucion) = obtenerInstucion($conn, $carrera["idInstitucion"]);
	foreach ($institucion as $ins) {
		$nombreInstitucionCarrera = $ins["nombre"];
		$idInstitucionCarrera = $ins["idInstitucion"];
	}

	list($modalidades, $contadorModalidades) = obtenerModalidad($conn, $carrera["idCatalogoModalidad"]);
	foreach ($modalidades as $mod) {
		$nombreModalidad = $mod["nombreModalidad"];
	}

	list($catalogoCarreras, $contadorCatalogoCarreras) = obtenerCatalogoCarrera($conn, $carrera["idCatalogoCarrera"]);
	foreach ($catalogoCarreras as $catalogoC) {
		$nombreCatalogoCarrera = $catalogoC["nombreCatalogoCarrera"];
	}

	$idCatalogoCarrera = $carrera["idCatalogoCarrera"];

	$nombreCarrera = $carrera["nombre"];

	$idCatalogoPeriodo = $carrera["idCatalogoPeriodo"];
	$idCatalogoModalidad = $carrera["idCatalogoModalidad"];

	$claveCarrera = $carrera["clave"];
	$idAutorizacionCarrera = $carrera["idAutorizacion"];
	$rvoeCarera = $carrera["rvoe"];

	$fechaExpRvoe = $carrera["fechaExpedicionRevoe"];
}
?>
<script>
	function mayus(e) {
		e.value = e.value.toUpperCase();
	}
</script>

<div class="row inicial">
	<div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > <a href="listadoCarreras.php"><i class="far fa-clipboard"></i> Listado carreras</a> > <i class="fas fa-edit"></i> Edición de carrera
		<hr>
	</div>

	<div class="col-lg-12">
		<form method="post" action="procesamiento.php?action=editarCarrera&idCarrera=<?= $token ?>" onsubmit="return confirm('¿Se encuentra segur@ de modificar la carrera?')">
			<h5><i class="fas fa-edit"></i> Edición de carrera</h5>
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
					La clave carrera ingresada corresponde a otra carrera registrada en su cuenta.
				</div>
			<?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
				<div class="alert alert-danger" role="alert">
					Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
				</div>
			<?php elseif ($_REQUEST["salida"] == "success") : ?>
				<div class="alert alert-success" role="alert">
					Carrera modificada correctamente.
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
				<?php if ($institucion["idInstitucion"] == $idInstitucionCarrera) : ?>
					<option value="<?= $institucion["idInstitucion"] ?>" selected><?= $institucion["clave"] ?> - <?= $institucion["nombre"] ?></option>
				<?php else : ?>
					<option value="<?= $institucion["idInstitucion"] ?>"><?= $institucion["clave"] ?> - <?= $institucion["nombre"] ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Tipo de carrera</label>
		<select name="tipoCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($carreras, $contadorCarreras) = obtenerCatalogoCarreras($conn);
			foreach ($carreras as $carr) : ?>
				<?php if ($carr["idCatalogoCarrera"] == $idCatalogoCarrera) : ?>
					<option value="<?= $carr["idCatalogoCarrera"] ?>" selected>-> <?= $carr["nombreCatalogoCarrera"] ?></option>
				<?php else : ?>
					<option value="<?= $carr["idCatalogoCarrera"] ?>"><?= utf8_encode($carr["nombreCatalogoCarrera"]) ?></option>
				<?php endif; ?>
			<?php endforeach; ?>

		</select>
	</div>
	<div class="col-lg-4">
		<label>* Nombre carrera</label>
		<input type="text" name="nombreCarrera" value="<?= $nombreCarrera ?>" onkeyup="mayus(this);" maxlength="200" class="form-control" required autofocus>
	</div>
	<div class="col-lg-4">
		<label>* Periodo</label>
		<select name="periodoCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($periodos, $contadorPeriodos) = obtenerCatalogoPeriodos($conn);
			foreach ($periodos as $periodo) : ?>
				<?php if ($periodo["idCatalogoPeriodo"] == $idCatalogoPeriodo) : ?>
					<option value="<?= $periodo["idCatalogoPeriodo"] ?>" selected>-> <?= $periodo["nombrePeriodo"] ?></option>
				<?php else : ?>
					<option value="<?= $periodo["idCatalogoPeriodo"] ?>"><?= utf8_encode($periodo["nombrePeriodo"]) ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Modalidad</label>
		<select name="modalidadCarrera" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($modalidades, $contadorModalidades) = obtenerCatalogoModalidades($conn);
			foreach ($modalidades as $modalidad) : ?>
				<?php if ($modalidad["idCatalogoModalidad"] == $idCatalogoModalidad) : ?>
					<option value="<?= $modalidad["idCatalogoModalidad"] ?>" selected>-> <?= $modalidad["nombreModalidad"] ?></option>
				<?php else : ?>
					<option value="<?= $modalidad["idCatalogoModalidad"] ?>"><?= utf8_encode($modalidad["nombreModalidad"]) ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* Clave carrera (Asignado por DGP)</label>
		<input type="number" name="claveCarrera" value="<?= $claveCarrera ?>" min="1" max="9999999999" class="form-control" required>
	</div>
	<div class="col-lg-4">
		<label>* Autorización reconocimiento</label>
		<select name="autorizacion" class="form-control" required="">
			<option value="">Seleccione una opción</option>
			<?php list($autorizaciones, $contadorAutorizaciones) = obtenerCatalogoAutorizacion($conn);
			foreach ($autorizaciones as $autorizacion) : ?>
				<?php if ($autorizacion["idAutorizacion"] == $idAutorizacionCarrera) : ?>
					<option value="<?= $autorizacion["idAutorizacion"] ?>" selected><?= utf8_encode($autorizacion["autorizacion"]) ?></option>
				<?php else : ?>
					<option value="<?= $autorizacion["idAutorizacion"] ?>"><?= utf8_encode($autorizacion["autorizacion"]) ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>* RVOE</label>
		<input type="number" class="form-control" value="<?= $rvoeCarera ?>" name="rvoe" min="1" max="9999999999" required>
	</div>
	<div class="col-lg-4">
		<label>* Fecha expedición revoe</label>
		<input type="date" class="form-control" value="<?= $fechaExpRvoe ?>" name="fechaExpedicionRvoe" required>
	</div>
	<div class="col-lg-12">
		<br>
		<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
	</div>


	</form>

</div>
<?php include("footer.php"); ?>