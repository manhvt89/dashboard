  <!-- Content Wrapper. Contains page content -->
  <style type="text/css">
      

.container {
  margin: 5% 3%;
}

.criteria {
  list-style-type: none;
  list-style-position: outside;
  list-style-image: none;
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
    </style>
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
                    <h4 data-type="title">
                        XEM TRƯỚC BIỂU MẪU ĐÁNH GIÁ THỰC HÀNH TỐT 5S
                    </h4>
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <?php foreach($theRecords as $record): ?>
                    <div class="area" id="area_row_<?=$record['id']?>"><?=$record['name']?></div>
                    <?php if($record['categories'] != null): ?>
                        <table class="responsive-table" width="90%">
                            <tr><td rowspan="2" data-title="heading">Nội dung đánh giá</td><td colspan = "5" data-title="heading" width="20%">Kết quả điểm</td></tr>
                            <tr><td data-type="point">1</td><td data-type="point">2</td><td data-type="point">3</td><td data-type="point">4</td><td data-type="point">5</td></tr>
                        <?php foreach($record['categories'] as $category): ?>
                            <tr id="category_row_<?=$category['id']?>"><td><b><?=$category['name']?></b></td><td></td><td></td><td></td><td></td><td></td></tr>
                            <?php if($category['questions'] != null): ?>
                                <?php foreach($category['questions'] as $question): ?>
                                    <tr id="question_row_<?=$category['id']?>" >
                                        <td data-type="question">
                                          <?=$question['content']?>
                                          
                                          <?php if(!empty($question['criterias'])): ?>
                                            <ul class="criteria">
                                              <?php $index =1; foreach($question['criterias'] as $criteria):?>
                                                <li><?=$index . '. '.$criteria['content']?></li>
                                              <?php $index++; endforeach;?>
                                            </ul>  
                                          <?php endif;?>
                                        </td>
                                        <td data-type="point">
                                            <label>
                                                <input type="radio" class="flat-red" name="question_point_<?=$question['id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point">
                                            <label>
                                                <input type="radio" class="flat-red" name="question_point_<?=$question['id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point">
                                            <label>
                                                <input type="radio" class="flat-red" name="question_point_<?=$question['id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point">
                                            <label>
                                                <input type="radio" class="flat-red" name="question_point_<?=$question['id']?>">
                                            </label>
                                        </td>
                                        <td data-type="point">
                                            <label>
                                                <input type="radio" class="flat-red" name="question_point_<?=$question['id']?>">
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div class="form-group">
                                                <label><?=trans('question_comment')?></label>
                                                <textarea class="form-control" rows="3" placeholder="Enter ..." id="question_comment_<?=$question['id']?>" name="question_comment_<?=$question['id']?>"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!-- /.row -->
            <div class="row">
            <?php if($form['status'] == 1): ?>
            <?php echo form_open(base_url('admin/assessment/lock_form'), 'class="form-horizontal"');  ?>               
                <div class="card-body">
                  <div class="form-check">
                        <input type="hidden" class="form-check-input" id="form_id" name="id" value="<?=$form['id']?>">                
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    
                  <button type="submit" name="submit" value="<?=trans('lock_form_submit')?>" class="btn btn-primary"><?=trans('lock_form_submit')?></button>
                </div>
                <?php echo form_close(); ?>
            <?php elseif($form['status'] == 3): ?>
              <div class="card-body">
                  <div class="form-check">
                                     
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    
                  <?=trans('form_lock')?>
                </div>
            <?php endif; ?>    
            </div>
        </div><!--/. container-fluid -->
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- PAGE PLUGINS -->
<!-- SparkLine -->