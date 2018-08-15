<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body flex-justify-center">
        <div class="col-md-8 col-sm-6 col-xs-12">
            <div class="innerContainer">
                <h4 class="subTitleB">
                    <i class="fa fa-certificate"></i> <?= $title ?>
                </h4>
                <div class="form-group">
                    Línea:
                    <input type="text" id="TextAutoCompletelinea" name="TextAutoCompletelinea" placeholder="Seleccionar Línea" placeholderauto="Línea Inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione una línea" objectauto="Lineas" actionauto="gets_lineas_ajax" varsauto="estado:=A" iconauto="ship">
                    <input type="hidden" id="linea" name="linea" value="">
                </div>
                <div class="form-group">
                    Código: 
                    <input id="articulo_generico" class="form-control" name="articulo_generico" validateempty="Ingrese un código" type="text">
                </div>
                <hr>
                <div class="form-group">
                    Asociar Código:
                    <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Seleccionar Artículo" placeholderauto="Artículo Inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un artículo" objectauto="Articulos" actionauto="gets_articulos_ajax" varsauto="estado:=A" iconauto="ship">
                    <input type="hidden" id="articulo" name="articulo" value="">
                </div>
            </div>
        </div>
    </div>
</div>

