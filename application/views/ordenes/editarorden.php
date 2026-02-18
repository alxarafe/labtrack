<div class="container">
    <?php
    $editar = isset($movimiento) && $movimiento;
    if (!isset($message) && isset($_GET['message'])) $message = $_GET['message'];
    ?>
    <?php if (isset($message)): ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Aviso</div>
            <div class="panel-body"><?= $message ?></div>
        </div>
    <?php endif ?>
    <div class="panel panel-default">
        <div class="panel-heading"><a
                    href="<?= base_url('ordenes/index/' . $orden['id']) ?>">Expediente <?= $orden['id'] ?></a>
            correspondiente a <strong><?= $orden['nombre'] ?>.</strong>.
        </div>
        <div class="panel-body">
            <div class="row">
                <?php if ($editar): // Se está editando un movimiento, no debe de dejar cambiar nada más que el movimiento ?>
                    <?php foreach ($centros as $value): ?>
                        <span><span class="btn btn-<?= $centro == $value['id'] ? 'info' : 'default' ?> btn-block touch-button"><?= $value['nombre_boton'] ?></span></span>
                    <?php endforeach ?>
                <?php else: ?>
                    <?php foreach ($centros as $value): ?>
                        <span><a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $value['id']) ?>"
                                 class="btn btn-<?= $centro == $value['id'] ? 'success' : 'primary' ?> btn-block touch-button"><?= $value['nombre_boton'] ?></a></span>
                    <?php endforeach ?>
                <?php endif ?>
                <span><a href="<?= base_url('ordenes') ?>"
                         class="btn btn-danger btn-block touch-button">Cancelar</a></span>
                <?php if ($this->is_supervisor && !$movimientos): ?>
                    <span><a href="<?= base_url('ordenes/borrar/' . $orden['id']) ?>"
                             class="btn btn-danger btn-block touch-button">Borrar</a></span>
                <?php endif ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php if (!$centro): ?>
                        <h2>Seleccione un centro de costo</h2>
                    <?php else: ?>
                        <?php if (isset($familia) && $familia): ?>
                            <?php if ($editar): // Se está editando un movimiento, no debe de dejar cambiar nada más que el movimiento ?>
                                <span class="btn btn-block btn-default"><?= $familia['nombre'] ?></span>
                            <?php else: ?>
                                <a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro) ?>"
                                   class="btn btn-block btn-info"><?= $familia['nombre'] ?></a>
                            <?php endif ?>
                            <?php if (isset($proceso) && $proceso): ?>
                                <?php if ($editar): // Se está editando un movimiento, no debe de dejar cambiar nada más que el movimiento ?>
                                    <span class="btn btn-block btn-default"><?= $proceso['nombre'] ?></span>
                                <?php else: ?>
                                    <a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $familia['id']) ?>"
                                       class="btn btn-block btn-info"><?= $proceso['nombre'] ?></a>
                                <?php endif ?>
                                <?php if (isset($secuencia)): ?>
                                    <?php if ($editar): // Se está editando un movimiento, no debe de dejar cambiar nada más que el movimiento ?>
                                        <span class="btn btn-block btn-info"><?= $secuencia['nombre'] ?></span>
                                    <?php else: ?>
                                        <a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $familia['id'] . '/' . $proceso['id']) ?>"
                                           class="btn btn-block btn-success"><?= $secuencia['nombre'] ?></a>
                                    <?php endif ?>

                                    <br/>
                                    <form action="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $familia['id'] . '/' . $proceso['id'] . '/' . $secuencia['id']) ?>"
                                          method="post" accept-charset="utf-8" class="form-horizontal">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="row col-md-8">
                                                    <?php if (isset($movimiento['hora'])): ?>
                                                        <?php if ($this->is_supervisor): ?>
                                                            <p>Instante: <input id="hora" name="hora" type="datetime"
                                                                                value="<?= date('d-m-Y H:i', strtotime($movimiento['hora'])); ?>"/>
                                                            </p>
                                                            <p>Operador: <input id="user" name="user" type="number"
                                                                                value="<?= $movimiento['id_operador']; ?>"/>
                                                            </p>
                                                        <?php else: ?>
                                                            <input id="hora" name="hora" type="datetime"
                                                                   value="<?= date('d-m-Y H:i', strtotime($movimiento['hora'])); ?>"
                                                                   hidden/>
                                                            <input id="user" name="user" type="number"
                                                                   value="<?= $movimiento['id_operador']; ?>" hidden/>
                                                            <p>Instante:
                                                                <strong><?= date('d-m-Y H:i', strtotime($movimiento['hora'])); ?></strong>
                                                            </p>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                    <p>Cantidad: <input id="cantidad" name="cantidad" type="number"
                                                                        value="<?= isset($cantidad) ? $cantidad : 1 ?>"/>
                                                    </p>
                                                    <p<?= $secuencia['duracionedit'] == 0 && $secuencia['duracion'] > 0 ? ' hidden' : '' ?>>
                                                        Duración: <input id="duracion" name="duracion" type="number"
                                                                         value="<?= isset($duracion) ? $duracion : $secuencia['duracion'] ?>"
                                                                         min="1" max="999"/></p>
                                                    <div class="checkbox">
                                                        <label><input name="repetido" type="checkbox"
                                                                      value="1" <?= isset($repetido) && ($repetido >= 1) ? 'checked' : '' ?>/>Repetido</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="fallointerno" type="checkbox"
                                                                      value="1" <?= isset($repetido) && ($repetido == 2) ? 'checked' : '' ?>/>Fallo
                                                            interno</label>
                                                    </div>
                                                </div>
                                                <div class="row col-md-4">
                                                    <button name="guardar" class="btn btn-primary btn-block"
                                                            type="submit">Aceptar
                                                    </button>
                                                    <?php if ($editar): // Se está editando un movimiento, no debe de dejar cambiar nada más que el movimiento ?>
                                                        <button name="borrar" class="btn btn-danger btn-block"
                                                                type="submit">Borrar
                                                        </button>
                                                        <input name="id_movimiento" value="<?= $movimiento['id'] ?>"
                                                               hidden/>
                                                    <?php else: ?>
                                                        <button name="repetir" class="btn btn-primary btn-block"
                                                                type="submit">Aceptar y repetir
                                                        </button>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <textarea id="notas" name="notas" class="form-control custom-control"
                                                      rows="3" style="resize:none;width:100%;"
                                                      placeholder="Ponga aquí las observaciones"><?= isset($notas) ? $notas : '' ?></textarea>
                                        </div>
                                    </form>

                                <?php else: ?>
                                    <h2>Secuencias</h2>
                                    <?php if ($secuencias): ?>
                                        <?php foreach ($secuencias as $value): ?>
                                            <span><a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $familia['id'] . '/' . $proceso['id'] . '/' . $value['id']) ?>"
                                                     class="btn btn-primary btn-block mini-touch-button"><?= $value['nombre_boton'] ?></a></span>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <h3>No hay secuencias. Seleccione otro centro de costes, familia o proceso</h3>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php else: ?>
                                <h2>Procesos</h2>
                                <?php if ($procesos): ?>
                                    <?php foreach ($procesos as $value): ?>
                                        <span><a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $familia['id'] . '/' . $value['id']) ?>"
                                                 class="btn btn-primary btn-block touch-button"><?= $value['nombre_boton'] ?></a></span>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <h3>No hay procesos. Seleccione otro centro de costes u otra familia</h3>
                                <?php endif ?>
                            <?php endif ?>
                        <?php else: ?>
                            <h2>Familias</h2>
                            <?php if ($familias): ?>
                                <?php foreach ($familias as $value): ?>
                                    <span><a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $centro . '/' . $value['id']) ?>"
                                             class="btn btn-primary btn-block touch-button"><?= $value['nombre_boton'] ?></a></span>
                                <?php endforeach ?>
                            <?php else: ?>
                                <h3>No hay familias. Seleccione otro centro de costes</h3>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="col-md-6">
                    <h3>Listado de secuencias</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <?php if ($supervisar = $this->is_supervisor && !isset($centro)) echo "<th>¿Ok?</th>"; ?>
                                <th>&nbsp;</th>
                                <th>Secuencia</th>
                                <th>ud</th>
                                <th>op</th>
                                <th>fecha</th>
                                <?php if ($this->is_admin) echo '<th>min</th>' ?>
                                <th>rep</th>
                                <th>Srv</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($movimientos) && $movimientos) {
                            if ($supervisar): ?>
                            <form action="<?= base_url('ordenes/index/' . $orden['id']) ?>" method="post"
                                  accept-charset="utf-8" class="form-horizontal">
                                <?php endif;
                                foreach ($movimientos as $value):
                                    ?>
                                    <tr>
                                        <?php if ($supervisar): ?>
                                            <td>
                                                <?php if ($value['supervisado'] == 0): $hay = true; ?>
                                                    <input name="ok[]" type="checkbox" value="<?= $value['id'] ?>"/>Ok
                                                <?php else: ?>
                                                    Ok
                                                <?php endif ?>
                                            </td>
                                        <?php endif ?>
                                        <td>
                                            <?php if ($value['notas'] == ''): ?>
                                                &nbsp;
                                            <?php else: ?>
                                                <span title="<?= $value['notas'] ?>"><span
                                                            class="glyphicon glyphicon-exclamation-sign"
                                                            aria-hidden="true"></span></span>
                                            <?php endif ?>
                                        </td>
                                        <?php if ($this->is_admin || (($this->is_supervisor || $value['id_operador'] == $this->user_id) && $value['supervisado'] == 0) || ($this->is_supervisor && $value['supervisado'] == $this->user_id)): ?>
                                            <td>
                                                <a href="<?= base_url('ordenes/index/' . $orden['id'] . '/' . $value['id_centrocosto'] . '/' . $value['id_familia'] . '/' . $value['id_proceso'] . '/' . $value['id_secuencia'] . '/' . $value['id']) ?>"><?= $value['secuencia']; ?></a>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $value['secuencia']; ?></td>
                                        <?php endif ?>
                                        <td><?= $value['unidades']; ?></td>
                                        <td><?= $value['id_operador']; ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($value['hora'])); ?></td>
                                        <?php if ($this->is_admin) echo '<td align="right">' . $value['duracion'] . '</td>' ?>
                                        <td><?= $value['repetido'] == 1 ? 'Rep' : ($value['repetido'] == 2 ? 'Fac' : ''); ?></td>
                                        <td><?= $value['supervisado']; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    if ($supervisar):
                        if (isset($hay) && $hay) echo '<button name="checkon" class="btn btn-primary btn-block" type="submit">Validar</button>';
                        ?>
                        </form>
                    <?php endif;
                    }
                    ?>
                </div>
            </div>
        </div> <!-- del panel body -->
    </div> <!-- del panel -->

</div>