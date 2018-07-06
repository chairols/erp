<div class="innerContainer">
    <form method="POST" confirmacion="¿Desea confirmar el pedido?">
        <h4 class="subTitleB"><i class="fa fa-building"></i> Proveedor</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" id="proveedor" name="proveedor" value="<?= $confirmacion['empresa'] ?>" class="form-control" disabled>
                <input type="hidden" id="idempresa" value="<?=$confirmacion['idempresa']?>">
            </div>
        </div>
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Confirmación</h4>
        <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
                <input type="text" id="fecha_confirmacion" name="fecha_confirmacion" value="<?= date('d/m/Y') ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha" disabled>
            </div>
        </div>
        <input type="hidden" id="idimportacion_confirmacion" value="<?= $confirmacion['idimportacion_confirmacion'] ?>">
    </form>
</div>

<div class="innerContainer">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Pendientes de Confirmación - Backorder</h3>
                </div>
                <div id="items_backorder">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Items Confirmados</h3>
                </div>
                <div class="box-body">
                    <div id="items_confirmados"></div>
                </div>
            </div>

        </div>
    </div>
</div>