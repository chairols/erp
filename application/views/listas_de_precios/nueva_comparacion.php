<div class="box box-primary">
    <div class="box-header flex-justify-center">
        <div class="col-md-6">
            <div class="innerContainer">
                <h4 class="subTitleB">
                    <i class="fa fa-braille"></i> Detalles de la Comparación
                </h4>
                <div class="row form-group inline-form-custom">
                    <div class="col-xs-12 col-sm-12">
                        Proveedores con Lista de Precios
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <select id="proveedores" multiple="" class="form-control chosenSelect">
                            <?php foreach($proveedores as $proveedor) { ?>
                            <option value="<?=$proveedor['idproveedor']?>"><?=$proveedor['proveedor']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group inline-form-custom">
                    <div class="col-xs-12 col-sm-12">
                        Marcas:
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <select id="marcas" multiple="" class="form-control chosenSelect">
                            <?php foreach($marcas as $marca) { ?>
                            <option value="<?=$marca['idmarca']?>"><?=$marca['marca']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="txC">
                    <button id="comparar" class="btn btn-primary btn-success" type="button">
                        <i class="fa fa-copy"></i> Comparar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>