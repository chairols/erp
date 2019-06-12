<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title"><?= $title ?></h3>
        <div class="box-tools pull-right">
            <button class="button btn bg-orange" id="comenzar">Comenzar Optimización</button>
            <button class="button btn bg-orange" id="comenzar_loading" style="display: none;">
                <i class="fa fa-refresh fa-spin"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover table-striped table-responsive">
            <thead>
                <tr>
                    <th>Tabla</th>
                    <th>Proceso</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr id="tr_proceso_1">
                    <td>Listas de Precios</td>
                    <td>Artículos Sin Asociar</td>
                    <td id="articulos_sin_asociar"></td>
                </tr>
                <tr id="tr_proceso_2">
                    <td>Listas de Precios</td>
                    <td>Artículos Duplicados</td>
                    <td id="articulos_duplicados"></td>
                </tr>
                <tr id="tr_proceso_3">
                    <td>Listas de Precios</td>
                    <td>Optimizar Base de Datos</td>
                    <td id="optimizar_base_de_datos"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>