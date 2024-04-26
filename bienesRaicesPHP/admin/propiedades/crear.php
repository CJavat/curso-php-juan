<?php
  require '../../includes/config/database.php';
  $conexion = conectarDB();

  // Arreglo con mensaje de errores
  $errores = [];

  if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // echo "<pre>";
    // var_dump( $_POST );
    // echo "</pre>";
    
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedores_id = $_POST['vendedor'];

    //TODO: Falta compilar el gulp para que agarre los estilos.
    if( !$titulo ) {
      $errores[] = "Debes añadir un título";
    }
    if( !$precio ) {
      $errores[] = "Debes añadir un precio";
    }
    if( strlen( $descripcion ) < 50 ) {
      $errores[] = "Debes añadir un descripcion y tener al menos 50 caracteres";
    }
    if( !$habitaciones ) {
      $errores[] = "Debes añadir un habitaciones";
    }
    if( !$wc ) {
      $errores[] = "Debes añadir un wc";
    }
    if( !$estacionamiento ) {
      $errores[] = "Debes añadir un estacionamiento";
    }
    if( !$vendedores_id ) {
      $errores[] = "Debes añadir un vendedores_id";
    }

    // Revisar que el arreglo de errores esté vacío
    if( empty( $errores ) ) {
      // Insertar en la base de datos.
      $query = "INSERT INTO propiedades ( titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id ) 
      VALUES( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedores_id' )";

      // echo $query;

      $resultado = mysqli_query( $conexion, $query );

      if( $resultado ) {
      echo "Insertado Correctamente";
      }
    }
  }

  require '../../includes/funciones.php';
  incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach( $errores as $error ): ?>
          <div class="alerta error">
            <?php echo $error ?>
          </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="">
          <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" >

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" >
            
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" >

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" cols="30" rows="10"></textarea>
          </fieldset>

          <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" >

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej. 3" min="1" max="9" >
            
            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 3" min="1" max="9" >
          </fieldset>

          <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
              <option value="">-- SELECCIONA UNA OPCIÓN --</option>
              <option value="1">Juan</option>
              <option value="2">Karen</option>
            </select>
          </fieldset>

          <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>