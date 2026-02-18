<div class="container">
    <?php if (isset($message)) : ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Aviso</div>
            <div class="panel-body"><?= $message ?></div>
        </div>
    <?php endif ?>
    <div class="panel panel-default">
        <div class="panel-heading">Indique un número de orden para <strong>repetir la secuencia</strong>.</div>
        <div class="panel-body">
            <div class="row">
                <?php foreach ($centros as $value) : ?>
                    <span><span class="btn btn-<?= $centro == $value['id'] ? 'info' : 'default' ?> btn-block touch-button"><?= $value['nombre_boton'] ?></span></span>
                <?php endforeach ?>
                <span><a href="<?= base_url('ordenes') ?>"
                         class="btn btn-danger btn-block touch-button">Cancelar</a></span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span class="btn btn-block btn-default"><?= $familia['nombre'] ?></span>
                    <span class="btn btn-block btn-default"><?= $proceso['nombre'] ?></span>
                    <span class="btn btn-block btn-info"><?= $secuencia['nombre'] ?></span>
                    <br/>
                    <form action="<?= base_url('ordenes/repetir/' . $centro . '/' . $familia['id'] . '/' . $proceso['id'] . '/' . $secuencia['id'] . '/' . $movimiento['id']) ?>"
                          method="post" accept-charset="utf-8" class="form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row col-md-8">
                                    <?php if ($expediente) : ?>
                                        <p>Nº de órden: <strong><?= $orden . ' ' . $expediente['nombre'] ?></strong>
                                            <input id="orden" name="orden" type="text" value="<?= $orden ?>" hidden/>
                                        </p>
                                    <?php else : ?>
                                        <p>Nº de órden: <input id="orden" name="orden" type="text"
                                                               value="<?= isset($orden) ? $orden : '' ?>" autofocus/>
                                        </p>
                                    <?php endif ?>
                                    <p>Cantidad: <input id="cantidad" name="cantidad" type="number"
                                                        value="<?= isset($cantidad) ? $cantidad : $movimiento['unidades'] ?>"/>
                                    </p>
                                    <p<?= $secuencia['duracionedit'] == 0 && $secuencia['duracion'] > 0 ? ' hidden' : '' ?>>
                                        Duración: <input id="duracion" name="duracion" type="number"
                                                         value="<?= isset($duracion) ? $duracion : $movimiento['duracion'] ?>"
                                                         min="1" max="999"/></p>
                                    <div class="checkbox">
                                        <label><input name="repetido" type="checkbox"
                                                      value="1" <?= isset($movimiento['repetido']) && ($movimiento['repetido'] >= 1) ? 'checked' : '' ?>/>Repetido</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="fallointerno" type="checkbox"
                                                      value="1" <?= isset($movimiento['repetido']) && ($movimiento['repetido'] == 2) ? 'checked' : '' ?>/>Fallo
                                            interno</label>
                                    </div>
                                </div>
                                <div class="row col-md-4">
                                    <?php if ($expediente) : ?>
                                        <button name="guardar" class="btn btn-primary btn-block" type="submit">Aceptar
                                        </button>
                                        <button name="volver" class="btn btn-danger btn-block" type="submit">Volver
                                        </button>
                                    <?php else : ?>
                                        <button name="buscar" class="btn btn-primary btn-block" type="submit">Buscar
                                        </button>
                                    <?php endif ?>
                                </div>
                            </div>
                            <textarea id="notas" name="notas" class="form-control custom-control" rows="3"
                                      style="resize:none;width:100%;"
                                      placeholder="Ponga aquí las observaciones"><?= isset($notas) ? $notas : $movimiento['notas'] ?></textarea>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Listado de secuencias</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Secuencia</th>
                                <th>ud</th>
                                <th>op</th>
                                <th>fecha</th>
                                <?php if ($this->is_admin) {
                                    echo '<th>min</th>';
                                } ?>
                                <th>rep</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($movimientos) && $movimientos) {
                                foreach ($movimientos as $value) : ?>
                                <tr>
                                    <td>
                                        <?php if ($value['notas'] == '') : ?>
                                            &nbsp;
                                        <?php else : ?>
                                            <span title="<?= $value['notas'] ?>"><span
                                                        class="glyphicon glyphicon-exclamation-sign"
                                                        aria-hidden="true"></span></span>
                                        <?php endif ?>
                                    </td>
                                    <td><?= $value['secuencia']; ?></td>
                                    <td><?= $value['unidades']; ?></td>
                                    <td><?= $value['id_operador']; ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($value['hora'])); ?></td>
                                    <?php if ($this->is_admin) {
                                        echo '<td align="right">' . $value['duracion'] . '</td>';
                                    } ?>
                                    <td><?= $value['repetido'] == 1 ? 'Rep' : ($value['repetido'] == 2 ? 'Fac' : ''); ?></td>
                                </tr>
                                <?php endforeach;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- del panel body -->
    </div> <!-- del panel -->

</div>