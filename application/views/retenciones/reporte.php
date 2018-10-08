<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="row form-group inline-form-custom">
            <div class="col-xs-4">
                <select id="idjurisdiccion" class="form-control chosenSelect">
                    <?php foreach($provincias as $provincia) { ?>
                    <option value="<?=$provincia['idjurisdiccion_afip']?>"><?=$provincia['idjurisdiccion_afip']?> - <?=$provincia['provincia']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-xs-3">
                <input type="text" id="fecha_desde" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
            </div>
            <div class="col-xs-3">
                <input type="text" id="fecha_hasta" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
            </div>
            <div class="col-xs-2">
                <button class="form-control btn btn-primary" id="buscar">Buscar</button>
            </div>
        </div>
        <div id="resultado">
            
        </div>
    </div>
</div>