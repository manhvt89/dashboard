<style type="text/css">
      .container {
        margin: 5% 3%;
      }
      
      h4[data-type=title] {
        text-align: center;
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
        text-align: right;
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
        float: left;
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
      #assessment_overview, #assessment_result,#assessment_result1, #assessment_result_heading, #assessment_best_practices_heading, #areas_best_practices, #areas_assessment_findings_heading, #areas_assessment_findings  {
        background-color:#fff !important;
      }
      #assessment_overview thead, #assessment_result thead,  #assessment_result_heading thead, #assessment_best_practices_heading thead, #areas_assessment_findings_heading thead{
              border: 2px solid green;
              text-align: center;
          }
      #assessment_overview thead tr th,  #assessment_result thead tr th{
              border: 0px solid green;
              text-align: center;
          }
      #assessment_best_practices_heading thead tr th, #assessment_result_heading thead tr th, #areas_assessment_findings_heading thead tr th{
            border: 0px solid green;
              text-align: center;
          }
      #areas_best_practices thead tr th{
        border: 1px solid green;
        text-align: center;
        vertical-align: middle;
        background-color: yellow;
        -webkit-print-color-adjust: exact; 
      }
      @media print {

          .responsive-table{
            min-width: 992px !important;
          }
          
          .pagebreak { page-break-before: always; } /* page-break-after works, as well */
          #assessment_result_heading thead {
              border: 2px solid green;
              text-align: center;
          }
          #assessment_overview th, #assessment_overview td {
              padding: .75rem;
              vertical-align: top;
              border-top: 0px solid #dee2e6;
              text-align: justify;
          }
      }
          </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=trans('preview')?></h1>
          </div>
          <div class="col-sm-6">
              <!--
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Overview  -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="col-12 table-responsive">
                  <table class="table" id="assessment_overview">
                    <thead>
                    <tr>
                      <th colspan="3"><?=trans('assessment_overview')?></th>
                    </tr>
                    <tr>
                      <th colspan="3">Assesssment Overview</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td width="10px">1.</td>
                      <td colspan="2">
                        <h4>
                          <?=trans('org_name')?><?=$record['company_name']?>                    
                        </h4>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <?=trans('org_address')?><?=$record['company_address'].', '. $wards[$record['company_wards_id']].', '.$cities[$record['company_city_id']].', '.$states[$record['company_state_id']]?>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <div class="row invoice-info">
                          <div class="col-sm-12 invoice-col">
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-6 invoice-col">
                          <?=trans('org_tel')?><?=$record['tel']?>
                          </div>
                          <div class="col-sm-6 invoice-col">
                          <?=trans('org_fax')?><?=$record['fax']?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td colspan="2">
                          <div class="row invoice-info">
                            <div class="col-sm-6 invoice-col">
                                <?=trans('org_authorized')?>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6 invoice-col">
                                <?=$record['authorized']?>
                            </div>
                            
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-6 invoice-col">
                                <?=trans('org_designation')?>
                            </div>
                            <div class="col-sm-6 invoice-col">
                                <?=$record['designation']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-6 invoice-col">
                                <?=trans('assessment_date')?>
                            </div>
                            <div class="col-sm-6 invoice-col">
                                <?=$record['assessment_date']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-6 invoice-col">
                                <?=trans('assessment_criteria')?>
                            </div>
                            <div class="col-sm-6 invoice-col">
                                <?=$record['assessment_criteria']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-6 invoice-col">
                                <?=trans('assessment_type')?>
                            </div>
                            <div class="col-sm-6 invoice-col">
                                <?=$record['assessment_type']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-12 invoice-col">
                                <?=trans('main_product')?>
                            </div>                            
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                          <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col">
                                <?=$record['product']?>
                            </div>
                          </div>
                      </td>
                    </tr>

                    <tr>
                      <td>7</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-12 invoice-col">
                                <?=trans('assessment_address')?>
                            </div>                            
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                          <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col">
                                <?=$record['assessment_address']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td colspan="2">
                          <div class="row invoice-info">                            
                            <div class="col-sm-12 invoice-col">
                                <?=trans('general_comment')?>
                            </div>
                            
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                          <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col">
                                <?=$record['comment']?>
                            </div>
                          </div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="pagebreak"></div>
    <!-- /.content -->
      <!-- /.content 2 -->
      <!-- Summary of Marks-->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="col-12 table-responsive">
                  <table class="table" id="assessment_result_heading">
                    <thead>
                    <tr>
                      <th colspan="3"><?=trans('assessment_result')?></th>
                    </tr>
                    <tr>
                      <th colspan="3">Summary of Marks</th>
                    </tr>
                    </thead>
                  </table>
                  <table class="table" id="assessment_result1">
                    <thead>
                      <tr>
                        <th colspan="2" rowspan="2"><?=trans('assessment_areas')?></th>
                        <th colspan="2"><?=trans('assessment_marks')?></th>                        
                        <th rowspan="2"><?=trans('assessment_percent')?></th>
                      </tr>
                      <tr>
                        <th ><?=trans('assessment_full_mark')?></th>
                        <th ><?=trans('assessment_scored')?></th>
                      </tr>
                    </thead>  
                    <tbody>
                    <?php foreach($areas_assessment as $key=>$area):?>
                    <tr>
                      <td width="10px"><?=$key+1?>.</td>
                      <td >
                        <h4>
                          <?=$area['name']?>                   
                        </h4>
                      </td>
                      <td width="10px"><?=$area['count_result']*5?></td>
                      <td width="10px"><?=$area['total_score']?></td>
                      <td width="10px"><?=$area['count_result'] == 0 ? '0': number_format($area['total_score']/($area['count_result']*5),2)?>%</td>
                    </tr>
                    <?php endforeach; ?>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"><?=trans('assessment_total')?></td>
                        <td><?=$max_marks?></td>
                        <td><?=$scored?></td>
                        <td><?=$max_marks==0 ? '0' : number_format(($scored/$max_marks),2)?>%</td>
                      </tr>
                    </tfoot>
                  </table>
                  
                </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3 col-10">
              <!-- title row -->
              <div class="chart-view">
                  <canvas id="canvas"></canvas>
              </div> 
            </div>
            <div class="invoice p-3 mb-3">  
              <div class="recommendation">
                <h3><?=trans('recommendation')?></h3>
                <div>
                      <?=$conclusions?>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- .row -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="pagebreak"></div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="col-12 table-responsive">
                  <table class="table" id="assessment_best_practices_heading">
                    <thead>
                    <tr>
                      <th colspan="3"><?=trans('photo_illustration_of_5s_best_practices')?></th>
                    </tr>
                    <tr>
                      <th colspan="3">Photo illustration of 5s best practices</th>
                    </tr>
                    </thead>
                  </table>
                  <table class="table" id="areas_best_practices">  
                    <tbody>
                    <?php foreach($areas_best_practices as $key=>$practice):?>
                    <tr>                     
                      <td colspan="2">
                        <h4>
                          <?=$practice['name']?>                   
                        </h4>
                      	<?=$practice['best_practices_content'] != null?$practice['best_practices_content'] : ''?>
											</td>                      
                    </tr>
                    <?php endforeach; ?>
                    
                    </tbody>
                  </table>
                </div>

            
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="pagebreak"></div>
    <!-- areas_assessment_findings -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="col-12 table-responsive">
                  <table class="table" id="areas_assessment_findings_heading">
                    <thead>
                    <tr>
                      <th colspan="2"><?=trans('assessment_findings_h2')?></th>
                    </tr>
                    <tr>
                      <th colspan="2">Assessment Findings</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Lưu Ý:</td>
                        <td>
                          <i>O: Điểm lưu ý - Observation</i><br>
                          <i>I: Điểm cần cái tiến - Need for further improvement</i>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table" id="areas_assessment_findings"> 
                    <tbody>
                    <?php foreach($areas_assessment_findings as $key=>$findings):?>
                    <tr>
                      <td >
                        <h4>
                          <?=$findings['name']?>                   
                        </h4>
                      	<?=$findings['assessment_findings_content']?>
											</td>
                      
                    </tr>
                    <?php endforeach; ?>
                    
                    </tbody>
                  </table>
                </div>

          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- .row -->
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <section class="no-print">
					<?php if($record['status'] == 1): ?>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info alert-dismissible text-center">                  
									<?=trans('working_assessment')?>	
                </div>
								<?php if($theRole == 1) :?>
									<?php echo form_open(base_url('admin/campaign/send_approve'), 'class="form-horizontal"');  ?>
										<input type="hidden" name="id" value="<?=$record['id']?>" />
										<button type="submit" class="btn btn-block btn-primary btn-lg"><?=trans('send_approvement')?></button>
									<?php echo form_close(); ?>
								<?php elseif($theRole == 0) :?>
								<?php else :?>
								<?php endif; ?>
							</div>
						</div>
					<?php elseif($record['status'] == 2):	?>
						<div class="row">
							<div class="col-md-12">
							<div class="alert alert-info alert-dismissible text-center">                  
									<?=trans('editting_assessment')?>	
                </div>
								<?php if($theRole == 1) :?>
									<?php echo form_open(base_url('admin/campaign/send_approve'), 'class="form-horizontal"');  ?>
										<input type="hidden" name="id" value="<?=$record['id']?>" />
										<button type="submit" class="btn btn-block btn-primary btn-lg"><?=trans('send_approvement')?></button>
									<?php echo form_close(); ?>
								<?php elseif($theRole == 0) :?>
								<?php else :?>
								<?php endif; ?>
							</div>
						</div>
					<?php elseif($record['status'] == 3):	?>
						<div class="row">
							<div class="col-md-12">
							<div class="alert alert-danger alert-dismissible text-center">                  
									<?=trans('reject_assessment')?>	
                </div>
							
							<?php if($theRole == 1) :?>
										<?php echo form_open(base_url('admin/campaign/making_edition'), 'class="form-horizontal"');  ?>
											<input type="hidden" name="id" value="<?=$record['id']?>" />
											<button type="submit" class="btn btn-block btn-primary btn-lg" name="approve" value="approve"><?=trans('making_edition')?></button>
											
										<?php echo form_close(); ?>
									<?php elseif($theRole == 0) :?>
									<?php else :?>
									<?php endif; ?>
								</div>
						</div>

					<?php elseif($record['status'] == 4): ?>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info alert-dismissible text-center">
                  
									<?=trans('waitting_assessment')?>	
                </div>
									<?php if($theRole == 3) :?>
										<?php echo form_open(base_url('admin/campaign/approve'), 'class="form-horizontal"');  ?>
											<input type="hidden" name="id" value="<?=$record['id']?>" />
											<button type="submit" class="btn btn-block btn-primary btn-lg" name="approve" value="approve"><?=trans('approve')?></button>
											<button type="submit" class="btn btn-block btn-primary btn-lg" name="approve" value="reject"><?=trans('reject')?></button>
										<?php echo form_close(); ?>
									<?php elseif($theRole == 0) :?>
									<?php else :?>
									<?php endif; ?>
							</div>
						</div>
					<?php elseif($record['status'] == 5): ?>
						<div class="row">
							<div class="col-md-12">
									<div class="alert alert-success alert-dismissible text-center">							
										<?=trans('approved_assessment')?>
									</div>
									<button type="button" class="btn btn-block btn-primary btn-lg" name="printer" value="approve" onClick="window.print()">Print</button>		
							</div>
						</div>
					<?php endif; ?>
		</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- ChartJS 1.0.1 -->
