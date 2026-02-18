<div class="container">
    <h1>Asociar proceso (<?= $proceso['id'] . ') ' . $proceso['nombre'] ?> a las siguientes familias:</h1>
    <?php if (!$familias): ?>
        <h2>Aún no hay datos</h2>
    <?php else: ?>

    <form action="<?= base_url('/configuracion/procesos/' . $proceso['id']) ?>" method="post" accept-charset="utf-8"
          class="form-horizontal">
        <?php foreach ($familias as $value): ?>
            <?php
            $checked = false;
            if ($marcadas) foreach ($marcadas as $vm) {
                $checked = $checked || ($vm['id'] == $value['id']);
            }
            ?>
            <div class="checkbox"><label><input type="checkbox" name="check[<?= $value['id'] ?>]"
                                                value="<?= $value['id'] ?>"<?= $checked ? ' checked' : '' ?><?= $value['estado'] == 0 ? ' disabled' : '' ?> /><?= $value['nombre'] ?>
                </label></div>
        <?php endforeach ?>
        <div class="row">
            <span><button name="guardar" class="btn btn-primary btn-block big-text-touch-button"
                          type="submit">Aceptar</button></span>
            <span><button name="cancelar" class="btn btn-danger btn-block big-text-touch-button"
                          type="submit">Cancelar</button></span>
        </div>
    </form>
</div>
<?php endif ?>
