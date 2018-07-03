<div class="innerContainer main_form">
    <form method="POST">
        <h4 class="subTitleB"><i class="fa fa-dollar"></i> Moneda</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <select name="idmoneda" class="form-control chosenSelect">
                    <?php foreach ($monedas as $moneda) { ?>
                        <option value="<?= $moneda['idmoneda'] ?>"><?= $moneda['moneda'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen" id="BtnCreate"><i class="fa fa-search"></i> Buscar</button>
        </div>
    </form>
</div>

<?php var_dump($monedas) ?>