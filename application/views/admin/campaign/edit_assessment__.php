<style type="text/css">
      .container {
        margin: 5% 3%;
      }
      
      h4[data-type=title] {
        text-align: center;
      }
      .image-upload > input
      {
          display: none;
      }

      .image-upload img
      {
          width: 80px;
          cursor: pointer;
      }

      .image-capture > input
      {
          display: none;
      }

      .image-capture img
      {
          width: 80px;
          cursor: pointer;
      }
      @media (min-width: 48em) {
        .container {
          margin: 2%;
        }
      }
      @media (min-width: 75em) {
        .container {
          margin: 2em auto;
          max-width: 75em;
        }
      }
      
      .responsive-table {
        width: 100%;
        margin-bottom: 1.5em;
        border-spacing: 0;
      }
      @media (min-width: 48em) {
        .responsive-table {
          font-size: 0.9em;
        }
      }
      @media (min-width: 62em) {
        .responsive-table {
          font-size: 1em;
        }
      }
      .responsive-table thead {
        position: absolute;
        clip: rect(1px 1px 1px 1px);
        /* IE6, IE7 */
        padding: 0;
        border: 0;
        height: 1px;
        width: 1px;
        overflow: hidden;
      }
      @media (min-width: 48em) {
        .responsive-table thead {
          position: relative;
          clip: auto;
          height: auto;
          width: auto;
          overflow: auto;
        }
      }
      .responsive-table thead th {
        background-color: #26890d;
        border: 1px solid gray;
        font-weight: normal;
        text-align: center;
        color: white;
      }
      .responsive-table thead th:first-of-type {
        text-align: left;
      }
      .responsive-table tbody,
      .responsive-table tr,
      .responsive-table th,
      .responsive-table td {
        display: block;
        padding: 0;
        text-align: left;
        white-space: normal;
      }
      @media (min-width: 48em) {
        .responsive-table tr {
          display: table-row;
        }
      }
      .responsive-table th,
      .responsive-table td {
        padding: 0.5em;
        vertical-align: middle;
      }
      @media (min-width: 30em) {
        .responsive-table th,
      .responsive-table td {
          padding: 0.75em 0.5em;
        }
      }
      @media (min-width: 48em) {
        .responsive-table th,
      .responsive-table td {
          display: table-cell;
          padding: 0.5em;
        }
      }
      @media (min-width: 62em) {
        .responsive-table th,
      .responsive-table td {
          padding: 0.75em 0.5em;
        }
      }
      @media (min-width: 75em) {
        .responsive-table th,
      .responsive-table td {
          padding: 0.75em;
        }
      }
      .responsive-table caption {
        margin-bottom: 1em;
        font-size: 1em;
        font-weight: bold;
        text-align: center;
      }
      @media (min-width: 48em) {
        .responsive-table caption {
          font-size: 1.5em;
        }
      }
      .responsive-table tfoot {
        font-size: 0.8em;
        font-style: italic;
      }
      @media (min-width: 62em) {
        .responsive-table tfoot {
          font-size: 0.9em;
        }
      }
      @media (min-width: 48em) {
        .responsive-table tbody {
          display: table-row-group;
        }
      }
      .responsive-table tbody tr {
        margin-bottom: 1em;
      }
      @media (min-width: 48em) {
        .responsive-table tbody tr {
          display: table-row;
          border-width: 1px;
        }
      }
      .responsive-table tbody tr:last-of-type {
        margin-bottom: 0;
      }
      @media (min-width: 48em) {
        .responsive-table tbody tr:nth-of-type(even) {
          background-color: rgba(0, 0, 0, 0.12);
        }
      }
      .responsive-table tbody th[scope=row] {
        background-color: #26890d;
        color: white;
      }
      @media (min-width: 30em) {
        .responsive-table tbody th[scope=row] {
          border-left: 1px solid gray;
          border-bottom: 1px solid ray;
        }
      }
      @media (min-width: 48em) {
        .responsive-table tbody th[scope=row] {
          background-color: transparent;
          color: #000001;
          text-align: left;
        }
      }
      .responsive-table tbody td {
        text-align: left;
      }
      @media (min-width: 48em) {
        .responsive-table tbody td {
          border: 1px solid gray;
          text-align: left;
        }
      }
      @media (min-width: 48em) {
        .responsive-table tbody td:last-of-type {
          border-right: 1px solid gray;
        }
      }
      .responsive-table tbody td[data-type=currency] {
        text-align: right;
      }
      
      .responsive-table tbody td[data-type=point] {
        text-align: center;
      }
      
      .responsive-table tbody td[data-title=heading] {
        text-align: center;
        font-weight: bold;
      }
      .responsive-table tbody td[data-title]:before {
        content: attr(data-title);
        /*float: left;*/
        font-size: 0.8em;
        color: rgba(0, 0, 0, 0.54);
      }
      @media (min-width: 30em) {
        .responsive-table tbody td[data-title]:before {
          font-size: 0.9em;
        }
      }
      @media (min-width: 48em) {
        .responsive-table tbody td[data-title]:before {
          content: none;
        }
      }
          </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= trans('evaluation_for') ?><?=$theArea['name']?></h1>
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
                    <?php $this->load->view('admin/includes/_messages.php') ?>

                    <?php echo form_open(base_url('admin/campaign/make_edit_assessment'), 'class="form-horizontal"');  ?>
                        <input type="hidden" id="id" name="id" value="<?=$record['id']?>">
                        <input type="hidden" id="question_ids" name="question_ids" value="<?=$strQuestionIds?>">
                        <input type="hidden" id="result_ids" name="result_ids" value="<?=$strResultIds?>">
                        <input type="hidden" id="company_id" name="company_id" value="<?=$record['company_id']?>">
                        <input type="hidden" id="area_id" name="area_id" value="<?=$theArea['id']?>">
												<input type="hidden" id="campaign_id" name="campaign_id" value="<?=$record['id']?>">
												
                        <div id="msg_error"></div>
                        <?php if($record['categories'] != null): ?>
                        <table class="responsive-table" width="90%">
                            <thead>
														<tr>
                                        <td colspan="6">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
																									<div id="photo_best_details_0"></div>
																									<div class="row">
																											<div class="col-md-3 image-capture">
																												<label for="photo_best_practice_0">
																														<img src="<?=base_url('assets/dist/img/capture.png')?>"/>
																												</label>
																													<input class="flat-red" type="file" name="photo_best_practice_0" id="photo_best_practice_0" onchange="fileSelected('0',1);" accept="image/*" capture="camera" />

																											</div>
																											<div class="col-md-3 image-upload">
																											<label for="photo_best_practice_u_0">
																														<img src="<?=base_url('assets/dist/img/upload.png')?>"/>
																												</label>
																												<input class="flat-red" type="file" name="photo_best_practice_u_0" id="photo_best_practice_u_0" onchange="fileSelected('0',1);" accept="image/*" />
																											</div>
																									</div>
																									<!--
																									<div class="row">
																											<div class="col-md-12">																											
																												<input class="flat-red" type="button" data-input="0" onclick="uploadFile('0',1)" value="Upload" />
																											</div>
																									</div> -->

																									<div id="best_progress_0"></div>
                                                  <div>
                                                      <label><?=trans('photo_illustration_of_5s_best_practices')?></label>
                                                      <div class="col-md-12">																												
																													<div id="display_best_photo_0" class="col-md-12">
																															
																																<?php if(!empty($best_photos)):
																																					foreach($best_photos as $photo): ?>
																																		<div class="col-md-12" style="padding:5px">			
																																			<img src="<?=base_url()?>/<?=$photo['path']?>" />
																																		</div>	
																																			<?php 
																																					endforeach;
																																		endif; ?>
														
																													</div>																																																								
                                                        
                                                      </div>
                                                  </div>
                                                  
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <div>
																											<label><?=trans('assessment_findings_h2')?></label>
																											<div class="col-md-12">
																														<div class="col-md-12">
																																
																																	<div id="display_finding_photo_0" class="col-md-12">
																																			
																																				<?php if(!empty($finding_photos)):
																																									foreach($finding_photos as $photo): ?>
																																						<div class="col-md-12" style="padding:5px">			
																																							<img src="<?=base_url()?>/<?=$photo['path']?>" />
																																						</div>	
																																							<?php 
																																									endforeach;
																																						endif; ?>
																		
																																	</div>
																																
																															<input type="file" name="photo_finding_0" id="photo_finding_0" onchange="fileSelected('0',2);" accept="image/*" capture="environment" />
																														</div>
																									</div>
                                                  <div id="photo_finding_details_0"></div>
                                                  
                                                  <div class="col-md-12">
																											<div class="col-md-12">
																											<input class="flat-red" type="button" data-input="0" onclick="uploadFile('0',2)" value="Upload" />
																											</div>
                                                  </div>
                                                  		<div id="finding_progress_0"></div>
                                                  </div>
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                              <tr><th rowspan="2" >Tiêu chí đánh giá</td><td colspan = "5" width="20%">Điểm đánh giá</th></tr>
                              <tr><th data-type="point">1</th><th data-type="point">2</th><th data-type="point">3</th><th data-type="point">4</th><th data-type="point">5</th></tr>
                            </thead>
                            <tbody>
                        <?php foreach($record['categories'] as $category): ?>
                            <tr id="category_row_<?=$category['id']?>"><td colspan="6"><b><?=$category['name']?></b></td></tr>
                            <?php if($category['questions'] != null): ?>
                                <?php foreach($category['questions'] as $question): ?>
                                    <tr id="question_row_<?=$category['id']?>" >
                                        <td data-type="question"><?=$question['content']?></td>
                                        <td data-type="point" data-title="1">
                                            <label>
                                                <input type="radio" value="1" <?=$question['score']==1? 'checked':'' ?> class="flat-red" name="result_score_<?=$question['result_id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point" data-title="2">
                                            <label>
                                                <input type="radio" value="2" <?=$question['score']==2? 'checked':'' ?> class="flat-red" name="result_score_<?=$question['result_id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point" data-title="3">
                                            <label>
                                                <input type="radio" value="3" <?=$question['score']==3? 'checked':'' ?> class="flat-red" name="result_score_<?=$question['result_id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point" data-title="4">
                                            <label>
                                                <input type="radio" value="4" <?=$question['score']==4? 'checked':'' ?> class="flat-red" name="result_score_<?=$question['result_id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point" data-title="5">
                                            <label>
                                                <input type="radio" value="5" <?=$question['score']==5? 'checked':'' ?> class="flat-red" name="result_score_<?=$question['result_id']?>">
                                            </label>
                                        </td>
                                    </tr>                                   
                                <?php endforeach; ?>
                            <?php endif;?>
                        <?php endforeach; ?>
                          </tbody>
                        </table>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="col-md-12">
                        <input type="submit" name="submit" value="<?= trans('edit_evaluation') ?>" class="btn btn-primary pull-right">
                        </div>
                  </div>
                    <?php echo form_close(); ?>                      
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- PAGE PLUGINS -->
<!-- SparkLine -->
<script type="text/javascript">
 
      function fileSelected(id,type) {
				if(type == 1)
				{

					var _name = 'photo_best_practice_'+id;
					var _name_display = "photo_best_details_" + id;
					var _best_progress = "best_progress_"+id;
					var _display_best_photo = "display_best_photo_"+id;
					var _progress = 'best_progress_' + id;

				} else {

					var _name = 'photo_finding_'+id;
					var _name_display = "photo_finding_details_" + id;
					var _best_progress = "finding_progress_"+id;
					var _display_best_photo = "display_finding_photo_"+id;
					var _progress = 'finding_progress_' + id;

				}
				document.getElementById(_progress).innerHTML = '';
        //
        var count = document.getElementById(_name).files.length;
        
              //document.getElementById('details').innerHTML = "";
 
				for (var index = 0; index < count; index ++)

				{

								var file = document.getElementById(_name).files[index];

								var fileSize = 0;

								if (file.size > 500 * 500)

											fileSize = (Math.round(file.size * 100 / (500 * 500)) / 100).toString() + 'MB';

								else

											fileSize = (Math.round(file.size * 100 / 500) / 100).toString() + 'KB';

											//document.getElementById(_name_display).innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;

							// document.getElementById(_name_display).innerHTML += '<p>';

				}
				uploadFile(id,type);
      }
 
      function uploadFile(id,type) {
				if(type ==1)
				{
					var _name = 'photo_best_practice_'+id;
					var _name_display = "photo_best_details_" + id;
				} else {
					var _name = 'photo_finding_'+id;
       		var _name_display = "photo_finding_details_" + id;
				}
        var _username = "<?=$this->session->userdata('username')?>";
        var _user_id = "<?=$this->session->userdata('admin_id')?>";
        var _area_id = $('#area_id').val();
        var _campaign_id =$('#campaign_id').val();
				var _crsf_token_name = "<?=$this->security->get_csrf_token_name()?>";
        var _crsf_token_value = "<?=$this->security->get_csrf_hash() ?>";
				var question_id = id;
        var fd = new FormData();
 
        var count = document.getElementById(_name).files.length;

        for (var index = 0; index < count; index ++)
        {
          var file = document.getElementById(_name).files[index];
          fd.append('file', file);
        }
        fd.append('question_id',id);
        fd.append('username',_username);
        fd.append('name_input_file',_name);
        fd.append('creator_id',_user_id);
        fd.append('area_id',_area_id);
        fd.append('campaign_id',_campaign_id);
				fd.append('type',type);
				fd.append(_crsf_token_name,_crsf_token_value);
				
 
        var xhr = new XMLHttpRequest();
 
        xhr.upload.addEventListener("progress", uploadProgress.bind(event,question_id,type), false);
 
        xhr.addEventListener("load", uploadComplete.bind(event,type), false);
 
        xhr.addEventListener("error", uploadFailed, false);
 
        xhr.addEventListener("abort", uploadCanceled, false);
 
        xhr.open("POST", "<?php echo base_url('admin/campaign/')?>upload");
 
        xhr.send(fd);
 
      }
 
      var uploadProgress = function(q_id,type, event) {

				if(type == 1)
				{
					var _progress = 'best_progress_' + q_id;
				} else {
					var _progress = 'finding_progress_' + q_id;
				}
				
				console.log(_progress);
				console.log(type);
				console.log(event);
 
        if (event.lengthComputable) {
 
          var percentComplete = Math.round(event.loaded * 100 / event.total);
 
          document.getElementById(_progress).innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById(_progress).innerHTML = 'unable to compute';
 
        }
 
      };
 
      var uploadComplete = function(type, evt) {
 
        /* This event is raised when the server send back a response */
				console.log(JSON.parse(evt.target.responseText));
				var obj = JSON.parse(evt.target.responseText);
				var id = obj.question_id;
				if(type ==1)
				{
					var _display_best_photo = "display_best_photo_"+id;
				} else {
					var _display_best_photo = "display_finding_photo_"+id;
				}
				var item = '<div class="col-md-12" style="padding:5px"><img src="'+obj.url+'" max-width="400px" /></div>';
				$('#'+_display_best_photo).append(item);
        //alert(evt.target.responseText);
 
      };
 
      function uploadFailed(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
 
      function uploadCanceled(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
 
    </script>
<script>
$( ".edit_category" ).click(function() {
      var category_id = $( this ).attr("data_id");
      $('#category_name_'+category_id).removeClass('hidden');
      $('#submit_category_name_'+category_id).removeClass('hidden');
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
</script>
