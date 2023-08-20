<?php include("cabecera.php"); ?>
<?php
date_default_timezone_set("America/Mexico_City");
include("conexion.php");
//include("funciones.php");

$token = $_REQUEST["token"];
list($antecedentes, $contadorAntecedentes) = obtenerCatalogoAntecedente($conn,$token);
list($met, $contadorTitulaciones) = obtenerTitulacionesEspecifico($conn, $token);
foreach ($met as $titulo) {
    $nombre = $titulo["nombre"];
    $apellidoPaterno = $titulo["apellidoPaterno"];
    $apellidoMaterno = $titulo["apellidoMaterno"];
    $curp = $titulo["curp"];
    $email = $titulo["email"];
    $folioC = $titulo["folioControl"];
    $fechaInicioC = $titulo["fechaInicioCarrera"];
    $fechaTerminacionC = $titulo["fechaTerminacionCarrera"];
    $fechaExpedicion = $titulo["fechaExpedicion"];
    $idModalidadTitulacion = $titulo["idServicio"];
    $fechaExamenP = $titulo["fechaExamenProfesional"];
    $fechaExcencionP = $titulo["fechaExcencionProfesional"];
    $servicio = $titulo["servicioSocial"];
    $idServicio = $titulo["idServicio"];
    $idEntidadExpedicion = $titulo["idEntidadExpedicion"];
    $institucionProcedencia = $titulo["institucionProcedencia"];
    $idTipoEstudio = $titulo["idTipoEstudio"];
    $idEntidadAntecedente = $titulo["idEntidadAntecedente"];
    $fechaInicioAntecedente = $titulo["fechaInicioAntecdente"];
    $fechaFinalAntecedente = $titulo["fechaFinalAntecdente"];
}

?>
<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
</script>


