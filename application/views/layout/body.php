<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
        <?php $this->view('layout/body/header'); ?>
        <?php $this->view('layout/body/menu'); ?>
        <section class="content-wrapper">
          <?php $this->view('layout/body/breadcrumbs'); ?>
          <div class="row">
            <div class="col-xs-12 col-xs-offset-0 col-sm-11 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 col-xl-8 col-xl-offset-2">
              <?php $this->view($view); ?>
            </div>
          </div>
        </section>
        <?php $this->view('layout/body/footer'); ?>
        <?php $this->view('layout/body/sidebar'); ?>
  </div>
  <?php $this->view('layout/body/scripts'); ?>
</body>
