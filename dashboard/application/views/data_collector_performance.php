<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Data Collectors</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Data Collector's Performance</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section id="apexchart">
                <div class="row">
                    <!-- Column Chart -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Collector's Performance</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="hh-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Collector's Status</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>User Name</th>
                                                <th>HH Surveyed</th>
                                                <th>Diarrhea (%)</th>
                                                <th>Ari (%)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($getData) && $getData != '') {
                                                $Sno = 0;
                                                foreach ($getData as $k => $r) {
                                                    $Sno++ ?>
                                                    <tr>
                                                        <td><?php echo $Sno ?></td>
                                                        <td class="ucname"><?php echo $r->full_name ?></td>
                                                        <td class="hh_surveyed"><?php echo $r->hh_surveyed ?></td>
                                                        <td class="dia"
                                                            data-key="<?php echo $r->dia ?>"><?php echo $r->dia ?>
                                                            <small class="primary">
                                                                (<?php echo number_format(($r->dia / $r->hh_surveyed) * 100, 1) ?>
                                                                %)
                                                            </small>
                                                        </td>
                                                        <td class="ari"
                                                            data-key="<?php echo $r->ari ?>"><?php echo $r->ari ?>
                                                            <small class="primary">
                                                                (<?php echo number_format(($r->ari / $r->hh_surveyed) * 100, 1) ?>
                                                                %)
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>User Name</th>
                                                <th>HH Surveyed</th>
                                                <th>Diarrhea (%)</th>
                                                <th>Ari (%)</th>
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
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/charts/chart-apex.js"></script>-->


<script>
    $(document).ready(function () {
        var $primary = '#7367F0',
            $success = '#28C76F',
            $danger = '#EA5455',
            $warning = '#FF9F43',
            $info = '#00cfe8',
            $label_color_light = '#dae1e7';

        var themeColors = [$primary, $success, $danger, $warning, $info];

        // RTL Support
        var yaxis_opposite = false;
        if ($('html').data('textdirection') == 'rtl') {
            yaxis_opposite = true;
        }

        var ucname = [];
        $.each($('.ucname'), function (i, v) {
            ucname.push($(v).text());
        });
        var hh_surveyed = [];
        $.each($('.hh_surveyed'), function (i, v) {
            hh_surveyed.push($(v).text());
        });
        var dia = [];
        $.each($('.dia'), function (i, v) {
            dia.push($(v).attr('data-key'));
        });
        var ari = [];
        $.each($('.ari'), function (i, v) {
            ari.push($(v).attr('data-key'));
        });

        var columnChartOptions = {
            chart: {
                height: 400,
                type: 'bar',
            },
            colors: themeColors,
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [
                {
                    name: 'Household Surveyed',
                    data: hh_surveyed
                }, {
                    name: 'Diarrhea',
                    data: dia
                }, {
                    name: 'ARI',
                    data: ari
                }
            ],
            legend: {
                offsetY: -10
            },
            xaxis: {
                categories: ucname,
            },
            yaxis: {
                title: {
                    text: 'Numbers'
                },
                opposite: yaxis_opposite
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        };
        var columnChart = new ApexCharts(
            document.querySelector("#hh-chart"),
            columnChartOptions
        );

        columnChart.render();


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