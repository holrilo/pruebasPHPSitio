<?php include("../template/cabecera.php"); ?>
<?php

$txtID = (isset($_POST['txtid'])) ? $_POST['txtid'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

// echo $txtID;
// echo $txtNombre;
// echo $txtImagen;
// echo $accion;

include("../config/bd.php");

switch ($accion) {
    case 'agregar':
        # code... INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'libro php ', 'imagen.jpg');

        $sentenciaSQL = $conexion->prepare("INSERT INTO `libros` (`nombre`, `imagen`) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen != "") {
            # code...
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        // echo "Presionado boton agregar";
        break;

    case 'modificar':
        # code...
        $sentenciaSQL = $conexion->prepare("UPDATE libros  SET nombre=:nombre where id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {
            # code...

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen from libros where id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                # code...
                if (file_exists("../../img/" . $libro["imagen"])) {
                    # code...
                    unlink("../../img/" . $libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE libros  SET imagen=:imagen where id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");

        break;
    case 'cancelar':
        # code...
        header("Location:productos.php");
        break;
    case 'seleccionar':
        # code...
        $sentenciaSQL = $conexion->prepare("select * from libros where id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];

        break;
    case 'borrar':
        # code...

        $sentenciaSQL = $conexion->prepare("SELECT imagen from libros where id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            # code...
            if (file_exists("../../img/" . $libro["imagen"])) {
                # code...
                unlink("../../img/" . $libro["imagen"]);
            }
        }


        $sentenciaSQL = $conexion->prepare("DELETE from libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");

        break;

    default:
        # code...
        break;
}

$sentenciaSQL = $conexion->prepare("select * from libros");
$sentenciaSQL->execute();
$listarLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">ID :</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID ?>" name="txtid" id="txtid" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre :</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre ?>" id="txtNombre" name="txtNombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Imagen :</label>

                    <?php if ($txtImagen != "") {
                        # code... 
                    ?>
                        <?php echo $txtImagen; ?>
                        <br>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen ?>" width="50" alt="">
                    <?php }  ?>
                    <input type="file" class="form-control" id="txtImagen" name="txtImagen" placeholder="Imagen">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "seleccionar") ? "disabled" : ""; ?> value="agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "seleccionar") ? "disabled" : ""; ?> value="modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "seleccionar") ? "disabled" : ""; ?> value="cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</div>
<div class="col-md-7">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listarLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id'] ?></td>
                    <td><?php echo $libro['nombre'] ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen'] ?>" width="50" alt="">

                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="txtid" id="txtid" value="<?php echo $libro['id']; ?>">
                            <input type="submit" name="accion" value="seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<?php include("../template/pie.php"); ?>