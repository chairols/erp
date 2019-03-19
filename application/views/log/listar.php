<div class="box box-primary">
    <div class="box-header">
        <form class="row form-group inline-form-custom" method="GET" action="/log/listar/">
            <div class="col-xs-3">
                <label>Usuarios</label>
                <select name="idusuario" id="idusuario" class="form-control chosenSelect">
                    <option value="">Todos los usuarios</option>
                    <?php foreach($usuarios as $usuario) { ?>
                    <option value="<?=$usuario['idusuario']?>"<?=($this->input->get('idusuario')==$usuario['idusuario'])?" selected":""?>><?=$usuario['nombre']?> <?=$usuario['apellido']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-xs-3">
                <label>Tabla</label>
                <select name="idtabla" id="idtabla" class="form-control chosenSelect">
                    <option value="">Todos los movimientos</option>
                    <?php foreach($tablas as $tabla) { ?>
                    <option value="<?=$tabla['tabla']?>"<?=($this->input->get('idtabla')==$tabla['tabla'])?" selected":""?>><?=$tabla['tabla']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-xs-2">
                <label>&nbsp;</label>
                <button type="submit" class="form-control btn btn-primary" id="buscar">Buscar</button>
            </div>
            
            
        </form>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
    <div class="box-body">
        <div class="tab-pane" id="timeline">
            <ul class="timeline timeline-inverse">
                <?php foreach($registros as $registro) { ?>
                <li class="time-label">
                    <span class="bg-red">
                        <?= substr($registro['fecha'], 0, 10)?>
                    </span>
                </li>
                <li>
                    <?php switch ($registro['tipo']) {
                            case 'add': ?>
                    <i class="fa fa-plus bg-green"></i>
                        <?php

                                break;
                            case 'edit': ?>
                    <i class="fa fa-edit bg-yellow"></i>
                        <?php
                                break;
                            case 'del': ?>
                    <i class="fa fa-remove bg-red"></i>
                        <?php
                                break;
                        } ?>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=substr($registro['fecha'], 11, 8)?></span>
                        
                        <h3 class="timeline-header"><?=$registro['nombre']?> <?=$registro['apellido']?></h3>
                        
                        <div class="timeline-body">
                            <?=$registro['texto']?>
                        </div>
                    </div>
                    <?php } ?>
                </li>
                
            </ul>
        </div>
    </div>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?= $total_rows ?> registros.</strong>
        </div>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
</div>