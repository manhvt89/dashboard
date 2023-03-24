  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              <?= trans('update_comment') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/campaign'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('campaign_list') ?></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <!-- form start -->
                <div class="box-body">

                  <!-- For Messages -->
                  <?php $this->load->view('admin/includes/_messages.php') ?>

                  <?php echo form_open(base_url('admin/campaign/make_general_comment'), 'class="form-horizontal"');  ?> 
                  <div class="form-group vnpi_form_editor">
                    <label for="archivement" class="col-md-12 control-label"><?= trans('general_archivement') ?></label>

                    <div class="col-md-12">
                      <textarea style="width:100%; min-height:300px;" name="archivement" class="form-control" id="archivement"><?=$record['archivement']?></textarea>
                      <input type="hidden" name="id" class="form-control" id="id" placeholder="" value="<?=$record['id']?>">
                    </div>
                  </div>

									<div class="form-group vnpi_form_editor">
                    <label for="main_problem" class="col-md-12 control-label"><?= trans('general_main_problem') ?></label>
                    <div class="col-md-12">
                      <textarea style="width:100%; min-height:300px;" name="main_problem" class="form-control" id="main_problem"><?=$record['main_problem']?></textarea>
                      <input type="hidden" name="id" class="form-control" id="id" placeholder="" value="<?=$record['id']?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <input type="submit" name="submit" value="<?= trans('btn_update_comment') ?>" class="btn btn-primary pull-right">
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
          </div>  
        </div>
      </div>
    </section> 
  </div>
  <!-- CK Editor -->
<script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/plugins/ckfinder/ckfinder.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    ClassicEditor
      .create(document.querySelector('#archivement'),{
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

	$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    ClassicEditor
      .create(document.querySelector('#main_problem'),{
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
