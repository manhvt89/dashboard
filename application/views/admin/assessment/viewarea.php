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
		<?php if(!empty($theArea)): ?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"><?= trans('the_evaluation_form') ?><?=$theArea['name']?></h5>

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
                  <div class="col-md-12">
                        <input type="hidden" id="csrf_tk_name" name="csrf_tk_name" value="<?php echo $this->security->get_csrf_hash();  ?>">
                        <div id="msg_error"></div>
                        <table class="table table-bordered table-striped dataTable no-footer">
                          <?php if($categories != null): ?>
                            <?php foreach($categories as $record): ?>
                              <tr id="row_category_<?=$record['id']?>">
                                  <td><?=$record['orderby']?></td>
                                  <td>
																		<!-- CATEGORY -->
																		<div class="row">
																				<div class="col-md-12">
																					<p id="lbl_category_name_<?=$record['id']?>" ><?=$record['name']?></p>
																				</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
                                      	<input type="text" class="txt_category_name hidden form-control" data_id="<?=$record['id']?>" id="category_name_<?=$record['id']?>" name="category_name_<?=$record['id']?>" value="<?=$record['name']?>">
																			</div>
																			<div class="col-md-12">
                                      	<button type="button" class="save-category btn btn-primary hidden" id="submit_category_name_<?=$record['id']?>" name="submit_category_name_<?=$record['id']?>" data_id="<?=$record['id']?>" value="<?=trans('category_submit')?>"><i class="fa fa-save"></i></button>
                                      	<button type="button" class="cancel-category btn btn-primary hidden" id="cancel_category_name_<?=$record['id']?>" name="cancel_category_name_<?=$record['id']?>" data_id="<?=$record['id']?>" value="<?=trans('category_submit')?>"><i class="fa fa-undo"></i></i></button>
																			</div>
																		</div>
																		<!-- END CATEGORY -->
																			<table width="100%" id="tbl_question_<?=$record['id']?>">
                                            <tr><td></td><td></td><td><a data_id="<?=$record['id']?>" href="javascript:void(0)" class="add_question" ><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>
                                            <?php if($record['questions'] != null): ?>
                                                <?php foreach($record['questions'] as $question): ?>
                                                   <tr id="row_question_<?=$question['id']?>">
                                                      <td>
                                                          <div id="lbl_question_<?=$question['id']?>">  
																														<?=$question['name']?><br>
																														<?=$question['content']=='.'?'':$question['content']?>
                                                          </div>
                                                          <!-- edit form -->
                                                          <?php //$this->load->view('admin/includes/_messages.php') ?>

                                                          <div class="frm_edit_question form-horizontal hidden" id='frm_edit_question_<?=$question['id']?>' > 
                                                            <div class="form-group">
                                                              <label for="edit_question_name_<?=$question['id']?>" class="col-md-12 control-label"><?= trans('question_name') ?></label>

                                                              <div class="col-md-12">
                                                                <input type="text" name="edit_question_name_<?=$question['id']?>" class="form-control" id="edit_question_name_<?=$question['id']?>" value="<?=$question['name']?>">
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="edit_question_content_<?=$question['id']?>" class="col-md-12 control-label"><?= trans('question_content') ?></label>

                                                              <div class="col-md-12">
                                                                <input type="text" name="edit_question_content_<?=$question['id']?>" class="form-control" id="edit_question_content_<?=$question['id']?>" value="<?=$question['content']?>">
                                                              </div>
                                                            </div>

                                                            <div class="form-group">
                                                              <label for="edit_question_order_<?=$question['id']?>" class="col-md-12 control-label"><?= trans('question_order') ?></label>

                                                              <div class="col-md-12">
                                                                <input type="text" name="edit_question_order_<?=$question['id']?>" class="form-control" id="edit_question_order_<?=$question['id']?>" value="<?=$question['orderby']?>">
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <div class="col-md-12">
                                                              <input type="hidden" class="" name="question_id_<?=$question['id']?>" value="<?= $question['id'] ?>" id="edit_question_id_<?=$question['id']?>" class="btn btn-primary pull-right">
                                                                <input data_id="<?=$question['id']?>" type="button" class="save_question" name="button" value="<?= trans('save_question') ?>" class="btn btn-primary pull-right">
                                                              </div>
                                                            </div>
                                                          </div>

																													<!-- Criterias -->
																													<table id="tbl_question_detail_<?=$question['id']?>">
																																<tr>
                                                                  <td><?=trans('category_of_review')?></td>                                                                  
                                                                  <td><?=trans('completion_rate')?></td>
                                                                  <td><a data_id="<?=$question['id']?>" href="javascript:void(0)" class="add_question_detail"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
																											
                                                                </tr>
                                                                <?php if(!empty($question['criterias'])): ?>
																																	<?php foreach($question['criterias'] as $criteria): ?>
																																		<tr id="row_display_criteria_<?=$criteria['id']?>">																																			
																																			<td><?=$criteria['content']?></td>																																
																																			<td><?=$criteria['percent']?></td>
																																			<td><a data_id="<?=$criteria['id']?>" href="javascript:void(0)" class="edit_criteria_act"><?=trans('edit_criteria')?></a></td>
																																		<tr>
																																		<tr id="row_criteria_<?=$criteria['id']?>" class="row_criteria_edit hidden" data_id="<?=$criteria['id']?>" >																																			
																																			<td>
																																				<input type="text" class="question_detail_text" data_id="<?=$criteria['id']?>" id="edit_question_detail_text_<?=$criteria['id']?>" name="question_detail_text_<?=$criteria['id']?>" value="<?=$criteria['content']?>" ></td>																																			
																																			<td>																																				
																																				<select class="question_detail_range form-control" data_id="<?=$criteria['id']?>" id="edit_question_detail_range_<?=$criteria['id']?>" name="question_detail_range_<?=$criteria['id']?>">                                 
																																					<option value="1" <?=$criteria['percent']==1?'selected':''?>>1</option>
																																					<option value="2" <?=$criteria['percent']==2?'selected':''?>>2</option>
																																					<option value="3" <?=$criteria['percent']==3?'selected':''?>>3</option>
																																					<option value="4" <?=$criteria['percent']==4?'selected':''?>>4</option>
																																					<option value="5" <?=$criteria['percent']==5?'selected':''?>>5</option>																																		                                  
																																			</select>
																																			</td>
																																			<td><a data_id="<?=$criteria['id']?>" href="javascript:void(0)" class="save_criteria_act"><?=trans('save_criteria')?></a></td>
																																		<tr>
																																	<?php endforeach; ?>
																																<?php endif; ?>
																													</table>
																													<!-- Them moi criteria -->
                                                          <div class="form hidden" id="form_add_criteria_<?=$question['id']?>">
                                          
                                                            <input type="hidden" class="hidden" data_id="<?=$question['id']?>" id="question_id_<?=$question['id']?>" name="question_id_<?=$question['id']?>" value="<?=$question['id']?>">
                                                            <div class="form-group">
																															<div class="col-md-6">
                                                              	<label for="question_detail_name_<?=$question['id']?>"><?=trans('question_detail_name')?></label>
																															</div>
																															<div class="col-md-6">
																																<input type="text" class="question_detail_name" data_id="<?=$question['id']?>" id="question_detail_name_<?=$question['id']?>" name="question_detail_name_<?=$question['id']?>" value="" placeholder="<?=trans('question_detail_name')?>">
																															</div>
																														</div>
                                                            <div class="form-group">
																															<div class="col-md-6">
																															<label for="question_detail_text_<?=$question['id']?>"><?=trans('question_detail_text')?></label>
																															</div>
																															<div class="col-md-6">  
																															<input type="text" class="question_detail_text" data_id="<?=$question['id']?>" id="question_detail_text_<?=$question['id']?>" name="question_detail_text_<?=$question['id']?>" value="" placeholder="<?=trans('question_detail_text')?>">
																															</div>  
																														</div>
                                                            <div class="form-group">
																															<div class="col-md-6">
                                                            		<label for="question_detail_range_<?=$question['id']?>">Điểm</label>
																															</div>
																															<div class="col-md-6">
																															
																																<select class="question_detail_range form-control" data_id="<?=$question['id']?>" id="question_detail_range_<?=$question['id']?>" name="question_detail_range_<?=$question['id']?>">                                 
																																		<option value="1">1</option>
																																		<option value="2">2</option>
																																		<option value="3">3</option>
																																		<option value="4">4</option>
																																		<option value="5">5</option>																																		                                  
																																</select>
                                                              	<!-- <input type="text" class="" data_id="<?=$question['id']?>" id="question_detail_range_<?=$question['id']?>" name="question_detail_range_<?=$question['id']?>" value="" placeholder="<?=trans('enter_question_range')?>"> -->
																															</div>
																														</div>																													
                                                            <div class="form-group">
																															<div class="col-md-6">
																																<label for="question_detail_order_<?=$question['id']?>"><?=trans('question_detail_order')?></label>
																															</div>
																															<div class="col-md-6">
																																<input type="text" class="question_detail_order" data_id="<?=$question['id']?>" id="question_detail_order_<?=$question['id']?>" name="question_detail_order_<?=$question['id']?>" value="" placeholder="<?=trans('enter_question_order')?>">
																															</div>
																														</div>
                                                            
                                                            <div class="form-group">
                                                              <button type="button" class="add_question_detail_btn btn btn-primary" id="submit_question_detail_<?=$question['id']?>" name="submit_question_detail_<?=$question['id']?>" data_id="<?=$question['id']?>" value="<?=trans('question_detail_submit')?>"><?=trans('question_detail_submit')?></button>
																															<button type="button" class="cancel_question_detail_btn btn btn-primary" id="cancel_question_detail_<?=$question['id']?>" name="cancel_question_detail_<?=$question['id']?>" data_id="<?=$question['id']?>" value="<?=trans('question_detail_cancel')?>"><?=trans('question_detail_cancel')?></button>
                                                            </div>

                                                          </div>
                                                          <!-- End -->
																													<!-- END Criterias -->
                                                      </td>
                                                      <td><a data_id="<?=$question['id']?>" href="javascript:void(0)" class="edit_question"><i class="fa fa-edit"></i></a></td>
																											<td><a data_id="<?=$question['id']?>" href="javascript:void(0)" class="delete_question" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                   </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                      </table>
                                      <div class="frm_add_question form hidden" id="form_add_question_<?=$record['id']?>">
                                          
                                          <input type="hidden" class="hidden" data_id="<?=$record['id']?>" id="category_id_<?=$record['id']?>" name="category_id_<?=$record['id']?>" value="<?=$record['id']?>">
                                          <div class="form-group">
                                            <label for="question_name_<?=$record['id']?>"><?=trans('question_name')?></label>
                                            <input type="text" class="" data_id="<?=$record['id']?>" id="question_name_<?=$record['id']?>" name="question_name_<?=$record['id']?>" value="" placeholder="<?=trans('enter_question_name')?>">
                                          </div>
                                          <div class="form-group">
                                          <label for="question_text_<?=$record['id']?>"><?=trans('question_text')?></label>
                                            <input type="text" class="" data_id="<?=$record['id']?>" id="question_text_<?=$record['id']?>" name="question_text_<?=$record['id']?>" value="" placeholder="<?=trans('enter_question_content')?>">
                                          </div>
                                          <div class="form-group">
                                          <label for="question_order_<?=$record['id']?>"><?=trans('question_order')?></label>
                                            <input type="text" class="" data_id="<?=$record['id']?>" id="question_order_<?=$record['id']?>" name="question_order_<?=$record['id']?>" value="" placeholder="<?=trans('enter_question_order')?>">
                                          </div>
                                          
                                          <div class="form-group">
                                            <button type="button" class="save-question btn btn-primary" id="submit_question_<?=$record['id']?>" name="submit_question_name_<?=$record['id']?>" data_id="<?=$record['id']?>" value="<?=trans('question_submit')?>"><?=trans('question_submit')?></button>
                                          </div>

                                      </div>  
                                    
                                    </td>
                                  <td><a data_id="<?=$record['id']?>" href="javascript:void(0)" class="edit_category" ><i class="fa fa-edit"></i></a></td>
                                  <td><a data_id="<?=$record['id']?>" href="javascript:void(0)" class="delete_category" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                              <tr><td>Hiện tại chưa có danh mục</td></tr>
                          <?php endif; ?>  
                        </table>
                        <div>
                        <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title"><?= trans('add_category_form')?></h3>
                          </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php $this->load->view('admin/includes/_messages.php') ?>
                        <?php echo form_open(base_url('admin/assessment/add_category'), 'class="form-horizontal"');  ?>               
                          <div class="card-body">
                            <div class="form-group">
                              <label for="category_name"><?=trans('category_name')?></label>
                              <input type="text" class="form-control" id="category_name" name="category_name" placeholder="<?=trans('enter_category_name')?>" value="">
                            </div>
                            <div class="form-group">
                          
                            <label for="category_order"><?=trans('category_order')?></label>
                              <select class="form-control" id="category_order" name="category_order">                                 
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                  <option value="9">9</option>
                                  <option value="10">10</option>
                                  <option value="11">11</option>
                                  <option value="12">12</option>
                                  <option value="13">13</option>
                                  <option value="14">14</option>
                                  <option value="15">15</option>
                                  <option value="16">16</option>                                  
                              </select>
                            
                              </div>
                            <div class="form-check">
                              
                                  <input type="checkbox" class="form-check-input" id="category_status" name="category_status" value="1">
                                  <input type="hidden" class="form-check-input" id="category_id" name="id" value="0">
              
                                  <input type="hidden" class="form-check-input" id="area_id" name="area_id" value="<?=$id?>">
                              <label class="form-check-label" for="category_status"><?=trans('category_status')?></label>
                            </div>
                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                              
                            <button type="submit" class="btn btn-primary" name="submit" value="<?=trans('category_submit')?>"><?=trans('category_submit')?></button>
                          </div>
                          <?php echo form_close(); ?>
                      </div>
                        </div>
                          
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                        
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
		<?php else: ?>
			<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Hạng mục không tồn tại</h5>

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
                  <div class="col-md-12">
										Không tồn tại mục này, vui lòng thử lại.
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</section>
		<?php endif ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- PAGE PLUGINS -->
