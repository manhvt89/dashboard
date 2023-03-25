<?php 
	$cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2);
?>  


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('admin/dashboard'); ?>" class="brand-link">
    <img src="<?= base_url($this->general_settings['favicon']); ?>" alt="Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $this->general_settings['application_name']; ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= ucwords($this->session->userdata('username')); ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
			<?php if($this->session->userdata('role_id') == 2): ?>		 
        <?php 
          $menu = get_sidebar_menu(); 

          foreach ($menu as $nav):

            $sub_menu = get_sidebar_sub_menu($nav['id']);

            $has_submenu = (count($sub_menu) > 0) ? true : false;
        ?>

        <?php if($this->rbac->check_module_permission($nav['controller_name'])): ?> 

        <li id="<?= ($nav['controller_name']) ?>" class="nav-item <?= ($has_submenu) ? 'has-treeview' : '' ?> has-treeview">

          <a href="<?= base_url('admin/'.$nav['controller_name']) ?>" class="nav-link">
            <i class="nav-icon fa <?= $nav['fa_icon'] ?>"></i>
            <p>
              <?= trans($nav['module_name']) ?>
              <?= ($has_submenu) ? '<i class="right fa fa-angle-left"></i>' : '' ?>
            </p>
          </a>

          <!-- sub-menu -->
          <?php 
            if($has_submenu): 
          ?>
          <ul class="nav nav-treeview">

            <?php foreach($sub_menu as $sub_nav): ?>

            <li class="nav-item">
              <a href="<?= base_url('admin/'.$nav['controller_name'].'/'.$sub_nav['link']); ?>" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p><?= trans($sub_nav['name']) ?></p>
              </a>
            </li>

            <?php endforeach; ?>
           
          </ul>
          <?php endif; ?>
          <!-- /sub-menu -->
        </li>

        <?php endif; ?>

        <?php endforeach; ?>

        <li class="nav-header"><?= trans('miscellaneous') ?></li>
        <li class="nav-item">
          <a href="https://adminlte.io/docs" class="nav-link">
            <i class="nav-icon fa fa-file"></i>
            <p><?= trans('documentation') ?></p>
          </a>
        </li>
				<?php elseif($this->session->userdata('admin_role_id') == 2):?>
					<li id="dashboard_index" class="nav-item">
						<a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
							<i class="nav-icon fa fa-home"></i>
							<p><?= trans('home') ?></p>
						</a>
					</li>
					<!-- Quản lý tài khoản-->
					<li class="nav-header"><?= trans('manage_user') ?></li>
					<li id="admin_index" class="nav-item">
						<a href="<?= base_url('admin/admin/index')?>" class="nav-link">
							<i class="nav-icon fa fa-server"></i>
							<p><?= trans('list_user') ?></p>
						</a>
					</li>
					<li id="admin_add" class="nav-item">
						<a href="<?= base_url('admin/admin/add')?>" class="nav-link">
							<i class="nav-icon fa fa-recycle"></i>
							<p><?= trans('create_new_admin') ?></p>
						</a>
					</li>
					<!-- hết quản lý tài khoản -->
					<!-- Quản lý doanh nghiệp-->
					<li class="nav-header"><?= trans('manage_company') ?></li>
					<li id="company_index" class="nav-item">
						<a href="<?= base_url('admin/company/index')?>" class="nav-link">
							<i class="nav-icon fa fa-server"></i>
							<p><?= trans('list_company') ?></p>
						</a>
					</li>
					<li id="company_add" class="nav-item">
						<a href="<?= base_url('admin/company/add')?>" class="nav-link">
							<i class="nav-icon fa fa-recycle"></i>
							<p><?= trans('create_new_company') ?></p>
						</a>
					</li>
					<!-- hết quản lý doanh nghiệp -->
					<!-- Quản lý đánh giá-->
					<li class="nav-header"><?= trans('manage_assessment') ?></li>
					<li id="campaign_index" class="nav-item">
						<a href="<?= base_url('admin/campaign/index')?>" class="nav-link">
							<i class="nav-icon fa fa-money"></i>
							<p><?= trans('list_campaign') ?></p>
						</a>
					</li>
					<!-- Hết quản lý đánh giá-->
					<!-- Quản lý Biểu mẫu-->
					<li class="nav-header"><?= trans('manage_form') ?></li>
					<li id="assessment_index" class="nav-item">
						<a href="<?= base_url('admin/assessment/index')?>" class="nav-link">
							<i class="nav-icon fa fa-money"></i>
							<p><?= trans('list_assessment') ?></p>
						</a>
					</li>
					<!-- Hết lý Biểu mẫu-->
					<!-- Quản lý tài khoản-->
					<li class="nav-header"><?= trans('manage_account') ?></li>
					<li id="profile_index" class="nav-item">
						<a href="<?= base_url('admin/profile/')?>" class="nav-link">
							<i class="nav-icon fa fa-user"></i>
							<p><?= trans('profile_account') ?></p>
						</a>
					</li>
					<li id="profile_change_pwd" class="nav-item">
						<a href="<?= base_url('admin/profile/change_pwd')?>" class="nav-link">
							<i class="nav-icon fa fa-key"></i>
							<p><?= trans('change_password') ?></p>
						</a>
					</li>

        <?php elseif($this->session->userdata('admin_role_id') == 6):?>

					<li id="dashboard_index" class="nav-item">
						<a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
							<i class="nav-icon fa fa-home"></i>
							<p><?= trans('home') ?></p>
						</a>
					</li>
					<!-- Quản lý doanh nghiệp-->
					<li class="nav-header"><?= trans('manage_company') ?></li>
					<li id="company_index" class="nav-item">
						<a href="<?= base_url('admin/company/index')?>" class="nav-link">
							<i class="nav-icon fa fa-server"></i>
							<p><?= trans('list_company') ?></p>
						</a>
					</li>
					<!-- hết quản lý doanh nghiệp -->
					<!-- Quản lý đánh giá-->
					<li class="nav-header"><?= trans('manage_assessment') ?></li>
					<li id="campaign_index" class="nav-item">
						<a href="<?= base_url('admin/campaign/index')?>" class="nav-link">
							<i class="nav-icon fa fa-check"></i>
							<p><?= trans('list_campaign') ?></p>
						</a>
					</li>
					<!-- Hết quản lý đánh giá-->
					<!-- Quản lý Biểu mẫu-->
					<!--
					<li class="nav-header"><?= trans('manage_form') ?></li>
					<li id="assessment_index" class="nav-item">
						<a href="<?= base_url('admin/assessment/index')?>" class="nav-link">
							<i class="nav-icon fa fa-wpforms"></i>
							<p><?= trans('list_assessment') ?></p>
						</a>
					</li> -->
					<!-- Hết lý Biểu mẫu-->
					<!-- Quản lý tài khoản-->
					<li class="nav-header"><?= trans('manage_account') ?></li>
					<li id="profile_index" class="nav-item">
						<a href="<?= base_url('admin/profile/')?>" class="nav-link">
							<i class="nav-icon fa fa-user"></i>
							<p><?= trans('profile_account') ?></p>
						</a>
					</li>
					<li id="profile_change_pwd" class="nav-item">
						<a href="<?= base_url('admin/profile/change_pwd')?>" class="nav-link">
							<i class="nav-icon fa fa-key"></i>
							<p><?= trans('change_password') ?></p>
						</a>
					</li>
					<!-- Hết quản lý tài khoản-->
					<?php endif; ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  $("#<?= $cur_tab ?>").addClass('menu-open');
  $("#<?= $cur_tab ?> > a").addClass('active');
</script>
