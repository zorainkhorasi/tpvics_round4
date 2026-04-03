<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Interview Status</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Interview Status
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
                                <h4 class="card-title">Interview Status</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th class="text-center">SNo</th>
                                                <th class="text-center">District</th>
                                                <th class="text-center">Cluster_no</th>
                                                <th class="text-center">HH Randomized</th>
                                                <th class="text-center">HH Visited</th>
                                                <th class="text-center">Completed</th>
                                                <th class="text-center">Refused</th>
                                                <th class="text-center">Other</th>
                                                <th class="text-center">MWRA Filled</th>
                                                <th class="text-center">ANC Filled</th>
                                                <th class="text-center">DPC Filled</th>
                                                <th class="text-center">IYCF</th>
                                                <th class="text-center">Immunization</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($data) && $data != '') {
                                                $Sno = 0;
                                                foreach ($data as $k => $r) {
                                                    $Sno++ ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $Sno ?></td>
                                                        <td class="text-center"><?php echo $r->district ?></td>
                                                        <td class="text-center">
                                                            <?php echo '<a href="' . base_url() . 'index.php/interviewstatus/getdetails/' . $r->cluster_no . '">' . $r->cluster_no . '</a>'; ?>
                                                        </td>


                                                        <td class="text-center"><?php echo $r->randomizedHH ?></td>
                                                        <td class="text-center"><?php echo$r->HHvisited ?> </td>


                                                        <td class="text-center"><?php echo $r->Completed ?></td>
                                                        <td class="text-center"><?php echo $r->Refused ?></td>
                                                        <td class="text-center"><?php echo $r->Others ?></td>
                                                        <td class="text-center"><?php echo $r->MWRAEntered ?></td>
                                                        <td class="text-center"><?php echo $r->ANC_Filled ?></td>
                                                        <td class="text-center"><?php echo $r->DPC_Filled ?></td>
                                                        <td class="text-center"><?php echo $r->IYCF_Filled ?></td>
                                                        <td class="text-center"><?php echo $r->Immunization ?></td>

                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th class="text-center">SNo</th>
                                                <th class="text-center">District</th>
                                                <th class="text-center">Cluster_no</th>
                                                <th class="text-center">HH Randomized</th>
                                                <th class="text-center">HH Visited</th>
                                                <th class="text-center">Completed</th>
                                                <th class="text-center">Refused</th>
                                                <th class="text-center">Other</th>
                                                <th class="text-center">MWRA Filled</th>
                                                <th class="text-center">ANC Filled</th>
                                                <th class="text-center">DPC Filled</th>
                                                <th class="text-center">IYCF</th>
                                                <th class="text-center">Immunization</th>
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


<script>

    $(document).ready(function () {
        $('.addbtn').click(function () {
            $('#addModal').modal('show');
        });
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