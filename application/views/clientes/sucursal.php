<div class="" id="">

    <div class="row form-group">

        <label class="control-label col-md-3 txR">Nombre</label>

        <div class="col-md-6">

            <input type="text" id="sucursal" class="form-control" value="">

        </div>

    </div>

    <div class="row form-group">

        <label class="control-label col-md-3 txR">País</label>

        <div class="col-md-6">

            <select class="form-control chosenSelect" id="sucursal_idprovincia">

                <?php foreach($paises as $pais) { ?>

                <option value="<?=$pais[ 'idpais' ]?>"><?=$pais['pais']?></option>

                <?php } ?>

            </select>

        </div>

    </div>

    <div class="row form-group">

        <label class="control-label col-md-3 txR">Provincia</label>

        <div class="col-md-6">

            <select class="form-control chosenSelect" id="sucursal_idprovincia">

                <?php foreach($provincias as $provincia) { ?>

                <option value="<?=$provincia['idprovincia']?>"<?=($provincia['idprovincia']==$cliente['idprovincia'])?" selected":""?>><?=$provincia['provincia']?></option>

                <?php } ?>

            </select>

        </div>

    </div>

    <div class="row form-group">

        <label class="control-label col-md-3 txR">Localidad</label>

        <div class="col-md-6">

            <input type="text" id="localidad" class="form-control" value="<?=$cliente['localidad']?>" maxlength="255">

        </div>

    </div>

    <div class="row form-group">

        <label class="control-label col-md-3 txR">Código Postal</label>

        <div class="col-md-6">

            <input type="text" id="codigo_postal" class="form-control" value="<?=$cliente['codigo_postal']?>" maxlength="10">

        </div>
    </div>

</div>
