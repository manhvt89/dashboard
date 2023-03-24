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
      #assessment_overview, #assessment_result{
        background-color:#fff !important;
      }
      #assessment_overview thead, #assessment_result thead {
              border: 2px solid green;
              text-align: center;
          }
          #assessment_overview thead tr th,  #assessment_result thead tr th{
              border: 0px solid green;
              text-align: center;
          }
      @media print {
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
                  <table class="table responsive-table" id="assessment_result1">
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
                      <td width="10px"><?=number_format($area['total_score']/($area['count_result']*5),2)?>%</td>
                    </tr>
                    <?php endforeach; ?>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"><?=trans('assessment_total')?></td>
                        <td><?=$max_marks?></td>
                        <td><?=$scored?></td>
                        <td><?=number_format(($scored/$max_marks),2)?>%</td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
            


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
  


              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="fa fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- .row -->
        <div class="row">
          <div class="col-12">
                <div class="chart">
                  <canvas id="canvas" style="height:230px"></canvas>
                </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- ChartJS 1.0.1 -->
<script src="<?= base_url()?>assets/plugins/chart.js/Chart.min.js"></script>

<!-- page script -->
<script>

var barChartData = {
          labels: [<?php foreach($areas_assessment as $key=>$area): ?>
                        <?php if($key == 0): ?>
                        
                        "<?=$area['name']?>"
                        <?php else: ?>
                          ,"<?=$area['name']?>"
                        <?php endif; ?>
                    <?php endforeach; ?>],
          datasets: [{
              type: 'bar',
                label: "",
                  data: [
                    <?php foreach($areas_assessment as $key=>$area): ?>
                        <?php if($key == 0): ?>
                        
                        "<?=number_format((100*$area['total_score'])/($area['count_result']*5),2)?>"
                        <?php else: ?>
                          ,"<?=number_format((100*$area['total_score'])/($area['count_result']*5),2)?>"
                        <?php endif; ?>
                    <?php endforeach; ?>],
                  fill: false,
                  backgroundColor: '#71B37C',
                  borderColor: '#71B37C',
                  hoverBackgroundColor: '#71B37C',
                  hoverBorderColor: '#71B37C',
                  yAxisID: 'y-axis-1'
          }, {
              label: "",
                  type:'line',
                  data: [70, 70, 70, 70, 70, 70],
                  fill: false,
                  borderColor: '#EC932F',
                  backgroundColor: '#EC932F',
                  pointBorderColor: '#EC932F',
                  pointBackgroundColor: '#EC932F',
                  pointHoverBackgroundColor: '#EC932F',
                  pointHoverBorderColor: '#EC932F',
                  yAxisID: 'y-axis-2'
          } ]
      };
      
      window.onload = function() {
          var ctx = document.getElementById("canvas").getContext("2d");
          window.myBar = new Chart(ctx, {
              type: 'bar',
              data: barChartData,
              options: {
              responsive: true,
              tooltips: {
                mode: 'label'
            },
            elements: {
              line: {
                  fill: false
              }
          },
            scales: {
              xAxes: [{
                  display: true,
                  gridLines: {
                      display: false
                  },
                  labels: {
                      show: true,
                  }
              }],
              yAxes: [{
                  type: "linear",
                  display: true,
                  position: "left",
                  id: "y-axis-1",
                  gridLines:{
                      display: false
                  },
                  labels: {
                      show:true,
                      
                  }
              }, {
                  type: "linear",
                  display: true,
                  position: "right",
                  id: "y-axis-2",
                  gridLines:{
                      display: false
                  },
                  labels: {
                      show:true,
                      
                  }
              }]
          }
          }
          });
      };


</script>