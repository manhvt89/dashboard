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
                <h5 class="card-title"><?= trans('evaluation_areas') ?></h5>

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
                            <tr id="row_area_<?=$record['id']?>">
                                <td><?=$record['orderby']?></td>
                                <td><?=$record['name']?></td>
                                <td><a href="<?=base_url('admin/assessment/form/').$assessment_id.'/'.$record['id']?>"><?=trans('edit_area')?></a></td>
                                <td><a href="<?=base_url('admin/assessment/area/').$record['id']?>"><?=trans('view_area')?></a></td>
																<td><a data_id="<?=$record['id']?>" class="delete_area" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?=$area_id == 0? trans('add_area_form'):trans('edit_area_form')?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo form_open(base_url('admin/assessment/form/'.$assessment_id), 'class="form-horizontal"');  ?>               
                <div class="card-body">
                  <div class="form-group">
                    <label for="area_name"><?=trans('area_name')?></label>
                    <input type="text" class="form-control" id="area_name" name="area_name" placeholder="<?=trans('enter_area_name')?>" value="<?=$theRecord==null?'':$theRecord['name']?>">
                  </div>
                  <div class="form-group">
                 
                  <label for="area_order"><?=trans('area_order')?></label>
                    <select class="form-control" id="area_order" name="area_order">
                        <?php if($theRecord == null): ?>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <?php else: ?>
                            <option value="1" <?= $theRecord['orderby']==1?'selected':''?>>1</option>
                            <option value="2" <?= $theRecord['orderby']==2?'selected':''?>>2</option>
                            <option value="3" <?= $theRecord['orderby']==3?'selected':''?>>3</option>
                            <option value="4" <?= $theRecord['orderby']==4?'selected':''?>>4</option>
                            <option value="5" <?= $theRecord['orderby']==5?'selected':''?>>5</option>
                            <option value="6" <?= $theRecord['orderby']==6?'selected':''?>>6</option>
                            <option value="7" <?= $theRecord['orderby']==7?'selected':''?>>7</option>
                            <option value="8" <?= $theRecord['orderby']==8?'selected':''?>>8</option>
                            <option value="9" <?= $theRecord['orderby']==9?'selected':''?>>9</option>
                        <?php endif; ?>
                    </select>
                  
                    </div>
                  <div class="form-check">
                    <?php if($theRecord == null): ?>
                        <input type="checkbox" class="form-check-input" id="area_status" name="area_status">
                        <input type="hidden" class="form-check-input" id="area_id" name="id" value="0">
    
                    <?php else: ?>
                        <input type="checkbox" name="area_status" <?= $theRecord['status'] ==1?'checked':'' ?> class="form-check-input" id="area_status">
                        <input type="hidden" class="form-check-input" id="area_id" name="id" value="<?=$theRecord['id']?>">
                        <?php endif; ?>
                    <label class="form-check-label" for="area_status"><?=trans('area_status')?></label>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
	$( ".delete_area" ).click(function() {
      var area_id = $( this ).attr("data_id");
      var csrf_tk_name = '<?=$this->security->get_csrf_hash()?>';
			console.log(csrf_tk_name);
			console.log(area_id);
			var row_id = "row_area_" + area_id;
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
												url: "<?=base_url('admin/assessment/delete_area')?>",
												data: {id:area_id, csrf_test_name: csrf_tk_name},
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
