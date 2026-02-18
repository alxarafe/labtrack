<div class="container">
    <h1>Supervisión de órdenes</h1>
    <?php if ($movimientos) : ?>
        <form action="<?= base_url('/ordenes') ?>" method="post" accept-charset="utf-8" class="form-horizontal">
            <div class="col-md-12">
                <h3>Listado de secuencias pendientes de supervisar</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Órden</th>
                            <th>&nbsp;</th>
                            <th>Secuencia</th>
                            <th>ud</th>
                            <th>op</th>
                            <th>fecha</th>
                            <?php if ($this->is_admin) {
                                echo '<th>min</th>';
                            } ?>
                            <th>rep</th>
                            <th>Srv</th>
                            <th>Validar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($movimientos as $value) : ?>
                            <tr>
                                <td><?= $value['id_orden'] . ' ' . $value['orden']; ?></td>
                                <td>
                                    <?php if ($value['notas'] == '') : ?>
                                        &nbsp;
                                    <?php else : ?>
                                        <span title="<?= $value['notas'] ?>"><span
                                                    class="glyphicon glyphicon-exclamation-sign"
                                                    aria-hidden="true"></span></span>
                                    <?php endif ?>
                                </td>
                                <?php if ($this->is_admin || $value['supervisado'] == 0 || ($this->is_supervisor && $value['supervisado'] == $this->user_id)) : ?>
                                    <td>
                                        <a href="<?= base_url('ordenes/index/' . $value['id_orden'] . '/' . $value['id_centrocosto'] . '/' . $value['id_familia'] . '/' . $value['id_proceso'] . '/' . $value['id_secuencia'] . '/' . $value['id']) ?>"><?= $value['secuencia']; ?></a>
                                    </td>
                                <?php else : ?>
                                    <td><?= $value['secuencia']; ?></td>
                                <?php endif ?>
                                <td><?= $value['unidades']; ?></td>
                                <td><?= $value['id_operador']; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($value['hora'])); ?></td>
                                <?php if ($this->is_admin) {
                                    echo '<td align="right">' . $value['duracion'] . '</td>';
                                } ?>
                                <td><?= $value['repetido'] == 1 ? 'Rep' : ($value['repetido'] == 2 ? 'Fac' : ''); ?></td>
                                <td><?= $value['supervisado']; ?></td>
                                <td><a href="<?= base_url('supervision/validar/' . $value['id']); ?>"
                                       class="btn btn-info">Validar</a></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    <?php else : ?>
        <p>No hay movimientos que supervisar</p>
    <?php endif ?>
</div>