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
                        <h2 class="content-header-title float-left mb-0">Card  Form</h2>
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
        <?php $data = $vac_details; ?>
        <style>
            :root {
                --primary-color: #3498db;
                --secondary-color: #2c3e50;
                --success-color: #2ecc71;
                --warning-color: #f39c12;
                --danger-color: #e74c3c;
                --light-bg: #f8f9fa;
                --border-color: #dee2e6;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f5f7fa;
                color: #333;
            }

            .card {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: none;
                margin-bottom: 20px;
            }

            .card-header {
                background-color: var(--secondary-color);
                color: white;
                border-radius: 10px 10px 0 0 !important;
                padding: 15px 20px;
                font-weight: 600;
            }

            .card-body {
                padding: 25px;
            }

            .form-label {
                font-weight: 600;
                color: var(--secondary-color);
                margin-bottom: 8px;
            }

            .form-control, .form-select {
                border-radius: 6px;
                padding: 10px 15px;
                border: 1px solid var(--border-color);
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                border-radius: 6px;
                padding: 10px 25px;
                font-weight: 600;
            }

            .btn-primary:hover {
                background-color: #2980b9;
                border-color: #2980b9;
            }

            .table {
                border-collapse: separate;
                border-spacing: 0;
                width: 100%;
            }

            .table th {
                background-color: var(--secondary-color);
                color: white;
                font-weight: 600;
                padding: 12px 15px;
            }

            .table td {
                padding: 12px 15px;
                vertical-align: middle;
            }

            .table tbody tr:nth-child(even) {
                background-color: #f8f9fa;
            }

            .table tbody tr:hover {
                background-color: rgba(52, 152, 219, 0.05);
            }

            .vaccine-option label {
                margin-right: 15px;
                font-weight: normal;
            }

            .vaccine-value {
                font-weight: 600;
            }

            .vaccine-value.updated {
                color: var(--success-color);
            }

            .vaccine-option-radio {
                margin-right: 5px;
            }

            .image-gallery {
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 20px;
            }

            .image-gallery img {
                width: 100%;
                height: auto;
                object-fit: cover;
            }

            .status-badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .status-ok {
                background-color: rgba(46, 204, 113, 0.2);
                color: var(--success-color);
            }

            .status-error {
                background-color: rgba(231, 76, 60, 0.2);
                color: var(--danger-color);
            }

            .status-warning {
                background-color: rgba(243, 156, 18, 0.2);
                color: var(--warning-color);
            }

            .check-all-options {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--secondary-color);
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 1px solid var(--border-color);
            }

            .field-group {
                margin-bottom: 20px;
            }

            .action-buttons {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 25px;
            }

            .info-card {
                background-color: white;
                border-left: 4px solid var(--primary-color);
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
            }

            @media (max-width: 768px) {
                .card-body {
                    padding: 15px;
                }

                .action-buttons {
                    flex-direction: column;
                }

                .action-buttons .btn {
                    width: 100%;
                }
            }
        </style>

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

        <?php
        if(isset( $_GET['c'])){

        ?>
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Image Gallery Section -->
                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-images me-2"></i>Child Images
                        </div>
                        <div class="card-body">
                            <div class="image-gallery">
                                <?php
                                $img = '';
                                if (1==1) {
                                    $img = '<div class="swiper-slide">
                                                <img class="img-fluid"
                                                     src="http://localhost/tpvics_round4/assets/images/banner/vac.png"
                                                     alt="vac.png">
                                            </div>
                                            <div class="swiper-slide">
                                                <img class="img-fluid"
                                                     src="http://localhost/tpvics_round4/assets/images/banner/vac.png"
                                                     alt="vac.png">
                                            </div>';
                                } else {
                                    $img = '<div class="swiper-slide text-center p-5"><i class="fas fa-image fa-3x text-muted mb-3"></i><p class="text-muted">No Image Available</p></div>';
                                } ?>

                                <div class="swiper-gallery swiper-container gallery-top mb-3">
                                    <div class="swiper-wrapper gallery_images">
                                        <?php echo $img; ?>
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>

                                <div class="swiper-container gallery-thumbs">
                                    <div class="swiper-wrapper gallery_images">
                                        <?php echo $img; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field-group">
                                <label for="image_status" class="form-label">Image Status</label>
                                <select id="image_status" class="image_status form-select">
                                    <?php
                                    $imageOptions = [
                                        '0' => 'Select Image Status',
                                        'OK' => 'OK',
                                        'Blur' => 'Blur',
                                        'Focus Issue' => 'Focus Issue',
                                        'Light Issue' => 'Light Issue',
                                        'Child Name not Matched' => 'Child Name not Matched',
                                        'No Image' => 'No Image'
                                    ];
                                    $savedValue = isset($vac_details_edit->image_status) ? $vac_details_edit->image_status : '0';
                                    foreach($imageOptions as $val => $label):
                                        ?>
                                        <option value="<?= $val ?>" <?= $savedValue == $val ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Child Information Section -->
                <div class="col-xl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-child me-2"></i>Child Information
                        </div>
                        <div class="card-body">
                            <div class="info-card">
                                <div class="row">
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="cluster_code" class="form-label">Cluster</label>
                                        <input type="text" class="form-control" required id="cluster_code"
                                               name="cluster_code" readonly disabled
                                               value="<?php echo(isset($data->cluster_code) && $data->cluster_code != '' ? $data->cluster_code : '') ?>">
                                    </div>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="hhno" class="form-label">Household Number</label>
                                        <input type="text" class="form-control" required id="hhno"
                                               name="hhno" readonly disabled
                                               value="<?php echo(isset($data->hhno) && $data->hhno != '' ? $data->hhno : '') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="ec14" class="form-label">Child Name</label>
                                        <input type="text" class="form-control" required id="ec14"
                                               name="ec14" readonly disabled
                                               value="<?php echo(isset($data->ec14) && $data->ec14 != '' ? $data->ec14 : '') ?>">
                                    </div>
                                    <?php
                                    if ($data->ec15 == 1) {
                                        $gender = 'Male';
                                    } else if ($data->ec15 == 2) {
                                        $gender = 'Female';
                                    } else {
                                        $gender = '';
                                    }
                                    ?>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="ec15" class="form-label">Gender</label>
                                        <input type="text" class="form-control" required id="ec15"
                                               name="ec15" readonly disabled
                                               value="<?php echo $gender; ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="ec13" class="form-label">Child Number</label>
                                        <input type="text" class="form-control" required id="ec13"
                                               name="ec13" readonly disabled
                                               value="<?php echo(isset($data->ec13) && $data->ec13 != '' ? $data->ec13 : '') ?>">
                                    </div>
                                    <div class="col-sm-6 col-12 mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="text"
                                               class="form-control"
                                               required id="dob" name="dob"
                                            <?php echo(isset($data->dob_val) && $data->dob_val == 2 ? '' : 'readonly disabled'); ?>
                                               value="<?php echo $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="field-group">
                                <label for="dobstatus" class="form-label">Date of Birth Status</label>
                                <select id="dobstatus" class="dobstatus form-select">
                                    <option value="0">Select DoB Status</option>
                                    <option value="1" <?= $vac_details_edit->dobstatus == 1 ? 'selected' : '' ?>>OK</option>
                                    <option value="2" <?= $vac_details_edit->dobstatus == 2 ? 'selected' : '' ?>>Invalid DoB</option>
                                </select>
                            </div>

                            <div class="field-group">
                                <div class="section-title">Bulk Actions</div>
                                <div class="check-all-options">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input checkAllBtn" type="radio" value="1" name="checkAllBtn"
                                                       data-type="m" onclick="clickAll()"
                                                    <?= $vac_details_edit->vac_status == 1 ? 'checked' : '' ?>>
                                                <label class="form-check-label">
                                                    Check All - Matched
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input checkAllBtn" type="radio" value="2" name="checkAllBtn"
                                                       data-type="nm" onclick="clickAll()"
                                                    <?= $vac_details_edit->vac_status == 2 ? 'checked' : '' ?>>
                                                <label class="form-check-label">
                                                    Check All - Not Matched
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input checkAllBtn" type="radio" value="3" name="checkAllBtn"
                                                       data-type="nr" onclick="clickAll()"
                                                    <?= $vac_details_edit->vac_status == 3 ? 'checked' : '' ?>>
                                                <label class="form-check-label">
                                                    Check All - Not Readable
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field-group">
                                <div class="section-title">Vaccination Records</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle bg-white">
                                        <thead class="table-secondary">
                                        <tr>
                                            <th class="text-center">Vaccine</th>
                                            <th class="text-center">Original Value</th>
                                            <th class="text-center">Updated Value</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $vaccines = [
                                            "bcg", "opv0", "opv1", "opv2", "opv3",
                                            "penta1", "penta2", "penta3",
                                            "pcv", "pcv2", "pcv3",
                                            "rv1", "rv2",
                                            "ipv", "ipv2",
                                            "measles1", "measles2",
                                            "hep_b",
                                            "tcv"
                                        ];

                                        foreach ($vaccines as $v):
                                            $oldValue = $vac_details->$v ?? '-';
                                            $newValue = $vac_details_edit->$v;
                                            $isUpdated = $oldValue != $newValue;

                                            $msg=$newValue;
                                            $class_='';
                                            if($newValue=='98'){
                                                $msg ='Vaccinator Error';
                                                $class_='text-danger';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><strong><?= strtoupper($v) ?></strong></td>
                                                <td class="text-center text-muted"><?= $oldValue ?></td>
                                                <td class="text-center">
                                                <span class="vaccine-value <?= $isUpdated ? 'updated' : '' ?> <?=$class_?>" id="<?= $v ?>_display">
                                                    <?=$msg?>
                                                </span>
                                                </td>
                                                <td class="vaccine-option">
                                                    <?php
                                                    // Determine which radio should be checked and which field to show
                                                    $checkedChange = $checkedError = $checkedDate = '';
                                                    $showDropdown = $showDate = 'style="display:none;"';
                                                    if ($newValue === '98') {
                                                        $checkedError = 'checked';
                                                    } elseif (preg_match('/^\d{2}$/', $newValue)) {
                                                        $checkedChange = 'checked';
                                                        $showDropdown = 'style="display:block;"';
                                                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $newValue)) {
                                                        $checkedDate = 'checked';
                                                        $showDate = 'style="display:block;"';
                                                    }
                                                    ?>

                                                    <div class="mb-2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input vaccine-option-radio" type="radio"
                                                                   name="<?= $v ?>_option" <?=$checkedChange?> value="change"
                                                                   onclick="toggleVaccineField('<?= $v ?>', 'code')">
                                                            <label class="form-check-label small">Change Code</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input vaccine-option-radio" type="radio"
                                                                   name="<?= $v ?>_option" <?=$checkedDate?> value="date"
                                                                   onclick="toggleVaccineField('<?= $v ?>', 'date')">
                                                            <label class="form-check-label small">Change Date</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input vaccine-option-radio" type="radio"
                                                                   name="<?= $v ?>_option" <?=$checkedError?> value="error"
                                                                   onclick="toggleVaccineField('<?= $v ?>', 'error')">
                                                            <label class="form-check-label small">Vaccinator Error</label>
                                                        </div>
                                                    </div>

                                                    <!-- Dropdown for Change Code -->
                                                    <div class="mt-2" id="dropdown-wrapper-<?= $v ?>" style="display:none;">
                                                        <select class="form-select form-select-sm" id="<?= $v ?>_dropdown" onchange="setVaccineValue('<?= $v ?>')">
                                                            <option value="" disabled selected>Select Code</option>
                                                            <option value="44">44</option>
                                                            <option value="66">66</option>
                                                            <option value="88">88</option>
                                                            <option value="97">97</option>
                                                        </select>
                                                    </div>

                                                    <!-- Date input for Change Date -->
                                                    <div class="mt-2" id="date-wrapper-<?= $v ?>" style="display:none;">
                                                        <input type="date" class="form-control form-control-sm" id="<?= $v ?>_date" onchange="setVaccineValue('<?= $v ?>')">
                                                    </div>

                                                    <!-- Hidden input that always stores the actual value -->
                                                    <input type="hidden" id="<?= $v ?>_value" name="<?= $v ?>" value="<?= $newValue ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="action-buttons">
                               <!-- <button type="button" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>-->
                                <button type="button" class="btn btn-primary" onclick="saveVaccinesData()">
                                    <i class="fas fa-save me-2"></i>Save Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </section>
        </div>
    <?php } ?>
    </div>
