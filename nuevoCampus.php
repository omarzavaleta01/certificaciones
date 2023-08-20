<?php include("cabecera.php"); ?>
<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
</script>
<div class="row inicial">
    <div class="col-lg-12">
        <hr>
        <a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > Instituciones > Alta de campus
        <hr>
    </div>
    <div class="col-lg-12">
        <form method="post" action="procesamiento.php?action=altaCampus" enctype="multipart/form-data">
            <h5><i class="fas fa-plus-square"></i> Alta de campus</h5>
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
                    El campus ya se encuentra registrado en su cuenta.
                </div>
            <?php elseif ($_REQUEST["salida"] == "missingdata") : ?>
                <div class="alert alert-danger" role="alert">
                    Error de validación: Token perdido, por favor vuelva a intentarlo nuevamente.
                </div>
            <?php elseif ($_REQUEST["salida"] == "success") : ?>
                <div class="alert alert-success" role="alert">
                    Campus registrado correctamente.
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
        <label>* Nombre de campus</label>
        <input type="text" name="nombreCampus" onkeyup="mayus(this);" maxlength="200" class="form-control" required autofocus>
    </div>
    <div class="col-lg-4">
        <label>* Numero de campus</label>
        <input type="number" name="noCampus" min="1" max="999999999" class="form-control" required>
    </div>
    <div class="col-lg-4">
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
        <br>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
    </div>
</div>

<?php include("footer.php"); ?>