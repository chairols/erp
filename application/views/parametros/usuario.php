<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <form method="POST" class="form-horizontal">
                <?php foreach ($parametros as $parametro) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3"><?= $parametro['parametro'] ?></label>
                        <div class="col-md-6">
                            <input type="text" maxlength="100" class="form-control" name="id-<?= $parametro['idparametro'] ?>" value="<?= $parametro['valor'] ?>">
                        </div>
                    </div>
                <?php } ?>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
</div>