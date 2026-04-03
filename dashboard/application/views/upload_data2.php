<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Upload Data</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Upload</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="basic-select2" id="dropzone-examples">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <!-- <form method="post" id="upload_form" enctype="multipart/form-data">
                                         <div class="col-md-6" align="right">Select File</div>
                                         <div class="col-md-6">
                                             <input type="file" name="file" id="csv_file" />
                                         </div>
                                         <br /><br /><br />
                                         <div class="col-md-12" align="center">
                                             <input type="submit" name="upload_file" id="upload_file" class="btn btn-primary" value="Upload" />
                                         </div>
                                     </form>-->
                                    <form id="document_form" method="post"
                                          onsubmit="return false" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <h4 class="card-title">Table</h4>
                                                <div class="form-group">
                                                    <select class="select2 form-control idTable" id="idTable"
                                                            name="idTable" required onchange="requiredField()">
                                                        <option value="0" readonly disabled selected>Table Type
                                                        </option>
                                                        <option value="bl_randomised">bl_randomised</option>
                                                        <option value="devices">devices</option>
                                                        <option value="users">users</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <h4 class="card-title">Upload File</h4>
                                                <div class="form-group">
                                                    <!--                                                        <input type="file" class="form-control" -->
                                                    <!--                                                               id="document_file" name="document_file" required>-->
                                                    <input type="file" class="form-control"
                                                           name="file" id="csv_file" required>
                                                </div>
                                            </div>
                                        </div>


                                        <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>

                                            <!--   <div class="col-md-12" >
                                                   <input type="submit" name="upload_file" id="upload_file"
                                                          class="btn btn-primary" value="Upload"/>
                                               </div>-->

                                            <button type="submit" class="btn btn-primary mybtn" name="upload_file"
                                                    id="upload_file">
                                                Submit
                                            </button>
                                        <?php } ?>

                                        <div class="row danger requiredFieldDiv hide mt-1">
                                            <div class="col-12 col-sm-12">
                                                <h6 class="danger">Required Fields</h6>
                                                <ul>
                                                </ul>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="row m-1">
                                        <div class="col-sm-12">
                                            <h4 class="res_heading" style="color: green;"></h4>
                                            <p class="res_msg" style="color: green;"></p>
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="process_area">

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
        /*$('#document_file').change(function () {
            $('#document_label').text(this.files[0].name);
        });*/

    });
    var total_selection = 0;
    var column_data = [];
    $(document).ready(function () {
        $('#document_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url('index.php/Upload_data/upload') ?>",
                method: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('.res_heading').html('');
                    $('.res_msg').html('');

                    if (data.error != '') {
                        $('.res_heading').html('Error').css('color', 'red');
                        $('.res_msg').html(data.error).css('color', 'red');
                    } else {
                        $('#process_area').html(data.output);
                        setTimeout(function () {
                            $('.set_column_data').each(function (i, v) {
                                var cn = $(v).data('column_number');
                                var cv = $(v).val();
                                column_data[cn] = cn;
                            })
                        }, 500);
                    }
                }
            });
        });

        /*$(document).on('change', '.set_column_data', function () {
            var column_name = $(this).val();
            var column_number = $(this).data('column_number');
            if (column_name in column_data) {
                toastMsg('Error', 'You have already define ' + column_name + ' column', 'error');
                alert('You have already define ' + column_name + ' column');
                $(this).val('');
                return false;
            }

            if (column_name != '') {
                column_data[column_name] = column_number;
            } else {
                const entries = Object.entries(column_data);
                for (const [key, value] of entries) {
                    if (value == column_number) {
                        delete column_data[key];
                    }
                }
            }

            total_selection = Object.keys(column_data).length;
            if (total_selection < 1) {
                $('#import').attr('disabled', false);
            } else {
                $('#import').attr('disabled', 'disabled');
            }
        });*/

        /*$(document).on('click', '#import', function (event) {
            event.preventDefault();
            $.ajax({
                url: "< ?php echo base_url('index.php/Upload_data/importData') ?>",
                method: "POST",
                data: {first_name: first_name, last_name: last_name, email: email},
                beforeSend: function () {
                    $('#import').attr('disabled', 'disabled');
                    $('#import').text('Importing...');
                },
                success: function (data) {
                    $('#import').attr('disabled', false);
                    $('#import').text('Import');
                    $('#process_area').css('display', 'none');
                    $('#upload_area').css('display', 'block');
                    $('#upload_form')[0].reset();
                    $('#message').html("<div class='alert alert-success'>" + data + "</div>");
                }
            })
        });*/

    });

    function submitData() {

        $('#idTable').css('border', '1px solid #babfc7');
        $('#document_file').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};

        var head = [];
        var thead = $('.myTable').find('thead').find('select');
        $.each(thead, function (i, v) {
            var mykeysVal = $(v).val();
            if (mykeysVal != '' && mykeysVal != undefined) {
                head.push(mykeysVal);
            } else {
                $(v).css('border', '1px solid red');
                toastMsg('Table', 'Invalid Table', 'error');
                flag = 1;
                return false;
            }

        });

        var body_keys = [];
        var body = $('.myTable').find('tbody').find('tr');
        $.each(body, function (m, n) {
            var body_val = [];
            $.each($(n).find('td'), function (p, q) {
                var myBodyVal = $(q).text();
                body_val.push(myBodyVal);
            });
            body_keys.push(body_val);
        });
        data['head'] = head;
        data['body'] = body_keys;
        data['idTable'] = $('#idTable').val();

        if (data['idTable'] == '' || data['idTable'] == undefined) {
            $('#idTable').css('border', '1px solid red');
            toastMsg('Table', 'Invalid Table', 'error');
            flag = 1;
            return false;
        }

        if (flag == 0) {
            $('.res_heading').html('');
            $('.res_msg').html('');
            $('.myImpBtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Upload_data/addExcelData')?>', data, 'POST', function (result) {
                $('.myImpBtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    if (response[0] == 'Success') {
                        toastMsg(response[0], response[1].message, 'success');
                        $('.res_heading').html(response[0]).css('color', 'green');
                        $('.res_msg').html(response[1]).css('color', 'green');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500)
                    } else {
                        toastMsg(response[0], response[1].message, 'error');
                        $('.res_heading').html(response[0]).css('color', 'red');
                        $('.res_msg').html(response[1].message).css('color', 'red');
                    }
                } catch (e) {
                }
            });

        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }


    }

    function chkCol(obj) {
        var column_name = $(obj).val();
        var column_number = $(obj).data('column_number');
        if (column_name in column_data) {
            toastMsg('Error', 'You have already define ' + column_name + ' column', 'error');
            $(obj).val('');
            return false;
        }
        if (column_name != '') {
            column_data[column_name] = column_number;
        } else {
            const entries = Object.entries(column_data);
            for (const [key, value] of entries) {
                if (value == column_number) {
                    delete column_data[key];
                }
            }
        }

        total_selection = Object.keys(column_data).length;
        if (total_selection < 1) {
            $('#import').attr('disabled', false);
        } else {
            $('#import').attr('disabled', 'disabled');
        }
    }

    function requiredField() {
        $('.requiredFieldDiv').addClass('hide').find('ul').html('');
        var idTable = $('#idTable').val();
        var html = '';
        if (idTable == 'bl_randomised') {
            html += '<li>uid</li>';
            html += '<li>srno</li>';
            html += '<li>uc_code</li>';
            html += '<li>hh02</li>';
            html += '<li>hl09</li>';
            html += '<li>hl10</li>';
            html += '<li>hl11</li>';
            html += '<li>hl12</li>';
            html += '<li>randDT</li>';
            html += '<li>village_code</li>';
            html += '<li>village_name</li>';
        } else if (idTable == 'devices') {
            html += '<li>imei</li>';
            html += '<li>tag</li>';
            html += '<li>appname</li>';
            html += '<li>appversion</li>';
        } else if (idTable == 'users') {
            html += '<li>username</li>';
            html += '<li>password</li>';
            html += '<li>full_name</li>';
        } else {
            html = '';
        }
        $('.requiredFieldDiv').removeClass('hide').find('ul').html(html);
    }

    function addData() {
        $('#idTable').css('border', '1px solid #babfc7');
        $('#document_file').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idTable'] = $('#idTable').val();
        data['document_file'] = $('#document_file').val();
        if (data['idTable'] == '' || data['idTable'] == undefined) {
            $('#idTable').css('border', '1px solid red');
            toastMsg('Table', 'Invalid Table', 'error');
            flag = 1;
            return false;
        }

        if (data['document_file'] == '' || data['document_file'] == undefined) {
            $('#document_file').css('border', '1px solid red');
            toastMsg('File', 'Invalid File', 'error');
            flag = 1;
            return false;
        }

        if (flag == 0) {
            $('.res_heading').html('');
            $('.res_msg').html('');
            $('.mybtn').attr('disabled', 'disabled');
            var formData = new FormData($("#document_form")[0]);
            CallAjax('<?php echo base_url('index.php/Upload_data/addExcelData')?>', formData, 'POST', function (result) {
                $('.mybtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    if (response[0] == 'Success') {
                        toastMsg(response[0], response[1].message, 'success');
                        $('.res_heading').html(response[0]).css('color', 'green');
                        $('.res_msg').html(response[1]).css('color', 'green');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500)
                    } else {
                        toastMsg(response[0], response[1].message, 'error');
                        $('.res_heading').html(response[0]).css('color', 'red');
                        $('.res_msg').html(response[1].message).css('color', 'red');
                    }
                } catch (e) {
                }
            }, true);
        }
    }


</script>