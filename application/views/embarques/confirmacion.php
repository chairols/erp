<div class="innerContainer main_form">
    <form method="POST">
        <h4 class="subTitleB"><i class="fa fa-ship"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <select name="proveedor" class="form-control chosenSelect">
                    <?php foreach($empresas as $empresa) { ?>
                    <option value="<?=$empresa['idproveedor']?>"><?=$empresa['empresa']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>
</div>

<?php var_dump($empresas); ?>