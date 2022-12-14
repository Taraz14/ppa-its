 <link rel="stylesheet" href="<?=base_url('assets')?>/datatables/css/jquery.dataTables.min.css">



<!-- Basic Tables start -->
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Administrator
            </div>
            <div class="card-body">
                <div class="mb-3">

                    <select class="form-control w-25 select2" aria-label="Default select example" id="select_level_user">
                    </select>
                </div>
                <div class="mb-3">
                
                    <button class="btn btn-primary tambah_user">Tambah User</button>
                </div>

                <div class="table-responsive">
                    <table id="tabel_serverside" class="table table-bordered display text-center" cellspacing="0" width="100%">
                      <thead>
                        <tr  class="text-center">
                          <th style="width: 5%; text-align: center;">NO</th>
                          <th style="width: 20%;">NAMA/EMAIL</th>
                          <th style="width: 5%; ">FOTO</th>
                          <th style="width: 15%;">LEVEL USER</th>
                          <th style="width: 15%;">STATUS</th>
                          <th style="width: 40%; text-align: center;">ACTION</th>
                      </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th style="width: 5%; text-align: center;">NO</th>
                      <th style="width: 20%;">NAMA/EMAIL</th>
                      <th  style="width: 5%;">FOTO</th>
                      <th style="width: 15%;">LEVEL USER</th>
                      <th style="width: 15%;">STATUS</th>
                      <th style="width: 40%; text-align: center;">ACTION</th>
                  </tr>
              </tfoot>
          </table>
      </div>
  </div>
  </div>

</section>
<!-- Basic Tables end -->
</div>



<script src="<?=base_url('assets/dist')?>/assets/extensions/jquery/jquery.min.js"></script>
<script src="<?=base_url('assets')?>/datatables/js/jquery.dataTables.min.js"></script>

<!-- <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script> -->
<!-- <script src="<?=base_url('assets/dist')?>/assets/js/pages/datatables.js"></script> -->
<script type="text/javascript">
    element = document.getElementById("admin_menu");
    element.classList.add("active");
</script>
<!-- js table -->
<script type="text/javascript" src="<?=base_url()?>/assets/js/user.js"></script>


