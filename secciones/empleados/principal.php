<?php
include ("../../db.php");

// Eliminar Empleados
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";

    // Buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("select foto, cv from tbl_empleados where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    // Elimina los archivos guardados en la app
    if (isset($registro_recuperado["foto"]) && isset( $registro_recuperado["foto"])!="") {
        if (file_exists("./".$registro_recuperado["foto"])){
            unlink("./".$registro_recuperado["foto"]);
        }
    }
    if (isset($registro_recuperado["cv"]) && isset( $registro_recuperado["cv"])!="") {
        if (file_exists("./".$registro_recuperado["cv"])){
            unlink("./".$registro_recuperado["cv"]);
        }
    }

    // Elimina Empleado
    $sentencia = $conexion->prepare("delete from tbl_empleados where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Eliminado";
    header("Location:principal.php?mensaje=".$mensaje);
}

// Listar Empleados
$sentencia = $conexion->prepare("select *,
(select nombredelpuesto from tbl_puestos
where tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto
from tbl_empleados");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include ("../../templates/header.php"); ?>

<h3>Empleados</h3>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button">Agregar Registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabla_id" class="table display">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fechas Ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_empleados as $registro) {?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td>
                                <?php echo $registro['nombres']; ?>
                                <?php echo $registro['apellidos']; ?>
                            </td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt=""/>
                            </td>
                            <td><a href="<?php echo $registro['cv']; ?>"><?php echo $registro['cv']; ?></a></td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['fechadeingreso']; ?></td>
                            <td><a name="btncarta" id="btncarta" class="btn btn-info"
                                    href="carta.php?txtID=<?php echo $registro['id']; ?>" role="button">Carta</a>
                                <a name="btneditar" id="btneditar" class="btn btn-warning"
                                    href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a name="btneliminar" id="btneliminar" class="btn btn-danger"
                                    href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include ("../../templates/footer.php"); ?>