</div>
<!-- END: Content-->
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">

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

        window.open(url); // open in new tab
    }


    $(document).ready(function () {
        gallery();
        //pickaDate();
    });

    $('#dobstatus').change(function() {
        if ($(this).val() == '2') { // Invalid DoB
            $('#dob').prop('readonly', false).prop('disabled', false);
          //  pickDate(); // initialize date picker if required
        } else {
            $('#dob').prop('readonly', true).prop('disabled', true);
        }
    });

    function toggleEditBox(v) {
        $("#edit-box-" + v).toggleClass("d-none");
    }

    // Change Code Handler
    $(document).on("change", ".changeCode", function () {
        let id = $(this).data("id");
        let wrapper = $("#input-wrapper-" + id);

        if (this.checked) {
            wrapper.html(`
            <select class="form-control form-control-sm" name="${id}">
                <option value="" disabled selected>Select Code</option>
                <option value="44">44</option>
                <option value="66">66</option>
                <option value="88">88</option>
                <option value="97">97</option>
            </select>
        `);
        } else {
            wrapper.html(`
            <input type="text" class="form-control form-control-sm" name="${id}" id="${id}">
        `);
        }
    });

    // Vaccinator Error (98)
    $(document).on("change", ".vaccinatorError", function () {
        let id = $(this).data("id");
        let wrapper = $("#input-wrapper-" + id);

        if (this.checked) {
            wrapper.html(`
            <input type="text" class="form-control form-control-sm" name="${id}_98" value="98">
        `);
            $("#" + id + "_change").prop("checked", false);
        } else {
            wrapper.html(`
            <input type="text" class="form-control form-control-sm" name="${id}">
        `);
        }
    });

    clickAll();
    function clickAll() {
        let type = $('input[name="checkAllBtn"]:checked').data("type");

        // Target only the three radios
        let vaccineRadios = $(".vaccine-option-radio"); // make sure all 3 radios have this class

        if (type === "m") { // Matched
            vaccineRadios.prop("disabled", true);
            vaccineRadios.closest('div').css("opacity", "0.5");
            $(".edit-box").addClass("d-none");
        } else if (type === "nm") { // Not Matched
            vaccineRadios.prop("disabled", false);
            vaccineRadios.closest('div').css("opacity", "1");
        } else if (type === "nr") { // Not Readable
            vaccineRadios.prop("disabled", true);
            vaccineRadios.closest('div').css("opacity", "0.5");
            $(".edit-box").addClass("d-none");
        }
    }



    // Show/hide dropdown or date input and set hidden value
    function toggleVaccineField(vaccine, type) {
        if(type === 'code') {
            $('#dropdown-wrapper-' + vaccine).show();
            $('#date-wrapper-' + vaccine).hide();
            $('#'+vaccine+'_value').val(''); // reset value
        } else if(type === 'date') {
            $('#dropdown-wrapper-' + vaccine).hide();
            $('#date-wrapper-' + vaccine).show();
            $('#'+vaccine+'_value').val($('#'+vaccine+'_date').val()); // set date as value
        } else if(type === 'error') {
            $('#dropdown-wrapper-' + vaccine).hide();
            $('#date-wrapper-' + vaccine).hide();
            $('#'+vaccine+'_value').val('98'); // vaccinator error
        }
    }

    // Update hidden input when dropdown or date changes
    function setVaccineValue(vaccine) {
        let selectedOption = $('input[name="'+vaccine+'_option"]:checked').val();
        if(selectedOption === 'change') {
            $('#'+vaccine+'_value').val($('#'+vaccine+'_dropdown').val());
        } else if(selectedOption === 'date') {
            $('#'+vaccine+'_value').val($('#'+vaccine+'_date').val());
        }
    }

    // Save all vaccines
    function saveVaccinesData() {
        let formData = {};
        let vaccines = ["bcg","opv0","opv1","opv2","opv3","penta1","penta2","penta3","pcv","pcv2","pcv3","rv1","rv2","ipv","ipv2","measles1","measles2","hep_b","tcv"];

        vaccines.forEach(v => {
            formData[v] = $('#'+v+'_value').val(); // always use hidden input
        });

        // Additional info
        formData['cluster_code'] = "<?= $data->cluster_code ?? '' ?>";
        formData['hhno'] = "<?= $data->hhno ?? '' ?>";
        formData['ec13'] = "<?= $data->ec13 ?? '' ?>";
        formData['image_status'] = $('#image_status').val();
        formData['dob'] = $('#dob').val();
        formData['dobstatus'] = $('#dobstatus').val();
        formData['vac_status'] = $('input[name="checkAllBtn"]:checked').val();

        $.ajax({
            url: '<?= base_url('index.php/Card_edit/save_vaccines_ajax'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.status == 'success'){
                    alert('Data saved successfully!');
                } else {
                    alert('Error saving data: ' + response.message);
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
                alert('AJAX error saving data');
            }
        });
    }




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
        setTimeout(function () {
            pickDate();
        }, 500);
    }


    function addata() {
        var data = {};
        data['cluster_code'] = $('#cluster_code').val();
        data['hhno'] = $('#hhno').val();
        data['ec'] = $('#ec').val();
        data['dob'] = $('#dob').val();

        data['bcg'] = $('#bcg').val();
        data['bcg_check'] = ($('#bcg_checklist_other').is(":checked") ? 98 : 0);
        data['opv0'] = $('#opv0').val();
        data['opv0_check'] = ($('#opv0_checklist_other').is(":checked") ? 98 : 0);
        data['opv1'] = $('#opv1').val();
        data['opv1_check'] = ($('#opv1_checklist_other').is(":checked") ? 98 : 0);
        data['opv2'] = $('#opv2').val();
        data['opv2_check'] = ($('#opv2_checklist_other').is(":checked") ? 98 : 0);
        data['opv3'] = $('#opv3').val();
        data['opv3_check'] = ($('#opv3_checklist_other').is(":checked") ? 98 : 0);
        data['penta1'] = $('#penta1').val();
        data['penta1_check'] = ($('#penta1_checklist_other').is(":checked") ? 98 : 0);
        data['penta2'] = $('#penta2').val();
        data['penta2_check'] = ($('#penta2_checklist_other').is(":checked") ? 98 : 0);
        data['penta3'] = $('#penta3').val();
        data['penta3_check'] = ($('#penta3_checklist_other').is(":checked") ? 98 : 0);
        data['pcv'] = $('#pcv').val();
        data['pcv_check'] = ($('#pcv_checklist_other').is(":checked") ? 98 : 0);
        data['pcv2'] = $('#pcv2').val();
        data['pcv2_check'] = ($('#pcv2_checklist_other').is(":checked") ? 98 : 0);
        data['pcv3'] = $('#pcv3').val();
        data['pcv3_check'] = ($('#pcv3_checklist_other').is(":checked") ? 98 : 0);
        data['rv1'] = $('#rv1').val();
        data['rv1_check'] = ($('#rv1_checklist_other').is(":checked") ? 98 : 0);
        data['rv2'] = $('#rv2').val();
        data['rv2_check'] = ($('#rv2_checklist_other').is(":checked") ? 98 : 0);
        data['ipv'] = $('#ipv').val();
        data['ipv_check'] = ($('#ipv_checklist_other').is(":checked") ? 98 : 0);
        data['measles1'] = $('#measles1').val();
        data['measles1_check'] = ($('#measles1_checklist_other').is(":checked") ? 98 : 0);
        data['measles2'] = $('#measles2').val();
        data['measles2_check'] = ($('#measles2_checklist_other').is(":checked") ? 98 : 0);
        data['hep_b'] = $('#hep_b').val();
        data['hep_b_check'] = ($('#hep_b_checklist_other').is(":checked") ? 98 : 0);
        data['ipv2'] = $('#ipv2').val();
        data['ipv2_check'] = ($('#ipv2_checklist_other').is(":checked") ? 98 : 0);
        data['tcv'] = $('#tcv').val();
        data['tcv_check'] = ($('#tcv_checklist_other').is(":checked") ? 98 : 0);
        var vd = validateData(data);
        if (vd) {

            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Card_edit/addForm'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                } else if (result == 2) {
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    toastMsg('Error', 'Invalid Household', 'error');
                } else if (result == 6) {
                    toastMsg('Error', 'Invalid Cluster & Household information', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            toastMsg('Page', 'Something went wrong', 'error');
        }
    }
</script>