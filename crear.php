<?php

include("db.php");
include("functions.php");

// if($_POST['operacion'] == 'Crear'){
    $imagen = '';
    if($_FILES["imagen_usuario"]["name"] != ''){
        $imagen = subir_imagen();
    }

    $stmt = $conn->prepare("INSERT INTO usuarios(nombre, apellidos, imagen, telefono, email) VALUES (:nombre, :apellidos, :imagen, :telefono, :email)");

    $resultado = $stmt->execute(
        array(
            ':nombre' => $_POST['nombre'],
            ':apellidos' => $_POST['apellidos'],
            ':email' => $_POST['email'],
            ':telefono' => $_POST['telefono'],
            ':imagen' => $imagen,
        )
    );

    if(!empty($resultado)){
        echo 'creado';
    }
// }

?>