<div class="container">
    <h1>Informes de productividad</h1>
    <?php if (isset($message)) : ?>
        <div class="panel panel-danger">
            <div class="panel-heading">Aviso</div>
            <div class="panel-body"><?= $message ?></div>
        </div>
    <?php endif ?>
    <form action="<?= base_url('/informes/usuario') ?>" method="post" accept-charset="utf-8" class="form-horizontal">
        <div class="col-md-8">
            <?php if ($this->is_supervisor) : ?>
                <div class="col-md-6">
                    <p>Usuarios:</p>
                    <select multiple id="usuario" name="usuario[]" class="selectpicker" size="10">
                        <?php /* <option value="0">Seleccione un usuario</option> */ ?>
                        <?php foreach ($usuarios as $user) : ?>
                            <option value="<?= $user['id'] ?>" <?= $user['id'] == $usuario ? 'selected' : '' ?>><?= $user['username'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php else : ?>
                <p>Usuario: <input id="usuario" name="usuario" type="number" value="<?= $this->user_id ?>" readonly></p>
            <?php endif ?>
            <?php if ($this->is_supervisor) {
                echo '<div class="col-md-6">';
            } ?>
            <p>Desde: <input id="fechadesde" name="fechadesde" type="date" value="<?= $fechadesde ?>"></p>
            <p>Hasta: <input id="fechahasta" name="fechahasta" type="date" value="<?= $fechahasta ?>"></p>
            <?php if ($this->is_supervisor) {
                echo '</div>';
            } ?>
        </div>
        <div class="col-md-4">
            <span><button name="aceptar" class="btn btn-primary btn-block big-text-touch-button"
                          type="submit">Aceptar</button></span>
        </div>
    </form>
</div>
<div class="container">
    <?php if (isset($informe) && $informe && count($informe) > 0) : ?>
        <?php if (!is_array($usuario)) {
            $usuario = array($this->user_id);
        } ?>
        <?php if ($this->is_supervisor) : ?>
            <a href="<?= base_url("informes/exportar/" . implode('-', $usuario) . "/$fechadesde/$fechahasta") ?>"
               target="_blank" class="btn btn-success">Exportar a CSV</a>
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
            $id_operador = -1;
            $id_cc = -1;
            $id_fam = -1;
            $contador = 0;
            $contador_cc = 0;
            $contador_fam = 0;
            $contador_sec = 0;
            $minutos = 0;
            $minutos_cc = 0;
            $minutos_fam = 0;
            $minutos_sec = 0;
            ?>
            <?php //if ($informe && count($informe)>0): ?>
            <?php foreach ($informe as $key => $value) : ?>
                <?php

                if (
                    $id_fam != $value['id_familia'] ||
                    $id_cc != $value['id_centrocosto'] ||
                    $id_operador != $value['id_operador']
                ) {
                    if ($id_fam != -1) {
                        echo "<tr><td colspan='7' align='right'>Total $fam ($minutos_fam minutos):</td><td>$contador_fam</td><td>Rep:</td><td>$contador_fam_rep<td>Fac:</td><td>$contador_fam_fac</td></tr>";
                    }
                    $contador_fam = 0;
                    $contador_fam_rep = 0;
                    $contador_fam_fac = 0;
                    $minutos_fam = 0;
                    $id_fam = $value['id_familia'];
                    $fam = $value['familia'];
                }

                if (
                    $id_cc != $value['id_centrocosto'] ||
                    $id_operador != $value['id_operador']
                ) {
                    if ($id_cc != -1) {
                        echo "<tr><td colspan='7' align='right'>Total $cc ($minutos_cc minutos):</td><td>$contador_cc</td><td>Rep:</td><td>$contador_cc_rep<td>Fac:</td><td>$contador_cc_fac</td></tr>";
                    }
                    $contador_cc = 0;
                    $contador_cc_rep = 0;
                    $contador_cc_fac = 0;
                    $minutos_cc = 0;
                    $id_cc = $value['id_centrocosto'];
                    $cc = $value['centrocosto'];
                }

                if ($id_operador != $value['id_operador']) {
                    if ($id_operador != -1) {
                        echo "<tr><td colspan='7' align='right'>Total operador $id_operador ($minutos minutos):</td><td>$contador</td><td>Rep:</td><td>$contador_rep<td>Fac:</td><td>$contador_fac</td></tr>";
                    }

                    $id_operador = $value['id_operador'];
                    $contador = 0;
                    $contador_fac = 0;
                    $contador_rep = 0;
                    $minutos = 0;
                }
                $contador += $value['unidades'];
                $contador_cc += $value['unidades'];
                $contador_fam += $value['unidades'];
                $minutos += $value['unidades'] * $value['duracion'];
                $minutos_cc += $value['unidades'] * $value['duracion'];
                $minutos_fam += $value['unidades'] * $value['duracion'];
                if ($value['repetido'] > 0) {
                    $contador_rep++;
                    $contador_cc_rep++;
                    $contador_fam_rep++;
                    if ($value['repetido'] = 2) {
                        $contador_fac++;
                        $contador_cc_fac++;
                        $contador_fam_fac++;
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
            echo "<tr><td colspan='7' align='right'>Total $fam ($minutos_fam minutos):</td><td>$contador_fam</td><td>Rep:</td><td>$contador_fam_rep<td>Fac:</td><td>$contador_fam_fac</td></tr>";
            echo "<tr><td colspan='7' align='right'>Total $cc ($minutos_cc minutos):</td><td>$contador_cc</td><td>Rep:</td><td>$contador_cc_rep<td>Fac:</td><td>$contador_cc_fac</td></tr>";
            echo "<tr><td colspan='7' align='right'>Total operador $id_operador ($minutos minutos):</td><td>$contador</td><td>Rep:</td><td>$contador_rep<td>Fac:</td><td>$contador_fac</td></tr>";
            ?>
        </table>
    <?php else : ?>
        <h3><?= isset($informe) ? 'No hay datos' : 'Revise los datos de la consulta y pulse en aceptar' ?></h3>
    <?php endif ?>
</div>