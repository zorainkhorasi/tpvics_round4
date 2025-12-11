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
                        <h2 class="content-header-title float-left mb-0">Manual Linelisting</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Manual Linelisting</li>
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
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select" autocomplete="uc"
                                                        id="district_select" onchange="changeDistricts()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($pa_list) && $pa_list != '') {
                                                        foreach ($pa_list as $k => $p) {
                                                            echo '<option value="' . $p->my_id . '" ' . (isset($slug_p) && $slug_p == $p->my_id ? "selected" : "") . '>' . $p->my_name . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Cluster
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control clusters_select"
                                                        onchange="displayClusterBtn()" autocomplete="clus"
                                                        id="clusters_select">
                                                    <option value="0" readonly disabled selected>Cluster</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chkCluster_div">
                                        <p class="geoarea_name"></p>
                                        <button type="button" class="btn btn-info chkCluster_btn"
                                                onclick="chkCluster()">
                                            Check Cluster
                                        </button>
                                    </div>
                                    <div class="row nextDiv hide">

                                        <div class="col-sm-12 col-12">

                                            <div class="row">
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Area/ Village
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control village"
                                                               id="village" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Name Health Facility
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control hf"
                                                               id="hf" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Vaccinator Visit Frequency
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="vaccinator_frequency">
                                                            <option>Select</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2">Quaterly</option>
                                                            <option value="3">Twice a year</option>
                                                            <option value="4">Once a year</option>
                                                            <option value="5">Only during campaigns</option>
                                                            <option value="6">No one has information about this</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Name of Vaccinator
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control name_of_vaccinator"
                                                               id="name_of_vaccinator" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Vaccinator Last Visit Date
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control vaccinator_visit_date"
                                                               id="vaccinator_visit_date" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        LHW Visit Frequency
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="lhw_frequency">
                                                            <option>Select</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2">Quaterly</option>
                                                            <option value="3">Twice a year</option>
                                                            <option value="4">Once a year</option>
                                                            <option value="5">Only during campaigns</option>
                                                            <option value="6">No one has information about this</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        LHW Name Deputed For this Area
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control name_of_lhw"
                                                               id="name_of_lhw" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        LHW Last Visit Date
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control lhw_visit_date"
                                                               id="lhw_visit_date" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Polio Worker Visit Frequency
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="polio_frequency">
                                                            <option>Select</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2">Quaterly</option>
                                                            <option value="3">Twice a year</option>
                                                            <option value="4">Once a year</option>
                                                            <option value="5">Only during campaigns</option>
                                                            <option value="6">No one has information about this</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Polio Health Worker Name
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control name_of_polio"
                                                               id="name_of_polio" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 col-4">
                                                    <div class="text-bold-600 font-medium-2">
                                                        Polio Worker Last Visit Date
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control polio_visit_date"
                                                               id="polio_visit_date" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Number of Households (having 12-23 Months Children):
                                            </div>
                                            <div class="form-group">
                                                <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/"
                                                       onKeyPress="if(this.value.length==3) return false;"
                                                       class="form-control number_hh" id="number_hh"
                                                       minlength="1" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nextDiv hide ">
                                        <button type="button" class="btn btn-primary" onclick="searchData()">Set
                                            Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="analytics-card" class="my_card hide">
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
<!-- END: Content-->
<input type="hidden" id="hidden_slug_dist"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<input type="hidden" id="hidden_slug_uc" value="<?php echo(isset($slug_uc) && $slug_uc != '' ? $slug_uc : ''); ?>">
<input type="hidden" id="hidden_slug_cluster"
       value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : ''); ?>">

