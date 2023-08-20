<?php include("cabecera.php"); ?>
<script>
	function mayus(e) {
    e.value = e.value.toUpperCase();
}
</script>
 <script>
     jQuery.fn.generaNuevosCampos = function(etiqueta, nombreCampo, indice){
                     
                      $(this).each(function(){
                        elem = $(this);
                        elem.data("etiqueta",etiqueta);
                        elem.data("nombreCampo",nombreCampo);
                        elem.data("indice",indice);

                        var elementoRespuestas = indice;
                        
                        elem.click(function(e){
                          e.preventDefault();
                          elem = $(this);
                          etiqueta = elem.data("etiqueta");
                          nombreCampo = elem.data("nombreCampo");
                          indice = elem.data("indice");
                          texto_insertar = '<div id="campos_'+indice+'"><p><a id="botonEliminarPregunta_'+indice+'" style="float: right;" class="btn btn-danger" title="Remover responsable"><i class="fas fa-trash"></i></a><br><br><div class="col-lg-12"><div class="row"><div class="col-lg-3"><label>* Cargo</label><select name="cargoResponsable[]" class="form-control" required><option value="">Seleccione una opción.</option><?php list($cargos,$contadorCargos) = obtenerCargos($conn); foreach($cargos as $cargo): ?><option value="<?=$cargo["idCargo"]?>"><?=$cargo["cargo"]?></option><?php endforeach;?></select></div><div class="col-lg-3"><label>* Nombre</label><input type="text" name="nombreResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required></div><div class="col-lg-3"><label>* Apellido paterno</label><input type="text" name="apellidoPaternoResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required></div><div class="col-lg-3"><label>* Apellido materno</label><input type="text" name="apellidoMaternoResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required></div><div class="col-lg-3"><label>* Profesión</label><select name="profesionResponsable[]" class="form-control" required><option value="">Seleccione una opción.</option><?php list($profesiones,$contadorProfesiones) = obtenerProfesiones($conn);foreach($profesiones as $nombreProfesion):?><option value="<?=$nombreProfesion["idProfesion"]?>"><?=$nombreProfesion["nombreProfesion"]?></option><?php endforeach;?></select></div><div class="col-lg-3"><label>* CURP</label><input type="text" name="curpResponsable[]" pattern="[A-Z0-9]+" title="Ingresar solo letras mayúsculas y números" onkeyup="mayus(this);" maxlength="18" class="form-control" required></div><div class="col-lg-3"><label>* Certificado (.cer)</label><input type="file" name="fileCerResponsable[]" accept=".cer" required></div><div class="col-lg-3"><label>* Clave privada (.key)</label><input type="file" name="fileKeyResponsable[]" accept=".key" required></div><div class="col-lg-3"><label>* Contraseña de clave privada</label><input type="text" name="clavePrivadaResponsable[]" id="clave1" maxlength="8" class="form-control" required></div></div></div></div><script>$("#botonEliminarPregunta_'+indice+'").click(function (){$("#campos_'+indice+'").remove(); actualizarElementos(); });<\/script>';
                          indice ++;
                          elem.data("indice",indice);
                          nuevo_campo = $(texto_insertar);
                          elem.before(nuevo_campo);
                        });

                      });
                      return this;
                    }
                    $(document).ready(function(){
                      $("#mascampos").generaNuevosCampos("Pregunta", "preguntas[]", 1);
                     
                      
          });