<script src="<?= base_url()?>assets/plugins/chart.js/chart.min.js"></script>

<!-- page script -->
<script>
const ctx = document.getElementById('canvas').getContext('2d');
const myChart = new Chart(ctx, {
    data: {
        datasets: [{
            type: 'bar',
            label: '',
            data: [
              <?php foreach($areas_assessment as $key=>$area): ?>
            <?php if($key ==0): ?>
              <?=number_format(100*$area['total_score']/($area['count_result']*5),1)?>
            <?php else: ?>
              ,<?=number_format(100*$area['total_score']/($area['count_result']*5),1)?>
            <?php endif;?>
          <?php endforeach;?>
              ],
            backgroundColor: [
              <?php foreach($areas_assessment as $key=>$area): ?>
            <?php if($key ==0): ?>
              'rgba(0, 102, 102, 01)'
            <?php else: ?>
              ,'rgba(0, 102, 102, 01)'
            <?php endif;?>
          <?php endforeach;?>
              ],
              borderColor: [
                <?php foreach($areas_assessment as $key=>$area): ?>
            <?php if($key ==0): ?>
              'rgba(0, 102, 102, 01)'
            <?php else: ?>
              ,'rgba(0, 102, 102, 01)'
            <?php endif;?>
          <?php endforeach;?>
              ],
              borderWidth: 1,
              order: 2,
              barThickness: 20,
        }, {
            type: 'line',
            label: '',
            data: [
              <?php foreach($areas_assessment as $key=>$area): ?>
            <?php if($key ==0): ?>
              70
            <?php else: ?>
              ,70
            <?php endif;?>
          <?php endforeach;?>
            ],
            borderColor: 'rgb(236, 18, 18)',
            order: 1
        }],
        labels: [
          <?php foreach($areas_assessment as $key=>$area): ?>
            <?php if($key ==0): ?>
              "<?=lable_chart($area['name'])?>"
            <?php else: ?>
              ,"<?=lable_chart($area['name'])?>"
            <?php endif;?>
          <?php endforeach;?>
          ]
    },
    options: {
      responsive: true,
    scales: {
      y: {
          beginAtZero: true,
          max:100,
          title: {
          display: true,
          text: 'Chart - by VNPI'
        },
        xAxes: [{
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90
                }
            }]
          
      }
    }
  }
});

function beforePrint () {
  for (const id in Chart.instances) {
    Chart.instances[id].resize()
  }
}

if (window.matchMedia) {
  let mediaQueryList = window.matchMedia('print')
  mediaQueryList.addListener((mql) => {
    if (mql.matches) {
      beforePrint()
    }
  })
}

window.onbeforeprint = beforePrint;
</script>
