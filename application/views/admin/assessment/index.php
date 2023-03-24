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
                <h5 class="card-title"><?= trans('form_list') ?></h5>

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
                            <thead>
                              <tr>
                                <td><?=trans('form_id')?></td>
                                <td><?=trans('form_name')?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </thead>
                            <?php foreach($records as $record): ?>
                            <tr id="row_form_<?=$record['id']?>">
                                <td><?=$record['id']?></td>
                                <td><?=$record['name']?></td>
                                <?php if($record['status'] > 2 ): ?>
                                <td></td>  
                                <td></td>
                                <?php else: ?>
                                <td><a href="<?=base_url('admin/assessment/index/').$record['id']?>"><?=trans('edit_form')?></a></td>
                                <td><a href="<?=base_url('admin/assessment/form/').$record['id']?>"><?=trans('view_form')?></a></td>
                                <?php endif; ?> 
                                <td><a href="<?=base_url('admin/assessment/previewform/').$record['id']?>"><?=trans('preview_form')?></a></td>
                                <td><a href="<?=base_url('admin/assessment/copy_form/').$record['id']?>"><?=trans('copy_form')?></a></td>
                                <?php if($record['status'] > 2 ): ?>
                                <td></td>
                                <?php else: ?>                                
                                <td><a data_id="<?=$record['id']?>" class="delete_form" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                <?php endif; ?> 
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
              <?php echo form_open(base_url('admin/assessment/index'), 'class="form-horizontal"');  ?>               
                <div class="card-body">
                  <div class="form-group">
                    <label for="area_name"><?=trans('form_name')?></label>
                    <input type="text" class="form-control" id="form_name" name="form_name" placeholder="<?=trans('enter_form_name')?>" value="<?=$theRecord==null?'':$theRecord['name']?>">
                  </div>
                 
                  <div class="form-check">
                    <?php if($theRecord == null): ?>
                        <input type="checkbox" class="form-check-input" id="form_status" name="form_status">
                        <input type="hidden" class="form-check-input" id="form_id" name="id" value="0">
    
                    <?php else: ?>
                        <input type="checkbox" name="form_status" <?= $theRecord['status'] ==1?'checked':'' ?> class="form-check-input" id="form_status">
                        <input type="hidden" class="form-check-input" id="form_id" name="id" value="<?=$theRecord['id']?>">
                        <?php endif; ?>
                    <label class="form-check-label" for="area_status"><?=trans('form_status')?></label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    
                  <button type="submit" name="submit" value="<?=trans('form_submit')?>" class="btn btn-primary"><?=trans('form_submit')?></button>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
	$( ".delete_form" ).click(function() {
      var form_id = $( this ).attr("data_id");
      var csrf_tk_name = '<?=$this->security->get_csrf_hash()?>';
			console.log(csrf_tk_name);
			console.log(form_id);
			var row_id = "row_form_" + form_id;
			//var r = confirm("Bạn có chắc chắn xóa mục này?");
			$.confirm({
						title: 'Xác nhận',
						content: 'Sau khi xóa bạn không thể khôi phục! Bạn có chắc chắn muốn xóa?',
						buttons: {
								confirm: {
									text:'Đồng ý xóa',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
												type: "POST",
												url: "<?=base_url('admin/assessment/delete_form')?>",
												data: {id:form_id, csrf_test_name: csrf_tk_name},
												//data: form_data,
												success: function(data) {
												
														if(data.result == 0)
														{
															$('#'+row_id).remove();
														} else {
															$.alert('Chưa xóa được khu vực này');
														}
												},
												dataType: "json",
											});
									}
								},
								cancel: {
									text: 'Hủy yêu cầu xóa',
									action: function () {

										$.alert('Bạn đã không thực hiện xóa!');
									}
								},
								
						}
				});
});
</script>