</script>
<div class="row inicial">
	<div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > Alta de institución
		<hr>
	</div>
	
	<div class="col-lg-12">
	<form method="post" action="procesamiento.php?action=altaUniversidad" enctype="multipart/form-data">
		<h5><i class="fas fa-plus-square"></i> Alta de institución</h5>
		 <strong>* Campos requeridos</strong>
	</div>
	<div class="col-lg-12">
		<?php if(isset($_REQUEST["salida"])): ?>
			<?php if($_REQUEST["salida"] == "error"): ?>
				<div class="alert alert-danger" role="alert">
				 Hubó un error con la comunicación del servidor, por favor vuelva a intentarlo más tarde.
				</div>
				<?php elseif($_REQUEST["salida"] == "repetido"): ?>
					<div class="alert alert-danger" role="alert">
					 La institución ya se encuentra registrada en su cuenta.
					</div>
				<?php elseif($_REQUEST["salida"] == "missingdata"): ?>
					<div class="alert alert-danger" role="alert">
					Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
					</div>
				<?php elseif($_REQUEST["salida"] == "success"): ?>
					<div class="alert alert-success" role="alert">
					Institución registrada correctamente.
					</div>

			<?php endif; ?>
		<?php endif;?>
	</div>
	
	<input type="hidden" value="<?=$_SESSION["token"]?>" name="csrf">	
	<div class="col-lg-6">
		<label>* Nombre institución</label>
		<input type="text" name="nombreInstitucion" onkeyup="mayus(this);" maxlength="200" class="form-control" required autofocus>
	</div>
	<div class="col-lg-6">
		<label>* Clave institución (Asignado por DGP)</label>
		<input type="number" name="claveInstitucion" min="1" max="999999" class="form-control" required >
	</div>
	
	<div class="col-lg-12">

		<hr>
		<h5>Datos de acceso.</h5>

	</div>
		<div class="col-lg-6">
			<div class="card">
				 <div class="card-header">
				    Datos al servidor de prueba proporcionados por SEP
				  </div>
				  <div class="card-body">
				  	<div class="row">
						<div class="col-lg-6">
							<label>Usuario</label>
							<input type="text" name="usuarioQA" class="form-control" maxlength="100">
						</div>
						<div class="col-lg-6">
							<label>Clave</label>
							<input type="password" name="claveQA" class="form-control" maxlength="100">
						</div>
					</div>
				  </div>
			</div>
			
		</div>
		<div class="col-lg-6">
			<div class="card">
				 <div class="card-header">
				    Datos al servidor de producción proporcionados por SEP
				  </div>
				  <div class="card-body">
				  	<div class="row">
						<div class="col-lg-6">
							<label>Usuario</label>
							<input type="text" name="usuarioProduccion" class="form-control" maxlength="100">
						</div>
						<div class="col-lg-6">
							<label>Clave</label>
							<input type="password" name="claveProduccion" class="form-control" maxlength="100">
						</div>
					</div>
				  </div>
			</div>
		</div>

		<div class="col-lg-12">
			<hr>
			<h5>Datos de responsables.</h5>
		</div>
		<div class="col-lg-12">
			<div class="row">
			<div class="col-lg-3">
				<label>* Cargo</label>
				<select name="cargoResponsable[]" class="form-control" required>
					<option value="">Seleccione una opción.</option>
					<?php list($cargos,$contadorCargos) = obtenerCargos($conn); foreach($cargos as $cargo): ?>
					<option value="<?=$cargo["idCargo"]?>"><?=$cargo["cargo"]?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="col-lg-3">
				<label>* Nombre</label>
				<input type="text" name="nombreResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required>
			</div>
			<div class="col-lg-3">
				<label>* Apellido paterno</label>
				<input type="text" name="apellidoPaternoResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required>
			</div>
			<div class="col-lg-3">
				<label>* Apellido materno</label>
				<input type="text" name="apellidoMaternoResponsable[]" onkeyup="mayus(this);" maxlength="50" class="form-control" required>
			</div>
			<div class="col-lg-3">
				<label>* Profesión</label>
				<select name="profesionResponsable[]" class="form-control" required>
					<option value="">Seleccione una opción.</option>
					<?php list($profesiones,$contadorProfesiones) = obtenerProfesiones($conn);foreach($profesiones as $nombreProfesion):?>
					<option value="<?=$nombreProfesion["abreviacion"]?>"><?=$nombreProfesion["nombreProfesion"]?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="col-lg-3">
				<label>* CURP</label>
				<input type="text" name="curpResponsable[]" pattern="[A-Z0-9]+" title="Ingresar solo letras mayúsculas y números" onkeyup="mayus(this);" maxlength="18" class="form-control" required>
			</div>
			<div class="col-lg-3">
				<label>* Certificado (.cer)</label>
				<input type="file" name="fileCerResponsable[]" accept=".cer" required>
			</div>
			<div class="col-lg-3">
				<label>* Clave privada (.key)</label>
				<input type="file" name="fileKeyResponsable[]" accept=".key" required>
			</div>
			<div class="col-lg-3">
				<label>* Contraseña de clave privada</label>
				<input type="text" name="clavePrivadaResponsable[]" id="clave1" maxlength="8" class="form-control" required>
			</div>

			
		</div>
		</div>

		<div class="col-lg-12"><br><a style="float: right;" id="mascampos" class="btn btn-info" title="Agregar un nuevo responsable"><i class="fa fa-plus-square"></i> Responsable</a></div>

		<div class="col-lg-12">
			<br>
			<button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
		</div>
	

</form>

</div>
<?php include("footer.php"); ?>