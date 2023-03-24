  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              <?= trans('view_company') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/company'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('company_list') ?></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <!-- form start -->
                <div class="box-body">

                  <div class="form-group">
                    <label for="companyname" class="col-md-12 control-label"><?= trans('company_name') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="companyname" class="form-control" id="companyname" placeholder="" disabled value="<?=$record['name']?>">
                    </div>
                  </div>
                 
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company_phone" class="col-md-12 control-label"><?= trans('company_phone') ?></label>

                        <div class="col-md-12">
                          <input type="number" name="company_phone" class="form-control" id="company_phone" placeholder="" disabled value="<?=$record['tel']?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company_fax" class="col-md-12 control-label"><?= trans('company_fax') ?></label>

                        <div class="col-md-12">
                          <input type="number" name="company_fax" class="form-control" id="company_fax" placeholder="" disabled value="<?=$record['fax']?>">
                        </div>
                      </div>
                    </div>  
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company_authorized" class="col-md-12 control-label"><?= trans('company_authorized') ?></label>

                        <div class="col-md-12">
                          <input type="text" name="company_authorized" class="form-control" id="company_authorized" placeholder="" disabled value="<?=$record['authorized']?>"> 
                        </div>
                      </div>
                    </div>  
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="company_designation" class="col-md-12 control-label"><?= trans('company_designation') ?></label>

                          <div class="col-md-12">
                            <input type="text" name="company_designation" class="form-control" id="company_designation" placeholder="" disabled value="<?=$record['designation']?>">
                          </div>
                      </div>
                    </div>
                  </div>    
                  <div class="form-group">
                    <label for="main_product" class="col-md-12 control-label"><?= trans('main_product') ?></label>

                    <div class="col-md-12">
                      <textarea id="main_product" name="main_product" style="width: 100%" disabled><?=$record['product']?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address" class="col-md-12 control-label"><?= trans('company_address') ?></label>

                    <div class="col-md-12">
                      <input type="text" name="address" class="form-control" id="address" placeholder="" disabled value="<?=$company_address?>">
                    </div>
                  </div>
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
        /*
        var aTelco = new Array('','Mobi','Vina','Viettel','VNMB','','ITelecom')
        var dataTelco = [
                            { id: 1, text: 'Mobi' },
                            { id: 2, text: 'Vina' },
                            { id: 3, text: 'Viettel' },
                            { id: 4, text: 'VNMB' },
                            { id: 6, text: 'ITelecom' }
        ];*/
    var states = <?=$states?>;
    var cities = <?=$cities?>;
    var wards = <?=$wards?>;
    var loadSelect2 = function () {
                // loading data from array
                $('#state').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_state') ?>",
                    data: states
                });

                $('#city').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_city') ?>",
                    disabled: true,
                });

                $('#ward').select2({
                    allowClear: true,
                    placeholder: "<?= trans('select_ward') ?>",
                    disabled: true,
                });
                //$('#city').prop('disabled', true);
                //$('#city').prop('disabled', true);
            }
    function setDataPrefix() {
          var valCity = $('#city').select2("val");
          $("#city").html('');

          var valWard = $('#ward').select2("val");
          $("#ward").html('');

          var stateselected = $('#state').select2("val");
          console.log(stateselected);
          if(stateselected.length==0){
              $('#city').prop('disabled', true);
              $('#ward').prop('disabled', true);
          } else {
            $('#city').prop('disabled', false);
            var vOption;
                      
                          vOption = '<option value="' + 0 + '" data-select2-id="' + 0 + '">' + '' + '</option>';
                         
                          $(vOption).appendTo('#city');
            $.each(cities, function (i, obj) {
                      if (obj.state_id == stateselected) {
                          var vOption;
                      
                          vOption = '<option value="' + obj.id + '" data-select2-id="' + obj.id + '">' + obj.text + '</option>';
                         
                          $(vOption).appendTo('#city');
                      }
                  });
                  
          var cityselected = $('#city').select2("val");
          console.log(cityselected);
          if(stateselected.length==0){
            $('#ward').prop('disabled', true);
          }
          else{
              
              $.each(wards, function (i, obj) {
                  if (obj.city_id == cityselected) {
                      var vOption;
                      
                      vOption = '<option value="' + obj.id + '" data-select2-id="' + obj.id + '">' + obj.text + '</option>';
                      
                      $(vOption).appendTo('#ward');
                  }
              });
              $("#ward").select2('destroy');
              $("#ward").val(valWard);
              $("#ward").select2(
                
              );
          }
        }
          console.log(valCity);
          $("#city").select2('destroy');
          //$("#city").val(valCity);
          $("#city").select2();

          
        
      }
  loadSelect2();
  //setDataPrefix();

  $('#state').on('change', function (e) {
            //$('#city').prop('disabled', false);
            setDataPrefix();
        });

  $('#city').on('change', function (e) {
            
            var valCity = $('#city').select2("val");
            $("#ward").html('');
            if(valCity != '')
            {
              console.log("city ID selected: "+ valCity);
              var vOption;                      
                        vOption = '<option value="' + 0 + '" data-select2-id="' + 0 + '">' + '' + '</option>';
                        $(vOption).appendTo('#ward');
              $.each(wards, function (i, obj) {
                    if (obj.city_id == valCity) {
                        var vOption;                      
                        vOption = '<option value="' + obj.id + '" data-select2-id="' + obj.id + '">' + obj.text + '</option>';
                        $(vOption).appendTo('#ward');
                    }
                });
                
                //$("#ward").val(valWard);
                $('#ward').prop('disabled', false);
                $('#ward').prop('allowClear', true);
                $("#ward").select2('destroy');
                $("#ward").select2();
            }
        });
        

</script>            