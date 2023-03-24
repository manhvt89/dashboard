  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              <?= trans('view_campaign') ?> </h3>
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

                  <div class="form-group">
                    <label for="companyname" class="col-md-12 control-label"><?= trans('campaign_name') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="companyname" class="form-control" id="companyname" placeholder="" disabled value="<?=$record['name']?>">
                    </div>
                  </div>
                 

                  <div class="form-group">
                    <label for="company_name" class="col-md-12 control-label"><?= trans('company_name') ?></label>

                    <div class="col-md-12">
                      <input type="txt" name="company_name" class="form-control" id="company_name" placeholder="" disabled value="<?=$record['company_name']?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="status_evaluation" class="col-md-12 control-label"><?= trans('status_evaluation') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="address" class="form-control" id="status_evaluation" placeholder="" disabled value="<?=$status?>">
                    </div>
                  </div>
									<div class="form-group">
                    <label for="assessment_modelity" class="col-md-12 control-label"><?= trans('assessment_modelity') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="assessment_modelity" class="form-control" id="assessment_modelity" placeholder="" disabled value="<?=$record['assessment_modelity']?>">
                    </div>
                  </div>
									<div class="form-group">
                    <label for="assessment_scope" class="col-md-12 control-label"><?= trans('assessment_scope') ?></label>

                    <div class="col-md-12">
                      <textarea width="100%" height="300" name="assessment_scope" class="form-control" id="assessment_scope" placeholder="" disabled ><?=$record['assessment_scope']?></textarea>
                    </div>
                  </div>
                  <?php if($record['status'] == 0): ?>
										<?php if($record['creator_id'] == $this->session->userdata('admin_id')):?>
                    <?php echo form_open(base_url('admin/campaign/make_ready'), 'class="form-horizontal"');  ?> 
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?=$record['id']?>">
                        
                        <input type="submit" name="submit" value="<?= trans('make_ready') ?>" class="btn btn-primary pull-right">
                      </div>
                    </div>
                    <?php echo form_close(); ?>
										<?php endif; ?>
                  <?php elseif ($record['status'] < 4): ?>
                    <div class="form-group">
                      <label for="address" class="col-md-12 control-label"><?= trans('make_assessment') ?></label>
                      <?php foreach($areas_assessment as $area): ?>
                      <div class="col-md-12">                      
                      <?php if($area['count_result'] == 0): ?>
                        <a href="<?=base_url("admin/campaign/assessment/").$record['id'].'/'.$area['id']?>"><?=$area['name']?></a> [<span style="color:red"><?=trans('never_assessment_pls_do_it')?></span>]
                      <?php else : ?>
                        <a href="<?=base_url("admin/campaign/edit_assessment/").$record['id'].'/'.$area['id']?>"><?=$area['name']?></a> [<?=trans('completed_assessment_pls_redo_it')?>]
                      <?php endif; ?>  
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12"> 
                      <?php if($record['comment'] ==""): ?>
                        <a href="<?=base_url("admin/campaign/general_comment/").$record['id']?>"><?=trans('general_comment')?></a> [<span style="color:red"><?=trans('never_do_general_comment')?></span>]
                      <?php else: ?> 
                        <a href="<?=base_url("admin/campaign/edit_general_comment/").$record['id']?>"><?=trans('general_comment')?></a> [<?=trans('completed_general_comment')?>]
                      <?php endif; ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12"> 
                      <?php if($record['conclusions'] ==""): ?>
                        <a href="<?=base_url("admin/campaign/recommendation/").$record['id']?>"><?=trans('general_conclusions')?></a> [<span style="color:red"><?=trans('never_do_general_conclusions')?></span>]
                      <?php else: ?> 
                        <a href="<?=base_url("admin/campaign/edit_recommendation/").$record['id']?>"><?=trans('general_conclusions')?></a> [<?=trans('completed_general_conclusions')?>]
                      <?php endif; ?>
                      </div>
                    </div>
                    <!-- Hình ảnh minh họa Best practice-->
                    <div class="form-group">
                      
                      <label for="address" class="col-md-12 control-label"><?= trans('best_practice_photo') ?></label>
                      <?php foreach($areas_best_practices as $best_practices): ?>
                      <div class="col-md-12"> 
                      <?php if($best_practices['best_practices_id'] == null): ?>
                        <a href="<?=base_url("admin/campaign/best_practices/").$record['id']."/".$best_practices['id']?>"><?=$best_practices['name']?></a> [<span style="color:red"><?=trans('never_do_general_best_practice_photo')?></span>]
                      <?php else: ?> 
                        <a href="<?=base_url("admin/campaign/edit_best_practices/").$record['id']."/".$best_practices['best_practices_id']?>"><?=$best_practices['name']?></a> [<?=trans('completed_general_best_practice_photo')?>]
                      <?php endif; ?>
                      </div>
                      <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                      <label for="address" class="col-md-12 control-label"><?= trans('assessment_findings') ?></label>
                      <?php foreach($areas_assessment_findings as $assessment_findings): ?>
                        <div class="col-md-12"> 
                        <?php if($assessment_findings['assessment_findings_id'] == null): ?>
                          <a href="<?=base_url("admin/campaign/assessment_finding/").$record['id']."/".$assessment_findings['id']?>"><?=$assessment_findings['name']?></a> [<span style="color:red"><?=trans('never_do_general_assessment_findings')?></span>]
                        <?php else: ?> 
                          <a href="<?=base_url("admin/campaign/edit_assessment_finding/").$record['id']."/".$assessment_findings['assessment_findings_id']?>"><?=$assessment_findings['name']?></a> [<?=trans('completed_general_assessment_findings')?>]
                        <?php endif; ?>
                        </div>
                      <?php endforeach; ?>
                    </div>
                      <?php if($flag > 0): ?>
                        <div class="form-group">
                        <div class="col-md-12">
                            <a href="<?=base_url("admin/campaign/make_pdf/").$record['id']?>"><button type="button" class="btn btn-block btn-primary"><?=trans('preview_result')?></button></a>
                        </div>
                      </div>
                    <?php endif; ?>
									<?php elseif($record['status'] > 3): ?>
										 <?php redirect(base_url('admin/campaign/make_pdf/').$record['id']); ?>			
                  <?php endif; ?>
                
                </div>
                <!-- /.box-body -->
              </div>
            </div>
          </div>  
        </div>
      </div>
    </section> 
  </div>         
