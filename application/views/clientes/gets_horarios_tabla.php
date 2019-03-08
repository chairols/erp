<table class="table table-bordered table-responsive table-striped">
    <thead>
        <tr>
            <th>Día</th>
            <th>Horario</th>
            <th>Tipo</th>
            <th>Observaciones</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($horarios as $horario) { ?>
            <tr>
                <td><?= $horario['dia'] ?></td>
                <td><?= $horario['desde'] ?> - <?= $horario['hasta'] ?></td>
                <td><?= $horario['tipo_horario'] ?></td>
                <td><?= $horario['observaciones'] ?></td>
                <td>
                    <a onclick="borrar_horario(<?= $horario['idcliente_horario'] ?>);" class="hint--top hint--bounce hint--error" aria-label="Eliminar Horario">
                        <button class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>