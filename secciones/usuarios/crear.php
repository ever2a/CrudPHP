<?php
include ("../../db.php");

if ($_POST) {
    $usuario = (isset($_POST['usuario'])? $_POST['usuario']:"");
    $pass = (isset($_POST['password'])? $_POST['password']:"");
    $correo = (isset($_POST['correo'])? $_POST['correo']:"");
    $sentencia = $conexion->prepare("insert into tbl_usuarios(usuario, pass, correo) 
        values (:usuario, :password, :correo)");
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $pass);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->execute();
    $mensaje = "Registro Creado";
    header("Location:principal.php?mensaje=". $mensaje);
}   
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL USUARIO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del Usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId"
                    placeholder="Nombre del usuario" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId"
                    placeholder="Escriba su contraseña" />
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Email:</label>
                <input type="email" class="form-control" name="correo" id="correo" aria-describedby="helpId"
                    placeholder="Escriba su email" />
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>