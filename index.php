<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

  <div class="container my-5">
    <h1 class="text-center">Crud</h1>

    <div class="row">
      <div class="col-2 offset-10">
        <div class="text-center">
          <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">Crear</button>
        </div>
      </div>
    </div>
    <br>
    <br>
    <div class="table-responsive">
      <table id="datos_usuario" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Imagen</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>

  </div>

  <!-- Modal -->
  <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalUsuarioLabel">Usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" id="formulario" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre">
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">apellidos</label>
              <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="apellidos">
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">telefono</label>
              <input type="text" class="form-control" name="telefono" id="telefono" placeholder="telefono">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="email">
            </div>
            <div class="mb-3">
              <label for="nombre" class="form-label">imagen</label>
              <input type="file" class="form-control" name="imagen_usuario" id="imagen_usuario">
              <span id="imagen-subida"></span>
            </div>

            <div class="modal-footer">
              <input type="hidden" name="id_usuario" id="id_usuario">
              <input type="hidden" name="operacion" id="operacion">
              <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
              <input type="reset" class="btn btn-secondary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


  <script type="text/javascript">
    $(document).ready(function() {
      var dataTable = $('#datos_usuario').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [2, 'asc'],
        "ajax": {
          url: "get_registers.php",
          type: "POST"
        },
        "columnsDefs": [{
          "targets": [0, 3, 4],
          "orderable": false
        }]
      });
      $(document).on('submit', '#formulario', function(event) {
        event.preventDefault();
        var nombres = $('#nombre').val();
        var apellidos = $('#apellidos').val();
        var telefono = $('#telefono').val();
        var email = $('#email').val();
        var extension = $('#imagen_usuario').val().split('.').pop().toLowerCase();

        if (extension != '') {
          if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("extension");
            $('#imagen_usuario').val('');
            return false;
          }
        }

        $.ajax({
          url: "crear.php",
          method: "POST",
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(data) {
            alert(data);
            $('#formulario').trigger('reset');
            $('#modalUsuario').modal('hide');
            dataTable.ajax.reload();
          }
        });

      })
    });
  </script>


</body>

</html>