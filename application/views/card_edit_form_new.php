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
                        <h2 class="content-header-title float-left mb-0">Card Edit Form</h2>
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
        <div class="content-body">
            <section class="basic-select2">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <?php
                                    $img = '';
                                    if ((isset($data->f01) && $data->f01 != '') || (isset($data->f02) && $data->f02 != '')) {
                                        $img = '<div class="swiper-slide">
                                                        <img class="img-fluid"
                                                             src="https://vcoe1.aku.edu/tpvics_shruc_r4/api/uploads/' . $data->f01 . '"
                                                             alt="' . $data->f01 . '">
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <img class="img-fluid"
                                                             src="https://vcoe1.aku.edu/tpvics_shruc_r4/api/uploads/' . $data->f02 . '"
                                                             alt="' . $data->f02 . '">
                                                    </div>';
                                    } else {
                                        $img = '<div class="swiper-slide"><p>No Image found</p></div>';
                                    } ?>
                                    <div class="swiper-gallery swiper-container gallery-top">
                                        <div class="swiper-wrapper gallery_images">
                                            <?php echo $img; ?>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                    <div class="swiper-container gallery-thumbs">
                                        <div class="swiper-wrapper mt-25 gallery_images">
                                            <?php echo $img; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="cluster_code" class="label-control ">Cluster</label>
                                                <input type="text" class="form-control" required id="cluster_code"
                                                       name="cluster_code" readonly disabled
                                                       value="<?php echo(isset($data->cluster_code) && $data->cluster_code != '' ? $data->cluster_code : '') ?>">


                                                <input type="hidden" class="form-control" required id="ec"
                                                       name="ec" readonly disabled
                                                       value="<?php echo(isset($ec) && $ec != '' ? $ec : '1') ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="hhno" class="label-control ">hhno</label>
                                                <input type="text" class="form-control" required id="hhno"
                                                       name="hhno" readonly disabled
                                                       value="<?php echo(isset($data->hhno) && $data->hhno != '' ? $data->hhno : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec14" class="label-control ">Child Name</label>
                                                <input type="text" class="form-control" required id="ec14"
                                                       name="ec14" readonly disabled
                                                       value="<?php echo(isset($data->ec14) && $data->ec14 != '' ? $data->ec14 : '') ?>">
                                            </div>
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
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec15" class="label-control ">Gender</label>
                                                <input type="text" class="form-control" required id="ec15"
                                                       name="ec15" readonly disabled
                                                       value="<?php echo $gender; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec13" class="label-control ">Child No</label>
                                                <input type="text" class="form-control" required id="ec13"
                                                       name="ec13" readonly disabled
                                                       value="<?php echo(isset($data->ec13) && $data->ec13 != '' ? $data->ec13 : '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="dob" class="label-control ">DoB</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required id="dob" name="dob"
                                                    <?php echo(isset($data->dob_val) && $data->dob_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy; ?>"
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 p-1">
                                            <label for="image_status">Image Status</label>
                                            <select id="image_status" class="image_status form-control">
                                                <?php
                                                $imageOptions = [
                                                    '0' => 'Image Status',
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

                                    <?php $selectedStatus = isset($vac_details_edit->dobstatus) ? $vac_details_edit->dobstatus : 0; ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 p-1">
                                            <label for="dobstatus">DoB Status</label>
                                            <select id="dobstatus" class="dobstatus form-control ">
                                                <option value="0" readonly>DoB Status</option>
                                                <option value="1"  <?= $selectedStatus == 1 ? 'selected' : '' ?>>OK </option>
                                                <option value="2"  <?= $selectedStatus == 2 ? 'selected' : '' ?>>Invalid DoB</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                    </div>
                                    <?php $selectedStatus = isset($vac_details_edit->vac_status) ? $vac_details_edit->vac_status : 0; ?>

                                        <div class="col-lg-4 col-md-4 p-1">
                                            <fieldset>
                                                <label>
                                                    <input type="radio" value="1" class="checkAllBtn" name="checkAllBtn"
                                                           data-type="m" onclick="clickAll()"
                                                        <?= $selectedStatus == 1 ? 'checked' : '' ?>>
                                                    Check All - Matched
                                                </label>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4 col-md-4 p-1">
                                            <fieldset>
                                                <label>
                                                    <input type="radio" value="2" class="checkAllBtn" name="checkAllBtn"
                                                           data-type="nm" onclick="clickAll()"
                                                        <?= $selectedStatus == 2 ? 'checked' : '' ?>>
                                                    Check All - Not Matched
                                                </label>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4 col-md-4 p-1">
                                            <fieldset>
                                                <label>
                                                    <input type="radio" value="3" class="checkAllBtn" name="checkAllBtn"
                                                           data-type="nr" onclick="clickAll()"
                                                        <?= $selectedStatus == 3 ? 'checked' : '' ?>>
                                                    Check All - Not Readable
                                                </label>
                                            </fieldset>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-12">

                                                <table class="table table-bordered align-middle bg-white shadow-sm">
                                                    <thead class="table-secondary text-center">
                                                    <tr>
                                                        <th>Vaccine</th>
                                                        <th>Old Value</th>
                                                        <th>New Value</th>
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
                                                        $newValue = $vac_details_edit->$v ?? $oldValue;
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><b><?= strtoupper($v) ?></b></td>
                                                            <td class="text-center text-muted"><?= $oldValue ?></td>
                                                            <td class="text-start position-relative">

                                                                <?php if ($oldValue != $newValue): ?>
                                                                    <span class="fw-bold text-success"><?= $newValue ?></span>
                                                                <?php endif; ?>

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

                                                                <div>
                                                                    <label>
                                                                        <input type="radio" name="<?= $v ?>_option" <?=$checkedChange?>  class="vaccine-option-radio" value="change" onclick="toggleVaccineField('<?= $v ?>', 'code')">
                                                                        Change Code
                                                                    </label>

                                                                    <label class="ms-2">
                                                                        <input type="radio" name="<?= $v ?>_option" <?=$checkedDate?> class="vaccine-option-radio" value="date" onclick="toggleVaccineField('<?= $v ?>', 'date')">
                                                                        Change Date
                                                                    </label>
                                                                    <label class="ms-2">
                                                                        <input type="radio" name="<?= $v ?>_option" <?=$checkedError?> class="vaccine-option-radio" value="error" onclick="toggleVaccineField('<?= $v ?>', 'error')">
                                                                        Vaccinator Error
                                                                    </label>
                                                                </div>

                                                                <!-- Dropdown for Change Code -->
                                                                <div class="mt-2" id="dropdown-wrapper-<?= $v ?>" style="display:none;">
                                                                    <select class="form-control form-control-sm" id="<?= $v ?>_dropdown" onchange="setVaccineValue('<?= $v ?>')">
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
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12 col-12 ">
                                            <button type="button" class="btn btn-primary" onclick="saveVaccinesData()">
                                                Insert Datas
                                            </button>
                                        </div>
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
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">

<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>
<script>

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