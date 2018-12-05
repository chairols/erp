<div class="box box-primary">
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <input type="hidden" id="idproveedor" value="<?=$proveedor['idproveedor']?>">
            <div class="form-group">
                <label class="control-label col-md-3">Proveedor</label>
                <div class="col-md-6">
                    <input type="text" id="proveedor" class="form-control" value="<?=$proveedor['proveedor']?>" maxlength="255" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">CUIT</label>
                <div class="col-md-6">
                    <input type="text" id="cuit" class="form-control inputMask" value="<?=$proveedor['cuit']?>" data-inputmask="'mask': '99-99999999-9'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Domicilio</label>
                <div class="col-md-6">
                    <input type="text" id="domicilio" class="form-control" value="<?=$proveedor['domicilio']?>" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Código Postal</label>
                <div class="col-md-6">
                    <input type="text" id="codigo_postal" class="form-control" value="<?=$proveedor['codigo_postal']?>" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Localidad</label>
                <div class="col-md-6">
                    <input type="text" id="localidad" class="form-control" value="<?=$proveedor['localidad']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Provincia</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idprovincia">
                        <?php foreach($provincias as $provincia) { ?>
                        <option value="<?=$provincia['idprovincia']?>"<?=($provincia['idprovincia']==$proveedor['idprovincia'])?" selected":""?>><?=$provincia['provincia']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">País</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idpais">
                        <?php foreach($paises as $pais) { ?>
                        <option value="<?=$pais['idpais']?>"<?=($pais['idpais']==$proveedor['idpais'])?" selected":""?>><?=$pais['pais']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Teléfono</label>
                <div class="col-md-6">
                    <input type="text" id="telefono" class="form-control" value="<?=$proveedor['telefono']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">E-Mail</label>
                <div class="col-md-6">
                    <input type="text" id="email" class="form-control" value="<?=$proveedor['email']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Contacto</label>
                <div class="col-md-6">
                    <input type="text" id="contacto" class="form-control" value="<?=$proveedor['contacto']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Tipo de IVA</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idtipo_responsable">
                        <?php foreach($tipos_responsables as $tipo_responsable) { ?>
                        <option value="<?=$tipo_responsable['idtipo_responsable']?>"<?=($tipo_responsable['idtipo_responsable']==$proveedor['idtipo_responsable'])?" selected":""?>><?=$tipo_responsable['tipo_responsable']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Ingresos Brutos</label>
                <div class="col-md-6">
                    <input type="text" id="iibb" class="form-control" value="<?=$proveedor['iibb']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">VAT</label>
                <div class="col-md-6">
                    <input type="text" id="vat" class="form-control" value="<?=$proveedor['vat']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Saldo Cuenta Corriente</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_cuenta_corriente" class="form-control inputMask" value="<?=$proveedor['saldo_cuenta_corriente']?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Saldo Inicial</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_inicial" class="form-control inputMask" value="<?=$proveedor['saldo_inicial']?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Saldo a Cuenta</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_a_cuenta" class="form-control inputMask" value="<?=$proveedor['saldo_a_cuenta']?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idmoneda">
                        <?php foreach($monedas as $moneda) { ?>
                        <option value="<?=$moneda['idmoneda']?>"<?=($moneda['idmoneda']==$proveedor['idmoneda'])?" selected":""?>><?=$moneda['moneda']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sitio Web</label>
                <div class="col-md-6">
                    <input type="text" id="web" class="form-control" value="<?=$proveedor['web']?>" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea class="form-control" id="observaciones"><?=$proveedor['observaciones']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Estado</label>
                <div class="col-md-6">
                    <?php if($proveedor['estado'] == 'A') { ?>
                    <span class="label label-success">ACTIVO</span>
                    <?php } else { ?>
                    <span class="label label-danger">INACTIVO</span>
                    <?php } ?>
                </div>
            </div>
            
            
            
            
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="modificar" class="btn btn-primary">Modificar</button>
                    <button type="button" id="modificar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>