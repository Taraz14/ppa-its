 <link rel="stylesheet" href="<?=base_url('assets')?>/datatables/css/jquery.dataTables.min.css">
 <!-- Basic Tables start -->
 <div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                Category List
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
                    <table id="tabel_serverside_cat" class="table table-bordered display text-center" cellspacing="0" width="100%">
                      <thead>
                        <tr  class="text-center">
                          <th style="width: 5%; text-align: center;">NO</th>
                          <th style="width: 50%;">Category name</th>
                          <th style="width: 45%; text-align: center;">ACTION</th>
                      </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                        <th style="width: 5%; text-align: center;">NO</th>
                        <th style="width: 50%;">Category name</th>
                        <th style="width: 45%; text-align: center;">ACTION</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Sub Category List
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
            <table id="tabel_serverside_sub_cat" class="table table-bordered display text-center" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                   <th style="width: 5%; text-align: center;">NO</th>
                   <th style="width: 25%;">Category name</th>
                   <th style="width: 25%;">Sub Category name</th>
                   <th style="width: 45%; text-align: center;">ACTION</th>
               </tr>
           </thead>
           <tfoot>
            <tr class="text-center">
             <th style="width: 5%; text-align: center;">NO</th>
             <th style="width: 25%;">Category name</th>
             <th style="width: 25%;">Sub Category name</th>
             <th style="width: 45%; text-align: center;">ACTION</th>
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
<script type="text/javascript">
    element = document.getElementById("categories_menu");
    element.classList.add("active");
</script>
<!-- js table -->
<script type="text/javascript" src="<?=base_url()?>/assets/js/category.js"></script>


