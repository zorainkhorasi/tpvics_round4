
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Listing Form - Functional & Styled</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* ===================================================
           EXACT COLOR MATCHING & LAYOUT REPLICATION CSS
           (Copied from your New UI HTML)
           =================================================== */

        /* 0. Outer Page Background */
        body {
            background-color: #f6f7f8;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        /* 1. Main Title */
        .section-title {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: #495057;
        }

        /* 2. Field Labels */
        label.form-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
            font-weight: normal;
        }
        label.label-inline {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: normal;
            white-space: nowrap;
            align-self: center;
            line-height: 1.5;
        }

        /* Primary labels for dynamically generated fields (Used by searchData for row titles) */
        .label-control.text-primary {
            font-weight: bold;
            font-size: 0.85rem;
            color: #007bff !important; /* Blue for primary label */
        }

        /* 3. Header Cluster/Area Box (Specific Teal Match) */
        .info-header-box {
            width: 100%;
            background-color: #ecfffb;
            border: 2px solid #045b62;
            padding: 5px 10px;
            /* Removed margin-bottom here as it's controlled by the parent element margin */
            font-size: 0.85rem;
            line-height: 1.3;
            color: #000000;
            max-width: 100%;
        }
        .info-header-box strong {
            font-weight: bold;
            color: #000000;
        }
        /* Style for Check Cluster button text */
        .geoarea_name { margin: 0; padding-top: 5px; font-size: 0.9rem; font-weight: bold; color: #045b62; }

        /* 4. Detail Boxes (VACCINATOR, LHW, POLIO WORKER) */
        .detail-box {
            background-color: #f7f7f7;
            border: 1px solid #e9ecef;
            padding: 15px;
            margin-bottom: 20px;
            height: 100%;
        }
        .detail-box label {
            font-weight: bold;
            color: #343a40;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .detail-box .mb-3,
        .detail-box .mb-0 {
            display: flex;
            align-items: center;
        }
        .detail-box .label-inline {
            margin-right: 8px;
            margin-bottom: 0 !important;
        }
        .detail-box .label-inline,
        .detail-box .form-label {
            font-weight: normal;
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: none;
        }
        .sub-header{
            color: #3e8d9b !important;
            font-weight: bold !important;
            font-size: 17px !important;
            place-self: anchor-center !important;
        }


        /* 5. Input Fields (The Underline Look) */
        .form-control-plaintext,
        .form-control-underline, /* Added for Selects/Date pickers */
        .form-control-plaintext:focus {
            padding: 0;
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0;
            border-bottom: 1px solid #ced4da;
            margin-top: -5px;
            margin-bottom: 5px;
            line-height: 1.8;
            background-color: transparent !important;
            font-size: 0.95rem;
            color: #212529;
            text-align: left;
            height: 35px;
        }

        /* Fix for the table input fields to fit better */
        .table .form-control-plaintext,
        .table .form-control-underline {
            height: 30px;
            margin-bottom: 0;
            margin-top: 0;
        }
        .form-control.error, .form-control-plaintext.error, .form-control-underline.error {
            border-color: red !important;
        }


        /* 6. Totals Section */
        .totals-section > div {
            display: flex;
            align-items: center;
        }
        .totals-section label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: normal;
            text-align: left;
            line-height: 1.2;
            margin-right: 8px;
        }
        .totals-section .form-control-plaintext {
            text-align: center;
            font-weight: 500;
            margin-top: 0;
        }
        .table-responsive > .table-bordered {
            border: 0;
            color: #ffffff;
        }
        /* 7. Table Styling */
        .table thead th {
            background-color: #d8f1ed;
            font-size: 0.85rem;
            font-weight: bold;
            color: #343a40;
            text-align: center;
            vertical-align: middle;
            border-color: #dee2e6;
            padding: 10px;
        }
        .table tbody td {
            vertical-align: middle;
            border-color: #d8e3e1;
        }
        .s-no {
            text-align: center;
            font-weight: normal;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* 8. Buttons */
        .btn-search {
            background-color: #388e3c;
            border-color: #388e3c;
            padding: 5px 30px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-search:hover {
            background-color: #2e7d32;
            border-color: #2e7d32;
        }
        /* Style for the Save Data button, matching the old logic's class */
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #138496;
        }

        /* Utility Class from Old Logic */
        .hide { display: none !important; }

    </style>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>

            <div class="content-body">

                <div class="container-fluid form-container my-5">
                    <h2 class="section-title">Manual Listing</h2>

                    <input type="hidden" id="hidden_slug_dist"
                           value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
                    <input type="hidden" id="hidden_slug_uc" value="<?php echo(isset($slug_uc) && $slug_uc != '' ? $slug_uc : ''); ?>">
                    <input type="hidden" id="hidden_slug_cluster"
                           value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : ''); ?>">

                    <div class="row mb-3 align-items-end">
                        <div class="col-md-3 d-flex align-items-center">
                            <label class="label-inline me-2" for="district_select">District</label>
                            <div class="flex-grow-1">
                                <select class="form-control form-control-plaintext select2 district_select" autocomplete="uc"
                                        id="district_select" onchange="changeDistricts()">
                                    <option value="0" readonly disabled selected>Select District</option>
                                    <?php if (isset($pa_list) && $pa_list != '') {
                                        foreach ($pa_list as $k => $p) {
                                            echo '<option value="' . $p->my_id . '" ' . (isset($slug_p) && $slug_p == $p->my_id ? "selected" : "") . '>' . $p->my_name . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center">
                            <label class="label-inline me-2" for="clusters_select">Cluster</label>
                            <div class="flex-grow-1">
                                <select class="form-control form-control-plaintext select2 clusters_select"
                                        onchange="displayClusterBtn()" autocomplete="clus"
                                        id="clusters_select">
                                    <option value="0" readonly disabled selected>Select Cluster</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex flex-column justify-content-md-end justify-content-start mt-3 mt-md-0">
                            <div class="info-header-box mb-2">
                                <strong>Cluster: <span id="cluster_id_display">TBD</span></strong><br>
                                Area: <span id="area_display">TBD</span> | Village: <span id="village_display">TBD</span>
                                <div class="mt-1">Number of Households: <span id="hh_count_display">TBD</span></div>
                            </div>

                            <div class="chkCluster_div d-flex justify-content-end align-items-center">
<!--                                <p class="geoarea_name me-3"></p>-->
                                <button type="button" class="btn btn-info chkCluster_btn"
                                        onclick="chkCluster()">
                                    Check Cluster
                                </button>
                            </div>
                        </div>
                    </div> <div class="nextDiv hide">

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label mb-3" style="font-size: 0.9rem; font-weight: bold; color: #43a1a9; text-transform: uppercase;">VILLAGE DETAIL</label>
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label class="label-inline me-2" for="village">Area/ Village</label>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control form-control-plaintext village" id="village" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label class="label-inline me-2" for="hf">Name Health Facility</label>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control form-control-plaintext hf" id="hf" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label class="label-inline me-2" for="number_hh">Number of Households (12-23 Months Children)</label>
                                        <div class="flex-grow-1">
                                            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/"
                                                   onKeyPress="if(this.value.length==3) return false;"
                                                   class="form-control form-control-plaintext number_hh" id="number_hh"
                                                   minlength="1" min="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4" data-masonry='{"percentPosition": true }'>

                            <div class="col-md-4">
                                <div class="detail-box">
                                    <p class="mb-3 sub-header">VACCINATOR DETAIL</p>

                                    <div class="mb-3">
                                        <label class="label-inline" for="vaccinator_frequency">Visit Frequency</label>
                                        <div class="flex-grow-1">
                                            <select class="form-control form-control-underline" id="vaccinator_frequency">
                                                <option value="" disabled selected>Select</option>
                                                <option value="1">Monthly</option>
                                                <option value="2">Quaterly</option>
                                                <option value="3">Twice a year</option>
                                                <option value="4">Once a year</option>
                                                <option value="5">Only during campaigns</option>
                                                <option value="6">No one has information about this</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="label-inline" for="name_of_vaccinator">Name</label>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control form-control-plaintext name_of_vaccinator" id="name_of_vaccinator" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="label-inline" for="vaccinator_visit_date">Last Visit Date</label>
                                        <div class="flex-grow-1">
                                            <input type="date" class="form-control form-control-plaintext vaccinator_visit_date" id="vaccinator_visit_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-box">
                                    <p class="mb-3 sub-header">LHW DETAIL</p>

                                    <div class="mb-3">
                                        <label class="label-inline" for="lhw_frequency">Visit Frequency</label>
                                        <div class="flex-grow-1">
                                            <select class="form-control form-control-underline" id="lhw_frequency">
                                                <option value="" disabled selected>Select</option>
                                                <option value="1">Monthly</option>
                                                <option value="2">Quaterly</option>
                                                <option value="3">Twice a year</option>
                                                <option value="4">Once a year</option>
                                                <option value="5">Only during campaigns</option>
                                                <option value="6">No one has information about this</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="label-inline" for="name_of_lhw">Name Deputed For this Area</label>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control form-control-plaintext name_of_lhw" id="name_of_lhw" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="label-inline" for="lhw_visit_date">Last Visit Date</label>
                                        <div class="flex-grow-1">
                                            <input type="date" class="form-control form-control-plaintext lhw_visit_date" id="lhw_visit_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-box">
                                    <p class="mb-3 sub-header">POLIO WORKER DETAIL</p>

                                    <div class="mb-3">
                                        <label class="label-inline" for="polio_frequency">Visit Frequency</label>
                                        <div class="flex-grow-1">
                                            <select class="form-control form-control-underline" id="polio_frequency">
                                                <option value="" disabled selected>Select</option>
                                                <option value="1">Monthly</option>
                                                <option value="2">Quaterly</option>
                                                <option value="3">Twice a year</option>
                                                <option value="4">Once a year</option>
                                                <option value="5">Only during campaigns</option>
                                                <option value="6">No one has information about this</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="label-inline" for="name_of_polio">Health Worker Name</label>
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control form-control-plaintext name_of_polio" id="name_of_polio" required>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="label-inline" for="polio_visit_date">Last Visit Date</label>
                                        <div class="flex-grow-1">
                                            <input type="date" class="form-control form-control-plaintext polio_visit_date" id="polio_visit_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-search" onclick="searchData()">Set Data</button>
                            </div>
                        </div>

                    </div> </div> <section id="analytics-card" class="my_card hide">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Linelisting</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card_html">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- END: Content-->
<input type="hidden" id="hidden_slug_dist"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<input type="hidden" id="hidden_slug_uc" value="<?php echo(isset($slug_uc) && $slug_uc != '' ? $slug_uc : ''); ?>">
<input type="hidden" id="hidden_slug_cluster"
       value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : ''); ?>">

    <script>
        // Placeholder functions (assuming your main application includes these globally)
        function showloader() { console.log("Showing Loader..."); }
        function hideloader() { console.log("Hiding Loader..."); }
        function CallAjax(url, data, method, callback) {
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: callback,
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    hideloader();
                }
            });
        }
        function toastMsg(title, message, type) { console.log(`TOAST - ${type.toUpperCase()}: ${title} - ${message}`); }

        // Placeholder for pickadate, assuming it is loaded elsewhere
        // If not loaded, this function will throw an error.
        function mydate() {
            if (typeof $.fn.pickadate !== 'undefined') {
                $('.mypickadat').pickadate({
                    selectYears: true,
                    selectMonths: true,
                    min: new Date(2019, 12, 1),
                    max: true,
                    format: 'dd-mm-yyyy'
                });
            } else {
                console.warn("Pickadate plugin not found. Date inputs may not be fully functional.");
            }
        }


        $(document).ready(function () {
            // Since $slug_cluster might be set, run changeDistricts on load if needed
            if ($('#district_select').val() != 0) {
                changeDistricts();
            }
            mydate();
        });

        function changeDistricts() {
            var data = {};
            data['district_select'] = $('.district_select').val();
            // Reset visibility
            $('.chkCluster_btn').removeClass('hide');
            $('.nextDiv').addClass('hide');
            $('.my_card').addClass('hide');


            if (data['district_select'] !== '' && data['district_select'] !== undefined && data['district_select'] !== '0') {

                showloader();

                // NOTE: PHP base_url() needs to be handled by your environment
                CallAjax('<?php echo base_url('index.php/manual_linelisting/getClustersData'); ?>', data, 'POST', function (res) {

                    hideloader();
                    var items = '<option value="" disabled selected>Select Clusters</option>';

                    var response = [];

                    try {
                        response = JSON.parse(res);
                    } catch (e) {
                        $('.clusters_select').html(items);
                        return;
                    }

                    var selectedCluster = "<?php echo $slug_cluster; ?>";

                    if (response.length > 0) {
                        $.each(response, function (i, v) {
                            items += `<option value="${v.cluster_no}" ${selectedCluster == v.cluster_no ? 'selected' : ''}>${v.cluster_no}</option>`;
                        });
                    }

                    $('.clusters_select').html(items);
                });

            } else {
                $('.clusters_select').html('');
            }
        }


        function displayClusterBtn() {
            $('.chkCluster_btn').removeClass('hide');
            $('.nextDiv').addClass('hide');
            $('.my_card').addClass('hide');
            // Reset info box
            $('.geoarea_name').html('');
            $('#cluster_id_display').text('TBD');
            $('#area_display').text('TBD');
            $('#village_display').text('TBD');
            $('#hh_count_display').text('TBD');
        }

        function chkCluster() {
            $('.my_card').addClass('hide');
            $('.card_html').html('');
            var flag = 0;

            var district_select = $('#district_select').val();
            if (district_select == '' || district_select == undefined || district_select == '0') {
                $('#district_select').addClass('error');
                flag = 1;
                toastMsg('District', 'Invalid District', 'error');
                return false;
            } else {
                $('#district_select').removeClass('error');
            }

            var cluster_select = $('#clusters_select').val();
            if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
                $('#clusters_select').addClass('error');
                flag = 1;
                toastMsg('Cluster', 'Invalid Cluster', 'error');
                return false;
            } else {
                $('#clusters_select').removeClass('error');
            }

            if (flag == 0) {
                var data = {};
                data['cluster'] = cluster_select;
                // NOTE: PHP base_url() needs to be handled by your environment
                CallAjax('<?php echo base_url() . 'index.php/Manual_linelisting/checkClusterExists' ?>',
                    data, 'POST', function (res) {

                        var response = JSON.parse(res);

                        if (response.exists == 0) {
                            // Cluster does NOT exist, proceed with linelisting
                            if (!response.cluster_data || response.cluster_data.length === 0) {
                                toastMsg('Cluster', 'Cluster data not found', 'error');
                                $('.geoarea_name').html('Invalid Cluster');
                                return false;
                            }
                            var c = response.cluster_data[0];

                            // Update the info box and status message
                            $('#cluster_id_display').text(cluster_select);
                            $('.geoarea_name').html('Cluster: <strong>' + cluster_select + '</strong> (Area: ' + c.geoarea + ')');

                            // Attempt to parse geoarea into Area and Village (assuming format "AREA | VILLAGE" or just "AREA")
                            let geoParts = c.geoarea.split('|').map(p => p.trim());
                            $('#area_display').text(geoParts[0] || 'N/A');
                            $('#village_display').text(geoParts[1] || 'N/A');
                            $('#hh_count_display').text(c.total_hh || 'TBD');


                            $('.chkCluster_btn').addClass('hide');
                            $('.nextDiv').removeClass('hide'); // Show the form fields
                            mydate();
                        } else {
                            // Cluster EXISTS, cannot proceed
                            toastMsg('Cluster', 'Cluster data already Exist', 'error');
                            $('.geoarea_name').html('Cluster Exists. Cannot Proceed.');
                        }
                    });
            }
        }


        function searchData() {
            $('.my_card').addClass('hide');
            $('.card_html').html('');
            var flag = 0;

            var district_select = $('#district_select').val();
            if (district_select == '' || district_select == undefined || district_select == '0') {
                $('#district_select').addClass('error');
                flag = 1;
                toastMsg('District', 'Invalid District', 'error');
                return false;
            } else {
                $('#district_select').removeClass('error');
            }

            var cluster_select = $('#clusters_select').val();
            if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
                $('#clusters_select').addClass('error');
                flag = 1;
                toastMsg('Cluster', 'Invalid Cluster', 'error');
                return false;
            } else {
                $('#clusters_select').removeClass('error');
            }

            var number_hh = $('#number_hh').val();
            if (number_hh == '' || number_hh == undefined || number_hh == '0' || number_hh < 20) {
                $('#number_hh').addClass('error');
                flag = 1;
                if (number_hh < 20) {
                    toastMsg('Household Number', 'Eligible Household must be greater than 19', 'error');
                } else {
                    toastMsg('Household Number', 'Invalid Household Number', 'error');
                }
                return false;
            } else {
                $('#number_hh').removeClass('error');
            }

            if (flag == 0) {

                var data = {};
                data['cluster_no'] = cluster_select;

                var html = '';

                // 1. DYNAMIC TOTALS FIELDS (Using NEW UI structure from the static HTML)
                html += '<div class="row mb-5 totals-section">';

                // Total Structure Identified
                html += '<div class="col-md-3 mb-3"> ' +
                    '   <label for="total_structure_identified" class="label-inline me-2">Total Structure Identified</label>' +
                    '   <div class="flex-grow-1">' +
                    '       <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control form-control-plaintext total_structure_identified" ' +
                    '           id="total_structure_identified" name="total_structure_identified" required>' +
                    '   </div>' +
                    '</div> ';

                // Total Household having 12-23 Months Children (Value fixed from #number_hh)
                html += '<div class="col-md-3 mb-3"> ' +
                    '   <label for="total_household_identified" class="label-inline me-2">Total Household having 12-23 Months Children</label>' +
                    '   <div class="flex-grow-1">' +
                    '       <input type="number" maxlength="3" max="3" class="form-control form-control-plaintext total_household_identified" value="' + number_hh + '"  ' +
                    '           id="total_household_identified" name="total_household_identified" required  readonly disabled>' +
                    '   </div>' +
                    '</div> ';

                // Total Residential Structures
                html += '<div class="col-md-3 mb-3"> ' +
                    '   <label for="total_residential_structures" class="label-inline me-2">Total Residential Structures</label>' +
                    '   <div class="flex-grow-1">' +
                    '       <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1" class="form-control form-control-plaintext total_residential_structures"  ' +
                    '           id="total_residential_structures" name="total_residential_structures" required>' +
                    '   </div>' +
                    '</div> ';

                // Date of Linelisting
                html += '<div class="col-md-3 mb-3"> ' +
                    '   <label for="linelisting_date" class="label-inline me-2">Date of Linelisting</label>' +
                    '   <div class="flex-grow-1">' +
                    '       <input type="text" class="form-control form-control-plaintext mypickadat linelisting_date"  value="<?php echo date("d-m-Y")?>" ' +
                    '           id="linelisting_date" name="linelisting_date" required>' +
                    '   </div>' +
                    '</div> ';
                html += '</div>'; // End of Totals Row


                // 2. DYNAMIC LINELISTING TABLE (Using NEW UI Table Structure)
                html += '<div class="row">' +
                    '<div class="col-12">' +
                    '<div class="table-responsive">' +
                    '<table class="table table-bordered align-middle">' +
                    '<thead>' +
                    '<tr>' +
                    '<th style="width: 5%;">S.NO</th>' +
                    '<th style="width: 20%;">Structure Number</th>' +
                    '<th style="width: 15%;">S.No of Household</th>' +
                    '<th style="width: 30%;">Name of Household</th>' +
                    '<th style="width: 30%;">Total 12-23 months children</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                for (var i = 1; i <= number_hh; i++) {
                    html += `
                    <tr>
                        <td class="s-no">${i}</td>
                        <td><input type="number" maxlength="3" max="3" pattern="/^-?\\d+\\.?\\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control form-control-plaintext structure_number_${i}" id="structure_number_${i}" required></td>
                        <td><input type="number" maxlength="3" max="3" pattern="/^-?\\d+\\.?\\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control form-control-plaintext household_no_${i}" id="household_no_${i}" required></td>
                        <td><input type="text" class="form-control form-control-plaintext household_name_${i}" id="household_name_${i}" required></td>
                        <td><input type="number" maxlength="1" max="1" pattern="/^-?\\d+\\.?\\d*$/" onKeyPress="if(this.value.length==1) return false;" minlength="1" min="1" class="form-control form-control-plaintext childAge_${i}" id="childAge_${i}" required></td>
                    </tr>
                `;
                }

                html +=                   '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>'; // End of Table Section

                // 3. SAVE BUTTON AND NOTE
                html += '<div class="text-right mt-4">' +
                    '<button type="button" class="btn btn-info mybtn" onclick="submitLineListing()">Save Data</button>' +
                    '</div>';
                html += '<div class="row mt-2"><div class="col-md-12 col-sm-12">' +
                    '<p class="text-danger danger">Note: Please check data carefully before uploading it.</p>' +
                    '</div></div>';

                // Insert into the card
                $('.card_html').html(html);
                $('.my_card').removeClass('hide');
                mydate();


            }
        }

        // The rest of the JS functions (mydate, submitLineListing) are identical to the previous functional block
        // and rely on the IDs and classes set by the modified searchData() function above.
        // (Pasting them here for completeness)

        // mydate() is defined above the ready function.

        function submitLineListing() {
            var flag = 0;
            var data = {};

            // --- 1. Top Section Data and Validation ---
            data['total_structure_identified'] = $('#total_structure_identified').val();
            data['total_household_identified'] = $('#total_household_identified').val();
            data['total_residential_structures'] = $('#total_residential_structures').val();
            data['linelisting_date'] = $('#linelisting_date').val();

            data['village'] = $('#village').val();
            data['hf'] = $('#hf').val();

            // Area/Village
            if (data['village'] == '' || data['village'] == undefined || data['village'] == '0') {
                $('#village').addClass('error');
                flag = 1;
                toastMsg('Area/Village', 'Invalid Area/Village', 'error');
                return false;
            } else {
                $('#village').removeClass('error');
            }

            // Health Facility
            if (data['hf'] == '' || data['hf'] == undefined || data['hf'] == '0') {
                $('#hf').addClass('error');
                flag = 1;
                toastMsg('Health Facility', 'Invalid Health Facility', 'error');
                return false;
            } else {
                $('#hf').removeClass('error');
            }

            // --- 2. Vaccinator Detail Validation ---
            data['vaccinator_frequency'] = $('#vaccinator_frequency').val();
            data['name_of_vaccinator'] = $('#name_of_vaccinator').val();
            data['vaccinator_visit_date'] = $('#vaccinator_visit_date').val();

            // If frequency is 'No one has information about this' (6), skip name/date validation
            if (data['vaccinator_frequency'] == "6") {
                $('#name_of_vaccinator').removeAttr('required').val('').removeClass('error');
                $('#vaccinator_visit_date').removeAttr('required').val('').removeClass('error');
            } else {
                $('#name_of_vaccinator').attr('required', true);
                $('#vaccinator_visit_date').attr('required', true);

                if ($('#name_of_vaccinator').val().trim() == '') {
                    $('#name_of_vaccinator').addClass('error');
                    flag = 1;
                    toastMsg('Vaccinator Name', 'Invalid Vaccinator Name', 'error');
                    return false;
                } else {
                    $('#name_of_vaccinator').removeClass('error');
                }

                let visitDate = $('#vaccinator_visit_date').val();
                let today = new Date().toISOString().split("T")[0];

                if (visitDate == '') {
                    $('#vaccinator_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('Vaccinator Visit Date', 'Invalid Visit Date', 'error');
                    return false;
                }

                if (visitDate >= today) {
                    $('#vaccinator_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('Vaccinator Visit Date', 'Visit date must be less than today', 'error');
                    return false;
                } else {
                    $('#vaccinator_visit_date').removeClass('error');
                }
            }

            // --- 3. Polio Worker Detail Validation ---
            data['polio_frequency'] = $('#polio_frequency').val();
            data['name_of_polio'] = $('#name_of_polio').val();
            data['polio_visit_date'] = $('#polio_visit_date').val();

            if (data['polio_frequency'] == "6") {
                $('#name_of_polio').removeAttr('required').val('').removeClass('error');
                $('#polio_visit_date').removeAttr('required').val('').removeClass('error');
            } else {
                $('#name_of_polio').attr('required', true);
                $('#polio_visit_date').attr('required', true);

                if ($('#name_of_polio').val().trim() == '') {
                    $('#name_of_polio').addClass('error');
                    flag = 1;
                    toastMsg('Polio Name', 'Invalid Polio Name', 'error');
                    return false;
                } else {
                    $('#name_of_polio').removeClass('error');
                }

                let visitDate = $('#polio_visit_date').val();
                let today = new Date().toISOString().split("T")[0];

                if (visitDate == '') {
                    $('#polio_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('Polio Visit Date', 'Invalid Visit Date', 'error');
                    return false;
                }

                if (visitDate >= today) {
                    $('#polio_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('Polio Visit Date', 'Visit date must be less than today', 'error');
                    return false;
                } else {
                    $('#polio_visit_date').removeClass('error');
                }
            }

            // --- 4. LHW Detail Validation ---
            data['lhw_frequency'] = $('#lhw_frequency').val();
            data['name_of_lhw'] = $('#name_of_lhw').val();
            data['lhw_visit_date'] = $('#lhw_visit_date').val();


            if (data['lhw_frequency'] == "6") {
                $('#name_of_lhw').removeAttr('required').val('').removeClass('error');
                $('#lhw_visit_date').removeAttr('required').val('').removeClass('error');
            } else {
                $('#name_of_lhw').attr('required', true);
                $('#lhw_visit_date').attr('required', true);

                if ($('#name_of_lhw').val().trim() == '') {
                    $('#name_of_lhw').addClass('error');
                    flag = 1;
                    toastMsg('LHW Name', 'Invalid LHW Name', 'error');
                    return false;
                } else {
                    $('#name_of_lhw').removeClass('error');
                }

                let visitDate = $('#lhw_visit_date').val();
                let today = new Date().toISOString().split("T")[0];

                if (visitDate == '') {
                    $('#lhw_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('LHW Visit Date', 'Invalid Visit Date', 'error');
                    return false;
                }

                if (visitDate >= today) {
                    $('#lhw_visit_date').addClass('error');
                    flag = 1;
                    toastMsg('LHW Visit Date', 'Visit date must be less than today', 'error');
                    return false;
                } else {
                    $('#lhw_visit_date').removeClass('error');
                }
            }

            // District/Cluster Check (redundant but kept for completeness of old logic)
            data['district_select'] = $('#district_select').val();
            if (data['district_select'] == '' || data['district_select'] == undefined || data['district_select'] == '0') {
                $('#district_select').addClass('error');
                flag = 1;
                toastMsg('District', 'Invalid District', 'error');
                return false;
            } else {
                $('#district_select').removeClass('error');
            }

            data['cluster_select'] = $('#clusters_select').val();
            if (data['cluster_select'] == '' || data['cluster_select'] == undefined || data['cluster_select'] == '0') {
                $('#clusters_select').addClass('error');
                flag = 1;
                toastMsg('Cluster', 'Invalid Cluster', 'error');
                return false;
            } else {
                $('#clusters_select').removeClass('error');
            }

            // --- 5. Linelisting Summary Fields Validation ---

            const structureIdObj = $('#total_structure_identified');
            if (data['total_structure_identified'] == '' || data['total_structure_identified'] == undefined || data['total_structure_identified'] == 0) {
                flag = 1;
                structureIdObj.addClass('error');
                toastMsg('Structure Identified', 'Invalid Total Structure', 'error');
            } else {
                structureIdObj.removeClass('error');
            }

            const hhIdObj = $('#total_household_identified');
            if (data['total_household_identified'] == '' || data['total_household_identified'] == undefined || data['total_household_identified'] == 0) {
                flag = 1;
                hhIdObj.addClass('error');
                toastMsg('Household Identified', 'Invalid Household Identified', 'error');
            } else {
                hhIdObj.removeClass('error');
            }

            const resStructObj = $('#total_residential_structures');
            if (data['total_residential_structures'] == '' || data['total_residential_structures'] == undefined || data['total_residential_structures'] == 0) {
                flag = 1;
                resStructObj.addClass('error');
                toastMsg('Residential Structure', 'Invalid Residential Structure', 'error');
            } else {
                resStructObj.removeClass('error');
            }

            const dateObj = $('#linelisting_date');
            if (data['linelisting_date'] == '' || data['linelisting_date'] == undefined) {
                flag = 1;
                dateObj.addClass('error');
                toastMsg('Linelisting Data', 'Invalid Linelisting Data', 'error');
            } else {
                dateObj.removeClass('error');
            }

            // Exit early if basic summary fields are missing to prevent complex validation issues
            if (flag != 0) return false;

            // Complex Validation Checks
            if (parseInt(data['total_structure_identified']) < 150 || parseInt(data['total_structure_identified']) > 500) {
                toastMsg("Total Structure", "Total Structure Identified must be between 150 and 500", 'error');
                structureIdObj.addClass('error');
                flag = 1;
            } else {
                structureIdObj.removeClass('error');
            }

            if (parseInt(data['total_residential_structures']) < 120 || parseInt(data['total_residential_structures']) > 500) {
                toastMsg("Total Residential Structures", "Total Residential Structures must be between 120 and 500", 'error');
                resStructObj.addClass('error');
                flag = 1;
            } else {
                resStructObj.removeClass('error');
            }

            if (parseInt(data['total_household_identified']) > parseInt(data['total_residential_structures'])) {
                toastMsg("Total Eligible Household Identified ", "cannot be greater than Residential Structures", 'error');
                hhIdObj.addClass('error');
                flag = 1;
            } else {
                hhIdObj.removeClass('error');
            }

            // Exit early if complex validation failed
            if (flag != 0) return false;

            // --- 6. Linelisting Loop Validation (Table Data) ---
            let prevValue = 0;
            let combinedList = [];
            data["option"] = [];

            for (var i = 1; i <= data['total_household_identified']; i++) {
                var m = {};

                // Structure Number Validation
                var structure_number_obj = $('#structure_number_' + i);
                var structure_number = parseInt(structure_number_obj.val());
                structure_number_obj.removeClass('error');

                if (!isNaN(structure_number) && structure_number > 0) {
                    if (structure_number < prevValue) {
                        flag = 1;
                        structure_number_obj.addClass('error');
                        toastMsg('Structure Number', 'Structure number cannot be less than previous value (Row ' + i + ')', 'error');
                        return false;
                    }
                    prevValue = structure_number;
                    m['structure_number'] = structure_number;
                } else if (structure_number > parseInt(data['total_structure_identified'])) {
                    structure_number_obj.addClass('error');
                    toastMsg('Structure Number', 'Structure can not be greater then identified structure (Row ' + i + ')', 'error');
                    flag = 1;
                    return false;
                } else {
                    flag = 1;
                    structure_number_obj.addClass('error');
                    toastMsg('Structure Number', 'Invalid Structure Number (Row ' + i + ')', 'error');
                    return false;
                }

                // Household Number Validation
                var household_no_obj = $('#household_no_' + i);
                var household_no = household_no_obj.val();
                household_no_obj.removeClass('error');

                if (household_no != '' && household_no != undefined && household_no != 0) {
                    m['household_no'] = household_no;
                } else {
                    flag = 1;
                    household_no_obj.addClass('error');
                    toastMsg('Household Number', 'Invalid Household Number (Row ' + i + ')', 'error');
                    return false;
                }


                // Combination Check
                var combo = structure_number + "-" + household_no;
                if (combinedList.includes(combo)) {
                    flag = 1;
                    structure_number_obj.addClass('error');
                    household_no_obj.addClass('error');
                    toastMsg('Duplicate Entry', 'Combination ' + combo + ' already exists (Row ' + i + ')', 'error');
                    return false;
                }
                combinedList.push(combo);
                m['combo'] = combo;

                // Household Name Validation (Alpha only)
                var household_name_obj = $('#household_name_' + i);
                var household_name = household_name_obj.val();
                var nameRegex = /^[A-Za-z ]+$/;
                household_name_obj.removeClass('error');

                if (
                    household_name !== '' &&
                    household_name !== undefined &&
                    household_name !== 0 &&
                    nameRegex.test(household_name)
                ) {
                    m['household_name'] = household_name;
                } else {
                    flag = 1;
                    household_name_obj.addClass('error');
                    toastMsg('Household Name', 'Only alphabets allowed. No numbers or symbols. (Row ' + i + ')', 'error');
                    return false;
                }

                // Child Age Validation (12-23 months children count)
                var childAge_obj = $('#childAge_' + i);
                var childAge = childAge_obj.val();
                childAge_obj.removeClass('error');

                if (childAge != '' && childAge != undefined && childAge != 0) {
                    m['childAge'] = childAge;
                } else {
                    flag = 1;
                    childAge_obj.addClass('error');
                    toastMsg('Child Age', 'Invalid Count of 12-23 months children (Row ' + i + ')', 'error');
                    return false;
                }

                data["option"].push(m);
            }

            // --- 7. Final Submission ---
            if (flag == 0) {
                showloader();
                $('.mybtn').addClass('hide').attr('disabled', 'disabled');
                // NOTE: PHP base_url() needs to be handled by your environment
                CallAjax('<?php echo base_url('index.php/Manual_linelisting/insertData'); ?>', data, 'POST', function (result) {
                    hideloader();
                    $('.mybtn').removeClass('hide').removeAttr('disabled', 'disabled');

                    // Server Response Handling
                    if (result == 1) {
                        toastMsg('Success', 'Successfully inserted', 'success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    } else if (result == 2) {
                        toastMsg('Cluster', 'Invalid Cluster', 'error');
                    } else if (result == 3) {
                        toastMsg('Error', 'Invalid Total Structure Identified', 'error');
                    } else if (result == 4) {
                        toastMsg('Error', 'Invalid Total Household having 12-23 Months Children', 'error');
                    } else if (result == 5) {
                        toastMsg('Error', 'Invalid Household Targeted Children', 'error');
                    } else if (result == 6) {
                        toastMsg('Error', 'Invalid Linelisting Date', 'error');
                    } else if (result == 7) {
                        toastMsg('Cluster', 'Cluster not found', 'error');
                    } else if (result == 8) {
                        toastMsg('Error', 'Error in inserting', 'error');
                    } else if (result == 10) {
                        toastMsg('Error', 'Error in Summary', 'error');
                    } else if (result == 12) {
                        toastMsg('Error', 'Invalid Linelisting Date', 'error');
                    } else if (result == 13) {
                        toastMsg('Error', 'Invalid Residential Structure', 'error');
                    } else if (result == 99) {
                        toastMsg('Error', 'Duplicate', 'error');
                    } else {
                        toastMsg('Error', 'Something went wrong', 'error');
                    }
                });
            } else {
                toastMsg('Error', 'Invalid Data', 'error');
            }
        }

    </script>