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
                    <?= trans('campaign_list') ?>
                  </h3>
              </div>
              <div class="d-inline-block float-right">
                
              </div>
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
                                <th width="50"><?= trans('assessment_type') ?></th>                                
                                <th><?= trans('evaluation_name') ?></th>
                                <th><?= trans('company_name') ?></th>
                                <th><?= trans('date_evaluation') ?></th>
                                <th><?= trans('status_evaluation') ?></th>
                                <th><?= trans('action_evaluation') ?></th>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
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
        "ajax": "<?=base_url('admin/campaign/list_campaigns_json')?>",
        "order": [[1,'desc']],
        "columnDefs": [
            { "targets": 0, "name": "stt", 'searchable':true, 'orderable':true},
            { "targets": 1, "name": "assessment_type", 'searchable':true, 'orderable':true},
            { "targets": 2, "name": "company_name", 'searchable':true, 'orderable':true},
            { "targets": 3, "name": "company_authorized", 'searchable':true, 'orderable':true},
            { "targets": 4, "name": "company_phone", 'searchable':true, 'orderable':true},
            { "targets": 5, "name": "company_address", 'searchable':true, 'orderable':true},
            { "targets": 6, "name": "company_view_evaluation", 'searchable':true, 'orderable':true},
          ],
					"language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi trên mỗi trang",
            "zeroRecords": "Bạn chưa tham gia cuộc đánh giá nào",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ tổng số bản ghi)",
						"decimal":        "",
						"emptyTable":     "No data available in table",
						"info":           "Showing _START_ to _END_ of _TOTAL_ entries",
						"infoPostFix":    "",
						"thousands":      ",",
						"loadingRecords": "Loading...",
						"processing":     "Processing...",
						"search":         "Tìm kiếm:",
						"paginate": {
								"first":      "Đầu tiên",
								"last":       "Cuối cùng",
								"next":       "Tiếp theo",
								"previous":   "Trước"
						},
						"aria": {
								"sortAscending":  ": activate to sort column ascending",
								"sortDescending": ": activate to sort column descending"
						}
        }
    });
  });
</script> 
<script>

$('#example1').on('click','.delete_campaign',function () {
      var campaign_id = $( this ).attr("data_id");
      var csrf_tk_name = '<?=$this->security->get_csrf_hash()?>';
			console.log(csrf_tk_name);
			console.log(campaign_id);
			var row_id = "row_" + campaign_id;
			//var r = confirm("Bạn có chắc chắn xóa mục này?");
			$.confirm({
						title: 'Xác nhận',
						content: 'Sau khi xóa bạn không thể khôi phục! Bạn có chắc chắn muốn xóa?',
						buttons: {
								confirm: {
									text:'Đồng ý xóa',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
												type: "POST",
												url: "<?=base_url('admin/campaign/delete_campaign')?>",
												data: {id:campaign_id, csrf_test_name: csrf_tk_name},
												//data: form_data,
												success: function(data) {
												
														if(data.result == 0)
														{
															$('#'+row_id).remove();
														} else {
															$.alert('Chưa xóa được cuộc đánh giá này');
														}
												},
												dataType: "json",
											});
									}
								},
								cancel: {
									text: 'Hủy yêu cầu xóa',
									action: function () {

										$.alert('Bạn đã không thực hiện xóa!');
									}
								},
								
						}
				});
});
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
