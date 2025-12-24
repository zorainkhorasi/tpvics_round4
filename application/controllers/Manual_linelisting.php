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
        //$dist_list = $MCustom->getDistricts($district);
        $pan_list = $MCustom->getDistirctData();
        $data['pa_list'] = $pan_list;

        $uc = '';
        $cluster = '';
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $uc = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        }
        if (isset($_GET['c']) && $_GET['c'] != '') {
            $cluster = $_GET['c'];
        }
        // echo 1;
        // die();
        $data['slug_p'] = $pan_list;
        $data['slug_distirct'] = $pan_list;
        $data['slug_uc'] = $uc;
        $data['slug_cluster'] = $cluster;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('manual_linelisting', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function getClustersData()
    {
        $MCustom = new Custom();
        $pan_list = $MCustom->getClustersNumber($_POST['district_select']);

        echo json_encode($pan_list);die;
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

            if (!empty($data)) {

                $Custom = new Custom();
                $mainArray = [];
                $hhids = [];   // store A-0001-001 type IDs

                foreach ($_POST['option'] as $opt) {

                    $hh04 = str_pad($opt['structure_number'], 3, '0', STR_PAD_LEFT); // 0001
                    $hh07 = str_pad($opt['household_no'], 2, '0', STR_PAD_LEFT);     // 001

                    // Unique ID check inside POST
                    $hhid = 'A-' . $hh04 . '-' . $hh07;

                    if (in_array($hhid, $hhids)) {
                        echo 99;   // Duplicate found
                        exit();
                    }

                    $hhids[] = $hhid;

                    // Build insert array
                    $temp = [];
                    $temp['col_dt']      = date('Y-m-d H:i:s');
                    $temp['cluster']     = $cluster;
                    $temp['hh01']     = $cluster;
                    $temp['enumcode']    = $data[0]->dist_id;
                   // $temp['enumstr']     = $data[0]->geoarea;
                    $temp['geoarea']     = $data[0]->geoarea;
                    $temp['formdate']    = date('d-m-y', strtotime($_POST['linelisting_date']));
                    $temp['xdt']     = date('H:i:s');
                   // $temp['hh02']        = $cluster;
                    $temp['projectname'] = 'TPVICS_R3';
                    $temp['tot_str']     = $_POST['total_structure_identified'];
                    $temp['tot_hh']      = $_POST['total_household_identified'];
                    $temp['hh07n']       = $_POST['total_residential_structures'];
                    $temp['data_collected'] = 'Manual';
                    $temp['username']    =  $this->encrypt->decode($_SESSION['login']['username']);
                    $temp['sysdate']     = date('Y-m-d H:i:s');

                    // Loop-specific fields
                    $temp['hh04']     = $hh04;
                    $temp['hh05']     = $hh07;
                    $temp['hh07']     = 1;
                    $temp['hh08']     = '1';
                    $temp['hh11']     = $opt['household_name'];
                    $temp['hh13']     = 1;
                    $temp['hh14']     = 1;
                    $temp['hh14a']     = $opt['childAge'];
                  //  $temp['hh15']     = ;
                   // $temp['hh12']     = '1';
                    $temp['tabNo']    = 'A';

                    // UID
                    $temp['_uid'] = $cluster . '_A_' . $hh07 . '_' . $hh04;

                    $mainArray[] = $temp;
                }

                // FINAL INSERT (BATCH)
                $InsertData = $this->db->insert_batch('listings', $mainArray);

                if ($InsertData) {

                    if (isset($_POST['facility_type']) && is_array($_POST['facility_type'])) {
        
                        // 2. Array ko comma-separated string mein convert karein
                        // $facility_string = implode(", ", $_POST['facility_type']);

                    }

                    $update_data = [
                        'village'      => $this->input->post('village'),
                        'hfname'      => $this->input->post('hf'),

                         'lat'      => $this->input->post('lat'),
                        'lng'      => $this->input->post('lng'),
                        'hftype'      => $this->input->post('facility_type'),

                        'vac_name'     => $this->input->post('name_of_vaccinator'),
                        'vac_freq'     => $this->input->post('vaccinator_frequency'),
                        'vac_lvisit'   => $this->input->post('vaccinator_visit_date'),

                        'lhw_name'     => $this->input->post('name_of_lhw'),
                        'lhw_freq'     => $this->input->post('lhw_frequency'),
                        'lhw_lvisit'   => $this->input->post('lhw_visit_date'),

                        'polio_name'   => $this->input->post('name_of_polio'),
                        'polio_freq'   => $this->input->post('polio_frequency'),
                        'polio_lvisit' => $this->input->post('polio_visit_date'),
                    ];

                    $this->db->where('cluster_no', $cluster);
                    $this->db->update('clusters', $update_data);



                    echo 1;  // success
                } else {
                    echo 8;  // insert error
                }

            } else {
                echo 7; // no data
            }



            $trackarray = array("action" => "Manual Linelisting -> Function: insertData() Manual Linelisting ",
                "activityName" => "Manual Linelisting insertData",  "result" => $InsertData, "PostData" => $mainArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 9;
        }
        echo $result;
    }

    public function checkClusterExists()
    {
        $cluster_no = $this->input->post('cluster');

        // Check in listings table
        $exists = $this->db->where('cluster', $cluster_no)
            ->where("(colflag IS NULL OR colflag = '0')")
            ->get('listings')
            ->num_rows();


        $this->db->select('*');
        $this->db->from('clusters');
        $this->db->where("(colflag IS NULL OR colflag = '0')");
        $this->db->where('cluster_no', $cluster_no);
        $this->db->order_by('cluster_no', 'ASC');
        $query = $this->db->get();
        $cluster_data = $query->result();
        echo json_encode([
            'exists'        => $exists,
            'cluster_data'  => $cluster_data
        ]);
        die;
    }



}

?>