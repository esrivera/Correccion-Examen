<?php
include './services/Servicios.php';
$modulo = new Servicios();

$cod_modulo = "";
$nombre = "";
$estado = "";
$accion = "Agregar";

if (isset($_POST['accionModulo']) && ($_POST['accionModulo'] == 'Agregar')) {
    $modulo->insertarModulo($_POST['cod_modulo'], $_POST['nombre'], $_POST['estado']);
} else if (isset($_POST["accionModulo"]) && ($_POST["accionModulo"] == "Modificar")) {
    $modulo->modificarModulo($_POST['cod_modulo'], $_POST['nombre'], $_POST['estado'], $_POST['cod_modulo_comparar']);
} else if (isset($_GET["update"])) {
    $result = $modulo->encontrarModulo($_GET['update']);
    if ($result != null) {
        $cod_modulo = $result['COD_MODULO'];
        $nombre = $result['NOMBRE'];
        $estado = $result['ESTADO'];
        $accion = "Modificar";
    }
} else if (isset($_GET['delete'])) {
    $modulo->eliminarLogicoModulo($_GET['delete']);
}
?>

<?php include 'includes/header.php'; ?>

<div class="page-wrapper">
    <!-- Table -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- title -->
                            <div class="d-md-flex align-items-center">
                                <img src="includes/assets/images/estadio.png" alt="homepage" class="dark-logo" />
                                <div>
                                    <h2 class="card-title">
                                        <p>&nbsp;&nbsp</p>Listado de Modulos
                                    </h2>
                                </div>
                            </div>
                            <!-- title -->
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr class="bg-light">
                                <th class="border-top-0">Codigo</th>
                                <th class="border-top-0">Nombre</th>
                                <th class="border-top-0">Estado</th>
                                <th class="border-top-0">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $modulo->mostrarModulos();
                            if ($result) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['COD_MODULO']; ?></td>
                                        <td><?php echo $row['NOMBRE']; ?></td>
                                        <td><?php echo $row['ESTADO']; ?></td>
                                        <td>
                                            <a href="modulo.php?update=<?php echo $row["COD_MODULO"]; ?>#editar" title="Editar datos" name="modificar" class="btn btn-primary btn-sm"><span class="far fa-edit fa-lg" aria-hidden="true"></span></a>
                                            <a href="modulo.php?delete=<?php echo $row["COD_MODULO"]; ?>" title="Eliminar" name="eliminar" class="btn btn-danger btn-sm"><span class="far fa-trash-alt fa-lg" aria-hidden="true"></span></a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4">No hay datos</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-body">
                <form action="modulo.php" name="forma" method="post" id="forma">
                    <input type="hidden" name="cod_modulo_comparar" value="<?php echo $cod_modulo ?>">
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Nombre</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="Alumno" class="form-control
                                            form-control-line" name="nombre" id="nombre" value="<?php echo $nombre ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-6">Codigo</label>
                        <label class="col-sm-4">Estado</label>
                        <div class="input-group col-md-12">
                            <input type="text" placeholder="54074" class="form-control
                                            form-control-line col-sm-6" name="cod_modulo" value="<?php echo $cod_modulo ?>" id="cod_modulo" required>
                            <div class="input-group-prepend
                                            cold-md-4">
                                <span class="input-group-text"></span>
                            </div>
                            <select name="estado" class="custom-select mr-sm-6" id="estado">
                                <option>Activo</option>
                                <option>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input class="btn btn-success btn-block" type="submit" name="accionModulo" value="<?php echo $accion ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- right column -->
    <div id="miTabla" class="col-md-7 column pull-right">
        <div id="cargando"></div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>