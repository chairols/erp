        
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu">
                  <?php foreach ($menu['menu'] as $m1) { ?>
                      <li class="<?= (count($m1['submenu']) > 0) ? "treeview " : "" ?><?= ($m1['active'] == 1) ? "active" : "" ?>">
                          <a href="<?= $m1['href'] ?>">
                              <i class="<?= $m1['icono'] ?>"></i>
                              <span><?= $m1['titulo'] ?></span>
                              <?php if (count($m1['submenu']) > 0) { ?>
                                  <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                  </span>
                              <?php } ?>
                          </a>
                          <!-- Comienza el segundo nivel del menú -->
                          <?php if (count($m1['submenu']) > 0) { ?>
                              <ul class="treeview-menu">
                                  <?php foreach ($m1['submenu'] as $m2) { ?>
                                      <li class="<?= ($m2['active'] == 1) ? "active" : "" ?>">
                                          <a href="<?= $m2['href'] ?>">
                                              <i class="<?= $m2['icono'] ?>"></i>
                                              <span><?= $m2['titulo'] ?></span>
                                              <?php if (count($m2['submenu']) > 0) { ?>
                                                  <span class="pull-right-container">
                                                      <i class="fa fa-angle-left pull-right"></i>
                                                  </span>
                                              <?php } ?>
                                          </a>
                                          <!-- Comienza el tercer nivel del menú -->
                                          <?php if (count($m2['submenu']) > 0) { ?>
                                              <ul class="treeview-menu">
                                                  <?php foreach ($m2['submenu'] as $m3) { ?>
                                                      <li class="<?= ($m3['active'] == 1) ? "active" : "" ?>">
                                                          <a href="<?= $m3['href'] ?>">
                                                              <i class="<?= $m3['icono'] ?>"></i>
                                                              <span><?= $m3['titulo'] ?></span>
                                                          </a>
                                                      </li>
                                                  <?php } ?>
                                              </ul>
                                          <?php } ?>
                                      </li>
                                  <?php } ?>
                              </ul>
                          <?php } ?>
                      </li>
                  <?php } ?>
              </ul>
          </section>
          <!-- /.sidebar -->
      </aside>
