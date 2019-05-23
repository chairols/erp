<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Empleado</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idempleado">
                        <?php foreach($empleados as $empleado) { ?>
                        <option value="<?=$empleado['idempleado']?>"><?=$empleado['nombre']?> <?=$empleado['apellido']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Período</label>
                <div class="col-md-3">
                    <select class="form-control chosenSelect" id="mes">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="anio" class="form-control inputMask" data-inputmask="'mask' : '9{4,4}'" value="<?=date("Y")?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Presentismo</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="presentismo">
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Pago Préstamo</label>
                <div class="col-md-6">
                    <input type="text" id="prestamo" class="form-control inputMask" data-inputmask="'mask': '[-]9{1,17}.99'" value="0.00">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
