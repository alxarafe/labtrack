<div class="container">
    <h1>Gestión de órdenes</h1>
    <form action="<?= base_url('/ordenes') ?>" method="post" accept-charset="utf-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">Alta de secuencias</div>
                    <div class="panel-body">
                        Introduzca el número de aviso y pulse Aceptar o Intro en el teclado.<br/>
                        Para abandonar la aplicación, pulse cancelar.
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php if (isset($message)): ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">Aviso</div>
                        <div class="panel-body"><?= $message ?></div>
                    </div>
                <?php endif ?>
                <p>Nº de órden: <input id="orden" name="orden" type="number" value="<?= isset($orden) ? $orden : '' ?>"
                                       autofocus></p>
            </div>
        </div>
        <?php /*if ($centros) foreach ($centros as $key=>$centro): ?>
	<button name="centro[<?=$key?>]" class="btn btn-primary btn-block touch-button" type="submit"><?= $centro['nombre'] ?></button>
	<?php endforeach */ ?>
        <button name="aceptar" class="btn btn-primary btn-block touch-button" type="submit">Aceptar</button>
        <button name="cancelar" class="btn btn-danger btn-block touch-button" type="submit">Cancelar</button>
        <?php if ($this->is_supervisor): ?>
            <button name="editar" class="btn btn-success btn-block touch-button" type="submit">Editar</button>
        <?php endif ?>
    </form>
</div>