<div class="card">
    <div class="col-lg-12">
		<hr>
		<a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > MET > <a href="listadoMET.php"><i class="far fa-clipboard"></i> Listado MET</a> > <i class="fas fa-edit"></i> Edición de MET
		<hr>
	</div>
    <div class="col-lg-12">
        <?php if (isset($_REQUEST["salida"])) : ?>
            <?php if ($_REQUEST["salida"] == "error") : ?>
                <div class="alert alert-danger" role="alert">
                    Hubó un error con la comunicación del servidor, por favor vuelva a intentarlo más tarde.
                </div>
            <?php elseif ($_REQUEST["salida"] == "errorF") : ?>
                <div class="alert alert-danger" role="alert">
                    La fecha inicial no puede ser mayor a la fecha de fin
                </div>  
            <?php elseif ($_REQUEST["salida"] == "errorC") : ?>
                <div class="alert alert-danger" role="alert">
                    Hubó un error en el CURP verificar que el CURP sea correcto
                </div>   
            <?php elseif ($_REQUEST["salida"] == "repetido") : ?>
                <div class="alert alert-danger" role="alert">
                    La clave MET ingresada corresponde a otra MET registrada en su cuenta.
                </div>
            <?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
                <div class="alert alert-danger" role="alert">
                    Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
                </div>
            <?php elseif ($_REQUEST["salida"] == "success") : ?>
                <div class="alert alert-success" role="alert">
                    MET modificado correctamente.
                </div>

            <?php endif; ?>
        <?php endif; ?>
    </div>
    <form method="post" action="procesamiento.php?action=editarMET&idMET=<?=$token?>" onsubmit="return confirm('¿Se encuentra segur@ de modificar la titulación?')">
    
        <div class="card-body">
        <input type="hidden" value="<?=$_SESSION["token"]?>" name="csrf">
            <div class="row">
                <div class="col-lg-3">
                
                    <label>* Nombre</label>
                    <input type="text" onkeyup="mayus(this);" name="alumno" value="<?= $nombre ?>" class="form-control" pattern="[A-Z ]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Apellido paterno</label>
                    <input type="text" onkeyup="mayus(this);" name="apellidoPaterno" value="<?= $apellidoPaterno ?>" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Apellido materno</label>
                    <input type="text" onkeyup="mayus(this);" name="apellidoMaterno" value="<?= $apellidoMaterno ?>" class="form-control" pattern="[A-Z]+" maxlength="250" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* CURP</label>
                    <input type="text" onkeyup="mayus(this);" name="curp" value="<?= $curp ?>" class="form-control" pattern="[A-Z0-9]+" minlength="18" maxlength="18" title="Ingresar solo letras mayúsculas" required>
                </div>
                <div class="col-lg-3">
                    <label>* Email</label>
                    <input type="email" name="email" value="<?= $email ?>" class="form-control" maxlength="150" required>
                </div>
                <div class="col-lg-3">
                    <label>* Folio de control (matrícula del alumno)</label>
                    <input type="text" pattern="[A-Za-z0-9]+" title="Ingresar solo letras mayúsculas, minúsculas y números." name="folioControl" value="<?= $folioC ?>" class="form-control" required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha inicio carrera</label>
                    <input type="date" name="fechaInicioCarrera" value="<?= $fechaInicioC ?>" class="form-control" required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha terminación carrera</label>
                    <input type="date" name="fechaFinCarrera" value="<?= $fechaTerminacionC ?>" class="form-control" required>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <h5>Datos de expedición</h5>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha expedición</label>
                    <input type="date" name="fechaExpedicion" value="<?= $fechaExpedicion ?>" class="form-control" required>
                </div>
                <div class="col-lg-3">
                    <label>* Modalidad titulación</label>
                    <select name="modalidadTitulacion" value="<?= $idModalidadTitulacion ?>" class="form-control" required="">
                        <option value="">Seleccione una modalidad</option>
                        <?php list($titulaciones, $contadorTitulacion) = obtenerCatalogoTitulaciones($conn);
                        foreach ($titulaciones as $titulacion) : ?>
                            <?php if ($titulacion["idModalidad"] == $idModalidadTitulacion) : ?>
                                <option value="<?= $titulacion["idModalidad"] ?>" selected>-> <?= $titulacion["modalidad"] ?></option>
                            <?php else : ?>
                                <option value="<?= $titulacion["idModalidad"] ?>"><?= $titulacion["modalidad"] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha examen profesional (dejar en blanco en caso de que el alumno haya exentado)</label>
                    <input type="date" name="fechaExamenProfesional" value="<?= $fechaExamenP ?>" class="form-control">
                </div>
                <div class="col-lg-3">
                    <label>* Fecha exención examen profesional (dejar en blanco en caso de que el alumno haya realizado el examen)</label>
                    <input type="date" name="fechaExcencionExamenProfesional" value="<?= $fechaExcencionP ?>" class="form-control">
                </div>
                <div class="col-lg-3">
                    <br>
                    <label>* ¿Cumplio servicio social?</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="servicioSocial" required id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="servicioSocial" required id="inlineRadio2" value="0">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>

                </div>
                <div class="col-lg-3">

                    <br>
                    <label>* Fundamento del servicio social</label>
                    <select name="fundamentoServicioSocial" value="<?= $idServicio ?>" class="form-control" required="">
                        <option value="">Seleccione un fundamento</option>
                        <?php list($servicios, $contadorServicios) = obtenerCatalogoServicio($conn);
                        foreach ($servicios as $servicio) : ?>
                            <?php if ($servicio["idServicio"] == $idServicio) : ?>
                                <option value="<?= $servicio["idServicio"] ?>" selected>-> <?= $servicio["fundamento"] ?></option>
                            <?php else : ?>
                                <option value="<?= $servicio["idServicio"] ?>"><?= utf8_encode($servicio["fundamento"]) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="col-lg-3">
                    <br>
                    <label>* Entidad</label>
                    <select name="entidadExpedicion" value="<?= $idEntidadExpedicion ?>" class="form-control" required="">
                        <option value="">Seleccione una entidad</option>
                        <?php list($entidades, $contadorEntidades) = obtenerCatalogoEntidades($conn);
                        foreach ($entidades as $entidad) : ?>

                            <?php if ($entidad["idEntidad"] == $idEntidadExpedicion) : ?>
                                <option value="<?= $entidad["idEntidad"] ?>" selected>-> <?= $entidad["entidad"] ?></option>
                            <?php else : ?>
                                <option value="<?= $entidad["idEntidad"] ?>"><?= utf8_encode($entidad["entidad"]) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <h5>Antecedente</h5>
                </div>
                <div class="col-lg-3">
                    <label>* Institución de procedencia (Sin signos de puntuación, comillas, puntos, etc)</label>
                    <input type="text" onkeyup="mayus(this);" name="institucionAntecedente" value="<?= $institucionProcedencia ?>" class="form-control" pattern="[A-Z0-9 ]+" maxlength="300" title="Ingresar solo letras mayúsculas y sin caracteres especiales." required>
                </div>
                <div class="col-lg-3">
                    <label>* Tipo estudio</label>
                    <select name="tipoEstudioAntecedente" value="<?= $idTipoEstudio ?>" id="tipoEstudio" class="form-control" required="">

                        <option value="">Seleccione un tipo de estudio</option>
                        <?php foreach ($antecedentes as $antecedente) : ?>
                            <?php if ($antecedente["idEstudio"] == $idTipoEstudio) : ?>
                                <option value="<?= $antecedente["idEstudio"] ?>" selected>-> <?= $antecedente["estudio"] ?></option>
                            <?php else : ?>
                                <option value="<?= $antecedente["idEstudio"] ?>"><?= utf8_encode($antecedente["estudio"]) ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Entidad</label>
                    <select name="entidadAntecedente" value="<?= $idEntidadAntecedente ?>" class="form-control" required="">
                        <option value="">Seleccione una entidad</option>
                        <?php foreach ($entidades as $entidad) : ?>

                            <?php if ($entidad["idEntidad"] == $idEntidadAntecedente) : ?>
                                <option value="<?= $entidad["idEntidad"] ?>" selected>-> <?= $entidad["entidad"] ?></option>
                            <?php else : ?>
                                <option value="<?= $entidad["idEntidad"] ?>"><?= utf8_encode($entidad["entidad"]) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha inicio</label>
                    <input type="date" name="fechaInicioAntecedente" value="<?= $fechaInicioAntecedente ?>" class="form-control" required>
                </div>
                <div class="col-lg-3">
                    <label>* Fecha terminación</label>
                    <input type="date" name="fechaFinAntecedente" value="<?= $fechaFinalAntecedente ?>" class="form-control" required>
                </div>
                <div id="validacion1" class="col-lg-3"></div>

            </div>
        </div>
        <div class="col-lg-12">
            <br>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        </div>
    </form>
    <br>
</div>

<?php include("footer.php"); ?>