<?php 
function crearNota($nombre, $contenido, $carpeta) { 
    $rutaCarpeta = 'notas/' . $carpeta . '/'; 
    if (!is_dir($rutaCarpeta)) { 
        mkdir($rutaCarpeta, 0777, true); 
    } 
    $rutaArchivo = $rutaCarpeta . $nombre . '.txt'; 
    file_put_contents($rutaArchivo, $contenido); 
} 
 
function abrirNota($nombre, $carpeta) { 
    $rutaArchivo = 'notas/' . $carpeta . '/' . $nombre . '.txt'; 
    if (file_exists($rutaArchivo)) { 
        $contenido = file_get_contents($rutaArchivo); 
        return $contenido; 
    } else { 
        return 'Error, el archivo no existe.'; 
    } 
} 
 
function guardarNota($nombre, $contenido, $carpeta) { 
    $rutaArchivo = 'notas/' . $carpeta . '/' . $nombre . '.txt'; 
    file_put_contents($rutaArchivo, $contenido); 
    return 'Archivo guardado correctamente.'; 
} 
 

function leerNota($rutaArchivo) { 
    if (file_exists($rutaArchivo)) { 
        $contenido = file_get_contents($rutaArchivo); 
        return $contenido; 
    } else { 
        return 'El archivo no existe.'; 
    } 
} 
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $nombreNota = $_POST['nombre-nota']; 
    $contenidoNota = $_POST['contenido-nota']; 
    $carpetaNota = $_POST['carpeta-nota']; 
 
    if (isset($_POST['crear'])) { 
        crearNota($nombreNota, $contenidoNota, $carpetaNota); 
    } elseif (isset($_POST['abrir'])) { 
        $notaAbierta = abrirNota($nombreNota, $carpetaNota); 
    } elseif (isset($_POST['guardar'])) { 
        $mensajeGuardado = guardarNota($nombreNota, $contenidoNota, $carpetaNota); 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html> 
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloc de Notas</title> 

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body> 
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="#NUEVA">NUEVA NOTA</a>
              <a class="nav-link" href="#ABRIR">ABRIR NOTA</a>
              <a class="nav-link" href="#GUARDAR">GUARDAR NOTA</a>
              <a class="nav-link" href="#LEER">LEER NOTA</a>
            </div>
          </div>
        </div>
      </nav><br><br>


      <h1>BIENVENIDO</h1>
      <h6>Este es un bloc de notas quepuede utilizar para su comodidad, en el encontrara diferentes secciones que podra utilizar de manera efectiva.</h6>
      <br>
      <h6> En el se encuentran cuatro secciones, las cuales podra buscar por la barra de navegacion, estas son:</h6><br>
      <li>Nueva nota (donde podra escribir una nueva nota, debera colocar el nombre de la carpeta y el nombre de la nota para ser guardadas)</li>
      <li>Abrir nota, en esta seccion colocara el nombre de la nota y la carpeta donde se guardo la informacion para ser mostrada. </li>
      <li>Guardar nota, esta funciona en conjunto con abrir nota, al abrirse mostrara la informacion y podra ser editada y guardada nuevamente.</li>
      <li>Leer nota, en esta seccion colocara nueva mente el nombre de la nota y de la carpeta y le permitira leer la informacion que se ha guardado en ella.</li><br><br>

    <hr>
    <div class="row" id="NUEVA">
        <div class="col-lg-12 col-sm-12 col-md-12">
        <h3>Nueva nota</h3>
    <form method="post" action="">
        <label for="carpeta-nota">Coloque el nombre de la carpeta:</label> 
        <input type="text" name="carpeta-nota" id="carpeta-nota" required><br><br> 
        <label for="nombre-nota">Coloque el nombre de la nota:</label> 
        <input type="text" name="nombre-nota" id="nombre-nota" required><br><br> 
        <label for="contenido-nota">Escriba lo que desea guardar:</label><br> 
        <textarea name="contenido-nota" id="contenido-nota" rows="15" cols="40" required></textarea><br><br> 
        <input type="submit" name="crear" value="CREAR"> <br><br><br>  
    </form> 
    </div>
    </div>

    <hr>

    <div class="row" id="ABRIR">
    <h3>Abrir nota</h3>
        <div class="col-lg-12 col-sm-12 col-md-12">
    <form method="post" action=""> 
        <label for="carpeta-nota-abrir">Carpeta:</label> 
        <input type="text" name="carpeta-nota" id="carpeta-nota-abrir" required><br><br>
        <label for="nombre-nota-abrir">Nombre de la Nota:</label> 
        <input type="text" name="nombre-nota" id="nombre-nota-abrir" required><br><br>
        <input type="submit" name="abrir" value="ABRIR"> 
    </form> 
    </div></div><br> <br>
    <hr>
 
    <div class="row" id="GUARDAR">
        <div class="col-lg-12 col-sm-12 col-md-12">
    <h3>Guardar nota</h3> 
    <h6>Al abrir la nota se le mostrara aqui la informacion para guardar.</h6>
    <?php if (isset($notaAbierta)): ?> 
        <div class="nota"> 
            <h3>Nota Abierta:</h3> 
            <p><?php echo $notaAbierta; ?></p> 
        </div> 
        <form method="post" action=""> 
            <input type="hidden" name="nombre-nota" value="<?php echo $nombreNota; ?>"> 
            <input type="hidden" name="carpeta-nota" value="<?php echo $carpetaNota; ?>"> 
            <label for="contenido-nota-guardar">Contenido:</label><br> 
            <textarea name="contenido-nota" id="contenido-nota-guardar" rows="5" cols="40" required><?php echo $notaAbierta; ?></textarea><br><br> 
            <input type="submit" name="guardar" value="GUARDAR"> 
        </form> 
    <?php endif; ?> 
    </div></div> <br> <br>

    <hr>
    
    <div class="row" id="LEER">
        <div class="col-lg-12 col-sm-12 col-md-12">
    <h3>Leer nota</h3><br><br>
    <form method="post" action=""> 
        <h5>Para obtener la ruta se necesita que coloque notas/nombrecarpeta/nombredelanota.txt</h5> 
        <label for="ruta-archivo">Escriba la ruta:</label> 
        <input type="text" name="ruta-archivo" id="ruta-archivo" required><br><br> 
        <input type="submit" name="leer" value="LEER"> <br> <br>
    </form> 
    <?php if (isset($_POST['leer'])): ?> 
        <div class="nota"> 
            <h3>Contenido de la Nota:</h3> 
            <p><?php echo leerNota($_POST['ruta-archivo']); ?></p> 
        </div> 
    <?php endif; ?> 
    </div>
    </div>
    

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body> 
</html>
