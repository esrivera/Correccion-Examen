<?php
include './services/Servicios.php';
$funcionalidad = new Servicios();
$cod_modulo = "";
$estado = "";
$url_principal = "";
$nombre = "";
$descripcion = "";
$accion = "Agregar";

if (isset($_POST['accionInfraestructura']) && ($_POST['accionInfraestructura'] == 'Agregar')) {
    $funcionalidad->insertarFuncionalidad(
        $_POST['url_principal'],
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['cod_modulo_ingresar']
    );
} else if (isset($_POST["accionInfraestructura"]) && ($_POST["accionInfraestructura"] == "Modificar")) {
    $funcionalidad->modificarFuncionalidad($_POST['cod_funcionalidad'], $_POST['url_principal'], $_POST['nombre'], $_POST['descripcion']);
} else if (isset($_GET["update"])) {
    $result = $funcionalidad->encontrarFuncionalidad($_GET['update'], $_GET['modulo']);
    if ($result != null) {
        $url_principal = $result['URL_PRINCIPAL'];
        $nombre = $result['NOMBRE'];
        $descripcion = $result['DESCRIPCION'];
        $accion = "Modificar";
    }
} else if (isset($_GET['delete'])) {
    $funcionalidad->eliminarFuncionalidad($_GET['delete']);
}
?>

<?php include 'includes/header.php'; ?>


<div class="page-wrapper">
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
                                        <p>&nbsp;&nbsp</p>Listado de Funcionalidades
                                    </h2>
                                </div>
                            </div>
                            <!-- title -->
                        </div>
                        <div class="col-md-4">
                            <div class="form">
                                <form action="" method="get">
                                    <div class="col-auto my-1">
                                        <h3 class="mr-sm-2" for="inlineFormCustomSelect">Modulo:</h3>
                                        <select name="modulo" class="custom-select mr-sm-4" id="selectmodulo">
                                            <?php
                                            $result2 = $funcionalidad->mostrarModulos();
                                            foreach ($result2 as $opciones) :
                                                $nombre_modulo = $_GET["modulo"];
                                            ?>
                                                <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-auto my-1">
                                        <br />
                                        <button type="submit" name="cod_modulo" value="Aceptar" class="btn btn-block btn-primary">Buscar</button>
                                    </div>
                                </form>
                                <script type="text/javascript">
                                    document.getElementById('selectmodulo').value = "<?php echo $_GET["modulo"] ?>";
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="funcionalidades.php" name="forma" method="post">
                    <input type="hidden" name="nombre_modulo" value="<?php echo $nombre_modulo ?>">
                    <div class="table-responsive">
                        <table class="table v-middle">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">Nombre</th>
                                    <th class="border-top-0">URL</th>
                                    <th class="border-top-0">Descripción</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $funcionalidad->mostrarFuncionalidades($nombre_modulo);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <input type="hidden" name="cod_funcionalidad" value="<?php echo $row["COD_FUNCIONALIDAD"]; ?>">
                                        <input type="hidden" name="cod_modulo" value="<?php echo $row["COD_MODULO"]; ?>">
                                        <tr>
                                            <td><?php echo $row['NOMBRE']; ?></td>
                                            <td><?php echo $row['URL_PRINCIPAL']; ?></td>
                                            <td><?php echo $row['DESCRIPCION']; ?></td>
                                            <td>
                                                <a href="funcionalidades.php?update=<?php echo $row["COD_FUNCIONALIDAD"]; ?>&modulo=<?php echo $row["COD_MODULO"]; ?>" title="Editar datos" name="modificar" class="btn btn-primary btn-sm"><span class="far fa-edit fa-lg" aria-hidden="true"></span></a>
                                                <a href="funcionalidades.php?delete=<?php echo $row["COD_FUNCIONALIDAD"]; ?>&modulo=<?php echo $row["COD_MODULO"]; ?>" title="Eliminar" name="eliminar" class="btn btn-danger btn-sm"><span class="far fa-trash-alt fa-lg" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
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
                <input type="hidden" name="cod_modulo_ingresar" value="<?php echo $nombre_modulo ?>">
                <div class="form-group">
                    <label class="col-md-12">URL</label>
                    <div class="col-md-12">
                        <input type="text" placeholder="" class="form-control
                                            form-control-line" name="url_principal" value="<?php echo $url_principal ?>" id="url" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="example-email" class="col-md-12">Nombre</label>
                    <div class="col-md-12">
                        <input type="text" placeholder="" class="form-control
                                            form-control-line" value="<?php echo $nombre ?>" name="nombre" id="nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Descripción</label>
                    <div class="col-md-12">
                        <input type="text" placeholder="" class="form-control
                                            form-control-line" value="<?php echo $descripcion ?>" name="descripcion" id="descripcion" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input class="btn btn-success btn-block" type="submit" name="accionInfraestructura" value="<?php echo $accion ?>">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    registrarModulo();
</script>
<?php include 'includes/footer.php'; ?>