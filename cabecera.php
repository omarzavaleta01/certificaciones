<?php
  session_start();
  error_reporting(1);
  include("conexion.php");
  include("funciones.php");

  if($_SESSION["idUser"] == ""){
    
    // header("Location: index.php");
  }
?>
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
   <?php include("partials/nav.php"); ?>
