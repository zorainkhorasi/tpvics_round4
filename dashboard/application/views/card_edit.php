<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/swiper.css">

<style>
    .img-fluid {
        width: 100%;
    }

    .my-table-bordered tr, th, td, .my-table-bordered thead th {
        border: 1px solid black;
    }

    .child_name {
        text-transform: capitalize;
    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Card Edit</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Card Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section class="basic-select2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        onchange="changeUCs()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($province) && $province != '') {
                                                        foreach ($province as $k => $p) {
                                                            echo '<option value="' . $k . '">' . $p . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6 col-12">
                                             <div class="text-bold-600 font-medium-2">
                                                 UC
                                             </div>
                                             <div class="form-group">
                                                 <select class="select2 form-control district_select"
                                                         onchange="changeUCs()">
                                                     <option value="0" readonly disabled selected>UC</option>
                                                 </select>
                                             </div>
                                         </div>-->
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Cluster
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control clusters_select"
                                                        onchange="changeCluster()">
                                                    <option value="0" readonly disabled selected>Cluster</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Household
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control household_select"
                                                        onchange="changeHH()">
                                                    <option value="0" readonly disabled selected>Household</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Child Line No
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control childNo_select">
                                                    <option value="0" readonly disabled selected>Child No</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class=" ">
                                        <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                            Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- gallery swiper start -->
            <section id="component-swiper-gallery" class="hide">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Clusters</h4>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="listdata list-group">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- gallery swiper ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">
<input type="hidden" id="hidden_id" value="">

<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>


<script>
    function changeUCs() {
        var data = {};
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            showloader();
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getClustersByDist'  ?>', data, 'POST', function (res) {
                hideloader();
                var items = '<option value="0"   readonly disabled selected>Cluster</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.cluster_code + '" onclick="changeCluster()">' + v.cluster_code + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.clusters_select').html('').html(items);
            });
        } else {
            $('.clusters_select').html('');
        }
    }

    function changeCluster() {
        var data = {};
        data['cluster'] = $('.clusters_select').val();
        if (data['cluster'] != '' && data['cluster'] != undefined && data['cluster'] != '0' && data['cluster'] != '$1') {
            showloader();
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getHhnoByCluster'  ?>', data, 'POST', function (res) {
                hideloader();
                var items = '<option value="0"   readonly disabled selected>Household</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.hhno + '" onclick="changeHH()">' + v.hhno + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.household_select').html('').html(items);
            });
        } else {
            $('.household_select').html('');
        }
    }

    function changeHH() {
        var data = {};
        data['cluster'] = $('.clusters_select').val();
        data['hh'] = $('.household_select').val();
        if (data['hh'] != '' && data['hh'] != undefined && data['hh'] != '0' && data['hh'] != '$1') {
            showloader();
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getChildNoByHH'  ?>', data, 'POST', function (res) {
                hideloader();
                var items = '<option value="0"   readonly disabled >Child No</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ec13 + '" selected>' + v.ec13 + '</option>';

                        })
                    } catch (e) {
                    }
                }
                $('.childNo_select').html('').html(items);
            });
        } else {
            $('.childNo_select').html('');
        }
    }

    function searchData() {
        var hh = $('.household_select').val();
        var child = $('.childNo_select').val();
        var clusters_select = $('.clusters_select').val();
        //var i = $('.some_id_select').val(); // make sure this exists

        var url = "<?= base_url('index.php/Card_edit/edit_form_new') ?>?c=" + clusters_select + "&h=" + hh + "&ec=" + child;

        window.open(url, '_blank'); // open in new tab
    }



</script>