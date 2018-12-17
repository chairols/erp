<table class="table table-condensed table-striped table-hover table-responsive table-bordered">
    <thead>
        <tr>
            <th>Archivo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($archivos as $archivo) { ?>
        <tr>
            <td><?=$archivo['nombre']?></td>
            <td>
                <a href="<?=$archivo['url']?>" target="_blank" class="hint--top hint--bounce hint--info" aria-label="Descargar">
                    <button class="btn btn-primary btn-xs" type="button">
                        <i class="fa fa-download"></i>
                    </button>
                </a>
                <a href="#" class="hint--top hint--bounce hint--error" aria-label="Eliminar">
                    <button class="btn btn-danger btn-xs" type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>