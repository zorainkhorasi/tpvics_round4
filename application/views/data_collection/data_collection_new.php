

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE0x1lV0C1lV+8ABH3VyxhVZ1WTRi3GJf6tk3SVJQG8lrN8mA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
/>
<style>

    /* Variables for colors and properties (optional but good practice) */
    :root {
        --primary-color: #00796b; /* A deep teal/green color */
        --secondary-color: #faebd7; /* Off-white/beige for the background */
        --text-color: white;
        --map-color: #ffaa00; /* Orange/Gold for the map */
    }

    .tpvics-header {
        /* Main container styling */
        width: 100%;
        border-radius: 8px;

        background-color: var(--color-card-main);

        overflow: hidden; /* To contain the map section's shape */
    }

    .header-content {
        display: flex;
        align-items: stretch;
        min-height: 150px; /* Adjust height of the header */
    }

    .text-section {
        /* The main teal section */
        background-color: var(--primary-color);
        color: var(--text-color);
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 2; /* Ensure text is above the map area's triangular cut */
        flex-grow: 1; /* Take up remaining space */
    }

    .icon-text {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .icon {
        font-size: 30px;
        margin-right: 10px;
    }

    .welcome-text {
        font-size: 27px;
        font-weight: 500;
        color: #dcffed;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .main-title {
        text-shadow: 2px 2px 12px rgb(30 30 30);
        color: #ffffff;
        font-size: 3.5em;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }

    /* Creating the diagonal cut effect on the right of the text section */
    .text-section::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        border-top: 84px solid transparent;
        border-bottom: 84px solid transparent;
        border-left: 50px solid var(--primary-color);
        transform: translateX(100%);
        z-index: 3;
    }


    .map-section {
        /* The beige section for the map */
        background-color:#fff8ed;
        width: 300px; /* Fixed width for the map area */
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;

    }

    /* Creating the outer arrow shape for the entire header */
    .map-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        /* Create the beige part of the arrow head */
        border-top: 75px solid transparent;
        border-bottom: 75px solid transparent;
        border-right: 50px solid var(--secondary-color); /* Matches background */
        transform: translateX(-100%);
        z-index: 1;
    }


    /* Map Styling - Using a simple SVG as a placeholder */
    .pakistan-map {
        width: 150px;
        height: auto;
        filter: drop-shadow(0 0px 0px rgba(0, 0, 0, 0.1))
    }

    .pakistan-map path {
        fill: var(--map-color);
    }

    /* Optional: Adjust for smaller screens */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            min-height: auto;
        }

        .text-section, .map-section {
            width: 100%;
            padding: 20px;
        }

        .text-section::after, .map-section::before {
            content: none; /* Remove complex shapes on mobile */
        }

        .main-title {
            font-size: 2.5em;
        }
    }

    /* --- Global Variables --- */
    :root {
        --bg-dark-primary: #1a1a2e;
        --bg-dark-secondary: #2c2c47;
        --bg-dark-tertiary:  #fff8ed;;; /* Light background for the right section */
        --text-light: #ffffff;
        --text-secondary: #a0a0c0;

        /* Status Colors */
        --color-complete-green: #38a169;
        --color-ongoing-orange: #dd6b20;
        --color-remaining-red: #e53e3e;

        /* Chart Colors (Left Panel) */
        --color-chart-1: #9b59b6;
        --color-chart-2: #8e44ad;
        --color-chart-3: #6c5ce7;
        --color-chart-4: #a29bfe;

        /* Right Card Primary Color */
        --color-card-main: #1f8d8d;;
        --color-card-header-bg: #dbf3eea6;
        --color-card-text-dark: #8b8b8b;
        --color-card-progress-track: #f0f0f0;
    }

    /* --- General Styling --- */
    body {
        /*background: linear-gradient(to right, #fffcf6 0%, #fdfaf4 50%, #39036e 100%);*/
        /*background: linear-gradient(to right, #fffcf6 0%, #b0a4bf 50%, #250a48 100%);*/
        background-color: var(--bg-dark-tertiary);
        /*background: linear-gradient(to right, #4c1874 0%, #2e1152 50%, #15042a 100%);*/
        color: var(--text-light);
        font-family: Arial, sans-serif;
    }

    hr {
        color: #4a4a6b;
        opacity: 0.5;
    }

    /* Search Button */
    .btn-search {
        background-color: #ffffff;
        color: #c3bdab;
        border: none;
        padding: 2px 25px;
        border-radius: 28px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* --- Left Panel Styling --- */
    .card-left {

    }

    .line-listing-title {
        font-size: 35px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #d7d7d7;
    }

    .chart-block {
        padding: 15px;
        background: #fff8ed;
        position: relative;
        text-align: center;
        border-radius: 15px;
    }

    .block-title {
        font-size: 17px;
        font-weight: 600;
        color: #96cdc2;
        text-transform: uppercase;
        justify-self: left;
    }
    .ucs-block-title{
        font-size: 20px;
        font-weight: bold;
        color: #bbbbbb;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    /* Positioning the large number inside the hollow of the radial chart */
    .chart-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        font-weight: 900;
        color: var(--text-light);
        margin-top: -10px;
        pointer-events: none; /* Prevents interaction with chart underneath */
    }

    /* Custom Legend for Left Charts */
    .chart-legend-list {
        text-align: left;
        margin-top: 15px;
    }

    .legend-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        padding: 2px 0;
        align-items: center;
    }

    .legend-name {
        display: flex;
        align-items: center;
        color: var(--text-secondary);
    }

    .legend-value {
        font-weight: 600;
        color: var(--text-light);
    }

    .legend-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 10px;
        box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
    }

    /* --- Right Panel (Main Content) Styling --- */
    .card-right {
        /*background-color: var(--bg-dark-tertiary); !* Light background *!*/
        border-radius: 10px;
        min-height: 890px;
    }

    /* --- SCROLLABLE CONTAINER FOR DISTRICT CARDS --- */
    .scrollable-card-container {
        max-height: 85vh;
        overflow-y: auto;
        padding-right: 15px;
    }
    /* ----------------------------------------------- */

    /* --- Individual Card Styling (The goal card) --- */
    .dashboard-card {
        background-color: var(--text-light); /* White background */
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* Remove padding to let inner elements handle it */
        overflow: hidden;
    }

    /* Card Header */
    .card-header-new {
        display: flex
    ;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(to left, #a7d1d1, #ffffff);        padding: 9px 16px;
    }

    .location-name-new {
        font-size: 13px;
        font-weight: 600;

        color: var(--color-card-text-dark);
    }

    .count-value-new {
        font-size: 1.2em;
        font-weight: bold;
        color: var(--color-card-main);
    }

    /* Chart Container */
    .chart-container {
        padding: 2px 0;
    }

    /* Progress Details Section */
    .progress-details {
        padding: 0 20px 20px 20px; /* Add padding to match original image */
    }

    .detail-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .icon-label {
        display: flex;
        align-items: center;

        min-width: 90px;
        font-size: 12px;
        width: 38%;
    }

    .icon {
        font-size: 1.1em;
        margin-right: 8px;
        line-height: 1;
    }

    .detail-row.completed .icon { color: var(--color-complete-green); }
    .detail-row.on-going .icon { color: var(--color-ongoing-orange); }
    .detail-row.remaining .icon { color: var(--color-remaining-red); }

    .label {
        color: var(--color-card-text-dark);
    }

    .bar-and-percentage {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .progress-bar-container {
        flex-grow: 1;
        height: 6px;
        background-color: var(--color-card-progress-track);
        border-radius: 3px;
        margin-right: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 3px;
    }

    .progress-bar.green { background-color: var(--color-complete-green); }
    .progress-bar.orange { background-color: var(--color-ongoing-orange); }
    .progress-bar.red { background-color: var(--color-remaining-red); }

    .percentage {
        font-size: 0.85em;
        font-weight: bold;
        width: 35px;
        text-align: right;
    }

    .detail-row.completed .percentage { color: var(--color-complete-green); }
    .detail-row.on-going .percentage { color: var(--color-ongoing-orange); }
    .detail-row.remaining .percentage { color: var(--color-remaining-red); }

    /* ApexChart specific adjustments */
    .apexcharts-text {
        font-family: Arial, sans-serif !important;
    }
    .dashboard-card {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .dashboard-card:hover {
        transform: scale(1.03);
    }
    .dashboard-card {
        border: 1px solid #ffffff;
    ;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 17px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s
        ease;
        cursor: pointer;
    }
    .dashboard-card:hover {
        transform: scale(1.03);
    }
    .chart-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .bi{
        padding-right: 9px;
    }
    /* Header container */
    .animated-header {
        background: #00796b;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        animation: fadeInDown 1.2s
        ease-in-out;
        flex-wrap: wrap;
    }

    .header-text {
        flex: 1;
    }

    .main-heading {
        font-size: 27px;
        font-weight: 500;
        color: #dcffed;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .sub-heading {
        text-shadow: 2px 2px 12px rgb(30 30 30);
        font-weight: bold;
        line-height: 33px;
        font-size: 47px;
        color: #ffffff;
    }

    /* Pakistan map styling */
    .header-map {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pakistan-map {
        width: 160px;
        height: auto;
        animation: float 4s ease-in-out infinite;
        filter: drop-shadow(0 0px 0px rgba(0, 0, 0, 0.1))
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    @media (max-width: 768px) {
        .pakistan-map {
            width: 120px;
            margin-top: 10px;
        }
    }
    /* Variables for easy theme changes (kept the same) */
    :root {
        --main-color: #279f8e; /* Teal/Green color for the gradient and accents */
        --text-color: #333;
        --count-color: #000;
    }

    .ps-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;

        height: 60px;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Combined shadow to the main container */
        border-radius: 5px;
        overflow: hidden; /* Important for containing the gradient and count box */
    }

    .ps-state-info-bar {
        display: flex
    ;
        align-items: center;
        /* height: 137%; */
        flex-grow: 1;

    }

    .ps-map-icon-wrapper {
        width: 86px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(to top right, #fff8ed, #ffffff);
        display: flex
    ;
        justify-content: center;
        align-items: center;
        position: relative;
        left: -18px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    /* Style for your dummy image within the circle */
    .ps-dummy-map-image {
        margin-right: -11px;
        width: 71px;
        height: auto;
        border-radius: 50%;
        clip-path: circle(40% at 50% 50%);
    }

    .ps-state-name-wrapper {
        padding-left: 5px; /* Space after the map icon */
        color: #fff; /* White text for the state name */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        /* Push the content far left to reveal the gradient transition */
        flex-grow: 1;
        /* Padding on the right to separate the text from the count box */
        padding-right: 10px;


        display: flex;                /* 1. Use Flexbox */
        justify-content: space-between; /* 2. Push children to the edges */
        align-items: center;          /* 3. Vertically align items */
        width: 100%;
    }

    .ps-state-name {
        font-size: 18px;
        font-weight: 600;
    }

    .ps-total-count {
        height: 100%;

        display: flex
    ;
        align-items: center;
        justify-content: center;
        font-size: 2.5em;
        font-weight: bold;
        color: var(--count-color);
        flex-shrink: 0;
    }
</style>

<div  style="" class="app-content content">

    <div class="container-fluid dashboard-container" style="background: #fff8ed;    margin-top: 93px; ">
      <div class="row">
          <div class="col-12">
              <div class="animated-header d-flex align-items-center justify-content-between mt-4">
                  <!-- ===== HEADER ===== -->
                  <header class="tpvics-header">
                      <div class="header-content">
                          <div class="text-section">
                              <div class="icon-text">
                                  <span class="icon"><i class="fa-solid fa-list"></i></span> <span class="welcome-text">Welcome to TPVICS</span>
                              </div>
                              <h1 class="main-title">Data Collection</h1>
                          </div>
                          <div class="map-section">
                              <img src="<?php echo base_url('assets/images/mapPAK.png'); ?>" alt="Pakistan Map" class="pakistan-map">
                          </div>
                      </div>
                  </header>



              </div>
          </div>

      </div>


<BR>

        <div class="row">


            <div class="col-lg-12 ps-4">




                <div id="districtCardsSection" class="row row-cols-1 row-cols-md-4 g-4 scrollable-card-container">

                    <!-- Total Cluster -->
                    <diiv class="col">
                        <div class="chart-block cluster-chart-block">
                            <h4 class="block-title">Total Cluster</h4>
                            <div id="totalclusterchart"></div>

                        </div>
                    </diiv>

                    <!-- Balochistan -->
                    <?php if($this->encrypt->decode($_SESSION['login']['idGroup']) == 1 ||  $this->encrypt->decode($_SESSION['login']['prcode'])==4) { ?>
                    <div class="col">
                        <div class="dashboard-card" data-district="BALOCHISTAN" data-id="4">
                            <div class="ps-header-container">
                                <div  style="    background: linear-gradient(to right, #5b6388 0%, #7d8ac7 35%, #dfe2f1 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/balochistanmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">
                                            <?php                 
                                       echo $dist_array[4];
                                        ?>
                                        </span>
                                        <span class="ps-total-count"><?php echo $totalcluster["list"][1]['clusters_by_district']; ?></span>
                                    </div>
                                </div>


                            </div>
                            <div id="balochistan" class="chart-container"></div> 

                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 60%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["BALOCHISTAN"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["BALOCHISTAN"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["BALOCHISTAN"]['inprogress']; ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["BALOCHISTAN"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo  $per["BALOCHISTAN"]['remaining']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       <?php } ?>

                    <!-- SINDH -->
                     <?php
                    if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 ||  $this->encrypt->decode($_SESSION['login']['prcode'])==3) { ?>
                    <div class="col">
                        <div class="dashboard-card" data-district="SINDH" data-id="3">
                            <div class="ps-header-container">
                                <div  style="  background: linear-gradient(to right, #c39b00 0%, #f9cf2c 35%, #f3ecd2 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/sindhmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[3];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo $totalcluster["list"][7]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div id="sindh" class="chart-container"></div>

                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 95%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["SINDH"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["SINDH"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["SINDH"]['inprogress']; ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["SINDH"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["SINDH"]['remaining']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      <?php }
                    ?>
                        <!-- Chart -->
                   
                    <!-- Punjab -->
                    <?php if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 ||  $this->encrypt->decode($_SESSION['login']['prcode'])==2) { ?>

                    <div class="col">

                        <div class="dashboard-card" data-district="PUNJAB" data-id="2">
                            <div class="ps-header-container">
                                <div  style="    background: linear-gradient(to right, #a53c27 0%, #d38a7c 35%, #f8eeeb 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/punjabmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[2];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo $totalcluster["list"][6]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div id="punjab" class="chart-container"></div>

                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 50%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["PUNJAB"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["punjab"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo  $per["punjab"]['inprogress']; ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["punjab"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo  $per["punjab"]['remaining']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                     <div class="col">
                        <h4 class="block-title">Total Province</h4>
                        <div id="totalpro"></div>
                    </div>
                    <!-- KPK -->
                    <?php  if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 || $this->encrypt->decode($_SESSION['login']['prcode'])==1) { ?>
                    <div class="col">
                        <div class="dashboard-card" data-district="KHYBER PAKHTUNKHWA" data-id="1">
                            <div class="ps-header-container">
                                <div  style="  background: linear-gradient(to right, #3f5378 0%, #9eb2d5 35%, #deeaff 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/KPKmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[1];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo $totalcluster["list"][5]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>


                            <div id="khyber_pakhtunkhwa" class="chart-container"></div>
                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 75%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["KHYBER PAKHTUNKHWA"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["KHYBER PAKHTUNKHWA"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["KHYBER PAKHTUNKHWA"]['inprogress']; ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["KHYBER PAKHTUNKHWA"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["KHYBER PAKHTUNKHWA"]['remaining']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Gilgit-Baltistan -->
                    <?php if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 || $this->encrypt->decode($_SESSION['login']['prcode'])==7) { ?>

                    <div class="col">
                        <div class="dashboard-card" data-district="Gilgit-Baltistan" data-id="7">
                            <div class="ps-header-container">
                                <div style="background: linear-gradient(to right, #183703 0%, #6f8a67 35%, #e0f3da 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/gilgitmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[7];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo $totalcluster["list"][2]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div id="gilgit_baltistan" class="chart-container"></div>
                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 45%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["GILGIT-BALTISTAN"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["GILGIT-BALTISTAN"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["GILGIT-BALTISTAN"]['inprogress']; ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["GILGIT-BALTISTAN"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo  $per["GILGIT-BALTISTAN"]['remaining']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- AJK -->
                    <?php     if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 || $this->encrypt->decode($_SESSION['login']['prcode'])==8) { ?>

                    <div class="col">
                        <div class="dashboard-card" data-district="AZAD JAMMU & KASHMIR" data-id="8">
                            <div class="ps-header-container">


                                <div style="    background: linear-gradient(to right, #f77c7c 0%, #e19090 35%, #f4dfdf 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/Kashimirmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[8];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo  $totalcluster["list"][0]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div id="azad_jammu_and_kashmir" class="chart-container"></div>
                            <div class="progress-details">
                                <!-- <div class="detail-row completed">
                                    <div class="icon-label">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span class="label">Completed</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar green" style="width: 70%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $completed["AZAD JAMMU & KASHMIR"]; ?></span>
                                    </div>
                                </div> -->
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?=$per["azad_jammu_and_kashmir"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["azad_jammu_and_kashmir"]['inprogress'] ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["azad_jammu_and_kashmir"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo  $per["azad_jammu_and_kashmir"]['remaining'] ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                      <!-- ISLAMABAD -->
                    <?php if($this->encrypt->decode($_SESSION['login']['idGroup']) ==1 || $this->encrypt->decode($_SESSION['login']['prcode'])==6) { ?>

                    <div class="col">
                        <div class="dashboard-card" data-district="ISLAMABAD" data-id="6">
                            <div class="ps-header-container">


                                <div style="    background: linear-gradient(to right, #f77c7c 0%, #e19090 35%, #f4dfdf 70%, #ffffff 100%);" class="ps-state-info-bar">
                                    <div class="ps-map-icon-wrapper">

                                        <img src="<?php echo base_url('assets/images/Kashimirmap.png'); ?>" alt="Map of India Icon" class="ps-dummy-map-image">

                                    </div>
                                    <div class="ps-state-name-wrapper">
                                        <span class="ps-state-name">     <?php                 
                                       echo $dist_array[6];
                                        ?></span>
                                        <span class="ps-total-count"><?php echo  $totalcluster["list"][6]['clusters_by_district']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div id="islamabad" class="chart-container"></div>
                            <div class="progress-details">
                            
                                <div class="detail-row on-going">
                                    <div class="icon-label">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span class="label">In Progress</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar orange" style="width: <?= $per["ISLAMABAD"]['inprogress'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["ISLAMABAD"]['inprogress'] ?>%</span>
                                    </div>
                                </div>
                                <div class="detail-row remaining">
                                    <div class="icon-label">
                                        <i class="bi bi-pause-circle-fill text-danger"></i>
                                        <span class="label">Pending</span>
                                    </div>
                                    <div class="bar-and-percentage">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar red" style="width: <?= $per["ISLAMABAD"]['remaining'] ?>%;"></div>
                                        </div>
                                        <span class="percentage"><?php echo $per["ISLAMABAD"]['remaining'] ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    ?>

                 

                </div>
                <div id="ucsSection" class="d-none">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <button style="color: #ffffff; border-radius: 30px; border-color: #ffffff; box-shadow: 0px 1px 4px 1px #b5b5b58a; background: #9bc3c0;" id="backButton" class="btn btn-sm btn-outline-dark">← Back</button>

                        <h4 id="ucsTitle" style="padding: 0; margin: 0; font-size: 30px; color: #b2d3d0; font-weight: bold;">[Your Title Here]</h4>

                        <div class="d-flex align-items-center">
                            <input id="ucsSearchInput" type="text" class="form-control me-2" placeholder="Search District..." style="width: 200px;">
                            <button id="ucsSearchButton" class="btn btn-primary">Search</button>
                        </div>
                    </div>
<!--                    <div class="d-flex align-items-center mb-4">-->
<!--                        <button style="color: #ffffff;border-radius: 30px;border-color: #ffffff;box-shadow: 0px 1px 4px 1px #b5b5b58a;background: #9bc3c0;" id="backButton" class="btn btn-sm btn-outline-dark">← Back</button>-->
<!--                        <h4 id="ucsTitle" style="    padding: 8px 0px 0px 19px;-->
<!--                            font-size: 30px;-->
<!--                            color: #b2d3d0;-->
<!--                            font-weight: bold;"></h4>-->
<!---->
<!---->
<!--                    </div>-->
                    <br>
                    <div id="ucsCards" class="row row-cols-1 row-cols-md-4 g-4"></div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <script>
        TotalProvince();
        districtprogress();
        totalprogress();

        // Province Progress
        function districtprogress() {
            // PHP array converted to JS object
            let per = <?php echo json_encode($per); ?>;
            // let district = <?php echo json_encode($dist_array); ?>;
            let completed = <?php echo json_encode($completed); ?>;

            //    console.log(completed);

               
            // Get all chart containers dynamically (assume they have IDs like Chart1, Chart2...)
            let chartIndex = 1;
            // console.log(district);
            
            for (let district in per) {
                // console.log(district);
                
                if (district === "total"||district === "training" ) continue; // skip total if needed
                    var value = per[district];
                                // console.log(district);

                 let name = district.replace(/_/g, ' ');
                name = name.toUpperCase();
                    // console.log(name);
                    
                result=value.completed;
                // console.log(result.completed);
                
                // Make dynamic options for each chart
                let options = {
                    series: [result],
                    chart: {
                        height: 200,
                        type: 'radialBar',
                        offsetY: -10
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -135,
                            endAngle: 135,
                            dataLabels: {
                                name: {
                                    offsetY: 20,
                                    fontSize: '11px',
                                    color: '#31aa80'
                                },
                                value: {
                                    offsetY: -10,
                                    fontSize: '20px',
                                    color: '#000000',
                                    formatter: function (val) {
                                        return val + "%";
                                    }
                                }
                            }
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            shadeIntensity: 0.15,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 50, 65, 91],
                            gradientToColors: ['#3ccca5']
                        }
                    },
                    stroke: { dashArray: 4 },
                    colors: ['#0d9595'],
                    // labels: ['Balochistan','Sindh','Punjab','Khyber Pakhtunkhwa','Gilgit-Baltistan','Azad Jammu & Kashmir'] // show district name
                    // labels:[name]
                    labels:[
                     [ "Completed: "+ completed[name]]
                       ]
                };

                let chartContainer = document.querySelector("#" + district);

                if (chartContainer) {
                    let chart = new ApexCharts(chartContainer, options);
                    chart.render();
                }

                chartIndex++;
            }
        }
            //Total Sum
        function totalprogress(){
            var sum = <?php echo json_encode($sum, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
            
            
           
            var options = {
                series: [sum.completed, sum.ip, sum.total],
                chart: {
                    height: 250,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 5,
                            size: '30%',
                            background: 'transparent',
                            image: undefined,
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                show: false,
                            }
                        },
                        barLabels: {
                            enabled: true,
                            useSeriesColors: true,
                            offsetX: -8,
                            fontSize: '16px',
                            formatter: function(seriesName, opts) {
                                return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                            },
                        },
                    }
                },
                colors: ['#126e5c', '#3b9886', '#446059', '#9dbab3'],
                labels: [ 'Complete', 'In Progress', 'Pending'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            show: false
                        }
                    }
                }]
            };

            var cluster = new ApexCharts(document.querySelector("#totalclusterchart"), options);
            var Ucs = new ApexCharts(document.querySelector("#totalUcsChart"), options);

            Ucs.render();
            cluster.render();
        }

        //Page 2 province ->district
        document.addEventListener("DOMContentLoaded", () => {
            const districtCards = document.querySelectorAll(".dashboard-card");
            const districtCardsSection = document.getElementById("districtCardsSection");
            const ucsSection = document.getElementById("ucsSection");
            const backButton = document.getElementById("backButton");
            const ucsTitle = document.getElementById("ucsTitle");
            const ucsCards = document.getElementById("ucsCards");       
                    
            // ✅ Example UCS data per district
          

            // ✅ Click handler for district cards
            districtCards.forEach(card => {
               
                // console.log(card);
                
                   card.addEventListener("click", () => {
                    // console.log('here');
                    // return false;
                    const district = card.dataset.district;   // Already using
                    const districtId = card.dataset.id;       // NEW → data-id read

                    showUcsSection(districtId,district); // If you want to pass ID instead
                });
            });

            
            // Page 2  Province-> District with on click on status
            function showUcsSection(districtId, district) {
               
               
               
                $.ajax({
                    url: "Data_collection_progress/dc_index/" + districtId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {

                       
                        // Prepare dynamic UCS data
                        const data = [];
                        for (let distName in response.per) {
                           
                            data.push({
                                name: distName,
                                progress: response.per[distName].percentage || 0,
                                completed: response.per[distName].completed || 0,
                                ongoing: response.ip[distName]|| 0,
                                remaining: response.per[distName].total|| 0
                            });
                        }

                        // Sort descending by progress
                        data.sort((a, b) => b.progress - a.progress);
                         
                        // Hide district cards, show UCS section
                        districtCardsSection.classList.add("d-none");
                        ucsSection.classList.remove("d-none");
                        ucsTitle.textContent = `${district} - UCS Details`;
                        ucsCards.innerHTML = "";

                        // Create UCS cards
                        data.forEach((ucs, index) => {

                               id=response.per[ucs.name].id;
                            //    console.log(id);
                               
                            const ucsCard = document.createElement("div");
                            ucsCard.className = "col";

                            ucsCard.innerHTML = `
                                <div class="dashboard-card p-3 text-center" data-id="${id}" data-ucs="${ucs.name}">
                                    <div class="card-header-new mb-2">
                                        <div class="location-name-new">${ucs.name}</div>
                                    </div>

                                    <!-- Chart section (Completed Click) -->
                                    <div id="chart-${id}-${index}" 
                                        class="chart-container progress-c"
                                        style="height: 180px; cursor:pointer;">
                                    </div>

                                    <div class="text-center mt-2">
                                        <div class="status-row">

                                            <!-- Ongoing -->
                                            <span class="badge bg-warning text-dark me-1 progress-ip" style="cursor:pointer;">
                                                Ongoing: ${ucs.ongoing}
                                            </span>

                                            <!-- Pending -->
                                            <span class="badge bg-danger progress-r" style="cursor:pointer;">
                                                Pending: ${ucs.remaining}
                                            </span>

                                             <!-- Completed -->
                                             <span class="badge bg-primary progress-cp" style="cursor:pointer;">
                                                Completed: ${ucs.completed}
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            `;

                            ucsCards.appendChild(ucsCard);

                            // Percent Value
                            var value = response.per[ucs.name].percentage;

                            // Apex radial chart
                            var chartOptions = {
                                series: [value],
                                chart: {
                                    height: 180,
                                    type: 'radialBar',
                                    sparkline: { enabled: true }
                                },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -135,
                                        endAngle: 135,
                                        hollow: { size: '70%' },
                                        track: { background: '#f0f0f0' },
                                        dataLabels: {
                                            name: { show: false },
                                            value: {
                                                fontSize: '22px',
                                                show: true,
                                                formatter: val => `${Math.round(val)}%`
                                            }
                                        }
                                    }
                                },
                                colors: ['#7b5cff']
                            };

                            const chartEl = document.querySelector(`#chart-${id}-${index}`);
                            const chart = new ApexCharts(chartEl, chartOptions);
                            chart.render();

                            // ---------------------------
                            // CLICK EVENTS
                            // ---------------------------

                            // Completed (chart click)
                            if (chartEl) {
                                chartEl.addEventListener("click", () => {
                                    const cardId = ucsCard.querySelector(".dashboard-card").dataset.id;
                                    dashboard_dt(cardId, "c");
                                });
                            }

                            // Ongoing Click
                            const ipEl = ucsCard.querySelector(".progress-ip");
                            if (ipEl) {
                                ipEl.addEventListener("click", () => {
                                 const cardId = ucsCard.querySelector(".dashboard-card").dataset.id;

                                    dashboard_dt(cardId, "ip");
                                });
                            }
                              const ipE2 = ucsCard.querySelector(".progress-cp");
                            if (ipE2) {
                                ipE2.addEventListener("click", () => {
                                 const cardId = ucsCard.querySelector(".dashboard-card").dataset.id;

                                    dashboard_dt(cardId, "c");
                                });
                            }


                            // Pending Click
                            const rEl = ucsCard.querySelector(".progress-r");
                            if (rEl) {
                                rEl.addEventListener("click", () => {
                                 const cardId = ucsCard.querySelector(".dashboard-card").dataset.id;

                                    dashboard_dt(cardId, "r");
                                });
                            }

                        }); // end foreach

                        const searchBtn = document.getElementById("ucsSearchButton");
                        const searchInput = document.getElementById("ucsSearchInput");


                        if (!searchBtn.dataset.bound) {

                            searchBtn.addEventListener("click", ucsSearch);
                            searchInput.addEventListener("keyup", e => {
                                if (e.key === "Enter") ucsSearch();
                            });

                            searchBtn.dataset.bound = "1";
                        }

                    },
                    error: function (xhr, status, error) {
                        console.log("AJAX Error:", error);
                    }
                });
            }

            function dashboard_dt(districtId, status) {

        
            window.open(
                    "Data_collection_progress/dc_dt?district_id=" + districtId + "&status=" + status,
                    "_blank"
                );

            }




            // ✅ Back button functionality
            backButton.addEventListener("click", () => {
                ucsSection.classList.add("d-none");
                districtCardsSection.classList.remove("d-none");
            });
        });

        // ✅ SEARCH FUNCTIONALITY
        document.getElementById("searchButton").addEventListener("click", () => {
            const query = document.getElementById("searchInput").value.trim().toLowerCase();
            // Search only looks at cards that are currently visible (i.e., not the ucsSection)
            const cards = document.querySelectorAll("#districtCardsSection .dashboard-card");

            if (query === "") {
                // Show all cards if input empty
                cards.forEach(card => card.closest(".col").classList.remove("d-none"));
            } else {
                cards.forEach(card => {
                    const name = card.querySelector(".location-name-new").textContent.toLowerCase();
                    if (name.includes(query)) {
                        card.closest(".col").classList.remove("d-none");
                    } else {
                        card.closest(".col").classList.add("d-none");
                    }
                });
            }
        });

        // // ✅ Optional: Enable live search when pressing Enter
        // document.getElementById("searchInput").addEventListener("keypress", e => {
        //     if (e.key === "Enter") document.getElementById("searchButton").click();
        // });

        function ucsSearch() {

            const q = document.getElementById("ucsSearchInput").value.trim().toLowerCase();
            const cards = document.querySelectorAll("#ucsCards .dashboard-card");

            cards.forEach(card => {
                const name = card.dataset.ucs.toLowerCase();
                card.closest(".col").classList.toggle("d-none", q && !name.includes(q));
            });
        }

        // Place this script block at the end of your HTML body or in a dedicated JS file
        function TotalProvince(){

            var per = <?php echo json_encode($per, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
            // console.log(per);
            
            
            // let provinces = Object.keys(per);
            // let completedValues = provinces.map(p => per[p].completed);
            let provinces = Object.keys(per).map(name => {
                return name
                    .replace(/_/g, " ")
                    .split(" ")
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                    .join(" ");
            });

            let completedValues = Object.keys(per).map(p => per[p].completed);
                //    console.log(completedValues);

            var options = {
                series: [{
                    name: 'Province',
                    // data: [per['punjab'], per['sindh'], per['balochistan'], per['khyber_pakhtunkhwa'], per['azad_jammu_and_kashmir'], per['gilgit_baltistan']]
                    data: completedValues
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5,
                        borderRadiusApplication: 'end'
                    },
                },
                colors: ['#81a8a8'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    // categories: ['Punjab', 'Sindh', 'Balochistan', 'KPK', 'AJK', 'Gilgit-Baltistan'],
                    categories: provinces
                },
                // yaxis: {
                //     title: {
                //         text: '$ (thousands)'
                //     }
                // },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#totalpro"), options);
            chart.render();

        }




    </script>


    </body>
    </html>