<div class="box box-primary">
    <div class="box-header">
        <form method="GET" action="/articulos/listar/" class="input-group input-group-sm col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <input class="form-control" name="articulo" id="articulo" placeholder="Artículo" type="text" value="<?= $this->input->get('articulo') ?>">
                </div>
                <div class="form-group col-md-4">
                    <input class="form-control" name="numero_orden" id="numero_orden" placeholder="Número de Orden" type="text" value="<?= $this->input->get('numero_orden') ?>">
                </div>
                <div class="col-md-4">
                    <div class="box-tools">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <?= $links ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <select class="form-control chosenSelect" name="idlinea" id="idlinea">
                        <option value="">--- Todas ---</option>
                        <?php foreach ($lineas as $linea) { ?>
                            <option value="<?= $linea['idlinea'] ?>"<?= ($linea['idlinea'] == $this->input->get('idlinea')) ? " selected" : "" ?>><?= $linea['linea'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control chosenSelect" name="stock" id="stock">
                        <option value=""<?=($this->input->get('stock')=="")?" selected":""?>>--- Todos ---</option>
                        <option value="S"<?=($this->input->get('stock')=="S")?" selected":""?>>Con Stock</option>
                        <option value="N"<?=($this->input->get('stock')=="N")?" selected":""?>>Sin Stock</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control chosenSelect" name="precio" id="precio">
                        <option value=""<?=($this->input->get('precio')=="")?" selected":""?>>--- Todos ---</option>
                        <option value="S"<?=($this->input->get('precio')=="S")?" selected":""?>>Con Precio</option>
                        <option value="N"<?=($this->input->get('precio')=="N")?" selected":""?>>Sin Precio</option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                
            </div>
        </form>
    </div>
    <div class="box-body no-padding">
        <table class="table table-hover table-responsive table-striped">
            <thead>
                <tr>
                    <th>Línea</th>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Estantería</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articulos as $articulo) { ?>
                    <tr>
                        <td><?= $articulo['linea'] ?></td>
                        <td><?= $articulo['articulo'] ?></td>
                        <td>
                            <?php if(strlen($articulo['color_fondo']) && strlen($articulo['color_letra'])) { ?>
                            <span class="badge" style="background-color: <?=$articulo['color_fondo']?>; color: <?=$articulo['color_letra']?>"><?=$articulo['marca']?></span>
                            <?php } else { ?>
                            <span class="badge"><?=$articulo['marca']?></span>
                            <?php } ?>
                        </td>
                        <td class="text-right">
                            <span class="badge <?= ($articulo['stock'] > 0) ? "bg-green" : "bg-red" ?>">
                                <?= $articulo['stock'] ?>
                            </span>
                        </td>
                        <td class="text-right">
                            <span class="badge <?=($articulo['precio'] > 0)?"bg-green":"bg-red"?>">
                                <?=number_format($articulo['precio'], 2)?>
                            </span>
                        </td>
                        <td class="text-right">
                            <span class="badge bg-purple"><?=$articulo['rack']?></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?= $total_rows ?> registros.</strong>
        </div>
        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?= $links ?>
            </ul>
        </div>
    </div>
</div>
