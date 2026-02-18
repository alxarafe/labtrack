<div class="container">
    <h1>Consulta de orden de trabajo</h1>
    <?php if (isset($message)): ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Aviso</div>
            <div class="panel-body"><?= $message ?></div>
        </div>
    <?php endif ?>
    <form action="<?= base_url('/informes/orden') ?>" method="post" accept-charset="utf-8" class="form-horizontal">
        <div class="col-md-8">
            <p>Orden: <input id="orden" name="orden" type="number" value="<?= $orden ?>"></p>
        </div>
        <div class="col-md-4">
            <span><button name="aceptar" class="btn btn-primary btn-block big-text-touch-button"
                          type="submit">Aceptar</button></span>
        </div>
    </form>
</div>
<div class="container">
    <?php if (isset($informe) && $informe && count($informe) > 0): ?>
        <?php if ($this->is_supervisor): ?>
            <a href="<?= base_url("informes/exportarorden/$orden") ?>" target="_blank" class="btn btn-success">Exportar
                a CSV</a>
        <?php endif ?>
        <table id="the_table" class="table table-hover" align="center">
            <tr>
                <td>ID</td>
                <td>Orden</td>
                <td>Usuario</td>
                <td>Hora</td>
                <td>C.Costo</td>
                <td>Familia</td>
                <td>Secuencia</td>
                <td>Ud</td>
                <td>Min</td>
                <td>Rep</td>
                <td>VºBº</td>
                <td>Notas</td>
            </tr>
            <?php
            $contador = 0;
            $contador_rep = 0;
            $contador_fac = 0;
            $minutos = 0;
            ?>
            <?php //if ($informe && count($informe)>0): ?>
            <?php foreach ($informe as $key => $value): ?>
                <?php

                $contador += $value['unidades'];
                $minutos += $value['unidades'] * $value['duracion'];
                if ($value['repetido'] > 0) {
                    $contador_rep++;
                    if ($value['repetido'] = 2) {
                        $contador_fac++;
                    }
                }
                ?>
                <tr id="fila<?= $key ?>">
                    <td><?= $value['id'] ?></td>
                    <td><?= $value['id_orden'] ?></td>
                    <td><?= $value['id_operador'] ?></td>
                    <td><?= $value['hora'] ?></td>
                    <td><?= $value['id_centrocosto'] . ' ' . $value['centrocosto'] ?></td>
                    <td><?= $value['id_familia'] . ' ' . $value['familia'] ?></td>
                    <td><?= $value['id_secuencia'] . ' ' . $value['secuencia'] ?></td>
                    <td><?= $value['unidades'] ?></td>
                    <td><?= $value['duracion'] ?></td>
                    <td><?= $value['repetido'] ?></td>
                    <td><?= $value['supervisado'] ?></td>
                    <td><?= $value['notas'] ?></td>
                </tr>
            <?php endforeach ?>
            <?php
            echo "<tr><td colspan='7' align='right'>Total orden ($minutos minutos):</td><td>$contador</td><td>Rep:</td><td>$contador_rep<td>Fac:</td><td>$contador_fac</td></tr>";
            ?>
        </table>
    <?php else: ?>
        <h3><?= isset($informe) ? 'No hay datos' : 'Revise los datos de la consulta y pulse en aceptar' ?></h3>
    <?php endif ?>
</div>