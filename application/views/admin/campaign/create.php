   <!-- Select2 -->
   <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/select2.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              <?= trans('add_new_company') ?> </h3>
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

                  <?php echo form_open(base_url('admin/campaign/save'), 'class="form-horizontal"');  ?> 
                  <div class="form-group">
                    <label for="campaign_name" class="col-md-12 control-label"><?= trans('campaign_name') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="campaign_name" class="form-control" id="campaign_name" placeholder="" value="<?=set_value('campaign_name')?>">
                    </div>
                  </div>                 

                  <div class="form-group">
                    <label for="assessment_date" class="col-md-12 control-label"><?= trans('assessment_date') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="assessment_date" class="form-control" id="assessment_date" placeholder="" value="<?=set_value('assessment_date')?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="assessment_criteria" class="col-md-12 control-label"><?= trans('assessment_criteria') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="assessment_criteria" class="form-control" id="assessment_criteria" placeholder="" value="<?=set_value('assessment_criteria')?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="assessment_type" class="col-md-12 control-label"><?= trans('assessment_type') ?></label>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('initial_assessment')?>" name="assessment_type">
                      <label class="form-check-label"><?=trans('initial_assessment')?></label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('extension_assessment')?>" name="assessment_type">
                      <label class="form-check-label"><?=trans('extension_assessment')?></label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('surveillance_assessment')?>" name="assessment_type">
                      <label class="form-check-label"><?=trans('surveillance_assessment')?></label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('re_assessment')?>" name="assessment_type">
                      <label class="form-check-label"><?=trans('re_assessment')?></label>
                    </div>
                
                  </div>
									<div class="form-group">
                    <label for="assessment_modelity" class="col-md-12 control-label"><?= trans('assessment_modelity') ?></label>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('insite')?>" name="assessment_modelity">
                      <label class="form-check-label"><?=trans('insite')?></label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="<?=trans('online')?>" name="assessment_modelity">
                      <label class="form-check-label"><?=trans('online')?></label>
                    </div>
                    
                  </div>
									<div class="form-group">
                    <label for="assessment_scope" class="col-md-12 control-label"><?= trans('assessment_scope') ?></label>

                    <div class="col-md-12">
                      <textarea style="width:100%; min-height:300px;" name="assessment_scope" class="form-control" id="assessment_scope"></textarea>
                  
                    </div>
                  </div>

									<div class="form-group">
                    <label for="state" class="col-md-12 control-label"><?= trans('select_form') ?>*</label>
                    <div class="col-md-12">
                      <select name="form" class="form-control" id="form">
                        <option value=""><?= trans('select_form') ?></option>
                      </select>
                    </div>
                  </div>

									<div class="form-group">
                    <label for="leader" class="col-md-12 control-label"><?= trans('select_leader') ?>*</label>
                    <div class="col-md-12">
                      <select name="leader" class="form-control" id="leader">
                        <option value=""><?= trans('select_leader') ?></option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="member" class="col-md-12 control-label"><?= trans('select_member') ?>*</label>
                    <div class="col-md-12">
                      <select name="member[]" class="form-control" id="member" multiple="multiple">
                        <option value=""><?= trans('select_member') ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
											<input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>" >
                      <input type="submit" name="submit" value="<?= trans('add_campaign') ?>" class="btn btn-primary pull-right">
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
  <script src="<?= base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
  <script type="text/javascript">
    "use strict";

    var forms = <?=$forms?>;
		var leaders = <?=$users?>;
    var members = <?=$users?>;
    var loadSelect2 = function () {
                // loading data from array
                $('#form').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_form') ?>",
                    data: forms,
										language: {
											noResults: function (params) {
												return "Chưa có biểu mẫu nào, vui lòng tạo biểu mẫu trước, hoặc liên hệ với quản trị.";
											}
										}
                });
                
								$('#leader').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_leader') ?>",
                    data: leaders,
										language: {
											noResults: function (params) {
												return "Chưa có người dùng nào, vui lòng tạo người dùng trước trước, hoặc liên hệ với quản trị.";
											}
										}
                });

                $('#member').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_member') ?>",
                    disabled: true,
										language: {
											noResults: function (params) {
												return "Chưa có người dùng nào, vui lòng tạo người dùng trước trước, hoặc liên hệ với quản trị.";
											}
										}
                });

								

            }
  loadSelect2();

	$('#leader').on('change', function (e) {
            //$('#city').prop('disabled', false);
          var userselected = $('#leader').select2("val");
          console.log(userselected);
          //$('#member').prop('allowClear', true);
          ///$("#member").select2('destroy');
          //$("#member").select2("val",'');
          if(userselected.length==0){
              $('#member').prop('disabled', true);
             
          } else {
            var vOption;                      
                        //vOption = '<option value="' + 0 + '" data-select2-id="' + 0 + '">' + '' + '</option>';
                        //$(vOption).appendTo('#member');
                  $.each(members, function (i, obj) {
                    if (obj.id != userselected) {
                        var vOption;                      
                        vOption = '<option value="' + obj.id + '" data-select2-id="' + obj.id + '">' + obj.text + '</option>';
                        $(vOption).appendTo('#member');
                    }
                });
                $('#member').prop('disabled', false);

          }
        }); 
  //setDataPrefix();
</script>            
