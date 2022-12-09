 <link rel="stylesheet" href="<?=base_url('assets')?>/datatables/datatables.min.css">
 <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Administrator</h3>
                <p class="text-subtitle text-muted">Manage administrator website</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('adm')?>">adm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrator</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                Jquery Datatable
            </div>
            <div class="card-body">
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
              </tr>
            </tfoot>
          </table>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
</div>


        </div>
    </div>
    <script src="<?=base_url('assets/dist')?>/assets/js/bootstrap.js"></script>
    <script src="<?=base_url('assets/dist')?>/assets/js/app.js"></script>
    
<script src="<?=base_url('assets/dist')?>/assets/extensions/jquery/jquery.min.js"></script>
<!-- <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script> -->
<script src="<?=base_url('assets')?>/datatables/datatables.min.js"></script>
<!-- <script src="<?=base_url('assets/dist')?>/assets/js/pages/datatables.js"></script> -->
<script type="text/javascript">
	element = document.getElementById("client_menu");
    element.classList.add("active");
</script>
<!-- js table -->
<script type="text/javascript" src="<?=base_url()?>/assets/js/user.js"></script>

</body>

</html>
