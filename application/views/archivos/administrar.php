<div class="row">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Ver Archivos</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary" onclick="cargar_archivos();">
                        <i class="fa fa-refresh"></i> Actualizar Lista
                    </button>
                </div>
            </div>
            <div class="box-body" id="ver_archivos">

            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Subir Archivos</h3>
            </div>
            <div class="box-body">
                <div id="DropzoneArchivos" class="dropzone txC" subir="/archivos/agregar_ajax/" eliminar="">

                </div>
                
                <!--<div subir="/archivos/agregar_ajax/">
                    <form action="/archivos/agregar_ajax/" class="dropzone" id="dropzonearch">
                        <div class="fallback">
                            <input name="file" type="file" accept="*">
                        </div>
                    </form>
                </div>-->
            </div>
        </div>
    </div>
</div>
