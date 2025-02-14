<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION['usuario'];
$usuario_id = $usuario['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quejasySugerencias";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_procesadas = "SELECT COUNT(*) AS procesadas FROM solicitudes WHERE usuario_id = $usuario_id AND estado = 'activa'";
$sql_en_proceso = "SELECT COUNT(*) AS en_proceso FROM solicitudes WHERE usuario_id = $usuario_id AND estado = 'en espera'";
$sql_cerradas = "SELECT COUNT(*) AS cerradas FROM solicitudes WHERE usuario_id = $usuario_id AND estado = 'inactiva'";

$result_procesadas = $conn->query($sql_procesadas)->fetch_assoc();
$result_en_proceso = $conn->query($sql_en_proceso)->fetch_assoc();
$result_cerradas = $conn->query($sql_cerradas)->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="styles.css">
    <style>
        body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
        body {font-size:16px;}
        .w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
        .w3-half img:hover{opacity:1}
        .panel-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
        }
        .panel-item {
            text-align: center;
        }
        .panel-item img {
            width: 50px;
            height: 50px;
        }
        .panel-item p {
            margin: 10px 0 0 0;
            font-size: 24px;
        }
    </style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onClick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
        <h3 class="w3-padding-64"><b>Facultad de ciencias de la computación</b></h3>
    </div>
    <div class="w3-bar-block">
        <a href="indexUsuario.php" onClick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Inicio</a> 
        <a href="panel.php" onClick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Panel</a> 
        <a href="RegistrarQueja.php" onClick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Realizar Solicitud</a> 
        <a href="seguimiento.php" onClick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Seguimiento de Q/S</a> 
        <a href="cerrar_sesion.php" onClick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Cerrar Sesión</a> 
    </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onClick="w3_open()"></a>
    <span>Facultad de ciencias de la computación</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onClick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
    <h1>Panel de Usuario</h1>
    <div class="panel-container">
        <div class="panel-item">
            <img src="imagenes\icono_queja.png" alt="Icono Queja">
            <p><?php echo $result_procesadas['procesadas']; ?></p>
            <p>No Procesadas</p>
        </div>
        <div class="panel-item">
            <img src="imagenes\icono_proceso.png" alt="Icono En Proceso">
            <p><?php echo $result_en_proceso['en_proceso']; ?></p>
            <p>En Proceso</p>
        </div>
        <div class="panel-item">
            <img src="imagenes\icono_cerrada.png" alt="Icono Cerrada">
            <p><?php echo $result_cerradas['cerradas']; ?></p>
            <p>Cerradas</p>
        </div>
    </div>
    <a href="indexUsuario.php">Volver</a>
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
