<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
        <?php $this->view('layout/body/header'); ?>
        <?php $this->view('layout/body/menu'); ?>
        <section class="content-wrapper">
          <?php $this->view('layout/body/breadcrumbs'); ?>
          <div class="row flex-justify-center">
            <div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 col-xl-10">
              <?php $this->view($view); ?>
            </div>
          </div>
        </section>
        <?php $this->view('layout/body/footer'); ?>
        <?php $this->view('layout/body/sidebar'); ?>
  </div>
  <?php $this->view('layout/body/scripts'); ?>
</body>
