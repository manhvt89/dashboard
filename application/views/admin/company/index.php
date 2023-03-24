<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css"> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
         <!-- For Messages -->
        <?php $this->load->view('admin/includes/_messages.php') ?>
        <div class="card">
            <div class="card-body">
                <div class="d-inline-block">
                  <h3 class="card-title">
                    <i class="fa fa-list"></i>
                    <?= trans('company_list') ?>
                  </h3>
              </div>
              <div class="d-inline-block float-right">
                
              </div>
            </div>
            <div class="card-body"> 
            </div> 
        </div>
    </section>


    <!-- Main content -->
    <section class="content mt10">
    	<div class="card">
    		<div class="card-body">
               <!-- Load Admin list (json request)-->
               <div class="data_container">
                <div class="datalist">
                        <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50">STT</th>
                                <th width="50"><?= trans('id') ?></th>
                                <th><?= trans('company_name') ?></th>
                                <th><?= trans('company_authorized') ?></th>
                                <th><?= trans('company_phone') ?></th>
                                <th><?= trans('company_address') ?></th>
                                <th><?= trans('company_view_evaluation') ?></th>
                                <th><?= trans('company_create_evaluation') ?></th>
                                <th width="50">ACT</th>
                            </tr>
                        </thead>
                        </table>
                </div> 
               </div>
           </div>
       </div>
    </section>
    <!-- /.content -->
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
      $("#example1").DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[25, 50, 100], [25, 50, 100]],
        "processing": true,
        "serverSide": true,
        //"deferLoading": total,
        "deferRender": true,
        "ajax": "<?=base_url('admin/company/list_companies_json')?>",
        "order": [[1,'desc']],
        "columnDefs": [
            { "targets": 0, "name": "stt", 'searchable':true, 'orderable':true},
            { "targets": 1, "name": "id", 'searchable':true, 'orderable':true},
            { "targets": 2, "name": "company_name", 'searchable':true, 'orderable':true},
            { "targets": 3, "name": "company_authorized", 'searchable':true, 'orderable':true},
            { "targets": 4, "name": "company_phone", 'searchable':true, 'orderable':true},
            { "targets": 5, "name": "company_address", 'searchable':true, 'orderable':true},
            { "targets": 5, "name": "company_view_evaluation", 'searchable':true, 'orderable':true},
            { "targets": 5, "name": "company_create_evaluation", 'searchable':true, 'orderable':true},
          ]
    });
  });

</script> 

<script>
//------------------------------------------------------------------

//---------------------------------------------------------------------
$("body").on("change",".tgl_checkbox",function(){
$.post('<?=base_url("admin/admin/change_status")?>',
{
    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	id : $(this).data('id'),
	status : $(this).is(':checked')==true?1:0
},
function(data){
	$.notify("Status Changed Successfully", "success");
});
});
</script>
