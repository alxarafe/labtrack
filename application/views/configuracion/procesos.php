<div class="container">
    <h1>Gestión de procesos</h1>
    <?php if (!$procesos): ?>
        <h2>Aún no hay datos</h2>
    <?php endif ?>
    <form action="<?= base_url('/configuracion/procesos') ?>" method="post" accept-charset="utf-8"
          class="form-horizontal">
        <table id="the_table" class="table table-hover" align="center">
            <tr>
                <td>ID</td>
                <td>Orden</td>
                <td>Familias</td>
                <td>Nombre</td>
                <td>Texto botón</td>
                <td>Estado</td>
            </tr>
            <?php if ($procesos) foreach ($procesos as $key => $value): ?>
                <tr id="fila<?= $key ?>"
                    class="<?= $value['estado'] > 0 ? ($value['estado'] == 1 ? 'success' : 'active') : 'danger' ?>">
                    <td><input id="id<?= $key ?>" name="id[<?= $key ?>]" value="<?= $value['id'] ?>"
                               hidden/><?= $value['id'] ?></td>
                    <td><input id="orden<?= $key ?>" type="number" name="orden[<?= $key ?>]"
                               value="<?= $value['orden'] ?>"/></td>
                    <td><a href="<?= base_url('/configuracion/procesos/' . $value['id']) ?>" class="btn btn-primary">Familias</a>
                    </td>
                    <td><input id="nombre<?= $key ?>" name="nombre[<?= $key ?>]" value="<?= $value['nombre'] ?>"/></td>
                    <td><input id="boton<?= $key ?>" name="nombre_boton[<?= $key ?>]"
                               value="<?= $value['nombre_boton'] ?>"/></td>
                    <td><input id="check<?= $key ?>" type="checkbox" name="off[<?= $key ?>]"
                               value="<?= $value['estado'] ?>"
                               onClick="checkactive(<?= $key ?>);" <?= $value['estado'] == 0 ? 'checked' : '' ?>>
                        Desactivado</input></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="row">
            <span><button class="btn btn-primary btn-block big-text-touch-button" onClick="addproc();" type="button">Nueva<br/>línea</button></span>
            <span><button name="guardar" class="btn btn-primary btn-block big-text-touch-button"
                          type="submit">Aceptar</button></span>
            <span><button name="cancelar" class="btn btn-danger btn-block big-text-touch-button"
                          type="submit">Cancelar</button></span>
        </div>
    </form>
</div>