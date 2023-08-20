<?php
session_start();
date_default_timezone_set("America/Mexico_City");
include("conexion.php");
include("funciones.php");
if($_SESSION["idUser"] == ""){
    header("Location: index.php?error=expired");
}

$opcion = $_REQUEST["action"];

if($opcion == "institucion"){
    $csrf = $_REQUEST["csrf"];
    if($csrf == $_SESSION["token"]){
        list($responsables,$contadorResponsables) = obtenerResponsables($conn,$_REQUEST["institucion"]);
        ?>
        <div class="row">
            <div class="col-lg-6">
                <label>* Responsable</label>
                <select class="form-control" name="responsable" required>
                    <option value="">Seleccione un responsable.</option>
                    <?php foreach($responsables as $responsable):?>
                        <option value="<?=$responsable["idResponsable"]?>"><?=$responsable["nombre"]?> <?=$responsable["apellidoPaterno"]?> <?=$responsable["apellidoMaterno"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label>* Carrera</label>
                <select name="carrera" class="form-control" required="">
                    <option value="">Seleccione una carrera</option>
                    <?php list($carreras,$contadorCarreras) = obtenerCarrerasInstitucion($conn,$_REQUEST["institucion"]); foreach($carreras as $carrera): ?>
                        <option value="<?=$carrera["idCarrera"]?>"><?=$carrera["clave"]?> - <?=$carrera["nombre"]?></option>
                    <?php endforeach; ?>
            </div>

        </div>

        <?php
    }else{
        echo "Error de sesión, por favor vuelva a intentarlo más tarde";
    }
}else if($opcion == "manual"){
    list($antecedentes,$contadorAntecedentes) = obtenerCatalogoAntecedente($conn);
    list($entidades,$contadorEntidades) = obtenerCatalogoEntidades($conn);
    list($servicios,$contadorServicios) = obtenerCatalogoServicio($conn);
    list($titulaciones,$contadorTitulacion) = obtenerCatalogoTitulaciones($conn);
    ?>
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
                    texto_insertar = '<div id="campos_'+indice+'"><a id="botonEliminarPregunta_'+indice+'" style="float: right;" class="btn btn-danger" title="Remover alumno"><i class="fas fa-trash"></i></a><br><br><div class="card">\n' +
                        '        <div class="card-header text-white bg-dark">\n' +
                        '            Datos del Alumno \n' +
                        '        </div>\n' +
                        '        <div class="card-body">\n' +
                        '            <div class="row">\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Nombre</label>\n' +
                        '                    <input type="text" onkeyup="mayus(this);" name="alumno[]" class="form-control" pattern="[A-Z ]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Apellido paterno</label>\n' +
                        '                    <input type="text" onkeyup="mayus(this);" name="apellidoPaterno[]" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Apellido materno</label>\n' +
                        '                    <input type="text" onkeyup="mayus(this);" name="apellidoMaterno[]" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* CURP</label>\n' +
                        '                    <input type="text" onkeyup="mayus(this);" name="curp[]" class="form-control" pattern="[A-Z0-9]+" maxlength="18" title="Ingresar solo letras mayúsculas" required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Email</label>\n' +
                        '                    <input type="email" name="email[]" class="form-control" maxlength="150" required>\n' +
                        '                </div>\n' +
                        '                 <div class="col-lg-3">\n '+
                        '                   <label>* Folio de control (matrícula del alumno)</label>\n'+
                        '                   <input type="text" pattern="[A-Za-z0-9]+" title="Ingresar solo letras mayúsculas, minúsculas y números." name="folioControl[]" class="form-control"  required>\n'+
                        '                 </div><div class="col-lg-3">\n' +
                        '                    <label>* Fecha inicio carrera</label>\n' +
                        '                    <input type="date" name="fechaInicioCarrera[]" class="form-control"  required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha terminación carrera</label>\n' +
                        '                    <input type="date" name="fechaFinCarrera[]" class="form-control"  required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-12"><hr><h5>Datos de expedición</h5></div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha expedición</label>\n' +
                        '                    <input type="date" name="fechaExpedicion[]" class="form-control"  required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Modalidad titulación</label>\n' +
                        '                    <select name="modalidadTitulacion[]" class="form-control" required="">\n' +
                        '                        <option value="">Seleccione una modalidad</option>\n' +
                        '                        <?php foreach($titulaciones as $titulacion): ?>\n' +
                        '                            <option value="<?=$titulacion["idModalidad"]?>"><?=$titulacion["modalidad"]?></option>\n' +
                        '                        <?php endforeach;?>\n' +
                        '                    </select>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha examen profesional (dejar en blanco en caso de que el alumno haya exentado)</label>\n' +
                        '                    <input type="date" name="fechaExamenProfesional[]" class="form-control">\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha exención examen profesional (dejar en blanco en caso de que el alumno haya realizado el examen)</label>\n' +
                        '                    <input type="date" name="fechaExcencionExamenProfesional[]" class="form-control">\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                     <br>' +
                        '                    <label>* ¿Cumplio servicio social?</label>\n' +
                        '                    <br>\n' +
                        '                    <div class="form-check form-check-inline">\n' +
                        '                        <input class="form-check-input" type="radio" name="servicioSocial[]" id="inlineRadio1" value="1">\n' +
                        '                        <label class="form-check-label" for="inlineRadio1">Si</label>\n' +
                        '                    </div>\n' +
                        '                    <div class="form-check form-check-inline">\n' +
                        '                        <input class="form-check-input" type="radio" name="servicioSocial[]" id="inlineRadio2" value="0">\n' +
                        '                        <label class="form-check-label" for="inlineRadio2">No</label>\n' +
                        '                    </div>\n' +
                        '                   \n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                     <br>' +
                        '                    <label>* Fundamento del servicio social</label>\n' +
                        '                    <select name="fundamentoServicioSocial[]" class="form-control" required="">\n' +
                        '                        <option value="">Seleccione un fundamento</option>\n' +
                        '                        <?php foreach($servicios as $servicio): ?>\n' +
                        '                            <option value="<?=$servicio["idServicio"]?>"><?=utf8_encode($servicio["fundamento"])?></option>\n' +
                        '                        <?php endforeach;?>\n' +
                        '                    </select>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                     <br>' +
                        '                    <label>* Entidad</label>\n' +
                        '                    <select name="entidadExpedicion[]" class="form-control" required="">\n' +
                        '                        <option value="">Seleccione una entidad</option>\n' +
                        '                        <?php foreach($entidades as $entidad): ?>\n' +
                        '                            <option value="<?=$entidad["idEntidad"]?>"><?=utf8_encode($entidad["entidad"])?></option>\n' +
                        '                        <?php endforeach;?>\n' +
                        '                    </select>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-12">\n' +
                        '                    <hr>\n' +
                        '                    <h5>Antecedente</h5>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Institución de procedencia (Sin signos de puntuación, comillas, puntos, etc)</label>\n' +
                        '                    <input type="text" onkeyup="mayus(this);" name="institucionAntecedente[]" class="form-control" pattern="[A-Z0-9 ]+" maxlength="300" title="Ingresar solo letras mayúsculas y sin caracteres especiales." required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Tipo estudio</label>\n' +
                        '                    <select name="tipoEstudioAntecedente[]" class="form-control" required="">\n' +
                        '                        <option value="">Seleccione un tipo de estudio</option>\n' +
                        '                        <?php foreach($antecedentes as $antecedente): ?>\n' +
                        '                            <option value="<?=$antecedente["idEstudio"]?>"><?=utf8_encode($antecedente["estudio"])?></option>\n' +
                        '                        <?php endforeach;?>\n' +
                        '                    </select>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' + 
                        '                    <label>* Entidad</label>\n' +
                        '                    <select name="entidadAntecedente[]" class="form-control" required="">\n' +
                        '                        <option value="">Seleccione una entidad</option>\n' +
                        '                        <?php foreach($entidades as $entidad): ?>\n' +
                        '                            <option value="<?=$entidad["idEntidad"]?>"><?=utf8_encode($entidad["entidad"])?></option>\n' +
                        '                        <?php endforeach;?>\n' +
                        '                    </select>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha inicio</label>\n' +
                        '                    <input type="date" name="fechaInicioAntecedente[]" class="form-control"  required>\n' +
                        '                </div>\n' +
                        '                <div class="col-lg-3">\n' +
                        '                    <label>* Fecha terminación</label>\n' +
                        '                    <input type="date" name="fechaFinAntecedente[]" class="form-control"  required>\n' +
                        '                </div>\n' +
                        '\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '    </div></div><script>$("#botonEliminarPregunta_'+indice+'").click(function (){$("#campos_'+indice+'").remove(); actualizarElementos(); });<\/script>';
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
            $("#tipoEstudio").change(function(){
            	var elemento = $("#tipoEstudio").val();
            	if(elemento == 1){
            		$("#validacion1").html("<label>N. Cédula</label><input type='number' class='form-control' name='cedula[]' required>");
            	}else{
            		$("#validacion1").html("");
            	}
            });
        });
    </script>
    <div class="card">
        <div class="card-header text-white bg-dark">
           Datos del Alumno
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <label>* Nombre</label>
                    <input type="text" onkeyup="mayus(this);" name="alumno[]" class="form-control" pattern="[A-Z ]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Apellido paterno</label>
                    <input type="text" onkeyup="mayus(this);" name="apellidoPaterno[]" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Apellido materno</label>
                    <input type="text" onkeyup="mayus(this);"  name="apellidoMaterno[]" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* CURP</label>
                    <input type="text" onkeyup="mayus(this);" name="curp[]" class="form-control" pattern="[A-Z0-9]+" maxlength="18" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Email</label>
                    <input type="email" name="email[]" class="form-control" maxlength="150" required>
                </div>
                <div class="col-lg-3">
                    <label>* Folio de control (matrícula del alumno)</label>
                    <input type="text" pattern="[A-Za-z0-9]+" title="Ingresar solo letras mayúsculas, minúsculas y números." name="folioControl[]" class="form-control"  required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha inicio carrera</label>
                    <input type="date" name="fechaInicioCarrera[]" class="form-control"  required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha terminación carrera</label>
                    <input type="date" name="fechaFinCarrera[]" class="form-control"  required>
                </div>
                <div class="col-lg-12"><hr><h5>Datos de expedición</h5></div>
                <div class="col-lg-3">
                    <label>* Fecha expedición</label>
                    <input type="date" name="fechaExpedicion[]" class="form-control"  required>
                </div>
                <div class="col-lg-3">
                    <label>* Modalidad titulación</label>
                    <select name="modalidadTitulacion[]" class="form-control" required="">
                        <option value="">Seleccione una modalidad</option>
                        <?php foreach($titulaciones as $titulacion): ?>
                            <option value="<?=$titulacion["idModalidad"]?>"><?=$titulacion["modalidad"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha examen profesional (dejar en blanco en caso de que el alumno haya exentado)</label>
                    <input type="date" name="fechaExamenProfesional[]" class="form-control">
                </div>
                <div class="col-lg-3">
                    <label>* Fecha exención examen profesional (dejar en blanco en caso de que el alumno haya realizado el examen)</label>
                    <input type="date" name="fechaExcencionExamenProfesional[]" class="form-control">
                </div>
                <div class="col-lg-3">
                <br>
                    <label>* ¿Cumplio servicio social?</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="servicioSocial[]" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="servicioSocial[]" id="inlineRadio2" value="0">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>

                </div>
                <div class="col-lg-3">

                <br>
                    <label>* Fundamento del servicio social</label>
                    <select name="fundamentoServicioSocial[]" class="form-control" required="">
                        <option value="">Seleccione un fundamento</option>
                        <?php foreach($servicios as $servicio): ?>
                            <option value="<?=$servicio["idServicio"]?>"><?=utf8_encode($servicio["fundamento"])?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <div class="col-lg-3">
                <br>
                    <label>* Entidad</label>
                    <select name="entidadExpedicion[]" class="form-control" required="">
                        <option value="">Seleccione una entidad</option>
                        <?php foreach($entidades as $entidad): ?>
                            <option value="<?=$entidad["idEntidad"]?>"><?=utf8_encode($entidad["entidad"])?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <h5>Antecedente</h5>
                </div>
                <div class="col-lg-3">
                    <label>* Institución de procedencia (Sin signos de puntuación, comillas, puntos, etc)</label>
                    <input type="text" onkeyup="mayus(this);" name="institucionAntecedente[]" class="form-control" pattern="[A-Z0-9 ]+" maxlength="300" title="Ingresar solo letras mayúsculas y sin caracteres especiales." required>
                </div>
                <div class="col-lg-3">
                    <label>* Tipo estudio</label>
                    <select name="tipoEstudioAntecedente[]" id="tipoEstudio" class="form-control" required="">
                        
                        <option value="">Seleccione un tipo de estudio</option>
                        <?php foreach($antecedentes as $antecedente): ?>
                            <option value="<?=$antecedente["idEstudio"]?>"><?=utf8_encode($antecedente["estudio"])?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Entidad</label>
                    <select name="entidadAntecedente[]" class="form-control" required="">
                        <option value="">Seleccione una entidad</option>
                        <?php foreach($entidades as $entidad): ?>
                            <option value="<?=$entidad["idEntidad"]?>"><?=utf8_encode($entidad["entidad"])?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha inicio</label>
                    <input type="date" name="fechaInicioAntecedente[]" class="form-control"  required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha terminación</label>
                    <input type="date" name="fechaFinAntecedente[]" class="form-control"  required>
                </div>
               	<div id="validacion1" class="col-lg-3"></div> 

            </div>
        </div>
    </div>
    <br>
    <button style="float: right;" type="button" id="mascampos" class="btn btn-primary" title="Agregar otro alumno"><i class="fas fa-plus-circle"></i></button>
    <br>


    <?php

}
?>