<!-- SparkLine -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
//Cancel
$( ".cancel_question_detail_btn" ).click(function() {
      
	var question_id = $( this ).attr("data_id");
  $('#form_add_criteria_' + question_id).addClass('hidden');
			
});

$( ".cancel-category" ).click(function() {
      
      $('.cancel-category').addClass('hidden');
			$('.txt_category_name').addClass('hidden');
			$('.save-category').addClass('hidden');
			
});

$( ".edit_category" ).click(function() {
			//Ẩn tất cả các item
			$('.cancel-category').addClass('hidden');
			$('.txt_category_name').addClass('hidden');
			$('.save-category').addClass('hidden');
			$('.frm_add_question').addClass('hidden');
			$('.frm_edit_question').addClass('hidden');
			
			//Hiển thị đúng item muốn edit
      var category_id = $( this ).attr("data_id");
      $('#category_name_'+category_id).removeClass('hidden');
      $('#submit_category_name_'+category_id).removeClass('hidden');
			$('#cancel_category_name_'+category_id).removeClass('hidden');
});

$( ".save-category" ).click(function() {
      var category_id = $( this ).attr("data_id");
      var name_value = $('#category_name_'+category_id).val();
      var csrf_tk_name = $('#csrf_tk_name').val();

      //var _csrfName = 'csrf_tk_name';
      //var _csrfValue = $('#csrf_tk_name').val();
           
           
         //  var form_data = new FormData();
         // form_data.append('name', name_value);
         // form_data.append(_csrfName, _csrfValue);
         // form_data.append('id', category_id);
      
      $.ajax({
        type: "POST",
        url: "<?=base_url('admin/assessment/update_category')?>",
        data: {id:category_id, name:name_value, csrf_test_name: csrf_tk_name},
        //data: form_data,
        success: function(data) {
        
            if(data.result == 0)
            {
              $('#lbl_category_name_'+category_id).html(name_value);
              $('#category_name_'+category_id).addClass('hidden');
              $('#submit_category_name_'+category_id).addClass('hidden');
            }
        },
        dataType: "json",
      });
      //$('#category_name_'+category_id).removeClass('hidden');
     // $('#submit_category_name_'+category_id).removeClass('hidden');
});

