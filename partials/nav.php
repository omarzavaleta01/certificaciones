<?php if($_SESSION["idUser"] == ""):?>
 <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <a class="navbar-brand" href="#">Certificación Electrónica</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
   
  </nav>
  <?php else: ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <a class="navbar-brand" href="#">Certificación Electrónica</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Instituciones
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="nuevaUniversidad.php"><i class="fas fa-plus-square"></i> Alta de institución</a>
            <a class="dropdown-item" href="listadoInstituciones.php"><i class="far fa-clipboard"></i> Listado de instituciones</a>
            <a class="dropdown-item" href="nuevoCampus.php"><i class="fas fa-plus-square"></i> Alta de campus</a>
            <a class="dropdown-item" href="listadoCampus.php"><i class="far fa-clipboard"></i> Listado de campus</a>
            <a class="dropdown-item" href="nuevaCarrera.php"><i class="fas fa-plus-square"></i> Alta de carrera</a>
            <a class="dropdown-item" href="listadoCarreras.php"><i class="far fa-clipboard"></i> Listado de carreras</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            MET
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="altaMET.php"><i class="fas fa-plus-square"></i> Carga de titulación</a>
            <a class="dropdown-item" href="listadoMET.php"><i class="far fa-clipboard"></i> Listado de titulaciones</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            MEC
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#"><i class="fas fa-plus-square"></i> Carga de certificación</a>
            <a class="dropdown-item" href="#"><i class="far fa-clipboard"></i> Listado de certificaciones</a>
          </div>
        </li>

      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle"></i> <?=$_SESSION["nombre"]?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="login.php?action=logout"><i class="fas fa-power-off"></i> Salir</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>


<?php endif; ?>