<div class="box box-primary">
    <div class="box-header">
        <div class="input-group input-group-sm col-md-12">
            <div class="row">
                <div class="form-group col-md-3">
                    <input class="form-control" name="articulo" id="articulo" placeholder="Artículo" type="text" value="<?= $this->input->get('articulo') ?>">
                </div>
                <div class="form-group col-md-2">
                    <input class="form-control" name="numero_orden" id="numero_orden" placeholder="Número de Orden" type="text" value="<?= $this->input->get('numero_orden') ?>">
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control chosenSelect" name="idmarca" id="idmarca">
                        <option value="">--- Todas ---</option>
                        <?php foreach($marcas as $marca) { ?>
                        <option value="<?=$marca['idmarca']?>"<?=($marca['idmarca']==$this->input->get('idmarca'))?" selected":""?>><?=$marca['marca']?></option>
                        <?php } ?>
                    </select>
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
                    <button type="button" id="buscar" class="btn btn-primary">Buscar</button>
                </div>
                
            </div>
        </div>
    </div>
    <div class="box-body">
        <div id="resultado">
            
        </div>
    </div>
</div>