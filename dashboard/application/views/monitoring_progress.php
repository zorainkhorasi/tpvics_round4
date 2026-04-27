<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Monitoring Progress Report </h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Monitoring Progress Report
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div class="row" style="padding: 20px;background: white;">

                    <!-- Partner -->
                    <div class="col-md-2">
                        <label>Partner *</label>
                        <select id="partner" class="form-control">
                            <option value="">Select Partner</option>
                            <?php foreach($partners as $p){ ?>
                                <option value="<?= $p['Partner'] ?>"><?= $p['Partner'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Province -->
                    <div class="col-md-2">
                        <label>Province</label>
                        <select id="province" class="form-control">
                            <option value="All">All</option>
                        </select>
                    </div>

                    <!-- District -->
                    <div class="col-md-2">
                        <label>District</label>
                        <select id="district" class="form-control">
                            <option value="All">All</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button onclick="loadData()" class="btn btn-primary mt-2">Search</button>
                    </div>



                </div>

                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Monitoring Report </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <?php foreach($columns as $col){ ?>
                                                    <th><?= $col ?></th>
                                                <?php } ?>
                                            </tr>
                                            </thead>
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


<!-- BEGIN: User Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

<script>

    $('#partner').change(function () {

        let partner = $(this).val();
        if (!partner) return;

        // 👉 Loader
        setLoading('#province');
        setLoading('#district');

        $.post('<?php echo base_url() . 'index.php/Monitoring_progress/getFilters'  ?>', { Partner: partner }, function (res) {

            let data = JSON.parse(res);

            fillDropdown('#province', data.province, 'Province');
            fillDropdown('#district', data.district, 'District');
        });
    });


    // 🔹 Province Change → update District + Observation
    $('#province').change(function () {

        let filters = {
            Partner: $('#partner').val(),
            Province: $('#province').val()
        };

        // 👉 Loader
        setLoading('#district');

        $.post('<?php echo base_url() . 'index.php/Monitoring_progress/getFilters'  ?>', filters, function (res) {

            let data = JSON.parse(res);

            fillDropdown('#district', data.district, 'District');
        });
    });


    // 🔹 District Change → update Observation
    $('#district').change(function () {

        let filters = {
            Partner: $('#partner').val(),
            Province: $('#province').val(),
            District: $('#district').val()
        };

        // 👉 Loader
        setLoading('#observation');

        $.post('<?php echo base_url() . 'index.php/Monitoring_progress/getFilters'  ?>', filters, function (res) {

            let data = JSON.parse(res);

            fillDropdown('#observation', data.observation, 'Observation');
        });
    });
    function setLoading(id) {
        $(id).html('<option value="">⏳ Loading...</option>');
    }


    // 🔹 Dropdown filler
    function fillDropdown(id, list, key) {
        let html = '<option value="All">All</option>';

        list.forEach(item => {
            html += `<option value="${item[key]}">${item[key]}</option>`;
        });

        $(id).html(html);
    }

    function loadData() {

        let partner = $('#partner').val();

        if (!partner) {
            alert('Partner is mandatory');
            return;
        }

        let filters = {
            Partner: partner,
            Province: $('#province').val(),
            District: $('#district').val()
        };

        $('#dataTable').DataTable({
            destroy: true,
            processing: true,
            language: {
                processing: "⏳ Loading data..."
            },
                dom: 'Blfrtip',
           // pageLength: 100, // default

            lengthMenu: [
                [50, 100, 400, 600, 1000,2000,3000, 5000],
                [50, 100, 400, 600, 1000,2000,3000, 5000],
            ],

            ajax: {
                url: '<?php echo base_url() . 'index.php/Monitoring_progress/getData'  ?>',
                type: 'POST',
                data: filters
            },

            columns: getColumns()
        });
    }

    function getColumns() {
        let cols = [];
        $('#dataTable thead th').each(function () {
            cols.push({data: $(this).text()});
        });
        return cols;
    }
</script>