<?php

    function subir_imagen(){
        if(isset($_FILES['imagen_usuario'])){
            $extension = explode('.', $_FILES['imagen_usuario']['name']);
            $nuevoNombre = rand() . '.' . $extension[1];
            $ubicacion = './img/' . $nuevoNombre;
            move_uploaded_file($_FILES['imagen_usuario']['tmp_name'], $ubicacion);
            return $nuevoNombre;
        }
    }

    function get_nombre_imagen($id_usuario){
        include('db.php');
        $stmt = $conn->prepare("SELECT imagen FROM usuarios WHERE id = '$id_usuario'");
        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach($result as $row){
            return $row['imagen'];
        }
    }

    function get_usuarios(){
        include('db.php');
        $stmt = $conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $stmt->rowCount();
    }

?>