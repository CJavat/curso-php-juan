<?php
  require '../../includes/config/database.php';
  $conexion = conectarDB();

  // Consultar para obtener a los vendedores.
  $consulta = "SELECT * FROM vendedores";
  $resultado = mysqli_query($conexion, $consulta);

  // Arreglo con mensaje de errores
  $errores = [];

  $titulo = '';
  $precio = '';
  $descripcion = '';
  $habitaciones = '';
  $wc = '';
  $estacionamiento = '';
  $vendedores_id = '';

  if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    
    // echo "<pre>";
    // var_dump( $_POST );
    // echo "</pre>";
    
    // echo "<pre>";
    // var_dump( $_FILES );
    // echo "</pre>";
    
    $titulo = mysqli_real_escape_string( $conexion, $_POST['titulo'] );
    $precio = mysqli_real_escape_string( $conexion, $_POST['precio'] );
    $descripcion = mysqli_real_escape_string( $conexion, $_POST['descripcion'] );
    $habitaciones = mysqli_real_escape_string( $conexion, $_POST['habitaciones'] );
    $wc = mysqli_real_escape_string( $conexion, $_POST['wc'] );
    $estacionamiento = mysqli_real_escape_string( $conexion, $_POST['estacionamiento'] );
    $vendedores_id = mysqli_real_escape_string( $conexion, $_POST['vendedor'] );
    $creado = date('Y-m-d');

    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];
    
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
      $errores[] = "Debes añadir un vendedor";
    }
    if( !$imagen['name'] || $imagen['error'] ) {
      $errores[] = "Debes añadir una imagen";
    }

    // Validar por tamaño de imagen (100 kb máximo)
    $medida = 1000 * 100;
    if( $imagen['size'] > $medida ) {
      $errores[] = "La imagen es muy pesada. Tamaño máximo es de 100kb";
    }


    // Revisar que el arreglo de errores esté vacío
    if( empty( $errores ) ) {
      // Insertar en la base de datos.
      $query = "INSERT INTO propiedades ( titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id ) 
      VALUES( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id' )";

      // echo $query;

      $resultado = mysqli_query( $conexion, $query );

      if( $resultado ) {
        // Redireccionar al usuario
        header('Location: /admin');
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

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
          <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>" >

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>" >
            
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" >

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" cols="30" rows="10"><?php echo $descripcion ?></textarea>
          </fieldset>

          <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" value="<?php echo $habitaciones ?>" >

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej. 3" min="1" max="9" value="<?php echo $wc ?>" >
            
            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 3" min="1" max="9" value="<?php echo $estacionamiento ?>" >
          </fieldset>

          <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
              <option value="">-- SELECCIONA UNA OPCIÓN --</option>
              <?php while( $vendedor = mysqli_fetch_assoc( $resultado ) ): ?>
                <option value="<?php echo $vendedor['id'] ?>" <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> >
                  <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'] ?>
                </option>
              <?php endwhile; ?>
            </select>
          </fieldset>

          <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>