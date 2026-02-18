<div class="container">
    <h1>Asociar secuencia (<?= $secuencia['id'] . ') ' . $secuencia['nombre'] ?> a los siguientes procesos:</h1>
    <?php if (!$procesos): ?>
        <h2>Aún no hay datos</h2>
    <?php else: ?>

    <form action="<?= base_url('/configuracion/secuencias/' . $secuencia['id']) ?>" method="post" accept-charset="utf-8"
          class="form-horizontal">
        <?php foreach ($procesos as $value): ?>
            <?php
            $checked = false;
            if ($marcados) foreach ($marcados as $vm) {
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