$( ".add_question" ).click(function() {
			//Ẩn tất cả
			$('.cancel-category').addClass('hidden');
			$('.txt_category_name').addClass('hidden');
			$('.save-category').addClass('hidden');
			$('.frm_add_question').addClass('hidden');
			$('.frm_edit_question').addClass('hidden');
      var category_id = $( this ).attr("data_id");
      $('#form_add_question_' + category_id).removeClass('hidden');
});

$( ".save-question" ).click(function() {
      var category_id = $( this ).attr("data_id");
      var name_value = $('#question_name_'+category_id).val();
      var content_value = $('#question_text_'+category_id).val();
      var csrf_tk_name = $('#csrf_tk_name').val();
      var order_value = $('#question_order_'+category_id).val();
      var tbl_id_string = "tbl_question_"+category_id;

      if(!$.isNumeric(order_value))
      {
          $('#msg_error').html("<?=trans('error_is_not_number_order')?>");
      } else {
         if( name_value == '' || content_value == '')
         {
          $('#msg_error').html("<?=trans('error_is_not_empty')?>");
         } else {
      
            $.ajax({
              type: "POST",
              url: "<?=base_url('admin/assessment/add_question')?>",
              data: {id:category_id, name:name_value, content: content_value, order:order_value, csrf_test_name: csrf_tk_name},
              //data: form_data,
              success: function(data) {
              
                  if(data.result == 0)
                  {
										$('.cancel-category').addClass('hidden');
										$('.txt_category_name').addClass('hidden');
										$('.save-category').addClass('hidden');
										$('.frm_add_question').addClass('hidden');
										$('.frm_edit_question').addClass('hidden');
                    $('#question_name_'+category_id).val('');
                    $('#question_text_'+category_id).val('');                  
                    $('#question_order_'+category_id).val('');
                    $('#msg_error').html('');
                    $('#form_add_question_' + category_id).addClass('hidden');
                    $('#'+tbl_id_string+' tr:last').after('<tr><td>'+name_value + '<br>'+content_value+'</td><td></td></tr>');
                  }
              },
              dataType: "json",
            });
        }
      }
});

