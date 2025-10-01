<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Data Quality Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Data Quality Report
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Quality Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="col-md-3">
                                        <select class="form-control" id="districtSelect">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $d): ?>
                                                <option  <?=$dist_id==$d['district']? 'selected':''?> value="<?= $d['district']; ?>"><?= $d['district']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" id="ucSelect">
                                            <option value="">Select UC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="redirectWithDistrict()">Search</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Quality Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-dark">
                                                <tr>
                                                    <?php foreach($columns as $col): ?>
                                                        <th>
                                                            <?= ucwords(str_replace('_', ' ', $col)) ?>
                                                        </th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($rows as $row): ?>
                                                    <tr>
                                                        <?php foreach($columns as $col): ?>
                                                            <td><?= $row[$col] ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->


<input type="hidden" id="h_dist_id" value="<?php echo $dist_id; ?>">
<input type="hidden" id="h_uc_id" value="<?php echo $uc_id; ?>">
<!-- BEGIN: User Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function(){
        $('#districtSelect').on('change', function(){
            getUcs();
        });
    });

    getUcs()
    function getUcs(){

        var dist_id = $('#districtSelect').val();
        var uc_id = $('#h_uc_id').val();

        if(dist_id){
            $.ajax({
                url: "<?= base_url('index.php/data_quality_report/getUcs'); ?>",  // adjust controller name
                type: "POST",
                data: {dist_id: dist_id},
                dataType: "json",
                success: function(response){
                    $('#ucSelect').empty();
                    $('#ucSelect').append('<option value="">Select UC</option>');
                    $.each(response, function(index, uc){
                        var selected = (uc_id && uc.ucName == uc_id) ? 'selected' : '';
                        $('#ucSelect').append('<option value="'+ uc.ucName +'" '+selected+'>'+ uc.ucName +'</option>');
                    });
                }
            });
        }else{
            $('#ucSelect').empty();
            $('#ucSelect').append('<option value="">Select UC</option>');
        }
    }

    function redirectWithDistrict() {
        let url = new URL(window.location.href);
        var distId = $('#districtSelect').val();
        var ucId   = $('#ucSelect').val();  // or $('#ucSelect').val() if UC comes from dropdown

        // Handle district
        if (distId) {
            url.searchParams.set('dist_id', distId);
        } else {
            url.searchParams.delete('dist_id');
        }

        // Handle UC
        if (ucId) {
            url.searchParams.set('uc_id', ucId);
        } else {
            url.searchParams.delete('uc_id');
        }

        window.location.href = url.toString(); // refresh page with updated params
    }

</script>