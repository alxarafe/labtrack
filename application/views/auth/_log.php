<div class="container">
    <div class="row">
        <?php if ($log) : ?>
            <table class="table table-hover" align="center">
                <tr>
                    <td>Id</td>
                    <td>Código</td>
                    <td>IP</td>
                    <td>Mensaje</td>
                    <td>Instante</td>
                </tr>
                <?php foreach ($log as $key => $value) : ?>
                    <tr id="fila<?= $key ?>">
                        <td><?= $value['id'] ?></td>
                        <td><?= $value['event_id'] ?></td>
                        <td><?= $value['ip_address'] ?></td>
                        <td><?= $value['message'] ?></td>
                        <td><?= $value['timestamp'] ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    </div>
</div>