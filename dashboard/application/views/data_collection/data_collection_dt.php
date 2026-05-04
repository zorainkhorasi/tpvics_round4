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
                        <h2 class="content-header-title float-left mb-0">Data Collection Progress</h2>
                
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Data Collection</li>
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
                                <h4 class="card-title">Data Collection Report</h4>
                            <div id="ucsSection" >
                         <div class="d-flex align-items-center mb-4">
                        <button style="color: #ffffff;border-radius: 30px;border-color: #ffffff;box-shadow: 0px 1px 4px 1px #b5b5b58a;background: #9bc3c0;" 
                        id="backButton" class="btn btn-sm btn-outline-dark">← Back</button>

                        <h4 id="ucsTitle" style="    padding: 8px 0px 0px 19px;
                            font-size: 30px;
                            color: #b2d3d0;
                            font-weight: bold;"></h4>


                    </div>
                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">

                                            <!-- ================= THEAD ================= -->
                                            <thead>
                                            <tr>
                                                <th>Sr #</th> <!-- ✅ Added -->
                                                <?php if (!empty($get_linelisting_table)): ?>
                                                    <?php foreach (array_keys((array)$get_linelisting_table[0]) as $col): ?>
                                                        <th><?= ucwords(str_replace('_', ' ', $col)) ?></th>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>

                                            <!-- ================= TBODY ================= -->
                                            <tbody>
                                            <?php
                                            $sr = 1; // ✅ counter start

                                            foreach ($get_linelisting_table as $row): ?>
                                                <tr>

                                                    <td><?= $sr++ ?></td> <!-- ✅ SR number -->

                                                    <?php foreach ($row as $key => $value): ?>

                                                        <?php
                                                        if ($key == 'Randomised_HH') {
                                                            echo '<td><a target="_blank" href="'.base_url('index.php/Data_collection_progress/randomized_household/'.$row->cluster_no).'">'.$value.'</a></td>';

                                                        } elseif ($key == 'Visited') {
                                                            echo '<td><a target="_blank" href="'.base_url('index.php/Data_collection_progress/collected_household/'.$row->cluster_no).'">'.$value.'</a></td>';

                                                        } elseif ($key == 'Completed') {
                                                            echo '<td><a target="_blank" href="'.base_url('index.php/Data_collection_progress/completed_household/'.$row->cluster_no).'">'.$value.'</a></td>';

                                                        } elseif ($key == 'Refused') {
                                                            echo '<td><a target="_blank" href="'.base_url('index.php/Data_collection_progress/refused_household/'.$row->cluster_no).'">'.$value.'</a></td>';

                                                        } else {
                                                            echo '<td>'.$value.'</td>';
                                                        }
                                                        ?>

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
            "displayLength": 25,
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
        $("#backButton").on("click", function () {
            window.location.href = "<?php echo base_url('index.php/data_collection_progress'); ?>";
        });
        
    });

</script>