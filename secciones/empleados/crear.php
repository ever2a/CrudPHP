<?php
include ("../../db.php");

if ($_POST) {
    $nombres = (isset($_POST['nombres'])? $_POST['nombres']:"");
    $apellidos = (isset($_POST['apellidos'])? $_POST['apellidos']:"");
    $foto = (isset($_FILES['foto']['name'])? $_FILES['foto']['name']:"");
    $cv = (isset($_FILES['cv']['name'])? $_FILES['cv']['name']:"");
    $idpuesto = (isset($_POST['idpuesto'])? $_POST['idpuesto']:"");
    $fechadeingreso = (isset($_POST['fechadeingreso'])? $_POST['fechadeingreso']:"");

    $sentencia = $conexion->prepare("insert into tbl_empleados(nombres, apellidos, foto, cv, idpuesto, fechadeingreso) 
        values (:nombres, :apellidos, :foto, :cv, :idpuesto, :fechadeingreso)");
    $sentencia->bindParam(":nombres", $nombres);
    $sentencia->bindParam(":apellidos", $apellidos);

    $fecha = new DateTime();
    $nombre_foto = ($foto!="")? $fecha->getTimestamp()."-".$_FILES['foto']['name']:"";
    $temp_foto = $_FILES['foto']['tmp_name'];
    if($temp_foto!="") {
        move_uploaded_file($temp_foto,"./".$nombre_foto);
    }
    $sentencia->bindParam(":foto", $nombre_foto);

    $nombre_cv = ($cv!="")? $fecha->getTimestamp()."-".$_FILES['cv']['name']:"";
    $temp_cv = $_FILES['cv']['tmp_name'];
    if($temp_cv!="") {
        move_uploaded_file($temp_cv,"./".$nombre_cv);
    }
    $sentencia->bindParam(":cv", $nombre_cv);

    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->execute();
    $mensaje = "Registro Creado";
    header("Location:principal.php?mensaje=". $mensaje);
}

// Listar Puestos
    $sentencia = $conexion->prepare("select * from tbl_puestos");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include ("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">DATOS DEL EMPLEADO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres:</label>
                <input type="text" class="form-control" name="nombres" id="nombres" aria-describedby="helpId"
                    placeholder="Nombres" />
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId"
                    placeholder="Apellidos" />
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId"
                    placeholder="Foto" />
            </div>
            <div class="mb-3">
                <label for="cv" class="form-label">Curriculum Vitae (PDF):</label>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV" />
            </div>
            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                <option selected>Select one</option>
                    <?php foreach ($lista_tbl_puestos as $registro) {?>
                        <option value="<?php echo $registro['id']?>">
                            <?php echo $registro['nombredelpuesto']?>
                        </option>
                    <?php } ?>
                </select>                
            </div>
            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de Ingreso:</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso"
                    aria-describedby="emailHelpId" placeholder="Fecha de ingreso" />
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="principal.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include ("../../templates/footer.php"); ?>