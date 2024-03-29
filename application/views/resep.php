<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Resep</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Resep</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-success" data-toggle="modal" data-target="#modal" onclick="add()">Add</button>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="resep">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Resep</th>
                  <th>Cost per Item (Estimated)</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<div class="modal fade" id="modal">
<div class="modal-dialog modal-xl">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Add Data</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="form">
      <input type="hidden" name="id" id="id">
      <div class="form-group">
        <label>Nama Resep Produk</label>
        <input type="text" name="nama" id="nama" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Total Cost Resep</label>
        <input name="cost" id="cost" class="form-control select2" disabled></select>
      </div>

			<table id="menuTable" class="table w-100 table-bordered table-hover">
				<tr>
					<th>Nama Bahan</th>
					<th>Qty</th>
					<th>Bahan Utama</th>
					<th>Action</th>
				</tr>
				<tr id='tr'>
					<td><div class="form-group"><select id="bahan" name="menuName[]" class="form-control select2" required></select></div><input type="hidden" id="id_bahan_before" value="0"></td>
					<td><div style="display: flex; align-items: center;"> <div class="form-group" style="margin-right: 5px;"> <input class="form-control" type="number" name="qty[]" min="1" required /></div><div><div class="col-auto align-self-center" id="satuan"></div></div></div></td>
					<td><div class="form-group"><input type="radio" class="form-control" name="isBahanUtama" required /></div></td>
					<td></td>
				</tr>
			</table><br>
			
      <button class="btn btn-add btn-success" type="submit">Add</button>
			<button class="btn btn-info" type="button" onclick="addRow()">Add Bahan</button>
      <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
</div>
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script>
  var readUrl = '<?php echo site_url('resep/read') ?>';
  var addUrl = '<?php echo site_url('resep/add') ?>';
  var deleteUrl = '<?php echo site_url('resep/delete') ?>';
  var editUrl = '<?php echo site_url('resep/edit') ?>';
  var getBahanUrl = '<?php echo site_url('bahan/get_bahan') ?>';
  var deleteBahan = '<?php echo site_url('resep/delete_detail_resep') ?>';
	var getResepUrl = '<?php echo site_url('resep/get_resep') ?>';
  var kategoriSearchUrl = '<?php echo site_url('resep/search') ?>';
  var bahanSearchUrl = '<?php echo site_url('bahan/search') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/resep.js') ?>"></script>
</body>
</html>
