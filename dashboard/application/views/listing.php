<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Line-Listing</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <?php
            $colors = array('primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3',
                'primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3');
            ?>
            <!-- Analytics card section start -->



            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Line-Listing</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Cluster</th>
                                                <th>HH</th>
                                                <th>Structure</th>
                                                <th>Under 5</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php


                                            if (isset($getData) && $getData != '') {
                                                $Sno = 0;
                                                foreach ($getData as $k => $r) {
                                                    $Sno++ ?>
                                                    <tr>
                                                        <td> <?php echo $Sno ?></td>
                                                        <td class="hh02"><?php echo $r['hh02'] ?></td>
                                                        <td class="hh"><?php echo $r['hh'] ?></td>
                                                        <td class="hl09"><?php echo $r['hl09'] ?></td>
                                                        <td class="under_five"><?php echo $r['under_five'] ?></td>

                                                        <?php if( $r['is_random']==1) {?>
                                                            <td class="is_random"><?php echo '<span  disabled="disabled" class="label btn btn-sm btn-success waves-effect waves-light">Randomized</span>' ?></td>
                                                        <?php } else {?>
                                                            <td class="is_random"> <?php echo '<span hh02="'.$r['hh02'].'" class="label btn btn-sm btn-info waves-effect waves-light randomize_sp">Click to Randomize</span>' ?></td>
                                                        <?php }?>

                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Cluster</th>
                                                <th>HH</th>
                                                <th>Structure</th>
                                                <th>Under 5</th>
                                                <th>Status</th>
                                            </tr>
                                            </tfoot>
                                        </table>
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

<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>
<script>
    $(document).ready(function () {

        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
            "oSearch": {"sSearch": " "},
            autoFill: false,
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text: 'JSON',
                    action: function (e, dt, button, config) {
                        var data = dt.buttons.exportData();

                        $.fn.dataTable.fileSave(
                            new Blob([JSON.stringify(data)]),
                            'Export.json'
                        );
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });

        $('.randomize_sp').click(function(){
            var data={};
            var flag=0;
            data['hh02']=$('.randomize_sp').attr('hh02');
            if (data['hh02'] == '' || data['hh02'] == undefined) {
                $('.randomize_sp').css('border', '1px solid red');
                flag = 1;
                toastMsg('Error', 'Invalid', 'error');
                return false;
            }
            if (flag == 0) {
                showloader();
                $('.mybtn').attr('disabled', 'disabled');
                CallAjax('<?php echo base_url('index.php/Listing/systematic_randomizer'); ?>', data, 'POST', function (result) {
                    hideloader();
                    if (result == 1) {
                        toastMsg('Success', 'Successfully inserted', 'success');
                        $('#addModal').modal('hide');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else if (result == 4) {
                        toastMsg('User', 'Duplicate User URL', 'error');
                    } else if (result == 3) {
                        toastMsg('User', 'Invalid User Name', 'error');
                    } else {
                        toastMsg('Error', 'Something went wrong', 'error');
                    }
                });

            } else {
                toastMsg('User', 'Something went wrong', 'error');
            }
        })
    });


</script>