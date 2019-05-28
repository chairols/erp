<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">Datos del Empleado</h3>
        <input type="hidden" id="idsueldo" value="<?=$sueldo['idsueldo']?>">
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Empleado</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?=$sueldo['empleado']?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Período</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?=$sueldo['periodo_mes']?>/<?=$sueldo['periodo_anio']?>" disabled="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">Conceptos</h3>
    </div>
    <div class="box-body">
        <div id="items">
            
        </div>
    </div>
</div>