$('.edit_question').click(function(){
			//Ẩn tất cả
			$('.cancel-category').addClass('hidden');
			$('.txt_category_name').addClass('hidden');
			$('.save-category').addClass('hidden');
			$('.frm_add_question').addClass('hidden');
			$('.frm_edit_question').addClass('hidden');
      var question_id = $( this ).attr("data_id");
      $('#frm_edit_question_' + question_id).removeClass('hidden');
});

$( ".save_question" ).click(function() { //Lưu update

      var _id = $( this ).attr("data_id"); //Question ID
     //alert(_id);
      var name_value = $('#edit_question_name_'+_id).val();
      var content_value = $('#edit_question_content_'+_id).val();
      var csrf_tk_name = $('#csrf_tk_name').val();
      var order_value = $('#edit_question_order_'+_id).val();
      //alert(order_value);
      
      if(!$.isNumeric(order_value))
      {
          $('#msg_error').html('<?=trans('error_is_not_number_order')?>');
      } else {
         if( name_value == '' || content_value == '')
         {
          $('#msg_error').html('<?=trans('error_is_not_empty')?>');
         } else {
      
            $.ajax({
              type: "POST",
              url: "<?=base_url('admin/assessment/update_question')?>",
              data: {id:_id, name:name_value, content: content_value, order:order_value, csrf_test_name: csrf_tk_name},
              //data: form_data,
              success: function(data) {
              
                  if(data.result == 0)
                  {
										$('.cancel-category').addClass('hidden');
										$('.txt_category_name').addClass('hidden');
										$('.save-category').addClass('hidden');
										$('.frm_add_question').addClass('hidden');
										$('.frm_edit_question').addClass('hidden');
                    $('#lbl_question_'+_id).html(name_value + '<br>' + content_value);
                    $('#edit_question_name_'+_id).val(name_value);
                    $('#edit_question_content_'+_id).val(content_value);                  
                    $('#edit_question_order_'+_id).val(order_value);
                    $('#msg_error').html('');
                    $('#frm_edit_question_' + _id).addClass('hidden');
                  }
              },
              dataType: "json",
            });
        }
      }
});

