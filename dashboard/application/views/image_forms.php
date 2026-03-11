<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/swiper.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* --- New UI base styles (kept from new UI) --- */
    body {
        background-color: #fff8ec;
        font-family: "Poppins", sans-serif;
    }

    .dropdown-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        justify-content: flex-start;
        align-items: center;

    }
    .dropdown-row .select2-container--default .select2-selection--single { height: 40px; }
    .dropdown-row select,
    .dropdown-row .select2-selection--single {
        border: 1px solid #ffffff;
        padding: 7px 10px;
        font-size: 14px;
        color: #333;
        min-width: 180px;
    }
    .dropdown-row select, .dropdown-row .select2-selection--single {
        border: 1px solid #ffffff;!important;
        border-radius: 52px;!important;
        padding: 7px 10px;
        font-size: 15px;
        background-color: #f7ffff;
        color: #0e8b86;
        min-width: 200px;
    }
    .content-row {
        display: flex;
        gap: 20px;
    }

    .left-card {
        flex: 0 0 65%;
        background: #fff;
        border: 1px solid #e3e3e3;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        min-height: 580px;
    }

    .card-header-new {
        background: #91c5bf;
        border-radius: 3px;
        padding: 10px 9px;
        font-weight: 600;
        color: #ffffff;
        display: flex
    ;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        letter-spacing: 0.3px;
    }

    .card-header-new i {
        color: #ffffff;
        font-size: 33px;
    }

    .info-grid {
        display: grid
    ;
        grid-template-columns: 3fr 1fr;
        column-gap: 15px;
        margin-top: 12px;
        font-size: 13px;
        line-height: 1.6;
    }

    .info-left p, .info-right p {
        margin: 0 0 6px;
    }

    .info-section span {
        font-weight: 600;
        color: #000;
    }

    .vaccination-table {
        border: 1px solid #ffffff;
        border-radius: 6px;
        margin-top: 12px;
        font-size: 12px;
        overflow: hidden;
    }

    .vaccination-table p {
        color: gray;
        font-weight: 200;
        margin: 0;
        border-bottom: 1px solid #d8f2f1;
        padding: 8px 10px;
        background: #fafafa;
    }

    .vaccination-table table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    .vaccination-table th,
    .vaccination-table td {
        border: 1px solid #ddd;
        padding: 6px;
        font-size: 13px;
    }

    .submit-btn {
        background: #d8f2d8;
        border: none;
        color: #1a1a1a;
        font-weight: 600;
        border-radius: 5px;
        padding: 7px 25px;
        display: block;
        margin: 15px auto 5px;
        transition: 0.3s;
    }

    .submit-btn:hover {
        background: #c7ebc7;
    }

    .right-space {
        flex: 1;
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 8px;
        min-height: 580px;
        box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.05);
        padding: 12px;
    }

    .label{
        color: #959089;
        font-size: 12px;
        font-weight: 300 !important;
    }

    /* small helper styles kept from old view */
    .img-fluid { width: 100%; }
    .my-table-bordered tr, th, td, .my-table-bordered thead th { border: 1px solid black; }
    .child_name { text-transform: capitalize; }
    .clickmsg { margin: 0; font-size: 9px; }

    /* color states used by old logic */
    .mygreen { background: #dff6ec !important; }
    .myred { background: #ffe5e5 !important; }
    .myorange { background: #fff2d6 !important; }

    @media (max-width: 992px) {
        .content-row { flex-direction: column; }
        .left-card { flex: 100%; }
    }

    /* Swiper thumbs spacing */
    .gallery-thumbs .swiper-slide img { cursor: pointer; max-height: 70px; object-fit: cover; }
    .gallery-top .swiper-slide img { object-fit: contain; max-height:420px; width:100%; }
    .left-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 100%;
    }

    .data_list {
        flex-grow: 1; /* pushes submit button to the bottom */
    }

    .left-card .submit-btn {
        padding: 10px 40px;
        font-weight: 600;
        border-radius: 6px;
    }

    .text-center.mt-4.mb-3 {
        margin-top: 40px !important; /* ensure proper gap from tables */
        margin-bottom: 30px !important;
    }

    @media (max-width: 992px) {
        .text-center.mt-4.mb-3 {
            margin-top: 25px !important;
        }
    }
    .table {
        --bs-table-color-type: initial;
        --bs-table-bg-type: initial;
        --bs-table-color-state: initial;
        --bs-table-bg-state: initial;
        --bs-table-color: var(--bs-emphasis-color);
        --bs-table-bg: var(--bs-body-bg);
        --bs-table-border-color: var(--bs-border-color);
        --bs-table-accent-bg: transparent;
        --bs-table-striped-color: var(--bs-emphasis-color);
        --bs-table-striped-bg: rgba(var(--bs-emphasis-color-rgb), 0.05);
        --bs-table-active-color: var(--bs-emphasis-color);
        --bs-table-active-bg: rgba(var(--bs-emphasis-color-rgb), 0.1);
        --bs-table-hover-color: var(--bs-emphasis-color);
        --bs-table-hover-bg: rgba(var(--bs-emphasis-color-rgb), 0.075);
        width: 136%;!important;
        margin-bottom: 1rem;
        vertical-align: top;
        border-color: var(--bs-table-border-color);
    }


    .gallery-top .swiper-slide img {
        object-fit: contain;
         max-height: 100%;
         width: auto;
    }
    .card{
        --bs-card-border-color:white

    }
</style>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div style="background: #fff8ec" class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Vaccination Card & Images</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Vaccination Card</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- Top dropdown row (shared) -->
            <div class="main-container">
                <div class="dropdown-row">
                    <!-- Keep the same selects and classes as your old view (select2 + selectors) -->
                    <select class="select2 form-control province_select" onchange="changeProvince()">
                        <option value="0" readonly disabled selected>District</option>
                        <?php if (isset($province) && $province != '') {
                            foreach ($province as $k => $p) {
                                echo '<option value="' . $k . '">' . $p . '</option>';
                            }
                        } ?>
                    </select>

                    <select class="select2 form-control district_select" onchange="changeUCs()">
                        <option value="0" readonly disabled selected>UC</option>
                    </select>

                    <select class="select2 form-control clusters_select" onchange="changeCluster()">
                        <option value="0" readonly disabled selected>Cluster</option>
                    </select>

                    <select class="select2 form-control household_select" onchange="changeHH()">
                        <option value="0" readonly disabled selected>Household</option>
                    </select>

                    <select class="select2 form-control childNo_select">
                        <option value="0" readonly disabled selected>Child No</option>
                    </select>

                    <button type="button" class="btn btn-primary" onclick="searchData()">Search</button>
                </div>

                <!-- Main two-column content (left: vaccination card, right: images) -->
                <div class="content-row">
                    <!-- LEFT: Vaccination Card Detail (new UI design) -->
                    <div class="left-card">
                        <div class="card-header-new">
                            <span>VACCINATION CARD DETAIL</span>
                            <i class="fa-solid fa-baby"></i>
                        </div>

                        <!-- info + vaccination tables -->
                        <div class="info-grid data_list" style="margin-top:12px;">
                            <div class="info-left">
                                <p style="font-weight: 700; color: #ed3dd3; font-size: 15px;">
                                    <span class="label">NAME:</span> -
                                </p>
                                <p><span class="label">DATE OF BIRTH:</span> -</p>
                                <p><span class="label">GENDER:</span> -</p>
                            </div>
                            <div class="info-right">
                                <p><span class="label">CLUSTER NO:</span> -</p>
                                <p><span class="label">HOUSEHOLD:</span> -</p>
                            </div>

              

                            <div class="vaccination-table" style="grid-column: 1 / -1;">
                                <p>VACCINATION VISIT</p>
                                <table>
                                    <tr><td colspan="6" style="height:120px;"></td></tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.data_list -->

                        <!-- ✅ Move Submit button BELOW -->
                        <div style="    margin-left: auto; " class=" mt-4 mb-3">
                            <button style=" background: #918e8e;
    color: #ffffff;
    border-radius: 49px; " class="btn submit-btn" id="staticSubmit" disabled>SUBMIT</button>
                        </div>
                    </div>
                    <!-- /LEFT -->

                    <!-- RIGHT: Images / Swiper gallery (keeps old behavior) -->
                    <div class="right-space">
                        <div class="card-header-new">
                            <span>IMAGE</span>
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <section id="component-swiper-gallery" class="hide">
                            <div class="card">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="swiper-gallery swiper-container gallery-top">
                                                        <div class="swiper-wrapper gallery_images">
                                                            <!-- Filled by JS: $('.gallery_images').html(items) -->
                                                        </div>
                                                        <!-- Add Arrows -->

                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right column details originally were here, but we've moved the details to left. Keep for any extras -->
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /RIGHT -->
                </div>
                <!-- /content-row -->
            </div>
            <!-- /main-container -->
        </div>
    </div>
</div>
<!-- END: Content-->

<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">
<input type="hidden" id="hidden_id" value="">

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // initialize select2 for the top selects (if select2 library is available)
    $(document).ready(function(){
        try {
            $('.select2').select2({ width: 'resolve' });
        } catch(e){ /* ignore if select2 not available */ }
    });

    // --- Swiper gallery init (same as your old gallery function) ---
    function gallery() {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            zoom: true,
            pagination: {
                el: '.swiper-pagination',
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    }

    /* --- Keep your existing JS functions as-is.
       The only change: .data_list and .gallery_images are now in new positions,
       but their class names are unchanged so old functions work. --- */

    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            showloader();
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                hideloader();
                var items = '<option value="0"   readonly disabled selected>District</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response[0], function (i, v) {
                            items += '<option value="' + i + '" onclick="changeUCs()">' + v + '</option>';
                        })
                    } catch (e) {}
                }
                $('.district_select').html('').html(items);
            });
        } else {
            $('.district_select').html('');
        }
    }

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
                    } catch (e) {}
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
                    } catch (e) {}
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
                    } catch (e) {}
                }
                $('.childNo_select').html('').html(items);
            });
        } else {
            $('.childNo_select').html('');
        }
    }

    function setValue(obj) {
        var a = $(obj).attr('data-id');
        if (a == 0) {
            $(obj).attr('data-id', 1).addClass('mygreen');
            $(obj).find('.clickmsg').text('Matched');
        } else if (a == 1) {
            $(obj).attr('data-id', 2).removeClass('mygreen').addClass('myred');
            $(obj).find('.clickmsg').text('Not Matched');
        } else if (a == 2) {
            $(obj).attr('data-id', 3).removeClass('myred').addClass('myorange');
            $(obj).find('.clickmsg').text('Not Readable');
        } else {
            $(obj).attr('data-id', 0).removeClass('myorange');
            $(obj).find('.clickmsg').text('');
        }
    }

    function SubmitData() {
        var flag = 0;
        var data = {};
        data['image_status'] = $('#image_status').val();
        data['dobstatus'] = $('#dobstatus').val();
        data['cluster_no'] = $('.clusters_select').val();
        data['household'] = $('.household_select').val();
        if (data['image_status'] == '' || data['image_status'] == undefined || data['image_status'] == '0') {
            $('#image_status').css('border', '1px solid red');
            flag = 1;
            toastMsg('Image Status', 'Invalid Image Status', 'error');
            return false;
        }
        if (data['dobstatus'] == '' || data['dobstatus'] == undefined || data['dobstatus'] == '0') {
            $('#dobstatus').css('border', '1px solid red');
            flag = 1;
            toastMsg('DoB Status', 'Invalid Date of Birth Status', 'error');
            return false;
        }
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        }
        if (data['household'] == '' || data['household'] == undefined || data['household'] == '0') {
            $('.household_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household', 'Invalid Household No', 'error');
            return false;
        }

        data['ec13'] = $('#ec13').val();
        data['f01'] = $('#f01').val();
        data['f02'] = $('#f02').val();
        data['child_ec14'] = $('.child_ec14').val();
        data['bcg0'] = $('.bcg0').attr('data-id');
        data['opv0'] = $('.opv0').attr('data-id');
        data['opv1'] = $('.opv1').attr('data-id');
        data['opv2'] = $('.opv2').attr('data-id');
        data['opv3'] = $('.opv3').attr('data-id');
        data['penta1'] = $('.penta1').attr('data-id');
        data['penta2'] = $('.penta2').attr('data-id');
        data['penta3'] = $('.penta3').attr('data-id');
        data['pcv1'] = $('.pcv1').attr('data-id');
        data['pcv2'] = $('.pcv2').attr('data-id');
        data['pcv3'] = $('.pcv3').attr('data-id');
        data['rv1'] = $('.rv1').attr('data-id');
        data['rv2'] = $('.rv2').attr('data-id');
        data['ipv0'] = $('.ipv0').attr('data-id');
        data['measles1'] = $('.measles1').attr('data-id');
        data['measles2'] = $('.measles2').attr('data-id');
        data['hep_b'] = $('.hep_b').attr('data-id');
        data['ipv2'] = $('.ipv2').attr('data-id');
        data['tcv'] = $('.tcv').attr('data-id');

        if (flag == 0) {
            $('.submitBtn').addClass('hide');
            showloader();
            CallAjax('<?php echo base_url('index.php/Image_forms/submitData') ?>', data, 'POST', function (result) {
                hideloader();
                setTimeout(function () { $('.submitBtn').removeClass('hide'); }, 1000);
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#component-swiper-gallery').addClass('hide');
                    $('.gallery_images').html('');
                    $('.data_list').html('');
                } else if (result == 2) {
                    $('.clusters_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    $('.household_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Household No', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            $('.clusters_select').css('border', '1px solid red');
            $('.household_select').css('border', '1px solid red');
            toastMsg('Error', 'Something went wrong', 'error');
        }
    }

    function editData() {
        var flag = 0;
        var data = {};
        data['image_status'] = $('#image_status').val();
        data['dobstatus'] = $('#dobstatus').val();
        data['cluster_no'] = $('.clusters_select').val();
        data['household'] = $('.household_select').val();
        if (data['image_status'] == '' || data['image_status'] == undefined || data['image_status'] == '0') {
            $('#image_status').css('border', '1px solid red');
            flag = 1;
            toastMsg('Image Status', 'Invalid Image Status', 'error');
            return false;
        }
        if (data['dobstatus'] == '' || data['dobstatus'] == undefined || data['dobstatus'] == '0') {
            $('#dobstatus').css('border', '1px solid red');
            flag = 1;
            toastMsg('DoB Status', 'Invalid Date Of Birth Status', 'error');
            return false;
        }
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        }
        if (data['household'] == '' || data['household'] == undefined || data['household'] == '0') {
            $('.household_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household', 'Invalid Household No', 'error');
            return false;
        }

        data['id'] = $('#hidden_id').val();
        data['ec13'] = $('#ec13').val();
        data['f01'] = $('#f01').val();
        data['f02'] = $('#f02').val();
        data['child_ec14'] = $('.child_ec14').val();
        data['bcg0'] = $('.bcg0').attr('data-id');
        data['opv0'] = $('.opv0').attr('data-id');
        data['opv1'] = $('.opv1').attr('data-id');
        data['opv2'] = $('.opv2').attr('data-id');
        data['opv3'] = $('.opv3').attr('data-id');
        data['penta1'] = $('.penta1').attr('data-id');
        data['penta2'] = $('.penta2').attr('data-id');
        data['penta3'] = $('.penta3').attr('data-id');
        data['pcv1'] = $('.pcv1').attr('data-id');
        data['pcv2'] = $('.pcv2').attr('data-id');
        data['pcv3'] = $('.pcv3').attr('data-id');
        data['rv1'] = $('.rv1').attr('data-id');
        data['rv2'] = $('.rv2').attr('data-id');
        data['ipv0'] = $('.ipv0').attr('data-id');
        data['measles1'] = $('.measles1').attr('data-id');
        data['measles2'] = $('.measles2').attr('data-id');
        data['hep_b'] = $('.hep_b').attr('data-id');
        data['ipv2'] = $('.ipv2').attr('data-id');
        data['tcv'] = $('.tcv').attr('data-id');

        if (flag == 0) {
            showloader();
            $('.submitBtn').addClass('hide');
            CallAjax('<?php echo base_url('index.php/Image_forms/editData') ?>', data, 'POST', function (result) {
                hideloader();
                $('.submitBtn').removeClass('hide');
                if (result == 1) {
                    toastMsg('Success', 'Successfully edited', 'success');
                    setTimeout(function () { window.location.reload(); }, 1000);
                } else if (result == 2) {
                    $('.clusters_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    $('.household_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Household No', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            $('.clusters_select').css('border', '1px solid red');
            $('.household_select').css('border', '1px solid red');
            toastMsg('Error', 'Something went wrong', 'error');
        }
    }

    function clickAll(obj) {
        var type = $(obj).attr('data-type');
        $('.inpType').each(function (i, v) {
            $(v).attr('data-id', 0);
            $(v).removeClass('mygreen');
            $(v).removeClass('myred');
            $(v).removeClass('myorange');
        });
        var myclass = '';
        var myd = '0';
        var mytext = '';
        if (type == 'm') {
            myclass = 'mygreen';
            mytext = 'Matched';
            myd = '1';
        } else if (type == 'nm') {
            myclass = 'myred';
            myd = '2';
            mytext = 'Not Matched';
        } else if (type == 'nr') {
            myclass = 'myorange';
            mytext = 'Not Readable';
            myd = '3';
        } else {
            myd = '0';
        }

        if ($(obj).is(':checked')) {
            $('.inpType').each(function (i, v) {
                $(v).addClass(myclass);
                $(v).attr('data-id', myd);
                $(v).find('.clickmsg').text(mytext);
            });
        } else {
            $('.inpType').each(function (i, v) {
                $(v).removeClass(myclass);
                $(v).attr('data-id', 0);
            });
        }
    }

    function color(v) {
        var mycolor = '';
        if (v == 1) {
            mycolor = 'mygreen';
        } else if (v == 2) {
            mycolor = 'myred';
        } else if (v == 3) {
            mycolor = 'myorange';
        } else {
            mycolor = '';
        }
        return mycolor;
    }

    function searchData() {
        $('#component-swiper-gallery').addClass('hide');
        $('.submitBtn').addClass('hide');
        var hidden_loginUser = $('#hidden_loginUser').val();
        var submitBtn = '<button class="btn btn-primary submitBtn" onclick="SubmitData()">Submit</button>';
        $('.alreadyscored').text('');
        var flag = 0;
        var data = {};
        data['childNo'] = $('.childNo_select').val();
        data['cluster_no'] = $('.clusters_select').val();
        data['household'] = $('.household_select').val();
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        }
        if (data['household'] == '' || data['household'] == undefined || data['household'] == '0') {
            $('.household_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household', 'Invalid household No', 'error');
            return false;
        }
        if (flag == 0) {
            CallAjax('<?php echo base_url('index.php/Image_forms/getData') ?>', data, 'POST', function (res) {
                $('#component-swiper-gallery').removeClass('hide');
                $('.submitBtn').removeClass('hide');
                var items = '';
                var data_items = '';
                var gender = '';
                if (res != '' && res != undefined) {
                    var image_status_val = '';
                    var dobstatus_val = '0';
                    var bcg0_val = '0';
                    var opv0_val = '0';
                    var hep_b_val = '0';
                    var opv1_val = '0';
                    var opv2_val = '0';
                    var opv3_val = '0';
                    var penta1_val = '0';
                    var penta2_val = '0';
                    var penta3_val = '0';
                    var pcv_val = '0';
                    var pcv2_val = '0';
                    var pcv3_val = '0';
                    var rv1_val = '0';
                    var rv2_val = '0';
                    var ipv_val = '0';
                    var measles1_val = '0';
                    var measles2_val = '0';
                    var ipv2_val = '0';
                    var tcv_val = '0';
                    var already_scored = '';

                    var response = JSON.parse(res);
                    try {
                        if (response['dataExist'] != '' && response['dataExist'] != undefined && response['dataExist'] != 0) {
                            toastMsg('Already Exist', data['cluster_no'] + ' already scored', 'info');
                            var lastIndex = response['dataExist'].slice(-1)[0];
                            image_status_val = lastIndex.image_status;
                            dobstatus_val = lastIndex.dobstatus;
                            bcg0_val = lastIndex.bcg0;
                            opv0_val = lastIndex.opv0;
                            hep_b_val = lastIndex.hep_b;
                            opv1_val = lastIndex.opv1;
                            opv2_val = lastIndex.opv2;
                            opv3_val = lastIndex.opv3;
                            penta1_val = lastIndex.penta1;
                            penta2_val = lastIndex.penta2;
                            penta3_val = lastIndex.penta3;
                            pcv_val = lastIndex.pcv1;
                            pcv2_val = lastIndex.pcv2;
                            pcv3_val = lastIndex.pcv3;
                            rv1_val = lastIndex.rv1;
                            rv2_val = lastIndex.rv2;
                            ipv_val = lastIndex.ipv0;
                            measles1_val = lastIndex.measles1;
                            measles2_val = lastIndex.measles2;
                            ipv2_val = lastIndex.ipv2;
                            tcv_val = lastIndex.tcv;
                            already_scored = '<p class="alreadyscored text-mycolor2">Already scored by: ' + lastIndex.createdBy + '</p>';
                            if (hidden_loginUser == lastIndex.createdBy) {
                                submitBtn = '<button class="btn btn-primary submitBtn" onclick="editData()">Edit</button>';
                                $('#hidden_id').val(lastIndex.id_Image_feedback);
                            }
                        }

                        if (response['data'] != '' && response['data'] != undefined && response['data'] != 0) {
                            $.each(response['data'], function (i, v) {
                                items += '<div class="swiper-slide"> ' +
                                    '<img class="img-fluid" src="https://vcoe1.aku.edu/tpvics_shruc_r4/api/uploads/' + v.f01 + '" alt="banner"> ' +
                                    '</div>' +
                                    '<div class="swiper-slide"> ' +
                                    '<img class="img-fluid" src="https://vcoe1.aku.edu/tpvics_shruc_r4/api/uploads/' + v.f02 + '" alt="banner"> ' +
                                    '</div>';

                                if (v.ec15 == 1) { gender = 'M'; } else if (v.ec15 == 2) { gender = 'F' } else { gender = ''; }
                                var dob = v.im04dd + '/' + v.im04mm + '/' + v.im04yy;

                                data_items = '<div class="row">' +
                                    '<div class="col-lg-6 col-md-12">' +
                                    '<h6>Cluster: ' + v.cluster_code + '</h6>' +
                                    '<h6 class="child_name">Child: ' + v.ec14 + '</h6>' +
                                    '<h6>Date of Birth: ' + dob + '</h6>' +
                                    already_scored +
                                    '<input type="hidden" id="child_ec14" class="child_ec14" value="' + v.ec14 + '">' +
                                    '<input type="hidden" id="ec13" class="ec13" value="' + v.ec13 + '">' +
                                    '<input type="hidden" id="f01" class="f01" value="' + v.f01 + '">' +
                                    '<input type="hidden" id="f02" class="f02" value="' + v.f02 + '">' +
                                    '</div>' +
                                    '<div class="col-lg-6 col-md-12">' +
                                    '<h6>Household: ' + v.hhno + '</h6>' +
                                    '<h6>Gender: ' + gender + '</h6>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                    '<div class="col-lg-12 col-md-12 p-1">' +
                                    '<label for="image_status">Image Status</label>' +
                                    '<select id="image_status" class="image_status form-control ">' +
                                    '<option value="0"      readonly >Image Status</option>' +
                                    '<option value="OK" ' + (image_status_val == 'OK' ? 'selected' : '') + '>OK</option>' +
                                    '<option value="Blur" ' + (image_status_val == 'Blur' ? 'selected' : '') + '>Blur</option>' +
                                    '<option value="Focus Issue" ' + (image_status_val == 'Focus Issue' ? 'selected' : '') + '>Focus Issue</option>' +
                                    '<option value="Light Issue" ' + (image_status_val == 'Light Issue' ? 'selected' : '') + '>Light Issue</option>' +
                                    '<option value="Child Name not Matched" ' + (image_status_val == 'Child Name not Matched' ? 'selected' : '') + '>Child Name not Matched</option>' +
                                    '<option value="No Image" ' + (image_status_val == 'No Image' ? 'selected' : '') + '>No Image</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                    '<div class="col-lg-4 col-md-4 p-1">' +
                                    ' <fieldset>' +
                                    '<label style="color: #198c19;">' +
                                    '<input type="radio" value="1" class="checkAllBtn" name="checkAllBtn" data-type="m" onclick="clickAll(this)">' +
                                    ' Check All - Matched ' +
                                    '</label>' +
                                    '</fieldset>' +
                                    '</div>' +

                                    '<div class="col-lg-4 col-md-4 p-1">' +
                                    ' <fieldset>' +
                                    '<label  style="color: #fd0000;">' +
                                    '<input type="radio" value="2" class="checkAllBtn" name="checkAllBtn" data-type="nm" onclick="clickAll(this)">' +
                                    ' Check All - Not Matched' +
                                    '</label>' +
                                    '</fieldset>' +
                                    '</div>' +
                                    '<div class="col-lg-4 col-md-4 p-1">' +
                                    ' <fieldset>' +
                                    '<label  style="color: #fda400;">' +
                                    '<input type="radio" value="3" class="checkAllBtn" name="checkAllBtn" data-type="nr"  onclick="clickAll(this)">' +
                                    ' Check All - Not Readable' +
                                    '</label>' +
                                    '</fieldset>' +
                                    '</div>' +
                                    '</div>' +

                                    '<div class="row">' +
                                    '<div class="col-lg-12 col-md-12 p-1">' +
                                    '<label for="dobstatus">DoB Status</label>' +
                                    '<select id="dobstatus" class="dobstatus form-control ">' +
                                    '<option value="0"readonly >DoB Status</option>' +
                                    '<option value="1" ' + (dobstatus_val == 1 ? 'selected' : '') + '>OK</option>' +
                                    '<option value="2" ' + (dobstatus_val == 2 ? 'selected' : '') + '>Invalid DoB</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '</div>' +

                                    '<table class="table my-table-bordered image_form_table" border="1">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th width="8%"></th>' +
                                    '<th  width="15%">At Birth</th>' +
                                    '<th width="15%">At 6 Weeks</th>' +
                                    '<th width="15%">At 10 Weeks</th>' +
                                    '<th width="15%">At 14 Weeks</th>' +
                                    '<th width="15%">At 9 Months</th>' +
                                    '<th width="15%">At 15 Months</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                    '<tr>' +
                                    '<th scope="row">BCG</th>' +
                                    '<td data-id="' + bcg0_val + '" class="bcg0 inpType ' + color(bcg0_val) + '"  onclick="setValue(this)" >' + v.bcg + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">OPV</th>' +
                                    '<td data-id="' + opv0_val + '" class="opv0 inpType ' + color(opv0_val) + '" onclick="setValue(this)" >' + v.opv0 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + opv1_val + '" class="opv1 inpType ' + color(opv1_val) + '" onclick="setValue(this)">' + v.opv1 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + opv2_val + '" class="opv2 inpType ' + color(opv2_val) + '" onclick="setValue(this)">' + v.opv2 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + opv3_val + '" class="opv3 inpType ' + color(opv3_val) + '" onclick="setValue(this)">' + v.opv3 + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">Hep-B</th>' +
                                    '<td data-id="' + hep_b_val + '" class="hep_b inpType ' + color(hep_b_val) + '" onclick="setValue(this)" >' + v.hep_b + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">Penta</th>' +
                                    '<td>-</td>' +
                                    '<td data-id="' + penta1_val + '" class="penta1 inpType ' + color(penta1_val) + '" onclick="setValue(this)">' + v.penta1 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + penta2_val + '" class="penta2 inpType ' + color(penta2_val) + '" onclick="setValue(this)">' + v.penta2 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + penta3_val + '" class="penta3 inpType ' + color(penta3_val) + '" onclick="setValue(this)">' + v.penta3 + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">PCV</th>' +
                                    '<td>-</td>' +
                                    '<td data-id="' + pcv_val + '" class="pcv1 inpType ' + color(pcv_val) + '" onclick="setValue(this)" >' + v.pcv + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + pcv2_val + '" class="pcv2 inpType ' + color(pcv2_val) + '" onclick="setValue(this)" >' + v.pcv2 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + pcv3_val + '" class="pcv3 inpType ' + color(pcv3_val) + '" onclick="setValue(this)" >' + v.pcv3 + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">RV</th>' +
                                    '<td>-</td>' +
                                    '<td data-id="' + rv1_val + '" class="rv1 inpType ' + color(rv1_val) + '" onclick="setValue(this)" >' + v.rv1 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + rv2_val + '" class="rv2 inpType ' + color(rv2_val) + '" onclick="setValue(this)" >' + v.rv2 + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">IPV 1</th>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td data-id="' + ipv_val + '" class="ipv0 inpType ' + color(ipv_val) + '" onclick="setValue(this)" >' + v.ipv + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">Measles</th>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td data-id="' + measles1_val + '" class="measles1 inpType ' + color(measles1_val) + '" onclick="setValue(this)" >' + v.measles1 + '<p class="clickmsg"></p></td>' +
                                    '<td data-id="' + measles2_val + '" class="measles2 inpType ' + color(measles2_val) + '" onclick="setValue(this)" >' + v.measles2 + '<p class="clickmsg"></p></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">IPV 2</th>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' + '<td data-id="' + ipv2_val + '" class="ipv2 inpType ' + color(ipv2_val) + '" onclick="setValue(this)" >' + v.ipv2 + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th scope="row">TCV</th>' +
                                    '<td>-</td>' +
                                    '<td>-</td>' + '<td>-</td>' +
                                    '<td>-</td>' + '<td data-id="' + tcv_val + '" class="tcv inpType ' + color(tcv_val) + '" onclick="setValue(this)" >' + v.tcv + '<p class="clickmsg"></p></td>' +
                                    '<td>-</td>' +
                                    '</tr>' +
                                    '</tbody>' +
                                    '</table>' ;

                            });
                        } else {
                            items += '<div class="swiper-slide"> ' +
                                '<p>No Image found</p>' +
                                '</div>';
                            data_items += '<p>No detail Found</p>';
                            toastMsg('Images', 'No detail Found', 'error');
                        }
                    } catch (e) {}
                } else {
                    items += '<div class="swiper-slide"> ' +
                        '<p>No Image found</p>' +
                        '</div>';
                    data_items += '<p>No detail Found</p>';
                    toastMsg('Images', 'No detail Found', 'error');
                }
                // populate the gallery (right) and data list (left)
                $('.gallery_images').html('').html(items);
                $('.data_list').html('').html(data_items);
                $('.info-left p span.label:contains("NAME:")').parent().html('<span class="label">NAME:</span> ' + v.ec14);
                $('.info-left p span.label:contains("DATE OF BIRTH:")').parent().html('<span class="label">DATE OF BIRTH:</span> ' + dob);
                $('.info-left p span.label:contains("GENDER:")').parent().html('<span class="label">GENDER:</span> ' + gender);
                $('.info-right p span.label:contains("CLUSTER NO:")').parent().html('<span class="label">CLUSTER NO:</span> ' + v.cluster_code);
                $('.info-right p span.label:contains("HOUSEHOLD:")').parent().html('<span class="label">HOUSEHOLD:</span> ' + v.hhno);

                var buttonText = 'SUBMIT';
                var buttonFunction = 'SubmitData()';

// Check if dataExist was found and if current user is the original scorer
                if (response['dataExist'] && hidden_loginUser == lastIndex.createdBy) {
                    buttonText = 'EDIT';
                    buttonFunction = 'editData()';
                }

                $('#staticSubmit').text(buttonText);
                $('#staticSubmit').attr('onclick', buttonFunction);
                $('#staticSubmit').prop('disabled', false);
                // initialize gallery after HTML injection
                setTimeout(function () {
                    gallery();
                }, 500);
            });
        } else {
            $('.clusters_select').css('border', '1px solid red');
            $('.household_select').css('border', '1px solid red');
            toastMsg('Page', 'Something went wrong', 'error');
        }
    }
</script>
