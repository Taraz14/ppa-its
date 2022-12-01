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
                Tabel Administrator
            </div>
            <div class="card-body">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Graiden</td>
                            <td>vehicula.aliquet@semconsequat.co.uk</td>
                            <td>076 4820 8838</td>
                            <td>Offenburg</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                            	<button href="#" class="btn icon btn-primary"><i class="bi bi-pencil"></i></button>
                            <button href="#" class="btn icon btn-secondary"><i class="bi bi-person"></i></button>
                            <button href="#" class="btn icon btn-info"><i class="bi bi-info-circle"></i></button>
                            <button href="#" class="btn icon btn-warning"><i class="bi bi-exclamation-triangle"></i></button>
                            <button href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></button>
                            <button href="#" class="btn icon btn-success"><i class="bi bi-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
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
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script src="<?=base_url('assets/dist')?>/assets/js/pages/datatables.js"></script>
<script type="text/javascript">
	element = document.getElementById("admin_menu");
    element.classList.add("active");
</script>
</body>

</html>
