<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Completed Forms/Households</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Completed Forms/Households</li>
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
                                <h4 class="card-title">Completed Forms/Households</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Village code</th>
                                                <th>Cluster</th>
                                                <th>Household</th>
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
                                                        <td class="uc_code"><?php echo $r->village_name ?></td>
                                                        <td class="uc_name"><?php echo $r->clusters ?></td>
                                                        <td class="clusters"><?php echo $r->elb11 ?></td>


                                                        <?php
                                                        $status = '';
                                                        $status_class = '';
                                                        if ($r->istatus == '1') {
                                                            $status = 'Completed';
                                                            $status_class = 'btn-success';
                                                        } elseif ($r->istatus == '2') {
                                                            $status = 'No household member at home or no competent respondent at home at time of visit';
                                                            $status_class = 'btn-warning';
                                                        } elseif ($r->istatus == '3') {
                                                            $status = 'Entire household absent for extended period of time';
                                                            $status_class = 'btn-info';
                                                        } elseif ($r->istatus == '4') {
                                                            $status = 'Refused';
                                                            $status_class = 'btn-danger';
                                                        } elseif ($r->istatus == '5') {
                                                            $status = 'Dwelling vacant or address not a dwelling';
                                                            $status_class = 'btn-primary';
                                                        } elseif ($r->istatus == '6') {
                                                            $status = 'Dwelling not found';
                                                            $status_class = 'btn-mycolor1';
                                                        } elseif ($r->istatus == '7') {
                                                            $status = 'No Child between 0-05 years';
                                                            $status_class = 'btn-mycolor3';
                                                        } elseif ($r->istatus == '8') {
                                                            $status = 'Temporarily locked';
                                                            $status_class = 'btn-mycolor3';
                                                        } elseif ($r->istatus == '96') {
                                                            $status = 'Others';
                                                            $status_class = 'btn-info';
                                                        } else {
                                                            $status = 'Invalid Status';
                                                            $status_class = 'btn-danger';
                                                        } ?>
                                                        <td class="status">
                                                            <span class="label   btn btn-sm <?php echo $status_class; ?> waves-effect waves-light"><?php echo $status; ?></span>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Village code</th>
                                                <th>Cluster</th>
                                                <th>Household</th>
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
    });

</script>