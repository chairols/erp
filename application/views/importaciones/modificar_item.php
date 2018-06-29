<div class="innerContainer">
    <div class="row txL">
        <a href="/importaciones/agregar_items/<?=$item['idimportacion']?>">
            <button type="button" class="btn btn-success btnGreen"><< Volver al Pedido</button>
        </a>
    </div>
    <form method="POST">
        <h4 class="subTitleB"><i class="fa fa-cubes"></i> Artículo</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <!-- Autocomplete Artículos -->
                <input type="text" value="<?=$articulo['articulo']?> - <?=$articulo['marca']['marca']?>" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Artículo" placeholderauto="Artículo inexistente" class="form-control TextAutoComplete" validateEmpty="Seleccione un artículo." objectauto="articulos" actionauto="gets_articulos_ajax" varsauto="estado:=A" iconauto="cube" required autofocus>
                <input type="hidden" id="articulo" name="idarticulo" value="<?=$articulo['idarticulo']?>">
            </div>
        </div>
        
        <h4 class="subTitleB"><i class="fa fa-cubes"></i> Cantidad</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input value="<?=$item['cantidad']?>" type="text" name="cantidad" placeholder="Cantidad" class="form-control" required>
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-usd"></i> Costo FOB</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input value="<?=$item['costo_fob']?>" type="text" name="costo_fob" placeholder="Costo FOB" class="form-control" required>
            </div>
        </div>
        <div class="row txC">
            <button type="submit" class="btn btn-success btnGreen"><i class="fa fa-edit"></i> Modificar Item</button>
        </div>
    </form>
</div>