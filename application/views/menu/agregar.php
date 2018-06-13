<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <form method="POST" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3">Ícono</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="50" class="form-control" id="icono" name="icono" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Menú</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="50" class="form-control" id="menu" name="menu">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Link</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="50" class="form-control" id="href" name="href" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Orden</label>
                    <div class="col-md-6">
                        <input type="number" maxlength="11" class="form-control" id="orden" name="orden" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Padre</label>
                    <div class="col-md-6">
                        <select name="padre" class="form-control chosenSelect">
                            <option value="0" selected>--- No tiene ---</option>
                            <?php foreach ($padres as $padre) { ?>
                                <option value="<?= $padre['idmenu'] ?>"><?= $padre['titulo'] ?></option>
                                <?php foreach ($padre['hijos'] as $hijo) { ?>
                                    <option value="<?= $hijo['idmenu'] ?>">↳ <?= $padre['titulo'] ?> → <?= $hijo['titulo'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Visible</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="checkbox" class="icheckbox_minimal-blue" name="visible">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Agregar</button>
                        <button type="reset" class="btn btn-primary">Limpiar</button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
</div>