<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo base_url() ?><!--assets/css/pages/card-analytics.css">-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">ORS</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">ORS Coverage</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section id="apexchart">
                <div class="row">
                    <?php
                    if (isset($getData) && $getData != '') {
                        foreach ($getData as $k => $r) { ?>


                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-end">
                                        <h4 class="mb-0"><?php echo $r['uc_name'] ?></h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body px-0 pb-0">
                                            <div class="graphs mt-75" id="goal-overview-chart_<?php echo $r['uc'] ?>">

                                            </div>
                                            <div class="row text-center mx-0">
                                                <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                                    <p class="mb-50">Yes</p>
                                                    <p class="font-large-1 text-bold-700 mb-50 yes_value"><?php echo $r['ors_yes'] ?></p>
                                                </div>
                                                <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                                    <p class="mb-50">No</p>
                                                    <p class="font-large-1 text-bold-700 mb-50 no_value"><?php echo $r['ors_no'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>


                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->


<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/charts/chart-apex.js"></script>-->
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/cards/card-analytics.js"></script>-->

<script>
    $(document).ready(function () {
        var $primary = '#7367F0',
            $success = '#28C76F',
            $danger = '#EA5455',
            $warning = '#FF9F43',
            $info = '#00cfe8',
            $label_color_light = '#dae1e7';

        var themeColors = [$primary, $success, $danger, $warning, $info, $label_color_light,
            $warning, $danger, $success, $info, $primary, $label_color_light,
            $success, $danger, $primary, $info, $label_color_light,
            $primary, $warning, $success, $info, $warning, $label_color_light
        ];

        $('.graphs').each(function (i, v) {
            var yes_value = $(v).parent('.card-body').find('.yes_value').text();
            if(yes_value=='' || yes_value==undefined){
                yes_value=0
            }
            var no_value = $(v).parent('.card-body').find('.no_value').text();
            if(no_value=='' || no_value==undefined){
                no_value=0
            }
            var sessionChartoptions = {
                chart: {
                    type: 'donut',
                    height: 315,
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [parseInt(yes_value), parseInt(no_value)],
                legend: {show: true},
                labels: ['Yes', 'No'],
                stroke: {width: 0},
                colors: [themeColors[i+1], themeColors[i+2]]
            };
            var ids = $(v).attr('id');

            var sessionChart = new ApexCharts(
                document.querySelector("#" + ids),
                sessionChartoptions
            );
            sessionChart.render();
        });


        /*var goalChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            colors: themeColors,
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $danger,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: $danger,
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00b5b5'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            series: [95],
            stroke: {
                lineCap: 'round'
            },
        };
        var goalChart = new ApexCharts(
            document.querySelector("#goal-overview-chart"),
            goalChartoptions
        );
        goalChart.render();*/

    });
</script>