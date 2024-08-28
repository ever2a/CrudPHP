<?php
include ("../../db.php");

// Carga los datos del Empleado
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']))? $_GET['txtID']:"";

    $sentencia = $conexion->prepare("select *, (select nombredelpuesto from tbl_puestos
        where tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto 
        from tbl_empleados where id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombres = $registro["nombres"];
    $apellidos = $registro["apellidos"];
    $nombre_completo = $nombres." ".$apellidos;
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $puesto = $registro["puesto"];
    $fechadeingreso = $registro["fechadeingreso"];

    $fecha_inicio = new DateTime($fechadeingreso);
    $fecha_fin = new DateTime(date('Y-m-d'));
    $periodo = date_diff($fecha_inicio,$fecha_fin);
}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendación</title>
</head>
<body>
    <h1>CARTA DE RECOMENDACIÓN LABORAL</h1>
    <br><br>
    Ayacucho, Perú - <strong><?php echo date('d M Y'); ?></strong>
    <br><br>
    A quien pueda interesar:
    <br><br>
    Reciba un cordial y respetuoso saludo.
    <br><br>
    A través de estas líneas, deseo hacer de su conocimiento que el Sr(a) <strong><?php echo $nombre_completo;?></strong>,
    quien laboro en mi organización durante <strong><?php echo $periodo->y;?> año(s)</strong>
    es un ciudadano con una conducta intachable. Ha demostrado ser un gran trabajador, comprometido,
    responsble y fiel cumplidor de sus tareas.
    Siempre ha manifestado preocupación por mejorar, capacitarse y actualizar sus conocimientos.
    <br><br>
    Durante estos años se ha desempeñado como: <strong><?php echo $puesto;?>.</strong>
    <br>
    Es por ello le sugiero considere esta recomendación, con la confianza de que estará siempre a la
    altura de sus compromisos y responsabilidades.
    <br><br>
    Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi número 
    de contacto para cualquier información de interés.
    <br><br><br><br><br><br><br><br>
    Atentamente
    <br>
    Ing. Ever Aronés Ayala
</body>
</html>
<?php
$HTML = ob_get_clean();
require_once('../../libs/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($opciones);
$dompdf->loadHtml($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));
?>