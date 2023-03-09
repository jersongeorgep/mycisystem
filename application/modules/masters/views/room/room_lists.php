<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><span></span><a href="<?= site_url('masters/room/add_new'); ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> New </a> <button type="button" id="delete_btn" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete </button></span></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm text-sm">
          <thead>
            <tr>
              <th class="text-center" width="6%">Sl. No.</th>
              <th class="text-center" width="2%"><input type="checkbox" id="select_all" name="select_all"></th>
              <th class="text-center" width="7%" >Room No</th>
              <th class="text-center" width="10%" >Branch</th>
              <th class="text-center" width="7%" >Bed Size</th>
              <th class="text-center" width="8%">Bathrooms</th>
              <th class="text-center" width="12%">Type</th>
              <th class="text-center" width="10%">Status</th>
              <th class="text-center" width="8%">Price</th>
              <th class="text-center" width="8%">Ex.Bed Price</th>
              <th class="text-center" width="6%">Action</th>
            </tr>
          </thead>
          <tbody id="show_data">
            <?php if ($rooms) :
              $sl_no = 1;
            ?>
              <?php foreach ($rooms as $value) : ?>
                <tr>
                  <td class="text-center"><?= $sl_no; ?></td>
                  <td class="text-center"><input type="checkbox" name="ids[]" id="ids_<?= $value->id; ?>" value="<?= $value->id; ?>" /></td>
                  <td class="text-center"><?= $value->room_no; ?></td>
                  <td class="text-center"><?= $value->branch_name; ?></td>
                  <td class="text-center"><?= $value->bed_size; ?></td>
                  <td class="text-center"><?= $value->bathrooms_count; ?></td>
                  <td class="text-center"><?= $value->type; ?></td>
                  <td class="text-center"><?= $value->room_status; ?></td>
                  <td class="text-right"><?= round($value->price, 2); ?></td>
                  <td class="text-right"><?= round($value->extra_bed_price, 2); ?></td>
                  <td><a href="<?= site_url('masters/room/edit_room/' . $value->id); ?>" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i></a></td>
                </tr>
              <?php
                $sl_no++;
              endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>

<!-- DataTables  & Plugins -->
<script src="<?= site_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      //"buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#select_all").click(function() {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#delete_btn').on('click', function() {
      var post_arr = [];
      $('#show_data input[type=checkbox]').each(function() {
        if (jQuery(this).is(":checked")) {
          var id = this.value;
          post_arr.push(id);
        }
      });
      if (post_arr.length > 0) {
        if (confirm("Do you really want to delete records?")) {
          $.ajax({
            type: "POST",
            url: base_url + "masters/room/delete_room",
            async: false,
            cache: false,
            data: {
              ids: post_arr
            },
            success: function(response) {
              $.each(post_arr, function(i, l) {
                $("#ids_" + l).closest('tr').remove();
              });
              toastr.error("Data Deleted");
            }
          });
        }
      } else {
        alert("Please select rows for delete");
      }
    });

  });
</script>