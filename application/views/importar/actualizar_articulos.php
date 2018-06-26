<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-md-3">Seleccionar Archivo</label>
                    <div class="col-md-6">
                        <select class="form-control chosenSelect" name="archivo">
                            <?php foreach($archivos as $archivo) { ?>
                            <option value="<?=$archivo['name']?>"><?=$archivo['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Procesar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>