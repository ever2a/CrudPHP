<?php
include ("../../db.php");

// Carga los datos del Empleado
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";

    $sentencia = $conexion->prepare("select * from tbl_empleados where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombres = $registro["nombres"];
    $apellidos = $registro["apellidos"];
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $fechadeingreso = $registro["fechadeingreso"];

    // Listar Puestos
    $sentencia = $conexion->prepare("select * from tbl_puestos");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

// Actualiza los datos del empleado
if ($_POST) {
    $txtID = (isset($_POST['txtID']))? $_POST['txtID']:"";
    $nombres = (isset($_POST['nombres'])? $_POST['nombres']:"");
    $apellidos = (isset($_POST['apellidos'])? $_POST['apellidos']:"");
    $idpuesto = (isset($_POST['idpuesto'])? $_POST['idpuesto']:"");
    $fechadeingreso = (isset($_POST['fechadeingreso'])? $_POST['fechadeingreso']:"");

    $sentencia = $conexion->prepare("update tbl_empleados set 
        nombres=:nombres, apellidos=:apellidos, idpuesto=:idpuesto, fechadeingreso=:fechadeingreso
        where id=:id");
    
    $sentencia->bindParam(":nombres", $nombres);
    $sentencia->bindParam(":apellidos", $apellidos);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Actualizar foto
    $foto = (isset($_FILES['foto']['name'])? $_FILES['foto']['name']:"");
    $fecha = new DateTime();
    $nombre_foto = ($foto!="")? $fecha->getTimestamp()."-".$_FILES['foto']['name']:"";
    $temp_foto = $_FILES['foto']['tmp_name'];
    if($temp_foto!="") {
        move_uploaded_file($temp_foto,"./".$nombre_foto);

        // Buscar la foto relacionado
        $sentencia = $conexion->prepare("select foto from tbl_empleados where id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        // Elimina la iamgen guardados en la app
        if (isset($registro_recuperado["foto"]) && isset( $registro_recuperado["foto"])!="") {
            if (file_exists("./".$registro_recuperado["foto"])){
                unlink("./".$registro_recuperado["foto"]);
            }
        }

        $sentencia = $conexion->prepare("update tbl_empleados set foto=:foto where id=:id");
        $sentencia->bindParam(":foto", $nombre_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    // Actualizar CV
    $cv = (isset($_FILES['cv']['name'])? $_FILES['cv']['name']:"");
    $nombre_cv = ($cv!="")? $fecha->getTimestamp()."-".$_FILES['cv']['name']:"";
    $temp_cv = $_FILES['cv']['tmp_name'];
    if($temp_cv!="") {
        move_uploaded_file($temp_cv,"./".$nombre_cv);

        // Buscar el cv relacionado
        $sentencia = $conexion->prepare("select cv from tbl_empleados where id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        // Elimina el cv guardados en la app
        if (isset($registro_recuperado["cv"]) && isset( $registro_recuperado["cv"])!="") {
            if (file_exists("./".$registro_recuperado["cv"])){
                unlink("./".$registro_recuperado["cv"]);
            }
        }

        $sentencia = $conexion->prepare("update tbl_empleados set cv=:cv where id=:id");
        $sentencia->bindParam(":cv", $nombre_cv);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    $mensaje = "Registro Actualizado";
    header("Location:principal.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL EMPLEADO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID;?>"
                    class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId"
                    placeholder="ID" />
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres:</label>
                <input type="text" value="<?php echo $nombres;?>"
                    class="form-control" name="nombres" id="nombres" aria-describedby="helpId"
                    placeholder="Nombres" />
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" value="<?php echo $apellidos;?>"
                    class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId"
                    placeholder="Apellidos" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                
                <img width="50" src="<?php echo $foto;?>" class="img-fluid rounded" alt=""/>
                <br><br>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId"
                    placeholder="Foto" />
            </div>
            <div class="mb-3">
                <label for="cv" class="form-label">Curriculum Vitae (PDF):</label>
                
                <a href="<?php echo $cv;?>"><?php echo $cv;?></a>
                <br><br>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV" />
            </div>
            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                <option selected>Select one</option>
                    <?php foreach ($lista_tbl_puestos as $registro) {?>
                        <option <?php echo ($idpuesto==$registro['id'])? "Selected":""?> 
                            value="<?php echo $registro['id']?>">
                            <?php echo $registro['nombredelpuesto']?>
                        </option>
                    <?php } ?>
                </select>                
            </div>
            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de Ingreso:</label>
                <input type="date" value="<?php echo $fechadeingreso;?>"
                    class="form-control" name="fechadeingreso" id="fechadeingreso"
                    aria-describedby="emailHelpId" placeholder="Fecha de ingreso" />
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>