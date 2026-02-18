<div class="container">
    <h1>Gestión de usuarios</h1>
    <?php if (isset($message)) : ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Aviso</div>
            <div class="panel-body"><?= $message ?></div>
        </div>
    <?php endif ?>
    <?php if (!$usuarios) : ?>
        <h2>Aún no hay datos</h2>
    <?php endif ?>
    <form action="<?= base_url('/configuracion/usuarios') ?>" method="post" accept-charset="utf-8"
          class="form-horizontal">
        <table id="the_table" class="table table-hover" align="center">
            <tr>
                <td>ID</td>
                <td>Nueva ID</td>
                <td>Nombre</td>
                <!-- <td>Código rápido</td> -->
                <td>Administrador</td>
                <td>Supervisor</td>
                <td>Estado</td>
            </tr>
            <?php if ($usuarios) {
                foreach ($usuarios as $key => $value) : ?>
                <tr id="fila<?= $key ?>"
                    class="<?= $value['active'] > 0 ? ($value['active'] == 1 ? 'success' : 'active') : 'danger' ?>">
                    <td><input id="oldid<?= $key ?>" name="oldid[<?= $key ?>]"
                               value="<?= isset($value['oldid']) ? $value['oldid'] : $value['id'] ?>"
                               hidden/><?= isset($value['oldid']) ? $value['oldid'] : $value['id'] ?></td>
                    <td><input id="id<?= $key ?>" name="id[<?= $key ?>]" value="<?= $value['id'] ?>"/></td>
                    <td><input id="nombre<?= $key ?>" name="nombre[<?= $key ?>]" value="<?= $value['username'] ?>"/>
                    </td>
                    <!--
        <td><input id="fastaccess<?= $key ?>" name="fastaccess[<?= $key ?>]" value="<?= $value['fastaccess'] ?>" /></td>
        -->
                    <td><input id="admin<?= $key ?>" type="checkbox" name="admin[<?= $key ?>]"
                               value="<?= $value['admin'] ?>" <?= $value['admin'] == 0 ? '' : 'checked' ?>>
                        Administrador</input></td>
                    <td><input id="supervisor<?= $key ?>" type="checkbox" name="supervisor[<?= $key ?>]"
                               value="<?= $value['supervisor'] ?>" <?= $value['supervisor'] == 0 ? '' : 'checked' ?>>
                        Supervisor</input></td>
                    <td><input id="check<?= $key ?>" type="checkbox" name="off[<?= $key ?>]"
                               value="<?= $value['active'] ?>"
                               onClick="checkactive(<?= $key ?>);" <?= $value['active'] == 0 ? 'checked' : '' ?>>
                        Desactivado</input></td>
                </tr>
                <?php endforeach;
            } ?>
        </table>
        <div class="row">
            <span><button class="btn btn-primary btn-block big-text-touch-button" onClick="addusr();" type="button">Nueva<br/>línea</button></span>
            <span><button name="guardar" class="btn btn-primary btn-block big-text-touch-button"
                          type="submit">Aceptar</button></span>
            <span><button name="cancelar" class="btn btn-danger btn-block big-text-touch-button"
                          type="submit">Cancelar</button></span>
    </form>
</div>