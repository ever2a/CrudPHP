<?php
include ("../../db.php");

// Carga los datos del puesto
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";

    $sentencia = $conexion->prepare("select * from tbl_usuarios where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelusuario = $registro["usuario"];
    $contraseña = $registro["pass"];
    $correo = $registro["correo"];
}

// Actualiza los datos del usuario
if ($_POST) {
    $txtID = (isset($_POST['txtID']))? $_POST['txtID']:"";
    $txtUsuario = (isset($_POST['usuario']))? $_POST['usuario']:"";
    $txtPass = (isset($_POST['password']))? $_POST['password']:"";
    $txtCorreo = (isset($_POST['correo']))? $_POST['correo']:"";

    $sentencia = $conexion->prepare("update tbl_usuarios set usuario=:usuario, pass=:pass, correo=:correo
        where id=:id");
    
    $sentencia->bindParam(":usuario", $txtUsuario);
    $sentencia->bindParam(":pass", $txtPass);
    $sentencia->bindParam(":correo", $txtCorreo);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Actualizado";
    header("Location:principal.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL USUARIO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID;?>"
                    class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId"
                    placeholder="ID" />
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del Usuario:</label>
                <input type="text" <input type="text" value="<?php echo $nombredelusuario;?>"
                    class="form-control" name="usuario" id="usuario" aria-describedby="helpId"
                    placeholder="Nombre del usuario" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="text" <input type="text" value="<?php echo $contraseña;?>"
                    class="form-control" name="password" id="password" aria-describedby="helpId"
                    placeholder="Escriba su contraseña" />
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Email:</label>
                <input type="email" <input type="text" value="<?php echo $correo;?>"
                    class="form-control" name="correo" id="correo" aria-describedby="helpId"
                    placeholder="Escriba su email" />
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>