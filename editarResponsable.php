<?php include("cabecera.php"); ?>
<?php
	$token = $_REQUEST["token"];
	list($institucion,$contadorInstitucion) = obtenerInstucion($conn,$token);
	foreach($institucion as $institucion){
		$nombreInstitucion = $institucion["nombre"];
		$claveInstitucion = $institucion["clave"];
		$usuarioQA = $institucion["usuarioQA"];
		$claveQA = $institucion["claveQA"];
		$usuarioProduccion = $institucion["usuarioProduccion"];
		$claveProduccion = $institucion["claveProduccion"];
	}
	list($responsable,$contadorResponsable) = obtenerResponsable($conn,$_REQUEST["idResponsable"]);
	foreach($responsable as $res){
		$cargoResponsable = $res["idCargo"];
		$nombreResponsable = $res["nombre"];
		$apellidoPaternoResponsable = $res["apellidoPaterno"];
		$apellidoMaternoResponsable = $res["apellidoMaterno"];
		$curpResponsable = $res["curp"];
	}
?>
<script>
	function mayus(e) {
    e.value = e.value.toUpperCase();
}
</script>
<script>
	$(document).ready(function(){
		$("#clave").change(function(){
			if(this.files.length == 0){
				$("#textoClave").html("Contraseña de clave privada");
				$("#claveCampo").removeAttr("required");
				$("#claveCampo").attr("disabled","disabled");
			}else{
				$("#textoClave").html("*Contraseña de clave privada");
				$("#claveCampo").removeAttr("disabled");
				$("#claveCampo").attr("required","required");
			}

		});
	});
</script>
<div class="row inicial">
	<div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > <a href="listadoInstituciones.php"><i class="far fa-clipboard"></i> Listado instituciones</a> > <i class="fas fa-edit"></i> <a href="edicionInstitucion.php?token=<?=$token?>">Edición de institución</a>: <?=$nombreInstitucion?> > Edición de responsable
		<hr>
	</div>
	<div class="col-lg-12">
	<form method="post" action="procesamiento.php?action=editarResponsable&idInstitucion=<?=$token?>&idResponsable=<?=$_REQUEST["idResponsable"]?>" enctype="multipart/form-data" onsubmit="return confirm('¿Se encuentra segur@ de modificar la información del responsable.');">
		<h5><i class="fas fa-edit"></i> Edición de responsable</h5>
		 <strong>* Campos requeridos</strong>
	</div>
	<div class="col-lg-12">
		<?php if(isset($_REQUEST["salida"])): ?>
			<?php if($_REQUEST["salida"] == "error"): ?>
				<div class="alert alert-danger" role="alert">
				 Hubó un error con la comunicación del servidor, por favor vuelva a intentarlo más tarde.
				</div>
				<?php elseif($_REQUEST["salida"] == "missingdata"): ?>
					<div class="alert alert-danger" role="alert">
					Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
					</div>
				<?php elseif($_REQUEST["salida"] == "success"): ?>
					<div class="alert alert-success" role="alert">
					Datos del responsable se han modificado correctamente.
					</div>

			<?php endif; ?>
		<?php endif;?>
	</div>
	<input type="hidden" value="<?=$_SESSION["token"]?>" name="csrf">
	<div class="col-lg-3">
		<label>* Cargo</label>
		<select name="cargoResponsable" class="form-control" required="">
			<option value="">Seleccione una opción.</option>
			<?php list($cargos,$contadorCargos) = obtenerCargos($conn); foreach($cargos as $cargo): ?>
				<option value="<?=$cargo["idCargo"]?>" <?php if($cargo["idCargo"] == $cargoResponsable): ?> selected <?php endif;?>><?=$cargo["cargo"]?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div class="col-lg-3">
		<label>* Nombre</label>
		<input type="text" name="nombreResponsable" value="<?=$nombreResponsable?>" pattern="[A-Z ]+" title="Ingresar solo letras mayúsculas." onkeyup="mayus(this);" maxlength="50" class="form-control" required>
	</div>
	<div class="col-lg-3">
		<label>* Apellido paterno</label>
		<input type="text" name="apellidoPaternoResponsable" value="<?=$apellidoPaternoResponsable?>" pattern="[A-Z ]+" title="Ingresar solo letras mayúsculas." onkeyup="mayus(this);" maxlength="50" class="form-control" required>
	</div>
	<div class="col-lg-3">
		<label>* Apellido materno</label>
		<input type="text" name="apellidoMaternoResponsable" value="<?=$apellidoMaternoResponsable?>" pattern="[A-Z ]+" title="Ingresar solo letras mayúsculas." onkeyup="mayus(this);" maxlength="50" class="form-control" required>
	</div>
	<div class="col-lg-3">
		<label>* CURP</label>
		<input type="text" name="curpResponsable" value="<?=$curpResponsable?>" pattern="[A-Z0-9]+" title="Ingresar solo letras mayúsculas y números" onkeyup="mayus(this);" maxlength="18" class="form-control" required>
	</div>
	<div class="col-lg-3">
		<label>Certificado (.cer)</label>
		<input type="file" name="fileCerResponsable" accept=".cer">
		<small id="emailHelp" class="form-text text-muted">Seleccionar solo si desea modificar el archivo actual.</small>
	</div>
	<div class="col-lg-3">
		<label>Clave privada (.key)</label>
		<input type="file" name="fileKeyResponsable" id="clave" accept=".key">
		<small id="emailHelp" class="form-text text-muted">Seleccionar solo si desea modificar el archivo actual. Si se selecciona además la clave de la firma será obligatoria.</small>
	</div>
	<div class="col-lg-3">
		<label id="textoClave">Contraseña de clave privada</label>
		<input type="text" name="clavePrivadaResponsable" pattern="[A-Za-z0-9]+" title="Solo se acepta letras minúsculas, mayúsculas y números." id="claveCampo" maxlength="8" class="form-control" disabled>
	</div>
	<div class="col-lg-12">
		<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
	</div>
	
	</form>
</div>
<?php include("footer.php"); ?>