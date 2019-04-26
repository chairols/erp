<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">Agregar Cuenta al Plan</h3>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">Número</label>
                <div class="col-sm-6">
                    <input type="text" id="idplan_de_cuenta" class="form-control input-sm inputMask" data-inputmask="'mask': '9{6,6}'" autofocus="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Cuenta</label>
                <div class="col-sm-6">
                    <input id="plan_de_cuenta" class="form-control" type="text" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Depende de </label>
                <div class="col-sm-6">
                    <input type="text" id="TextAutoCompleteplan" name="TextAutoCompleteplan" placeholder="Cuenta Padre" placeholderauto="Cuenta inexistente" class="form-control TextAutoComplete" value="" objectauto="plan_de_cuentas" actionauto="gets_cuentas_json" varsauto="estado:=A" iconauto="" autofocus="">
                    <input type="hidden" id="plan" name="plan" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Imputa Caja</label>
                <div class="col-sm-6">
                    <select class="form-control chosenSelect" id="imputa_caja">
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Imputa Mayor</label>
                <div class="col-sm-6">
                    <select class="form-control chosenSelect" id="imputa_mayor">
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Cuenta Corriente</label>
                <div class="col-sm-6">
                    <select class="form-control chosenSelect" id="cuenta_corriente">
                        <option value="">-- Vacío --</option>
                        <option value="B">B</option>
                        <option value="G">G</option>
                        <option value="I">I</option>
                        <option value="P">P</option>
                        <option value="S">S</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Ajuste</label>
                <div class="col-sm-6">
                    <select class="form-control chosenSelect" id="ajuste">
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="agregar">Agregar Cuenta</button>
                <button class="btn btn-primary" id="agregar_loading" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>