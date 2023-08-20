<?php
	session_start();
?>
<?php if($_SESSION["idUser"] == ""): ?>
	<!doctype html>
<html lang="es_MX">
  <head>
    <meta charset="utf-8" content="text/html" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="CEO & Software Developer Carlos Alexis Campos Mariscal ccampos@evolutionclub.com.mx">
    <title>Titulación y Certificación Electrónica</title>

    <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <meta name="theme-color" content="#563d7c">
  <link rel="stylesheet" href="herramientas/fontawesome/css/all.css">
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js" type="text/javascript"></script>


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .inicial{
          margin-left: 20px;
          margin-right: 20px;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/pricing.css" rel="stylesheet">
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <a class="navbar-brand" href="#">Certificación Electrónica</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
   
  </nav>
<div class="container">
	<div class="row" style="margin-top: 20px;">
		<div class="col-lg-4">
			
		</div>
	<div class="col-lg-8">
		<div class="card">
		  <div class="card-header">
		    ¡Bienvenido! - Iniciar sesión.
		  </div>
		  <div class="card-body">
		    <blockquote class="blockquote mb-0">
		     <form method="post" action="login.php?action=login">
				<label class="sr-only" for="inlineFormInputGroup">Correo electrónico</label>
			      <div class="input-group mb-2">
			        <div class="input-group-prepend">
			          <div class="input-group-text"><i class="fas fa-at"></i></div>
			        </div>
			        <input type="email" name="email" maxlength="100" title="Ingrese su correo electrónico" class="form-control <?php if($_REQUEST["error"] == "login"): ?>is-invalid <?php endif;?>" id="inlineFormInputGroup" placeholder="Correo Electrónico" required autofocus>
			      </div>
			      <label class="sr-only" for="inlineFormInputGroup2">Clave</label>
			      <div class="input-group mb-2">
			        <div class="input-group-prepend">
			          <div class="input-group-text"><i class="fas fa-key"></i></div>
			        </div>
			        <input type="password" name="clave" maxlength="100" title="Ingrese su clave de acceso" class="form-control <?php if($_REQUEST["error"] == "login"): ?>is-invalid <?php endif;?>" id="inlineFormInputGroup2" placeholder="Clave de acceso" required>
			        <?php if($_REQUEST["error"] == "login"): ?><div class="invalid-feedback">No se encontró información con los datos ingresados.</div><?php endif;?>
			      </div>
			     
			      <button type="submit" class="btn btn-outline-info"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
			</form>
		      <footer class="blockquote-footer">Desarrollado por Evolution Club <i class="far fa-copyright"></i> <?=date("Y")?></footer>
		    </blockquote>
		  </div>
		</div>
	</div>
	</div>
</div>
</body>
</html>
	<?php else: ?>
<?php include("cabecera.php"); ?>
<div class="row">
	<div class="col-lg-12">
		<h5><center>Bienvenido <?=$_SESSION["nombre"]?>, es un gusto volver a verte.</center></h5>
	</div>
</div>
<?php include("footer.php"); ?>
<?php endif;?>
