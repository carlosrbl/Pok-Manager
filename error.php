<?php
    session_start();

    $codigoError = $_SESSION["error"];

    require_once "includes/errorHeader.inc.php";
    require_once "includes/errores.inc.php";
    require_once "includes/footer.inc.php";
    require_once "includes/dialogo.inc.php";
?>