$( ".delete_question" ).click(function() {
      var question_id = $( this ).attr("data_id");
      var csrf_tk_name = '<?=$this->security->get_csrf_hash()?>';
			console.log(csrf_tk_name);
			console.log(area_id);
			var row_id = "row_question_" + question_id;
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
												url: "<?=base_url('admin/assessment/delete_question')?>",
												data: {id:question_id, csrf_test_name: csrf_tk_name},
												//data: form_data,
												success: function(data) {
												
														if(data.result == 0)
														{
															$('#'+row_id).remove();
														} else {
															$.alert('Chưa xóa được câu hỏi này');
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


$( ".delete_category" ).click(function() {
      var category_id = $( this ).attr("data_id");
      var csrf_tk_name = '<?=$this->security->get_csrf_hash()?>';
			console.log(csrf_tk_name);
			console.log(area_id);
			var row_id = "row_category_" + category_id;
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
												url: "<?=base_url('admin/assessment/delete_category')?>",
												data: {id:category_id, csrf_test_name: csrf_tk_name},
												//data: form_data,
												success: function(data) {
												
														if(data.result == 0)
														{
															$('#'+row_id).remove();
														} else {
															$.alert('Chưa xóa được danh mục này');
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

$( ".add_question_detail" ).click(function() {
      var question_id = $( this ).attr("data_id");
      $('#form_add_criteria_' + question_id).removeClass('hidden');
});

$( ".add_question_detail_btn" ).click(function() {
      
      var question_id = $( this ).attr("data_id");
      var name_value = $('#question_detail_name_'+question_id).val();
      var content_value = $('#question_detail_text_'+question_id).val();
      var csrf_tk_name = $('#csrf_tk_name').val();
      var order_value = $('#question_detail_order_'+question_id).val();
      var tbl_id_string = "tbl_question_detail_"+question_id;
			var question_detail_range = $('#question_detail_range_'+question_id).val();
      //var question_detail_max = $('#question_detail_grade_'+question_id).val();
			//order_value = 2;
      if(!$.isNumeric(order_value))
      {
          //$('#msg_error').html("<?=trans('error_is_not_number_order')?>");
          alert('<?=trans('error_is_not_number_order')?>');
      } else {
         //if( name_value == '' || content_value == '')
				 if( content_value == '')
         {
            //$('#msg_error').html("<?=trans('error_is_not_empty')?>");
            alert('<?=trans('error_is_not_empty')?>');
         } else {
      
            $.ajax({
              type: "POST",
              url: "<?=base_url('admin/assessment/add_question_detail')?>",
              data: {question_id:question_id, range: question_detail_range ,name:name_value, content: content_value, order:order_value, csrf_test_name: csrf_tk_name},
              //data: form_data,
              success: function(data) {
              
                  if(data.result == 0)
                  {
                    $('#question_detail_name_'+question_id).val('');
                    $('#question_detail_text_'+question_id).val('');                  
                    $('#question_detail_order_'+question_id).val('');
                    $('#question_detail_range_'+question_id).val('');
                    $('#question_detail_grade_'+question_id).val('');
                    //$('#msg_error').html('');
                    $('#form_add_criteria_' + question_id).addClass('hidden');
                    $('#'+tbl_id_string+' tr:last').after('<tr><td>'+content_value+'</td><td>'+question_detail_range+'</td><td></td></tr>');
                  }
              },
              dataType: "json",
            });
        }
      }
});
$( ".edit_criteria_act" ).click(function() {
      var criteria_id = $( this ).attr("data_id");
      $('#row_criteria_' + criteria_id).removeClass('hidden');
});

$( ".save_criteria_act" ).click(function() {
      
      var criteria_id = $( this ).attr("data_id");
      var content_value = $('#edit_question_detail_text_'+criteria_id).val();
      var csrf_tk_name = $('#csrf_tk_name').val();      
      var tbl_id_string = "tbl_question_detail_"+criteria_id;
			var question_detail_range = $('#edit_question_detail_range_'+criteria_id).val();
      //var question_detail_max = $('#question_detail_grade_'+question_id).val();
			order_value = 2;
      if(!$.isNumeric(order_value))
      {
          //$('#msg_error').html("<?=trans('error_is_not_number_order')?>");
          alert('<?=trans('error_is_not_number_order')?>');
      } else {
         //if( name_value == '' || content_value == '')
				 if( content_value == '')
         {
            //$('#msg_error').html("<?=trans('error_is_not_empty')?>");
            alert('<?=trans('error_is_not_empty')?>');
         } else {
      
            $.ajax({
              type: "POST",
              url: "<?=base_url('admin/assessment/save_question_detail')?>",
              data: {criteria_id:criteria_id, range: question_detail_range , content: content_value, csrf_test_name: csrf_tk_name},
              //data: form_data,
              success: function(data) {
              
                  if(data.result == 0)
                  {
                    //$('#edit_question_detail_text_'+criteria_id).val('');
                   // $('#edit_question_detail_range_'+criteria_id).val('');                  
                   
                    //$('#msg_error').html('');
                    $('#row_criteria_' + criteria_id).addClass('hidden');
                    //$('tr#row_display_criteria_' + criteria_id + ' >td').remove();
                    $('tr#row_display_criteria_' + criteria_id ).children('td').eq(0).html(content_value);
                    $('tr#row_display_criteria_' + criteria_id ).children('td').eq(1).html(question_detail_range);
                    //$('#row_display_criteria_' + criteria_id).html('<td>'+content_value+'</td><td>'+question_detail_range+'</td><td></td>');
                  }
              },
              dataType: "json",
            });
        }
      }
});

</script>
