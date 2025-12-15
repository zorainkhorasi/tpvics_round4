<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/swiper.css">
<head>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqc6KT5zG3/Jd9jf3BlWqBKejZbyi4T695lqS/PRRzFChAW9vS/FwXl49EExB6T1kE3K17/5A=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"/>

</head>
<style>
    .img-fluid {
        width: 100%;
    }

    .my-table-bordered tr, th, td, .my-table-bordered thead th {
        border: 1px solid #dfdfdf;
    }

    .child_name {
        text-transform: capitalize;
    }

    /* --- BEGIN NEW UI & MODAL STYLES --- */
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --light-bg: #f8f9fa;
        --border-color: #dee2e6;

        /* NEW IMMUNIZATION SCHEDULE VARIABLES */
        --immu-font: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        --immu-border-dark: #afa6a6;
        --immu-border-light: #ccc;
        --immu-bg-card: #f9f9f9;
        --immu-bg-input: #fff;

        /* Palette */
        --tone-brown: #5c3523;
        --tone-red: #c9252c;
        --tone-magenta: #bc3689;
        --tone-cyan: #4cbbf5;
        --tone-orange: #fd9b43;
        --tone-green: #00b05b;
        --tone-royal: #3a75f1;
        --tone-navy: #004d9e;
        --tone-purple: #ae00d4;

        /* Modal Colors (Based on your image) */
        --modal-text-header: #789087;
        --modal-btn-gray: #d9d9d9;
        --modal-btn-active-bg: #dcfef6;
        --modal-btn-save-bg: #e0f7f3;
        --modal-btn-save-text: #2f7d6d;
        --modal-btn-cancel-bg: #1f6050;
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
        font-size: 18px;
        font-weight: 600;
        color: #176c64;
        margin-bottom: 15px;
        padding-bottom: 4px;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title-main {
        font-size: 18px;
        font-weight: 600;
        color: #176c64;
        margin-bottom: 15px;
        padding-bottom: 4px;

    }

    .field-group {
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;

    }

    .info-card {
        background-color: #bcfbf41a;
        border-left: 4px solid #4fa39a;
        padding: 15px;
        border-radius: 14px;
        margin-bottom: 5px;
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

    /* Main large image slider */
    .swiper-gallery.gallery-top {
        /*height: 220px;        !* adjust as needed *!*/
    }

    /* Images inside main slider */
    .swiper-gallery.gallery-top img {
        height: 100%;
        object-fit: contain; /* keeps image ratio without cropping */
    }

    /* Thumbnail slider */
    .gallery-thumbs {
        height: 80px; /* adjust as needed */
        margin-top: 10px;
    }

    .gallery-thumbs img {
        height: 100%;
        object-fit: cover;
    }

    .child-card {
        width: 100%;
        background: #f4fffbad;
        margin: 25px 0;
        border-radius: 20px;
        position: relative;
        padding: 4px 25px;
    }

    .child-header {
        display: flex;
        align-items: center;
        position: relative;
        margin-bottom: 15px;
    }

    .child-icon {
        width: 40px;
        height: 40px;
        background: #2d7c6e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .child-icon img {
        width: 33px;
        filter: brightness(0) invert(1);
    }

    .child-title {
        margin-left: 15px;
        color: #a4b5b2;
        font-size: 22px;
        font-weight: 700;
    }

    .child-number {
        position: absolute;
        right: 10px;
        color: #7c8a86;
        font-size: 16px;
    }

    .child-number span {
        font-weight: 700;
        font-size: 20px;
    }

    .child-line {
        border: none;
        border-top: 1px solid #bcd2cc;
        margin-bottom: 25px;
    }

    .child-card label {
        font-weight: 500;
        color: #2f3b38;
    }

    .child-card .form-control,
    .child-card .form-select {
        border: none;
        background: transparent;
        border-bottom: 1px solid #a9c1bb;
        border-radius: 0;
    }

    .child-card .form-select {
        background: #faf5f7;
        padding: 5px 8px;
        border-radius: 13px !important;
        border: 1px solid #eee1e1;
    }

    /* NEW: IMMUNIZATION SCHEDULE TABLE STYLES */
    .immu-schedule-table {
        width: 100%;
        border-collapse: collapse;

        font-family: var(--immu-font);
    }

    /*.immu-row { border-bottom: 2px solid var(--immu-border-dark); }*/
    .immu-row:last-child {
        border-bottom: none;
    }

    .immu-cell {
        padding: 15px;
        vertical-align: middle;
    }

    .immu-period-col {
        color: #18403c;
        background: #f1ffff;
        width: 90px;;
        text-align: center;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        line-height: 1.2;
    }

    .immu-doses-col {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;

        align-items: center;
    }

    .immu-ticket {
        position: relative;
        display: flex;
        background-color: var(--immu-bg-card);
        border-radius: 10px;
        overflow: hidden;
        width: 190px;
        height: 95px;
        border: 2px solid transparent;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s, border 0.3s ease-in-out, background-color 0.3s;
    }

    .immu-ticket:hover {
        box-shadow: 0 4px 14px rgb(170 205 201)
    }

    .immu-stripe {
        width: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-weight: 900;
        font-size: 8px;
        letter-spacing: 1px;
        writing-mode: vertical-lr;
        text-orientation: upright;
        text-transform: uppercase;
        user-select: none;
    }

    /*.fill-brown { background-color: var(--tone-brown); }*/
    /*.fill-red { background-color: var(--tone-red); }*/
    /*.fill-magenta { background-color: var(--tone-magenta); }*/
    /*.fill-cyan { background-color: var(--tone-cyan); }*/
    /*.fill-orange { background-color: var(--tone-orange); }*/
    /*.fill-green { background-color: var(--tone-green); }*/
    /*.fill-royal { background-color: var(--tone-royal); }*/
    /*.fill-navy { background-color: var(--tone-navy); }*/
    /*.fill-purple { background-color: var(--tone-purple); }*/
    /*.tiny-text { font-size: 10px; letter-spacing: 0.5px; }*/


    /* ... (CSS continues up to here) ... */

    .immu-stripe {
        width: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-weight: 900;
        font-size: 9px;
        letter-spacing: 1px;
        writing-mode: vertical-lr;
        text-orientation: upright;
        text-transform: uppercase;
        user-select: none;
    }

    /* The above colorful fill classes are now removed from use. */
    .immu-data-area {
        flex: 1;
        padding: 8px 12px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* ... (CSS continues) ... */

    .immu-sub-label {
        display: block;
        text-align: center;
        font-size: 9px;
        color: #444;
        font-weight: 600;
    }

    /* Completion Status BORDER STYLES */
    /* *** NOTE: data-status="complete" is being used for a different (orange) style,
    *** I am modifying it below to follow the green/red requirement for updated/error */

    /* ORIGINAL ORANGE/COMPLETE STATUS (MODIFIED TO GREEN/UPDATED) */
    .immu-ticket[data-status="complete"], .immu-ticket[data-status="updated"] {
        border: 2px solid var(--tone-red);
        background-color: #fce7e7;
        box-shadow: 0 0 10px rgba(201, 37, 44, 0.5);
    }

    .immu-ticket[data-status="complete"] .immu-stripe, .immu-ticket[data-status="updated"] .immu-stripe {

        background-color: var(--tone-red);
    }


    /* ERROR STATUS (RETAINED RED BORDER, ADDING RED STRIPE) */
    .immu-ticket[data-status="error"] {
        border: 2px solid #ff9600;
        background-color: #fff7ec;
        box-shadow: 0 0 10px rgb(255 226 185);

    }

    /* NEW STRIPE COLOR FOR ERROR: RED */
    .immu-ticket[data-status="error"] .immu-stripe {
        background-color: #ff9600;
    }

    /* Setting a default stripe color for non-status tickets (optional, based on your original multi-color use) */
    .immu-ticket .immu-stripe {
        background-color: #578580; /* Default gray for tickets without a status */
    }

    /* MODAL POPUP STYLES */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(2px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-card {
        background-color: #fff;
        width: 600px;
        max-width: 90%;
        border-radius: 30px;
        border: 2px solid #8caaa1;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        position: relative;
        font-family: var(--immu-font);
    }

    .modal-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        justify-content: flex-start;
    !important;
        border-bottom: 2px solid #dcdcdc;
    }

    .modal-icon {
        font-size: 32px;
        margin-right: 15px;
        background-color: var(--modal-btn-cancel-bg);
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-title {
        font-size: 42px;
        font-weight: bold;
        color: var(--modal-text-header);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .modal-tabs {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 15px;
    }

    .modal-tab-btn {
        flex: 1;
        border: none;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        background-color: var(--modal-btn-gray);
        color: #333;
        transition: 0.3s;
        border-radius: 5px;
    }

    .modal-tab-btn.active {
        background-color: var(--modal-btn-active-bg);
        color: #000;
    }

    .modal-inputs-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 18px;
    }

    .modal-input {

        flex: 1;
        height: 46px;
        border: 2px solid #ccc;
        background-color: #fafafa;
        font-size: 11px;
        padding: 0 10px;
        text-align: center;
        transition: background-color 0.3s, border-color 0.3s, opacity 0.3s;
        border-radius: 5px;
    }

    input[type="date"] {
        display: block;
        padding-top: 2px;
    }

    .immu-input-box {

        width: 100%;

        height: 18px;

        border: 1px solid var(--immu-border-light);

        background-color: var(--immu-bg-input);

        margin-bottom: 2px;

        box-sizing: border-box;

        font-size: 11px;

        padding-left: 4px;

        font-weight: 600; /* Added font weight for data visibility */

    }

    .modal-input:focus {
        outline: none;
        border-color: var(--modal-text-header);
    }

    .modal-input.disabled-field {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        background-color: #e0e0e0;
        border-color: #a0a0a0;
    }

    .modal-input.tick-field {
        width: 8px;
        font-size: 14px;
        line-height: 32px;
        background-color: #ffe5e5;
        color: #bf0d0d;
        font-weight: bold;
        border: 1px solid red;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .btn-action {
        padding: 10px 40px;
        border-radius: 20px;
        border: none;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-save {
        background-color: var(--modal-btn-save-bg);
        color: var(--modal-btn-save-text);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .btn-cancel {
        background-color: var(--modal-btn-cancel-bg);
        color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .btn-action:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* --- END NEW UI & MODAL STYLES --- */
    .vaccination-header {
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .vaccination-options .form-check {
        display: inline-block;
        margin-right: 20px;
    }

    .info-line {
        display: flex;
        flex-wrap: wrap;
        gap: 3px;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .info-box {
        flex: 1;
        min-width: 250px;
    }

    .info-label {
        font-weight: 600;
        margin-right: 5px;
    }

    .info-blank {
        display: inline-block;
        border-bottom: 1px solid #000;
        width: 160px;
        height: 21px;
        padding: 0px 34px;
    }

    /*    image viewr*/
    /* Modal Styling */
    .modal-viewer {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 9999; /* Sit on top of everything */
        padding-top: 50px; /* Location of the box (top) */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity (dark background) */
    }

    /* Modal Content (Image) */
    .modal-content-wrapper {
        margin: auto;
        display: block;
        width: 80%; /* Adjust as needed */
        max-width: 700px; /* Adjust as needed */
        height: auto;
        max-height: 90vh;
        text-align: center;
    }

    .modal-image {
        width: 100%;
        height: auto;
        max-height: calc(100vh - 100px); /* Account for padding/controls */
        object-fit: contain;
        transition: transform 0.3s ease-in-out; /* Smooth transform transitions */
        transform: scale(1) rotateY(0deg); /* Initial state for zoom/flip */
        cursor: grab;
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* Controls */
    .modal-controls {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }

    .control-btn {
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .section-header-container {
        display: flex;
        justify-content: space-between; /* Pushes the title and the dropdown apart */
        align-items: center; /* Vertically aligns items in the middle */
        padding-bottom: 10px; /* Optional: adds space below the header */
        border-bottom: 1px solid #ccc; /* Optional: separates header from content */
    }

    /* * 3. Styles for the main title (your original code)
     */
    .section-title-main {
        font-size: 1.5em; /* Example size */
        font-weight: bold;
        margin: 0; /* Remove default margins for clean alignment */
    }

    /*
     * 4. Styles for the Dropdown button
     */
    .edit-history-dropdown button {
        padding: 8px 15px;
        background-color: #f0f0f0; /* Light background for the button */
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
    }

    /* * Optional: Simple Dropdown Content styling
     * (You'd likely use a dedicated library or more complex CSS for a real dropdown)
     */
    .dropdown-content {
        display: none; /* Hide by default */
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 250px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 10px;
    }

    .edit-history-dropdown:hover .dropdown-content {
        display: block; /* Show on hover for this example */
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
                        <h2 class="content-header-title float-left mb-0">Card Review</h2>
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

        <section class="basic-select2">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 col-12">
                                        <div class="text-bold-600 font-medium-2">
                                            District
                                        </div>
                                        <div class="form-group">
                                            <select class="select2 form-control district_select"
                                                    onchange="changeUCs()">
                                                <option value="0" readonly disabled selected>District</option>
                                                <?php if (isset($province) && $province != '') {
                                                    foreach ($province as $k => $p) {
                                                        if ($dis == $k) {
                                                            echo '<option value="' . $k . '" selected>' . $p . '</option>';
                                                        } else {
                                                            echo '<option value="' . $k . '">' . $p . '</option>';
                                                        }

                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
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
                                    <div class="col-sm-3 col-12">
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
                                    <div class="col-sm-2 col-12">
                                        <div class="text-bold-600 font-medium-2">
                                            Child Line No
                                        </div>
                                        <div class="form-group">
                                            <select class="select2 form-control childNo_select">
                                                <option value="0" readonly disabled selected>Child No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12 py-2">
                                        <button type="button" class="btn btn-primary" onclick="searchData()">SEARCH
                                        </button>

                                        <button type="button" class="btn btn-danger ml-2" onclick="resetPage()">RESET
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (isset($_GET['c'])) {

            ?>
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div style=" padding: 0px 20px;" class="card">
                            <div class="card-header"></div>
                            <div class="child-card">

                                <div class="child-header d-flex align-items-center ">
                                    <div class="child-icon">
                                        <i style="font-size: 30px;color: white;" class="fa fa-child"></i>
                                    </div>

                                    <div class="child-title h5 mb-0">CHILD DETAILS</div>

                                    <div class="child-number">
                                        Child No: <span><?= $data->ec13 ?? 1 ?></span>
                                    </div>
                                </div>

                                <hr class="child-line">


                                <div class="info-line">
                                    <div class="info-box">
                                        <span class="info-label">Cluster:</span>
                                        <span class="info-blank"><?= $data->cluster_code ?? '' ?></span>
                                    </div>

                                    <div class="info-box">
                                        <span class="info-label">Household Number:</span>
                                        <span class="info-blank"><?= $data->hhno ?? '' ?></span>
                                    </div>

                                    <div class="info-box">
                                        <span class="info-label">Child Name:</span>
                                        <span class="info-blank"><?= $data->ec14 ?? '' ?></span>
                                    </div>
                                </div>

                                <div class="info-line">

                                    <div class="info-box">
                                        <span class="info-label">Gender:</span>
                                        <span class="info-blank"><?= $data->ec15 == 1 ? 'Male' : 'Female' ?></span>
                                    </div>

                                    <div class="info-box">
                                        <span class="info-label">Age :</span>
                                        <span class="info-blank"><?= $data->trueageinmonths ?? '' ?> Months</span>
                                    </div>

                                    <div class="info-box">
                                        <span class="info-label">Date of Birth:</span>

                                        <span id="dob_display"
                                              class="info-blank"><?= $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy ?></span>

                                        <?php
                                        $is_invalid = ($vac_details_edit->dobstatus == 2);
                                        ?>
                                        <span id="dob_editable_container" class="info-blank"
                                              style="display: <?= $is_invalid ? 'inline' : 'none' ?>;">
                                <input type="date" name="new_dob" id="new_dob_input" class="form-control"
                                       disabled
                                       style="font-size: 11px; width: 100px;margin: -4px -29px; display: inline-block;    border-bottom: none;!important "
                                       placeholder="DD-MM-YYYY">
                                    </div>

                                    <div class="info-box">
                                        <label class="info-label">Date of Birth Status</label>
                                        <select style="font-size: 11px" id="dobstatus" class="form-select">
                                            <option value="0">Select DoB Status</option>
                                            <option
                                                value="1" <?= $vac_details_edit->dobstatus == 1 ? 'selected' : '' ?>>OK
                                            </option>
                                            <option
                                                value="2" <?= $vac_details_edit->dobstatus == 2 ? 'selected' : '' ?>>
                                                Invalid DoB
                                            </option>
                                        </select>
                                    </div>
                                    <div class="info-box">
                                        <label class="info-label" style="margin-right: 10px;">Date Of Birth
                                            Type:</label>

                                        <div style="display: flex; align-items: center; gap: 15px;">

                                            <label
                                                style="display: flex; align-items: center; margin: 0; cursor: pointer;">
                                                <input
                                                    type="radio"
                                                    name="duration_type"
                                                    id="yearsCheck"
                                                    value="years"
                                                    <?= (isset($vac_details_edit->dob_type) && trim(strtolower($vac_details_edit->dob_type)) === 'years') ? 'checked' : '' ?>
                                                    style="margin-right: 5px;"
                                                >
                                                Years
                                            </label>

                                            <label
                                                style="display: flex; align-items: center; margin: 0; cursor: pointer;">
                                                <input
                                                    type="radio"
                                                    name="duration_type"
                                                    id="monthsCheck"
                                                    value="months"
                                                    <?= (isset($vac_details_edit->dob_type) && trim(strtolower($vac_details_edit->dob_type)) === 'months') ? 'checked' : '' ?>
                                                    style="margin-right: 5px;"
                                                >
                                                Months
                                            </label>

                                        </div>
                                    </div>
                                  <!--  <div class="info-box">
                                        <span
                                            class="info-label">Already Reviewed By:</span> <?php /*= $vac_details_edit->createdBy ?? 'Not Reviewed' */?>
                                    </div>-->

                                </div>
                            </div>

                        </div>

                        <?php
                        // --- 1. Define the Schedule Structure and Color Mapping for the New UI ---
                        $vaccine_schedule = [
                            "AT BIRTH" => ["bcg", "hep_b", "opv0"],
                            "6 WEEKS" => ["opv1", "rv1", "pcv1", "penta1"],
                            "10 WEEKS" => ["opv2", "rv2", "pcv2", "penta2", "ipv"],
                            "14 WEEKS" => ["opv3", "penta3", "pcv3", "ipv2"], // Grouping remaining vaccines
                            "9 MONTHS" => ["mr1", "tcv"],
                            "15 MONTHS" => ["mr2"],

                        ];

                        $stripe_map = [
                            'bcg' => 'fill-brown', 'hep_b' => 'fill-red', 'opv0' => 'fill-magenta',
                            'opv1' => 'fill-magenta', 'rv1' => 'fill-cyan', 'pcv1' => 'fill-orange', 'penta1' => 'fill-green',
                            'opv2' => 'fill-magenta', 'rv2' => 'fill-cyan', 'pcv2' => 'fill-orange', 'penta2' => 'fill-green', 'ipv' => 'fill-royal',
                            'mr1' => 'fill-purple', 'tcv' => 'fill-navy tiny-text',
                            'mr2' => 'fill-purple', 'opv3' => 'fill-magenta', 'penta3' => 'fill-green', 'pcv3' => 'fill-orange', 'ipv2' => 'fill-royal',
                        ];
                        // Assuming $vac_details and $vac_details_edit are defined
                        ?>

                        <div class="field-group ">

                            <div class="vaccination-header">
                                <div class="section-header-container">

                                    <div class="section-title-main">
                                        Vaccination Records
                                    </div>

                                    <div class="edit-history-dropdown">
                                        <button>
                                            <i class="fa fa-history"></i> View History
                                        </button>

                                        <div class="dropdown-content">
                                            <p><strong>Version History:</strong></p>
                                            <ul>
                                                <?php foreach ($vac_details_edit_names as $row): ?>
                                                    <li><b><?php echo $row->created_date; ?></b>: Record updated by <b><?php echo $row->createdby; ?></b></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <!-- Right side options -->
                                <div class="vaccination-options">

                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="immu-schedule-table">
                                    <?php foreach ($vaccine_schedule as $period => $vaccines): ?>
                                        <tr class="immu-row">
                                            <td class="immu-cell immu-period-col"><?= $period ?></td>
                                            <td class="immu-cell immu-doses-col">
                                                <?php
                                                foreach ($vaccines as $v):
                                                    // --- Data Retrieval Logic ---
                                                    $oldValue = $vac_details->$v ?? '-';
                                                    $newValue = $vac_details_edit->$v ?? '-';
                                                    $newValue = ($newValue === '') ? '-' : $newValue; // Treat empty string as default '-'

                                                    // --- Display Logic for Card and Modal ---
                                                    $updated_display = 'Click to set';
                                                    $status = ''; // 'complete', 'error', or ''
                                                    $display_color = 'initial';
                                                    $font_weight = 'normal';

                                                    if ($newValue === '98') {
                                                        $updated_display = 'VACCINATOR ERROR';
                                                        $status = 'error';
                                                        $display_color = 'var(--tone-red)';
                                                        $font_weight = 'bold';
                                                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $newValue)) {
                                                        // Format: YYYY-MM-DD
                                                        $updated_display = date('d-m-Y',strtotime($newValue));
                                                        $oldValue = date('d-m-Y',strtotime($oldValue));
                                                        $status = ($oldValue != $newValue && $newValue != '-') ? 'complete' : '';
                                                        $display_color = '#000';
                                                        $font_weight = 'bold';
                                                    } elseif (preg_match('/^\d{2}$/', $newValue) && $newValue != '-') {
                                                        // Format: Code (e.g., 44, 97)
                                                        $updated_display = 'CODE: ' . $newValue;
                                                        $status = ($oldValue != $newValue) ? 'complete' : '';
                                                        $display_color = 'var(--tone-royal)';
                                                        $font_weight = 'bold';
                                                    }
                                                    ?>
                                                    <div class="immu-ticket" data-vaccine="<?= $v ?>"
                                                         data-status="<?= $status ?>">
                                                        <div
                                                            class="immu-stripe <?= $stripe_map[$v] ?? 'fill-gray' ?>"><?= strtoupper($v) ?></div>
                                                        <div class="immu-data-area">
                                                            <div class="immu-field-group">
                                                                <div class="immu-input-box"><?= $oldValue ?></div>
                                                                <span class="immu-sub-label">Original Value:</span>
                                                            </div>
                                                            <div class="immu-field-group">
                                                                <input type="text"
                                                                       class="immu-input-box clickable-box"
                                                                       id="<?= $v ?>_display"
                                                                       value="<?= $updated_display ?>"
                                                                       style="color: <?= $display_color ?>; font-weight: <?= $font_weight ?>;"
                                                                       readonly
                                                                       placeholder="Click to set"
                                                                >
                                                                <span class="immu-sub-label">Corrected Value:</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="<?= $v ?>_value" name="<?= $v ?>"
                                                           value="<?= $newValue ?>">
                                                <?php endforeach; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <div class="action-buttons  text-end py-2">
                            <button type="button" class="btn btn-primary" onclick="saveVaccinesData()">
                                Save Data
                            </button>
                        </div>
                    </div>
                    <!--</div>-->

                    <div class="col-xl-4 col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="child-card">

                                    <div class="child-header d-flex align-items-center ">
                                        <div class="child-icon">
                                            <i style="font-size: 30px; color: white;"
                                               class="fa-solid fa-id-card"></i>
                                        </div>

                                        <div class="child-title h5 mb-0">VACCINATION CARD IMAGE</div>


                                    </div>
                                    <div class="field-group">
                                        <label for="image_status" class="form-label">Image Status</label>
                                        <select style="font-size: 11px;" id="image_status"
                                                class="image_status form-select">
                                            <?php $imageOptions = ['0' => 'Select Image Status', 'OK' => 'OK', 'Blur' => 'Blur', 'Focus Issue' => 'Focus Issue', 'Light Issue' => 'Light Issue', 'Child Name not Matched' => 'Child Name not Matched', 'No Image' => 'No Image'];
                                            $savedValue = isset($vac_details_edit->image_status) ? $vac_details_edit->image_status : '0';
                                            foreach ($imageOptions as $val => $label): ?>
                                                <option
                                                    value="<?= $val ?>" <?= $savedValue == $val ? 'selected' : '' ?>><?= $label ?></option> <?php endforeach; ?>
                                        </select>
                                        <div class="field-group">
                                            <div class="section-title">Image Feedback</div>
                                            <label for="comments" class="form-label">Comments / Notes</label>
                                            <textarea id="comments" name="comments" class="form-control" rows="3"
                                                      placeholder="Add any relevant notes or comments here..."><?= isset($vac_details_edit->image_comments) ? htmlspecialchars($vac_details_edit->image_comments) : '' ?></textarea>
                                        </div>
                                    </div>
                                    <br>

                                    <br>


                                    <div class="section-title">Image</div>
                                    <div class="card-body">
                                        <div class="image-gallery">
                                            <?php $img = '';
                                            if (1 == 1) {
                                                $img = '<div class="swiper-slide"> 
                                <img class="img-fluid" src="http://localhost/tpvics_round4/assets/images/banner/vac.png" alt="vac.png"> </div>
                                 <div class="swiper-slide">
                                  <img class="img-fluid" src="http://localhost/tpvics_round4/assets/images/banner/vac.png" alt="vac.png"> </div>';
                                            } else {
                                                $img = '<div class="swiper-slide text-center p-5">
                                       <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                       <p class="text-muted">No Image Available</p></div>';
                                            } ?>
                                            <div class="swiper-gallery swiper-container gallery-top mb-3">
                                                <div class="swiper-wrapper gallery_images"> <?php echo $img; ?> </div>
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                            <div class="swiper-container gallery-thumbs">
                                                <div class="swiper-wrapper gallery_images"> <?php echo $img; ?> </div>
                                            </div>
                                        </div>

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
<div id="imageViewerModal" class="modal-viewer">
    <span class="close-btn">&times;</span>
    <div class="modal-content-wrapper">
        <img class="modal-image" id="fullScreenImage" src="" alt="Full Screen Image">
    </div>
    <div class="modal-controls">
        <button id="zoomInBtn" class="control-btn">+</button>
        <button id="zoomOutBtn" class="control-btn">-</button>
        <button id="flipBtn" class="control-btn">Flip</button>
        <button id="rotateBtn" class="control-btn">Rotate</button>
    </div>
</div>
<div id="actionModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                </svg>
            </div>
            <div class="modal-title">ACTION</div>
        </div>

        <div class="modal-tabs">
            <button class="modal-tab-btn" id="tabCode" onclick="selectTab('code')">CHANGE CODE</button>
            <button class="modal-tab-btn active" id="tabDate" onclick="selectTab('date')">CHANGE DATE</button>
            <button class="modal-tab-btn" id="tabError" onclick="selectTab('error')">VACCINATOR ERROR</button>
        </div>

        <div class="modal-inputs-row">
            <select class="modal-input" id="inputCode">
                <option value="" disabled selected>Select Code</option>
                <option value="44">44– Date not clear</option>
                <option value="88">88 – Tick mark only</option>
                <option value="66">66 – Given (mother’s recall)</option>
                <option value="97">97 – Not given (mother’s recall)</option>
            </select>
            <input type="date" class="modal-input" id="inputDate">
            <input type="text" class="modal-input disabled-field tick-field" id="inputError" readonly value="Error">
        </div>

        <div class="modal-footer">
            <button class="btn-action btn-save" onclick="saveData()">SAVE</button>
            <button class="btn-action btn-cancel" onclick="closeModal()">CANCEL</button>
        </div>
    </div>
</div>
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">

<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>

<script>

    let today = new Date();
    today.setDate(today.getDate() - 1);
    let yyyy = today.getFullYear();
    let mm = ("0" + (today.getMonth() + 1)).slice(-2);
    let dd = ("0" + today.getDate()).slice(-2);

    document.getElementById('inputDate').setAttribute('max', `${yyyy}-${mm}-${dd}`);


    // ===========================================
    // EXISTING SEARCH/CLUSTER LOGIC (RETAINED)
    // ===========================================
    changeUCs();

    function changeUCs() {
        var data = {};
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            showloader();
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getClustersByDist'  ?>', data, 'POST', function (res) {
                hideloader();
                var items = '<option value="0"   readonly disabled selected>Cluster</option>';
                var selectedCluster = "<?php echo $cluster; ?>";

                if (res !== '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);

                    $.each(response, function (i, v) {

                        if (selectedCluster == v.cluster_code) {
                            items += '<option value="' + v.cluster_code + '" selected onclick="changeCluster()">' + v.cluster_code + '</option>';
                        } else {
                            items += '<option value="' + v.cluster_code + '" onclick="changeCluster()">' + v.cluster_code + '</option>';
                        }

                    });
                }
                $('.clusters_select').html('').html(items);
                changeCluster();
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

    changeHH()

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
        var d = $('.district_select').val();
        var hh = $('.household_select').val();
        var child = $('.childNo_select').val();
        var clusters_select = $('.clusters_select').val();

        var url = "<?= base_url('index.php/Card_edit/edit_form_new') ?>?dis=" + d + "& c=" + clusters_select + "&h=" + hh + "&ec=" + child;

        window.location.href = url;
    }

    function resetPage() {
        var url = "<?= base_url('index.php/Card_edit/edit_form_new') ?>";

        window.location.href = url;
    }


    $(document).ready(function () {
        gallery();
        initModalTriggers(); // Initialize new modal click handlers
        clickAll();
    });

    $('#dobstatus').change(function () {
        if ($(this).val() == '2') { // Invalid DoB
            $('#dob_editable_container').show();
            $('#dob_display').hide();
            $('#new_dob_input').prop('disabled', false);
        } else {
            $('#dob_editable_container').hide();
            $('#dob_display').show();
            $('#new_dob_input').prop('disabled', true);
        }
    });

    // Attach clickAll handler to the new radio buttons
    $(document).on('change', 'input[name="checkAllBtn"]', clickAll);

    function clickAll() {
        let type = $('input[name="checkAllBtn"]:checked').val();
        const clickableBoxes = $('.clickable-box');

        if (type == 1 || type == 3) { // Matched or Not Readable: disable interaction
            clickableBoxes.addClass('disabled-field').prop('disabled', true);
            clickableBoxes.closest('.immu-ticket').css("opacity", "0.5");
        } else if (type == 2) { // Not Matched: enable interaction
            clickableBoxes.removeClass('disabled-field').prop('disabled', false);
            clickableBoxes.closest('.immu-ticket').css("opacity", "1");
        }
    }

    // ===========================================
    // NEW MODAL LOGIC
    // ===========================================
    const modal = document.getElementById('actionModal');
    const inputCode = document.getElementById('inputCode');
    const inputDate = document.getElementById('inputDate');
    const inputError = document.getElementById('inputError');

    let activeTab = 'date';
    let activeInputBox = null;
    let activeTicket = null;
    let activeHiddenInput = null;

    function initModalTriggers() {
        const triggers = document.querySelectorAll('.clickable-box');
        triggers.forEach(box => {
            box.addEventListener('click', function () {
                // If bulk action disabled it, do nothing
                if (this.classList.contains('disabled-field')) return;

                // 1. Remember which elements are active
                activeInputBox = this;
                activeTicket = this.closest('.immu-ticket');

                // Identify the vaccine name (e.g., 'bcg')
                const vaccineName = activeTicket.getAttribute('data-vaccine');
                // Find the hidden input based on the expected ID
                activeHiddenInput = document.getElementById(vaccineName + '_value');

                if (!activeHiddenInput) {
                    console.error('Hidden input not found for vaccine:', vaccineName);
                    return;
                }

                // 2. Load current value and set the initial modal state
                const currentValue = activeHiddenInput.value;

                // Determine initial tab and input values based on the HIDDEN value
                if (currentValue === '98') {
                    selectTab('error');
                } else if (currentValue && !isNaN(currentValue) && currentValue.length > 0 && currentValue !== '-') { // Code (e.g., 44, 97, 88)
                    selectTab('code');
                    inputCode.value = currentValue;
                } else if (currentValue && currentValue.includes('-')) { // Assume date format (YYYY-MM-DD)
                    selectTab('date');
                    inputDate.value = currentValue;
                } else {
                    // Default state or cleared state
                    selectTab('date');
                    inputCode.value = '';
                    inputDate.value = '';
                }

                // 3. Show the modal
                modal.style.display = 'flex';
            });
        });
    }

    function selectTab(tabName) {
        activeTab = tabName;
        const tabs = document.querySelectorAll('.modal-tab-btn');
        tabs.forEach(t => t.classList.remove('active'));

        // Reset all inputs to default disabled/hidden state
        inputCode.classList.add('disabled-field');
        inputCode.disabled = true;
        inputDate.classList.add('disabled-field');
        inputDate.disabled = true;
        inputError.classList.add('disabled-field');
        inputError.disabled = true;

        // Clear inputs unless we are activating them (This prevents carryover if the user doesn't interact)
        if (tabName !== 'code') inputCode.value = '';
        if (tabName !== 'date') inputDate.value = '';


        // Apply logic based on the selected tab
        switch (tabName) {
            case 'code':
                document.getElementById('tabCode').classList.add('active');
                inputCode.classList.remove('disabled-field');
                inputCode.disabled = false;
                break;

            case 'date':
                document.getElementById('tabDate').classList.add('active');
                inputDate.classList.remove('disabled-field');
                inputDate.disabled = false;
                break;

            case 'error':
                document.getElementById('tabError').classList.add('active');
                inputError.classList.remove('disabled-field');
                inputError.disabled = true;
                break;
        }
    }

    function saveData() {
        if (!activeInputBox || !activeTicket || !activeHiddenInput) {
            closeModal();
            return;
        }

        let finalValue = '-';
        let displayValue = 'Click to set';
        let newStatus = '';
        let displayColor = 'initial';
        let font_weight = 'normal';

        // Determine what to save based on the active tab
        switch (activeTab) {
            case 'date':
                if (inputDate.value) {
                    finalValue = inputDate.value;
                    displayValue = finalValue;
                    newStatus = 'complete';
                    displayColor = "#000";
                    font_weight = 'bold';
                } else {
                    finalValue = '-';
                }
                break;

            case 'code':
                if (inputCode.value) {
                    finalValue = inputCode.value;
                    displayValue = 'CODE: ' + finalValue;
                    newStatus = 'complete';
                    displayColor = "var(--tone-royal)";
                    font_weight = 'bold';
                } else {
                    finalValue = '-';
                }
                break;

            case 'error':
                finalValue = '98';
                displayValue = 'VACCINATOR ERROR';
                newStatus = 'error';
                displayColor = "var(--tone-red)";
                font_weight = 'bold';
                break;
        }

        // 1. Update the HIDDEN input value (Crucial for AJAX submission)
        activeHiddenInput.value = finalValue;

        // 2. Update the VISIBLE input box
        activeInputBox.value = displayValue;
        activeInputBox.style.fontWeight = font_weight;
        activeInputBox.style.color = displayColor;

        // 3. Update the visual ticket status
        activeTicket.setAttribute('data-status', newStatus);

        closeModal();
    }

    function closeModal() {
        modal.style.display = 'none';
        activeInputBox = null;
        activeTicket = null;
        activeHiddenInput = null;
        inputCode.value = '';
        inputDate.value = '';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }


    // ===========================================
    // UPDATED SAVE ALL VACCINES (RETAINED/MODIFIED)
    // ===========================================
    function saveVaccinesData() {
        let formData = {};
        let vaccines = ["bcg", "opv0", "opv1", "opv2", "opv3", "penta1", "penta2", "penta3", "pcv1", "pcv2", "pcv3", "rv1", "rv2", "ipv", "ipv2", "mr1", "mr2", "hep_b", "tcv"];

        vaccines.forEach(v => {
            // Use the value from the hidden input field
            formData[v] = $('#' + v + '_value').val();
        });

        let dobType = $('input[name="duration_type"]:checked').val();

        if (!dobType) {
            alert("Date of Birth type is required");
            return false; // stop form submission
        }

        formData['dob_type'] = dobType;

        // Additional info
        formData['cluster_code'] = "<?= $data->cluster_code ?? '' ?>";
        formData['hhno'] = "<?= $data->hhno ?? '' ?>";
        formData['ec13'] = "<?= $data->ec13 ?? '' ?>";
        formData['image_status'] = $('#image_status').val();
        formData['dob'] = '<?= $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy ?>';
        formData['dobstatus'] = $('#dobstatus').val();
        formData['vac_status'] = $('input[name="checkAllBtn"]:checked').val();
        formData['image_comments'] = $('#comments').val(); // <--- ADD THIS LINE
        formData['dob'] = '<?= $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy ?>';


        if (!formData['image_status']) {

            alert("Image Status is required");
            $('#image_status').css('border', '1px solid red');
            return false;
        }
        if (!formData['dobstatus']) {
            alert("DOB Status is required");
            $('#dobstatus').css('border', '1px solid red');
            return false;
        }

        $.ajax({
            url: '<?= base_url('index.php/Card_edit/save_vaccines_ajax'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    alert('Data saved successfully!');
                } else {
                    alert('Error saving data: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert('AJAX error saving data');
            }
        });
    }


    // ===========================================
    // REMAINING UTILITY FUNCTIONS (RETAINED)
    // ===========================================

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

    // image viewr:
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('imageViewerModal');
        const fullScreenImage = document.getElementById('fullScreenImage');
        const closeBtn = document.querySelector('.close-btn');
        const zoomInBtn = document.getElementById('zoomInBtn');
        const zoomOutBtn = document.getElementById('zoomOutBtn');
        const flipBtn = document.getElementById('flipBtn');
        const rotateBtn = document.getElementById('rotateBtn'); // NEW BTN

        // State variables
        let currentScale = 1;
        let isFlipped = false;      // FIXED (You used it without defining)
        let currentRotation = 0;    // NEW (for rotation)
        const scaleStep = 0.2;
        const rotationStep = 90;    // rotate 90-degree per click

        // Open modal on image click
        document.querySelectorAll('.image-gallery .img-fluid').forEach(image => {
            image.addEventListener('click', function () {
                const imgSrc = this.getAttribute('src');
                fullScreenImage.setAttribute('src', imgSrc);
                modal.style.display = 'block';

                // Reset transformations
                currentScale = 1;
                isFlipped = false;
                currentRotation = 0;

                fullScreenImage.style.transform = `scale(1) rotateY(0deg) rotate(0deg)`;
            });
        });

        // Close modal
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside image
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Zoom In
        zoomInBtn.addEventListener('click', function () {
            currentScale += scaleStep;
            updateTransform();
        });

        // Zoom Out
        zoomOutBtn.addEventListener('click', function () {
            if (currentScale > scaleStep) {
                currentScale -= scaleStep;
                updateTransform();
            }
        });

        // Flip Image Horizontally
        flipBtn.addEventListener('click', function () {
            isFlipped = !isFlipped;
            updateTransform();
        });

        // ★ NEW – Rotate Image ★
        rotateBtn.addEventListener('click', function () {
            currentRotation += rotationStep;
            updateTransform();
        });

        // Apply zoom + flip + rotate
        function updateTransform() {
            const flipRotation = isFlipped ? 180 : 0;

            fullScreenImage.style.transform =
                `scale(${currentScale}) rotateY(${flipRotation}deg) rotate(${currentRotation}deg)`;
        }
    });

</script>