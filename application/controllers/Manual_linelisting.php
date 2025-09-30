<?php

class Manual_linelisting extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
//        $this->load->model('mmanual_linelisting');
        $this->load->model('custom');
        $this->load->model('msettings');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $district = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $district = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $dist_list = $MCustom->getDistricts($district);
        $data['dist'] = $dist_list;

        $uc = '';
        $cluster = '';
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $uc = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        }
        if (isset($_GET['c']) && $_GET['c'] != '') {
            $cluster = $_GET['c'];
        }

        $data['slug_district'] = $district;
        $data['slug_uc'] = $uc;
        $data['slug_cluster'] = $cluster;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('manual_linelisting', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function insertData()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['cluster_select']) || $_POST['cluster_select'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['total_structure_identified']) || $_POST['total_structure_identified'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();
        }

        if (!isset($_POST['total_household_identified']) || $_POST['total_household_identified'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();
        }
        if (!isset($_POST['total_residential_structures']) || $_POST['total_residential_structures'] == '') {
            $flag = 1;
            $result = 13;
            echo $result;
            exit();
        }
        /* if (!isset($_POST['household_targeted_children']) || $_POST['household_targeted_children'] == '') {
             $flag = 1;
             $result = 5;
             echo $result;
             exit();
         }*/

        if (!isset($_POST['option']) || $_POST['option'] == '') {
            $flag = 1;
            $result = 10;
            echo $result;
            exit();
        }

        if (!isset($_POST['linelisting_date']) || $_POST['linelisting_date'] == '') {
            $flag = 1;
            $result = 12;
            echo $result;
            exit();
        }

        if ($flag == 0) {
            $cluster = $_POST['cluster_select'];

            $M = new Custom();
            $data = $M->getClustersData($cluster);

            if (isset($data) && $data != '') {
                $Custom = new Custom();
                $formArray = array();
                $formArray['col_dt'] = date('Y-m-d H:i:s');
                $formArray['clustercode'] = $cluster;
                $formArray['enumcode'] = $data[0]->dist_id;
                $formArray['enumstr'] = $data[0]->geoarea;
                $formArray['formdate'] = date('d-m-y', strtotime($_POST['linelisting_date']));
                $formArray['gpstime'] = date('H:i:s');
                $formArray['hh02'] = $cluster;
                $formArray['projectname'] = 'TPVICS2020-LINELISTING';
                $formArray['tot_str'] = $_POST['total_structure_identified'];
                $formArray['tot_hh'] = $_POST['total_household_identified'];
                $formArray['hh07n'] = $_POST['total_residential_structures'];
                $formArray['data_collected'] = 'Manual';
                $formArray['username'] = $_SESSION['login']['UserName'];
                $formArray['sysdate'] = date('Y-m-d H:i:s');


                foreach ($_POST['option'] as $opt) {
                    $formArray['hh03'] = $opt['structure_number'];
                    $formArray['hh08a1'] = '1';
                    $formArray['hh07'] = $opt['household_no'];
                    $formArray['hh08'] = $opt['household_name'];
                    $formArray['hh13'] = $opt['childAge'];
                    $formArray['hh12'] = '1';
                    $formArray['tabNo'] = 'A';
                    $uid = $cluster . '_' . $formArray['tabNo'] . '_' . $formArray['hh07'] . '_' . $formArray['hh03'];
                    $formArray['UID'] = $uid;

                    $InsertData = $Custom->Insert($formArray, 'col_id', 'listings', 'N');
                    if ($InsertData) {
                        $result = 1;
                    } else {
                        $result = 8;
                    }
                }


            } else {
                $result = 7;
            }


            $trackarray = array("action" => "Manual Linelisting -> Function: insertData() Manual Linelisting ",
                "activityName" => "Manual Linelisting insertData",  "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 9;
        }
        echo $result;
    }


}

?>