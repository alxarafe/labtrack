<div class="container">
    <h1><?= $alta ? 'Alta de una nueva orden' : 'Edición de orden' ?></h1>
    <div class="row">
        <form action="<?= base_url("/ordenes/edit/$orden") ?>" method="post" accept-charset="utf-8"
              class="form-horizontal">
            <div class="col-md-6">
                <p>Nº de órden: <strong><?= $orden ?></strong></p>
                <p>Nombre del cliente: <input id="nombre" name="nombre" type="text" value="<?= $nombre ?>"></p>
            </div>
            <div class="col-md-6">
                <?php if ($alta) : ?>
                    <button name="aceptar" class="btn btn-primary btn-block big-text-touch-button" type="submit">
                        Aceptar
                    </button>
                <?php else : ?>
                    <button name="cambiar" class="btn btn-success btn-block big-text-touch-button" type="submit">
                        Aceptar
                    </button>
                <?php endif ?>
                <button name="cancelar" class="btn btn-danger btn-block big-text-touch-button" type="submit">Cancelar
                </button>
            </div>
        </form>
    </div>
</div>