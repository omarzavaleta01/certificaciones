<?php include("cabecera.php"); ?>

<script>
	jQuery.fn.generaNuevosCampos = function(etiqueta, nombreCampo, indice) {

		$(this).each(function() {
			elem = $(this);
			elem.data("etiqueta", etiqueta);
			elem.data("nombreCampo", nombreCampo);
			elem.data("indice", indice);

			var elementoRespuestas = indice;

			elem.click(function(e) {
				e.preventDefault();
				elem = $(this);
				etiqueta = elem.data("etiqueta");
				nombreCampo = elem.data("nombreCampo");
				indice = elem.data("indice");	
				texto_insertar = '<div id="campos_' + indice + '"><hr><p><a id="botonEliminarPregunta_' + indice + '" style="float: right;" class="btn btn-danger "><i class="fas fa-trash"></i></a><div><br><strong>* Ingresar materias de la carrera</strong><hr><input type="hidden" value="<?= $idCarrera["idCarrera"] ?>" readonly name="idCarrera[]"><p>Nombre de la materia<input type="text" class="form-control preguntaCampo" placeholder="Escriba el nombre de la asignatura" onkeyup="mayus(this);" name="nombreAsignatura[]" required /></p><div class="row"><div class="col-lg-4"><label>Asignatura</label><input type="text" class="form-control incorrecto" name="" placeholder="Escriba la asignatura" ></div><div class="col-lg-4"><label>Clave de la asignatura</label><input type="number" class="form-control" name="claveAsignatura[]" min="1" max="9999999999" required></div><div class="col-lg-4"><label>Tipo de asignatura</label><select name="tipoCarrera[]" class="form-control" required><option value="">Seleccione una opción.</option><?php list($asignaturas, $contadorAsignaturas) = obtenerTipoAsignatura($conn);foreach ($asignaturas as $asignatura) : ?><option value="<?= $asignatura["idTipoAsignatura"] ?>"><?= $asignatura["nombreAsignatura"] ?></option><?php endforeach; ?></select></div></div></div><br></div><script>$("#botonEliminarPregunta_' + indice + '").click(function (){$("#campos_' + indice + '").remove(); actualizarElementos(); });<\/script>';
				indice++;
				elem.data("indice", indice);
				nuevo_campo = $(texto_insertar);
				elem.before(nuevo_campo);
			});

		});
		return this;
	}
	$(document).ready(function() {
		$("#mascampos").generaNuevosCampos("Pregunta", "preguntas[]", 1);
	});
</script>

<?php
$token = $_REQUEST["token"];
list($carrera, $contadorCarrera) = obtenerCarrera($conn, $token);
foreach ($carrera as $carrera) {
	$idCarrera = $carrera["idCarrera"];
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
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > <a href="listadoCarreras.php"><i class="far fa-clipboard"></i> Listado carreras</a> > <i class="fas fa-edit"></i> Alta mapa curricular
		<hr>
	</div>

	<div class="col-lg-12">
		<form method="post" action="procesamiento.php?action=altaAsignatura1&idCarrera=<?= $token ?>" onsubmit="return confirm('¿Se encuentra segur@ de registrar estas materias en esta carrera?')">
			<h5><i class="fas fa-edit"></i> Alta mapa curricular</h5>
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
					Proceso correcto.
				</div>

			<?php endif; ?>
		<?php endif; ?>
	</div>

	<input type="hidden" value="<?= $_SESSION["token"] ?>" name="csrf">
	<div class="col-lg-4">
		<label>Institución</label>
		<select name="" id="institucion" class="form-control" required readonly>
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
	<br>

	<div class="col-lg-4">
		<label>* Nombre carrera</label>
		<input type="hidden" value="<?= $idCarrera["idCarrera"] ?>" readonly name="idCarrera[]">
		<input type="text" name="" value="<?= $nombreCarrera ?>" required onkeyup="mayus(this);" maxlength="1" class="form-control" required autofocus readonly>
	</div>

	<div class="col-lg-12">
		<br>
		<strong>* Ingresar materias de la carrera</strong>
		<hr>
		<p>Nombre de la materia<input type="text" class="form-control preguntaCampo" onkeyup="mayus(this);" placeholder="Escriba el nombre de la asignatura" name="nombreAsignatura[]" required /></p>
		<div class="row">
			<div class="col-lg-4"><label>Asignatura</label><input type="text" class="form-control incorrecto" name="" placeholder="Escriba la asignatura" ></div>
			<div class="col-lg-4"><label>Clave de la asignatura</label><input type="number" class="form-control" name="claveAsignatura[]" min="1" max="9999999999" placeholder="Escriba la clave de la asignatura" required></div>

			<div class="col-lg-4"><label>Tipo de asignatura</label><select name="tipoCarrera[]" class="form-control" required>
					<option value="">Seleccione una opción.</option>

					<?php list($asignaturas, $contadorAsignaturas) = obtenerTipoAsignatura($conn);
					foreach ($asignaturas as $asignatura) : ?>
						<option value="<?= $asignatura["idTipoAsignatura"] ?>"><?= $asignatura["nombreAsignatura"] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div><br>

	<br>
	<div class="col-lg-12">
		<br>
		<a style="float: left;" id="mascampos" class="btn btn-secondary" title="Agregar una materia"><i class="fa fa-plus-square"></i> Materia</a>
	</div>

	<div class="col-lg-12">
		<br>
		<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
	</div>

	</form>

</div>
<?php include("footer.php"); ?>