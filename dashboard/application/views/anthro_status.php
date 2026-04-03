<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Anthro & HB Status</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Anthro & HB Status
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
                                <h4 class="card-title">Anthro & HB Status</h4>
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
                                                <th class="text-center">Household Visited</th>
                                                <th class="text-center">Members Present at home</th>
                                                <th class="text-center">MWRAs in Roster</th>
                                                <th class="text-center">MWRAs Anthro done</th>
                                                <th class="text-center">Index MWRAs for HB</th>
                                                <th class="text-center">Under five in Roster</th>
                                                <th class="text-center">Under five for Anthro</th>
                                                <th class="text-center">Index Child for HB</th>
                                                <th class="text-center">Female Adolescent in Roster</th>
                                                <th class="text-center">Adolescent for Anthro</th>
                                                <th class="text-center">Adolescent for HB</th>
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
                                                            <?php echo '<a href="' . base_url() . 'index.php/anthro_hb_status/getdetails/' . $r->cluster_no . '">' . $r->cluster_no . '</a>'; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo  $r->HHvisited?>
                                                        </td>
                                                        <td class="text-center"><?php echo $r->present_members ?></td>
                                                        <td class="text-center"><?php echo $r->MWRAs ?></td>
                                                        <td class="text-center"><?php echo $r->AN_MWRAs ?></td>
                                                        <td class="text-center"><?php echo $r->HB_MWRAs ?></td>
                                                        <td class="text-center"><?php echo $r->U5 ?></td>
                                                        <td class="text-center"><?php echo $r->AN_U5 ?></td>
                                                        <td class="text-center"><?php echo $r->HB_IndexChild ?></td>
                                                        <td class="text-center"><?php echo $r->Fem_Adolescent ?></td>
                                                        <td class="text-center"><?php echo $r->AN_Adolescent ?></td>
                                                        <td class="text-center"><?php echo $r->hb_Adolescent ?></td>

                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th class="text-center">SNo</th>
                                                <th class="text-center">District</th>
                                                <th class="text-center">Cluster_no</th>
                                                <th class="text-center">Household Visited</th>
                                                <th class="text-center">Members Present at home</th>
                                                <th class="text-center">MWRAs in Roster</th>
                                                <th class="text-center">MWRAs Anthro done</th>
                                                <th class="text-center">Index MWRAs for HB</th>
                                                <th class="text-center">Under five in Roster</th>
                                                <th class="text-center">Under five for Anthro</th>
                                                <th class="text-center">Index Child for HB</th>
                                                <th class="text-center">Female Adolescent in Roster</th>
                                                <th class="text-center">Adolescent for Anthro</th>
                                                <th class="text-center">Adolescent for HB</th>
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