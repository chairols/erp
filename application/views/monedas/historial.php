<div class="innerContainer">
    <h4 class="subTitleB"><i class="fa fa-dollar"></i> Moneda</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select name="moneda" id="moneda" class="form-control chosenSelect">
                <?php foreach ($monedas as $moneda) { ?>
                    <option value="<?= $moneda['idmoneda'] ?>"><?= $moneda['moneda'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-6">
            <h4 class="subTitleB"><i class="fa fa-calendar"></i> Desde</h4>
            <input type="text" id="desde" name="desde" value="<?= date('d/m/Y') ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
        </div>
        <div class="col-xs-6">
            <h4 class="subTitleB"><i class="fa fa-calendar"></i> Hasta</h4>
            <input type="text" id="hasta" name="hasta" value="<?= date('d/m/Y') ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
        </div>
    </div>
    <hr>
    <div class="row txC">
        <button type="button" class="btn btn-success btnGreen" id="buscar"><i class="fa fa-search"></i> Buscar</button>
    </div>
</div>


<div class="innerContainer">
    <div class="row">
        <div class="col-xs-6">
            <div id="grafico"></div>
        </div>
        <div class="col-xs-6">
            <div id="tabla"></div>
        </div>
    </div>
</div>

