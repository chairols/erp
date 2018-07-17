<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-trademark"></i> Marcas Relacionadas con el Proveedor
        </h3>
    </div>
    <form method="POST">
        <div class="box-body">
            <?php foreach ($marcas_lista as $marca_lista) { ?>
                <div class="row">
                    <div class="col-xs-5 col-sm-2 text-right"></div>
                    <div class="col-xs-5 col-sm-2 text-right">
                        <?= $marca_lista['marca_lista'] ?> <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="col-xs-5 col-sm-3 text-left">
                        <select id="<?=$marca_lista['marca_lista']?>" name="<?= $marca_lista['marca_lista'] ?>" class="form-control chosenSelect">
                            <?php foreach ($marcas as $marca) { ?>
                                <option value="<?= $marca['idmarca'] ?>"<?= ($marca_lista['marca_lista'] == $marca['marca']) ? " selected" : "" ?>><?= $marca['marca'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>
        <div class="box-footer txC">
            <button class="btn btn-success" type="submit">Continuar <i class="fa fa-arrow-right"></i></button>
        </div>
    </form>
</div>