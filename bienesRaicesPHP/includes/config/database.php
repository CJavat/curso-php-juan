<?php

function conectarDB() {
  $db = mysqli_connect('localhost', 'root', '', 'bienesraices_crud');

  if( $db ) {
    echo "Se Conectó";
  } else {
    echo "No se Conectó";
  }
}