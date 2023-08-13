<?php
    include("db.php");
    include("functions.php");

    $query = "SELECT * FROM usuarios ";
    $salida = array();

    if(isset($_POST["search"]["value"])){
        $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
        $query .= 'OR apellidos LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if(isset($_POST["order"])){
        $query .= 'ORDER BY ' . $_POST["order"][0]['column'] . ' ' . $_POST["order"][0]['dir'] . ' ';
    } else {
        $query .= ' ORDER BY id DESC ';
    }

    if($_POST['length'] != -1){
        $query .= 'LIMIT ' . $_POST['start'] . ',' . $_POST['length'];
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll();

    $datos = array();

    $filtered_rows = $stmt->rowCount();

    foreach($resultado as $row){
        $imagen = '';
        if($row['imagen'] != ''){
            $imagen = '<img src="img/'. $row['imagen'] . '" class="img-thumbnail" width="50" height="50"/>';
        } else {
            $imagen = '';
        }

        $subarray = array();
        $subarray[] = $row["id"];
        $subarray[] = $row["nombre"];
        $subarray[] = $row["apellidos"];
        $subarray[] = $row["telefono"];
        $subarray[] = $row["email"];
        $subarray[] = $imagen;
        $subarray[] = $row["created_at"];
        $subarray[] = '
        <button class="btn btn-primary editar" name="editar">Editar</button>
        <br>
        <button class="btn btn-danger borrar" name="borrar">Borrar</button>
        ';
        $datos[] = $subarray;
    }

    $salida = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => get_usuarios(),
        "data" => $datos
    );
    
    echo json_encode($salida);

?>