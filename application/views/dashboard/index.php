<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon">
                <i class="fa fa-money"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Dolar AFIP</span>
                <span class="info-box-number"><?=$dolar['valor']?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description"><?=$dolar['fecha']?></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon">
                <i class="fa fa-dollar"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Corrección</span>
                <span class="info-box-number"><?=$parametro['factor_correccion']?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description"></span>
            </div>
        </div>
    </div>
</div>
    <pre>
        <?php var_dump($session); ?>
    </pre>
    
