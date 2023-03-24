  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= trans('evaluation_form') ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"><?= trans('evaluation_form') ?></h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <div class="btn-group">
                      <!--
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-wrench"></i>
                    </button> -->
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <!--<a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a> -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                        <table class="table table-bordered table-striped dataTable no-footer">
                            <?php foreach($records as $record): ?>
                            <tr>
                                <td><a href="<?=base_url('admin/assessment/index/').$record['id']?>"><?=$record['name']?></a></td>
                                <!--<td><a href="<?=base_url('admin/assessment/index/').$record['id']?>"><?=trans('edit_area')?></a></td>
                                <td><a href="<?=base_url('admin/assessment/area/').$record['id']?>"><?=trans('view_area')?></a></td> -->
                            </tr>
                            <?php endforeach; ?>
                        </table>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?=$id == 0? trans('add_form_form'):trans('edit_form_form')?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo form_open(base_url('admin/assessment/form'), 'class="form-horizontal"');  ?>               
                <div class="card-body">
                  <div class="form-group">
                    <label for="form_name"><?=trans('form_name')?></label>
                    <input type="text" class="form-control" id="form_name" name="form_name" placeholder="<?=trans('enter_form_name')?>" value="<?=$theRecord==null?'':$theRecord['name']?>">
                  </div>
                  
                  <div class="form-check">
                    <?php if($theRecord == null): ?>
                        <input type="checkbox" class="form-check-input" id="form_status" name="form_status">
                        <input type="hidden" class="form-check-input" id="form_id" name="id" value="0">
    
                    <?php else: ?>
                        <input type="checkbox" name="area_status" <?= $theRecord['status'] ==1?'checked':'' ?> class="form-check-input" id="area_status">
                        <input type="hidden" class="form-check-input" id="area_id" name="id" value="<?=$theRecord['id']?>">
                        <?php endif; ?>
                    <label class="form-check-label" for="form_status"><?=trans('form_status')?></label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    
                  <button type="submit" name="submit" value="<?=trans('area_submit')?>" class="btn btn-primary"><?=trans('area_submit')?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- PAGE PLUGINS -->
<!-- SparkLine -->