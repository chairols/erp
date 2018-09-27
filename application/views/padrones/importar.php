<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Jurisdicción</label>
                <div class="col-md-6">
                    <select name="jurisdiccion" id="jurisdiccion" class="form-control chosenSelect">
                        <?php foreach ($jurisdicciones as $jurisdiccion) { ?>
                            <option value="<?= $jurisdiccion['idjurisdiccion_afip'] ?>"><?= $jurisdiccion['idjurisdiccion_afip'] ?> - <?= $jurisdiccion['provincia'] ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Archivo</label>
                <div class="col-md-6">
                    <select name="archivo" id="archivo" class="form-control chosenSelect">
                        <?php
                        while ($archivo = readdir($archivos)) {
                            $flag = false;
                            if ($archivo != '.' && $archivo != '..') {
                                $flag = true;
                            }
                            ?>
                            <?php if ($flag) { ?>
                                <option value="<?= $archivo ?>"><?= $archivo ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" id="procesar">
                    <button type="button" id="agregar" class="btn btn-primary">Procesar</button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" id="procesar_loading" style="display: none;">
                    <button type="button" id="agregar_loading" class="btn btn-primary"><i class="fa fa-refresh fa-spin"></i> Procesar</button>
                </div>
            </div>
        </div>
    </div>
</div>