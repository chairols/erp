<?php foreach( $sucursales as $key => $sucursal ){ ?>
<div class="contenedor-sucursal" id="<?=$sucursal[ 'idcliente_sucursal' ]?>" <?php if( $key > 0 ) { ?> style="display:none;" <?php } ?> >
    <input type="hidden" id="idcliente_sucursal" value="<?=$sucursal[ 'idcliente_sucursal' ]?>">
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Nombre</label>
        <div class="col-md-6">
            <input type="text" id="sucursal_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="form-control" value="<?=$sucursal[ 'sucursal' ]?>">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">País</label>
        <div class="col-md-6">
            <select class="form-control chosenSelect" id="sucursal_idpais_<?=$sucursal[ 'idcliente_sucursal' ]?>">
                <?php foreach($paises as $pais) { ?>
                <option value="<?=$pais[ 'idpais' ]?>" <?php if( $pais[ 'idpais' ] == $sucursal[ 'idpais' ] ) echo 'selected="selected"'; ?> ><?=$pais[ 'pais' ]?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Provincia</label>
        <div class="col-md-6">
            <select class="form-control chosenSelect" id="sucursal_idprovincia_<?=$sucursal[ 'idcliente_sucursal' ]?>">
                <?php foreach($provincias as $provincia) { ?>
                <option value="<?=$provincia['idprovincia']?>"<?=($provincia['idprovincia']==$sucursal['idprovincia'])?" selected":""?>><?=$provincia['provincia']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Localidad</label>
        <div class="col-md-6">
            <input type="text" id="sucursal_localidad_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="form-control" value="<?=$sucursal[ 'localidad' ]?>" maxlength="255">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Dirección</label>
        <div class="col-md-6">
            <input type="text" id="sucursal_direccion_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="form-control" value="<?=$sucursal[ 'direccion' ]?>" maxlength="255">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Código Postal</label>
        <div class="col-md-6">
            <input type="text" id="sucursal_codigo_postal_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="form-control" value="<?=$sucursal[ 'codigo_postal' ]?>" maxlength="10">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Teléfono</label>
        <div class="col-md-6">
            <input type="text" id="sucursal_telefono_<?=$sucursal['idcliente_sucursal']?>" class="form-control" value="<?=$sucursal['telefono']?>" maxlength="255">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Transporte</label>
        <div class="col-md-6">
            <select class="form-control chosenSelect" id="sucursal_idtransporte_<?=$sucursal[ 'idcliente_sucursal' ]?>">
            <?php foreach($transportes as $transporte) { ?>
                <option value="<?=$transporte['idtransporte']?>"<?=($transporte['idtransporte']==$sucursal['idtransporte'])?" selected":""?>><?=$transporte['transporte']?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Es Casa Central</label>
        <div class="col-md-6">
                <input type="checkbox" id="sucursal_casa_central_<?=$sucursal[ 'idcliente_sucursal' ]?>" <?php if( $sucursal[ 'casa_central' ] == 'S' ) echo 'checked' ?> class="iCheckbox casaCentral" value="S">
        </div>
    </div>
    <div class="row form-group">
        <label class="control-label col-md-3 txR">Observaciones</label>
        <div class="col-md-6">
            <textarea id="sucursal_observaciones_<?=$sucursal['idcliente_sucursal']?>" class="form-control"><?=$sucursal['observaciones']?></textarea>
        </div>
    </div>
    <div class="row form-group txC">
        <div class="col-md-6 col-sm-6 col-xs-12 txR">
            <button type="button" id="modificar_sucursal_<?=$sucursal[ 'idcliente_sucursal' ]?>" sucursal="<?=$sucursal[ 'idcliente_sucursal' ]?>" class="modificarSucursal btn btn-primary">Modificar</button>
            <button type="button" id="modificar_sucursal_loading_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 txL">
            <button type="button" id="eliminar_sucursal_<?=$sucursal[ 'idcliente_sucursal' ]?>" sucursal="<?=$sucursal[ 'idcliente_sucursal' ]?>" class="eliminarSucursal btn btn-danger">Eliminar</button>
            <button type="button" id="eliminar_sucursalr_loading_<?=$sucursal[ 'idcliente_sucursal' ]?>" class="eliminarSucursal btn btn-danger" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
        </div>
    </div>
</div>
<?php } ?>