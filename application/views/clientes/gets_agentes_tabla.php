<table class="table table-bordered table-responsive table-striped">
    <thead>
        <tr>
            <th>Sucursal</th>
            <th>Cargo</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($agentes as $agente) { ?>
            <tr>
                <td><?= $agente['sucursal'] ?></td>
                <td><?= $agente['cargo'] ?></td>
                <td><?= $agente['agente'] ?></td>
                <td><?= $agente['email'] ?></td>
                <td><?= $agente['telefono'] ?></td>
                <td>
                    <a onclick="borrar_agente(<?= $agente['idcliente_agente'] ?>);" class="hint--top hint--bounce hint--error" aria-label="Eliminar Agente">
                        <button class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>