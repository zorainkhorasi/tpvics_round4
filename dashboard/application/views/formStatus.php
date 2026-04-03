<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Form</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Form Status</li>
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
                                <h4 class="card-title">Forms Status</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Village Id</th>
                                                <th>Village Name</th>
                                                <th>Household Id</th>
                                                <th>Activity Status</th>
                                                <th>Device Tag Id</th>
                                                <th>User Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($forms) && $forms != '') {
                                                $Sno = 0;
                                                foreach ($forms as $k => $r) {
                                                    $Sno++ ?>
                                                    <tr>
                                                        <td><?php echo $Sno ?></td>
                                                        <td><?php echo $r->village_id ?></td>
                                                        <td><?php echo $r->village_name ?></td>
                                                        <td><?php echo $r->household_id ?></td>
                                                        <td><?php echo $r->activity_status ?></td>
                                                        <td><?php echo $r->device_tag_id ?></td>
                                                        <td><?php echo $r->full_name ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Village Id</th>
                                                <th>Village Name</th>
                                                <th>Household Id</th>
                                                <th>Activity Status</th>
                                                <th>Device Tag Id</th>
                                                <th>User Name</th>
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