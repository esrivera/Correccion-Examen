<?php
include './services/Servicios.php';
$rol = new Servicios();
//$modulo = new Servicios();
$nombre_rol = "";
$cod_modulo = "";
$estado = "";
$url_principal = "";
$nombre = "";
$descripcion = "";
$accion = "Agregar";

if (isset($_POST['accionRol']) && ($_POST['accionRol'] == 'Agregar')) {
    $rol->insertarModuloPorRol($_POST['rol'], $_POST['modulo']);
} else if (isset($_GET['delete'])) {
    $rol->eliminarrol($_GET['delete'], $_GET['modulo']);
}

?>

<?php include 'includes/header.php'; ?>
<!-- main container -->
<div class="page-wrapper content">
   <!-- end upper main stats -->
    <div id="pad-wrapper" class="form-page">
        <!-- statistics chart built with jQuery Flot -->
        <div class="row form-wrapper">
            <!-- left column -->
            <!--INICIO TABLA-->
            <div class="container">
                <div class="row">
                    <div class="card col-12">
                    <div class="card-body">
                    <div class="col-12">
                        <h3>ROL</h3>
                        <form action="" method="get">
                            <select class="form-control" name="rol" id="selectrol">
                                <option value="" disabled="" selected="">Selecciona un Módulo</option>
                                <?php
                                $result2 = $rol->mostrarRoles();
                                foreach ($result2 as $opciones) :
                                    $nombre_rol = $_GET["rol"];
                                ?>
                                    <option value="<?php echo $opciones['COD_ROL'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                                <?php endforeach ?>
                            </select><br>
                            <input type="submit" name="cod_rol" value="Aceptar" class="btn btn-primary">
                        </form>
                        <script type="text/javascript">
                            document.getElementById('selectrol').value = "<?php echo $_GET["rol"] ?>";
                        </script>
                    </div><br>

                    <div class="col-12"><br>
                        <form action="rol.php" name="forma" method="post" id="forma">
                            <div class="table-responsive">
                                <table id="tablaRoles" class="table v-middle" style="width: 100%;">
                                    <thead class="text-center">
                                        <tr class="bg-light">
                                            <th>Modulos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $rol->mostrarModulosPorRol($nombre_rol);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>

                                                <input type="hidden" name="cod_modulo" value="<?php echo $row["COD_MODULO"]; ?>">
                                                <input type="hidden" name="nombre_rol" value="<?php echo $row["COD_ROL"]; ?>">
                                                <tr>
                                                    <td><?php echo $row["NOMBRE"]; ?></td>

                                                    <td>
                                                        <div class="text-center">
                                                            <div class="btn-group">
                                                                <a href="rol.php?delete=<?php echo $row["COD_ROL"]; ?>&modulo=<?php echo $row["COD_MODULO"]; ?>" title="Eliminar" name="eliminar" class="btn btn-danger btn-sm"><span class="far fa-trash-alt fa-lg" aria-hidden="true"></span></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="2">No hay datos</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                                    </div>
                    </div>
                </div>
            </div><br>
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <!--<form action="index.php" name="forma" method="post" id="forma">-->
                        <div class="form-group row" id="editar">
                            <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Rol</label>
                            <div class="col-sm-4">
                                <input type="text" name="rol" value="<?php echo $nombre_rol ?>" require class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" id="editar">
                            <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Módulo</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="modulo" id="selectmodulo">
                                    <option value="" disabled="" selected="">Selecciona un Módulo</option>
                                    <?php
                                    $result3 = $rol->mostrarModulos();
                                    foreach ($result3 as $opciones) :
                                    ?>
                                        <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <input type="submit" name="accionRol" value="<?php echo $accion ?>" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- right column -->
        <div id="miTabla" class="col-md-7 column pull-right">
            <div id="cargando"></div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    registrarModulo();
</script>
<?php include 'includes/footer.php'; ?>