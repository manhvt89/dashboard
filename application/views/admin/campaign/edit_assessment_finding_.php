  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= trans('best_practice_for') ?><?=$theArea['name']?></h1>
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
                <h5 class="card-title"><?= trans('assessment_findings_for') ?><?=$theArea['name']?></h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <div class="btn-group">
                      
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?=base_url('admin/campaign/view/').$record['id']?>" class="dropdown-item"><?=trans('back_to')?></a>
                      <!--
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

                    <?php echo form_open(base_url('admin/campaign/make_edit_assessment_finding'), 'class="form-horizontal"');  ?>
                        <input type="hidden" id="id" name="id" value="<?=$assessment_finding['id']?>"> 
                        <input type="hidden" id="campaign_id" name="campaign_id" value="<?=$record['id']?>">               
                        <div id="msg_error"></div>
                        <div class="form-group">
                            <label for="content" class="col-md-12 control-label"><?= trans('assessment_finding_content') ?></label>

                            <div class="col-md-12">
																<?php if(strip_tags($assessment_finding['content']) != ""): ?>
																	
																	<textarea style="width:100%; min-height:300px;" name="content" class="form-control" id="content"><?=$assessment_finding['content']?></textarea>
																<?php else : ?>
																	<?php 
																  $_html_content = '<figure class="table">
																	 <table>
																		 <tbody>';
																		  if(!empty($thefindingPhotos))
																			{
																				$index = 1;
																				foreach($thefindingPhotos as $photo)
																				{
																						if($index % 2 == 1)
																						{
																							$_html_content = $_html_content . '<tr>
																							<td>
																									<figure class="image">
																									<img src="'. base_url().$photo['path'].'">
																								 </figure>
																							 </td>';
																						} else {
																							$_html_content = $_html_content . '	<td>
																									<figure class="image">
																										<img src="'. base_url().$photo['path'].'">
																									</figure>
																								</td>
																							</tr>';
																						}
																						$index++;
																				}
																			}
																			 
																				
																	$_html_content = $_html_content.'		
																			</tbody>
																		</table>
																	</figure>
																	<p>Nhận xét</p>';
																	?>
																<textarea style="width:100%; min-height:300px;" name="content" class="form-control" id="content"><?=$_html_content?></textarea>
																
																<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                            <input type="submit" name="submit" value="<?= trans('btn_add_assessment_finding') ?>" class="btn btn-primary pull-right">
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
  <!-- CK Editor -->
<script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/plugins/ckfinder/ckfinder.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    ClassicEditor
      .create(document.querySelector('#content'),{
          ckfinder: {
            uploadUrl: '<?=base_url()?>assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
          },
          //toolbar: [ 'ckfinder', 'imageUpload', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo' ],
          toolbar: { 
                      items: [
                        'ckfinder', 'imageUpload',
                          'heading', '|',
                          'bold', 'italic', '|',
                          'link', '|',
                          'outdent', 'indent', '|',
                          'bulletedList', 'numberedList', '|',
                    
                          'insertTable', '|',
                          'uploadImage', 'blockQuote', '|',
                          'undo', 'redo'
                      ],
                      shouldNotGroupWhenFull: true
                  },
          config: {
			ui: {
				width: '100%',
				height: '300px'
			}
		}       
      })
      .then(function (editor) {
        // The editor instance
      })
      .catch(function (error) {
        console.error(error)
      })

    // bootstrap WYSIHTML5 - text editor

  })
</script>
