<div class="innerContainer">
    <h4 class="subTitleB"><i class="fa fa-map-signs"></i> Provincia</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <select class="chosenSelect form-control" id="provincia">
                <?php foreach ($provincias as $provincia) { ?>
                <option value="<?=$provincia['idprovincia']?>"><?=$provincia['provincia']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <h4 class="subTitleB"><i class="fa fa-slack"></i> ID Jurisdicción AFIP</h4>
    <div class="row form-group inline-form-custom">
        <div class="col-xs-12">
            <input type="text" id="idjurisdiccion" class="form-control inputMask" data-inputmask="'mask': '999'" autofocus>
        </div>
    </div>
    <div class="row txC">
        <button type="button" class="btn btn-success btnGreen" id="agregar"><i class="fa fa-plus"></i> Agregar Jurisdicción</button>
    </div>
</div>