<script>
    $(document).ready(function () {
        //changeDist();
        mydate();
    });


    //changePro();
    function changeDistricts() {
        var data = {};
        data['district_select'] = $('.district_select').val();

        if (data['district_select'] !== '' && data['district_select'] !== undefined && data['district_select'] !== '0') {

            showloader();

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
    }

    function chkCluster() {
        $('.my_card').addClass('hide');
        $('.card_html').html('');
        var flag = 0;

        var district_select = $('#district_select').val();
        if (district_select == '' || district_select == undefined || district_select == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        /*var uc_select = $('#uc_select').val();
        if (uc_select == '' || uc_select == undefined || uc_select == '0') {
            $('#uc_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('UC', 'Invalid UC', 'error');
            return false;
        }*/

        var cluster_select = $('#clusters_select').val();
        if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }
        if (flag == 0) {
            var data = {};
            data['cluster'] = cluster_select;
            CallAjax('<?php echo base_url() . 'index.php/Manual_linelisting/checkClusterExists' ?>',
                data, 'POST', function (res) {

                    var response = JSON.parse(res);
                    var items = 'Invalid Cluster';
                    if (response.exists == 0) {
                        toastMsg('Cluster', 'Invalid Cluster Number', 'error');
                        if (!response.cluster_data || response.cluster_data.length === 0) {
                            toastMsg('Cluster', 'Cluster data not found', 'error');
                            $('.geoarea_name').html(items);
                            return false;
                        }
                        var c = response.cluster_data[0];
                        if (c.geoarea !== undefined && c.geoarea !== '') {
                            items = 'Cluster: ' + cluster_select + ' (Area: ' + c.geoarea + ')';
                        }
                        $('.geoarea_name').html(items);

                        $('.chkCluster_btn').addClass('hide');
                        $('.nextDiv').removeClass('hide');

                        mydate();
                    }else{
                        toastMsg('Cluster', 'Cluster data already Exist', 'error');
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
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        /*var uc_select = $('#uc_select').val();
        if (uc_select == '' || uc_select == undefined || uc_select == '0') {
            $('#uc_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('UC', 'Invalid UC', 'error');
            return false;
        }*/

        var cluster_select = $('#clusters_select').val();
        if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }

        var number_hh = $('#number_hh').val();
        if (number_hh == '' || number_hh == undefined || number_hh == '0') {
            $('#number_hh').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household Number', 'Invalid Household Number', 'error');
            return false;
        }

        if (number_hh < 20) {
            $('#number_hh').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household Number', 'Eligible Household must be greater than 19', 'error');
            return false;
        }


        if (flag == 0) {

            var data = {};
            data['cluster_no'] = cluster_select;


            var html = '';
            html += '<div class="row">';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_structure_identified" class="label-control text-primary">Total Structure Identified</label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control  total_structure_identified" ' +
                'id="total_structure_identified" name="total_structure_identified"  autocomplete="structure_hh" required>' +
                '        </div>' +
                '    </div> ';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_household_identified" class="label-control text-primary">Total Household having 12-23 Months Children </label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1" class="form-control  total_household_identified"  autocomplete="total_hh" value="' + number_hh + '"  ' +
                'id="total_household_identified" name="total_household_identified" required  readonly disabled>' +
                '        </div>' +
                '    </div> ';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_residential_structures" class="label-control text-primary">Total Residential Structures</label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1" class="form-control  total_residential_structures"  autocomplete="total_hs"  ' +
                'id="total_residential_structures" name="total_residential_structures" required>' +
                '        </div>' +
                '    </div> ';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="linelisting_date" class="label-control text-primary">Date of Linelisting </label>' +
                '            <input type="text" class="form-control mypickadat linelisting_date"  value="<?php echo date("d/m/Y")?>" ' +
                'id="linelisting_date" name="linelisting_date" required>' +
                '        </div>' +
                '    </div> ';
            html += '</div>';

            for (var i = 1; i <= number_hh; i++) {
                html += '<div class="row">';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="structure_number" class="label-control text-primary">Structure Number</label>' +
                    '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control structure_number_' + i + '"  autocomplete="structure_number" id="structure_number_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="household_no" class="label-control text-primary">S.No of Household</label>' +
                    '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control household_no_' + i + '"   autocomplete="household_no" id="household_no_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="household_name_' + i + '" class="label-control text-primary">Name of Household</label>' +
                    '            <input type="text" class="form-control household_name_' + i + '" id="household_name_' + i + '"  autocomplete="name_hh" required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '              <label for="childAge_' + i + '" class="label-control text-primary">Total 12-23 months children</label>' +
                    '              <input type="number" maxlength="1" max="1" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" minlength="1" min="1" class="form-control childAge_' + i + '"  autocomplete="childAge" id="childAge_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';
                html += '</div>';

            }

            html += '<div class=" ">' +
                '<button type="button" class="btn btn-info" onclick="submitLineListing()">' +
                'Save Data</button>' +
                '</div>';
            html += '<div class="row"><div class="col-md-12 col-sm-12">' +
                '<p class="danger">Note: Please check data carefully before uploading it.</p>' +
                '</div></div>';

            $('.card_html').html(html);
            $('.my_card').removeClass('hide');
            mydate();


        }
    }

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2019, 12, 1),
            max: true,
            format: 'dd-mm-yyyy'
        });
    }

    function submitLineListing() {
        var flag = 0;
        var data = {};
        data['total_structure_identified'] = $('#total_structure_identified').val();
        data['total_household_identified'] = $('#total_household_identified').val();
        data['total_residential_structures'] = $('#total_residential_structures').val();
        data['linelisting_date'] = $('#linelisting_date').val();

        data['village'] = $('#village').val();
        data['hf'] = $('#hf').val();

        if (data['village'] == '' || data['village'] == undefined || data['village'] == '0') {
            $('#village').css('border', '1px solid red');
            flag = 1;
            toastMsg('Area/Village', 'Invalid Area/Village', 'error');
            return false;
        }

        if (data['hf'] == '' || data['hf'] == undefined || data['hf'] == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Health Facility', 'Invalid Health Facility', 'error');
            return false;
        }


        data['vaccinator_frequency'] = $('#vaccinator_frequency').val();
        data['name_of_vaccinator'] = $('#name_of_vaccinator').val();
        data['vaccinator_visit_date'] = $('#vaccinator_visit_date').val();

        if (data['vaccinator_frequency'] == "6") {

            $('#name_of_vaccinator').removeAttr('required').val('').css('border', '');
            $('#vaccinator_visit_date').removeAttr('required').val('').css('border', '');
            $('#name_of_vaccinator').removeClass('error');
            $('#vaccinator_visit_date').removeClass('error');

        } else {
            $('#name_of_vaccinator').attr('required', true);
            $('#vaccinator_visit_date').attr('required', true);

            if ($('#name_of_vaccinator').val().trim() == '') {
                $('#name_of_vaccinator').css('border', '1px solid red');
                flag = 1;
                toastMsg('Vaccinator Name', 'Invalid Vaccinator Name', 'error');
                return false;
            } else {
                $('#name_of_vaccinator').css('border', '');
            }


            // ----------- DATE VALIDATION -----------
            let visitDate = $('#vaccinator_visit_date').val();
            let today = new Date().toISOString().split("T")[0]; // yyyy-mm-dd

            if (visitDate == '') {
                $('#vaccinator_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('Vaccinator Visit Date', 'Invalid Visit Date', 'error');
                return false;
            }

            if (visitDate >= today) {
                $('#vaccinator_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('Vaccinator Visit Date', 'Visit date must be less than today', 'error');
                return false;
            } else {
                $('#vaccinator_visit_date').css('border', '');
            }
        }

        data['polio_frequency'] = $('#polio_frequency').val();
        data['name_of_polio'] = $('#name_of_polio').val();
        data['polio_visit_date'] = $('#polio_visit_date').val();


        if (data['polio_frequency'] == "6") {

            $('#name_of_polio').removeAttr('required').val('').css('border', '');
            $('#polio_visit_date').removeAttr('required').val('').css('border', '');
            $('#name_of_polio').removeClass('error');
            $('#polio_visit_date').removeClass('error');

        } else {
            $('#name_of_polio').attr('required', true);
            $('#polio_visit_date').attr('required', true);

            if ($('#name_of_polio').val().trim() == '') {
                $('#name_of_polio').css('border', '1px solid red');
                flag = 1;
                toastMsg('Polio Name', 'Invalid Polio Name', 'error');
                return false;
            } else {
                $('#name_of_polio').css('border', '');
            }


            // ----------- DATE VALIDATION -----------
            let visitDate = $('#polio_visit_date').val();
            let today = new Date().toISOString().split("T")[0]; // yyyy-mm-dd

            if (visitDate == '') {
                $('#polio_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('Polio Visit Date', 'Invalid Visit Date', 'error');
                return false;
            }

            if (visitDate >= today) {
                $('#polio_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('Polio Visit Date', 'Visit date must be less than today', 'error');
                return false;
            } else {
                $('#polio_visit_date').css('border', '');
            }


        }

        data['district_select'] = $('#district_select').val();
        if (data['district_select'] == '' || data['district_select'] == undefined || data['district_select'] == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        data['lhw_frequency'] = $('#lhw_frequency').val();
        data['name_of_lhw'] = $('#name_of_lhw').val();
        data['lhw_visit_date'] = $('#lhw_visit_date').val();


        if (data['lhw_frequency'] == "6") {

            $('#name_of_lhw').removeAttr('required').val('').css('border', '');
            $('#lhw_visit_date').removeAttr('required').val('').css('border', '');
            $('#name_of_lhw').removeClass('error');
            $('#lhw_visit_date').removeClass('error');

        } else {
            $('#name_of_lhw').attr('required', true);
            $('#lhw_visit_date').attr('required', true);

            if ($('#name_of_lhw').val().trim() == '') {
                $('#name_of_lhw').css('border', '1px solid red');
                flag = 1;
                toastMsg('LHW Name', 'Invalid LHW Name', 'error');
                return false;
            } else {
                $('#name_of_lhw').css('border', '');
            }

            // ----------- DATE VALIDATION -----------
            let visitDate = $('#lhw_visit_date').val();
            let today = new Date().toISOString().split("T")[0]; // yyyy-mm-dd

            if (visitDate == '') {
                $('#lhw_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('LHW Visit Date', 'Invalid Visit Date', 'error');
                return false;
            }

            if (visitDate >= today) {
                $('#lhw_visit_date').css('border', '1px solid red');
                flag = 1;
                toastMsg('LHW Visit Date', 'Visit date must be less than today', 'error');
                return false;
            } else {
                $('#lhw_visit_date').css('border', '');
            }
        }

        data['district_select'] = $('#district_select').val();
        if (data['district_select'] == '' || data['district_select'] == undefined || data['district_select'] == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        data['cluster_select'] = $('#clusters_select').val();
        if (data['cluster_select'] == '' || data['cluster_select'] == undefined || data['cluster_select'] == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }


        if (data['total_structure_identified'] == '' || data['total_structure_identified'] == undefined || data['total_structure_identified'] == 0) {
            flag = 1;
            $('#total_structure_identified').addClass('error');
            toastMsg('Structure Identified', 'Invalid Total Structure', 'error');
            return false;
        } else {
            $('#total_structure_identified').removeClass('error');
        }

        if (data['total_household_identified'] == '' || data['total_household_identified'] == undefined || data['total_household_identified'] == 0) {
            flag = 1;
            $('#total_household_identified').addClass('error');
            toastMsg('Household Identified', 'Invalid Household Identified', 'error');
            return false;
        } else {
            $('#total_household_identified').removeClass('error');
        }

        if (data['total_residential_structures'] == '' || data['total_residential_structures'] == undefined || data['total_residential_structures'] == 0) {
            flag = 1;
            $('#total_residential_structures').addClass('error');
            toastMsg('Residential Structure', 'Invalid Residential Structure', 'error');
            return false;
        } else {
            $('#total_residential_structures').removeClass('error');
        }

        /* if (data['household_targeted_children'] == '' || data['household_targeted_children'] == undefined) {
             flag = 1;
             $('#household_targeted_children').addClass('error');
             toastMsg('Targeted Children', 'Invalid Targeted Children', 'error');
             return false;
         } else {
             $('#household_targeted_children').removeClass('error');
         }*/

        if (data['linelisting_date'] == '' || data['linelisting_date'] == undefined) {
            flag = 1;
            $('#linelisting_date').addClass('error');
            toastMsg('Linelisting Data', 'Invalid Linelisting Data', 'error');
            return false;
        } else {
            $('#linelisting_date').removeClass('error');
        }

        /*if (data['total_structure_identified'] < data['total_household_identified']) {
            flag = 1;
            $('#total_household_identified').addClass('error');
            toastMsg('Household Identified', 'Household Identified is greater than Total Identified', 'error');
            return false;
        } else {
            $('#total_household_identified').removeClass('error');
        }*/

        /*  if (data['total_household_identified'] < data['household_targeted_children']) {
              flag = 1;
              $('#household_targeted_children').addClass('error');
              toastMsg('Household Targeted Children', 'Household Targeted Children is greater than Household Identified', 'error');
              return false;
          } else {
              $('#household_targeted_children').removeClass('error');
          }*/

        // if (data['total_structure_identified'] < 5 || data['total_structure_identified'] > 20) {


        if (parseInt(data['total_structure_identified']) < 150 || parseInt(data['total_structure_identified']) > 500) {
            //msg += "Total Structure Identified must be between 150 and 500\n";
            toastMsg("Total Structure", "Total Structure Identified must be between 150 and 500", 'error');
            flag = 1;
        }

        // ---------------------- 2) Total Residential Structures Validations -----------------------

        if (parseInt(data['total_residential_structures']) < 120 || parseInt(data['total_residential_structures']) > 500) {
            //msg += "\n";
            toastMsg("Total Residential Structures", "Total Residential Structures must be between 120 and 500", 'error');
            flag = 1;
        }


        //alert(data['total_household_identified'])
        //alert(data['total_residential_structures'])

        if (parseInt(data['total_household_identified']) > parseInt(data['total_residential_structures'])) {
            toastMsg("Total Eligible Household Identified ", "cannot be greater than Residential Structures", 'error');
            flag = 1;
        }

        let prevValue = 0;
        let combinedList = [];
        data["option"] = [];
        for (var i = 1; i <= data['total_household_identified']; i++) {
            var m = {};

            var structure_number_obj = $('#structure_number_' + i);
            var structure_number = parseInt(structure_number_obj.val());

            if (!isNaN(structure_number) && structure_number > 0) {

                if (structure_number < prevValue) {
                    flag = 1;
                    structure_number_obj.addClass('error');
                    toastMsg('Structure Number', 'Structure number cannot be less than previous value', 'error');
                    return false;
                }
                prevValue = structure_number;

                m['structure_number'] = structure_number;
                structure_number_obj.removeClass('error');
            } else {
                flag = 1;
                structure_number_obj.addClass('error');
                toastMsg('Structure Number', 'Invalid Structure Number', 'error');
                return false;
            }

            var household_no_obj = $('#household_no_' + i);
            var household_no = household_no_obj.val();

            if (household_no != '' && household_no != undefined && household_no != 0) {
                m['household_no'] = household_no;
                household_no_obj.removeClass('error');
            } else {
                flag = 1;
                household_no_obj.addClass('error');
                toastMsg('Household Number', 'Invalid Household Number', 'error');
                return false;
            }


            var combo = structure_number + "-" + household_no;

            if (combinedList.includes(combo)) {
                flag = 1;
                structure_number_obj.addClass('error');
                household_no_obj.addClass('error');
                toastMsg('Duplicate Entry', 'Combination ' + combo + ' already exists', 'error');
                return false;
            }

            combinedList.push(combo);
            m['combo'] = combo;

            /*var household_name_obj = $('#household_name_' + i);
            var household_name = household_name_obj.val();
            if (household_name != '' && household_name != undefined && household_name != 0) {
                m['household_name'] = household_name;
                household_name_obj.removeClass('error');
            } else {
                flag = 1;
                household_name_obj.addClass('error');
                toastMsg('Household Name', 'Invalid Household Name', 'error');
                return false;
            }*/


            var household_name_obj = $('#household_name_' + i);
            var household_name = household_name_obj.val();
            var nameRegex = /^[A-Za-z ]+$/;

            if (
                household_name !== '' &&
                household_name !== undefined &&
                household_name !== 0 &&
                nameRegex.test(household_name)
            ) {
                m['household_name'] = household_name;
                household_name_obj.removeClass('error');
            } else {
                flag = 1;
                household_name_obj.addClass('error');
                toastMsg('Household Name', 'Only alphabets allowed. No numbers or symbols.', 'error');
                return false;
            }


            var childAge_obj = $('#childAge_' + i);
            var childAge = childAge_obj.val();
            if (childAge != '' && childAge != undefined && childAge != 0) {
                m['childAge'] = childAge;
                childAge_obj.removeClass('error');
            } else {
                flag = 1;
                childAge_obj.addClass('error');
                toastMsg('Child Age', 'Invalid Count of 12-23 months children', 'error');
                return false;
            }

            data["option"].push(m);
        }

        if (flag == 0) {
            showloader();
            $('.mybtn').addClass('hide').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Manual_linelisting/insertData'); ?>', data, 'POST', function (result) {
                hideloader();
                $('.mybtn').removeClass('hide').removeAttr('disabled', 'disabled');
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
                    toastMsg('Error', 'Invalid went wrong', 'error');
                }
            });
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }

</script>