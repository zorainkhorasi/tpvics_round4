<?php error_reporting(0);
ini_set('memory_limit', '256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');

class Dashboard extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mlinelisting');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', '');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('welcome', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Dashboard Main",
            "action" => "View Dashboard -> Function: Dashboard/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }


    function linelisting_dashboard()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'dashboard/linelisting_dashboard');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 1;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            }

            $MLinelisting = new MLinelisting();

            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);


            $dist_array = array();
            if (isset($district) && $district != '') {
                foreach ($getClustersProvince as $k => $v) {
                    $my_id = $v->my_id;
                    $dist_array[$my_id] = $v->my_name;
                }
            } else {
                foreach ($getClustersProvince as $k => $v) {
                    $my_id = $v->my_id;
                    $dist_array[$my_id] = $v->my_name;
                }
            }
            $data['dist_array'] = $dist_array;

            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);

            $totalcluster = 0;
            foreach ($totalClusters_district as $k => $r) {
                $myTotalArray = array();
                $myTotalArray['clusters_by_district'] = $r->clusters_by_district;
                $totalcluster = $totalcluster + $r->clusters_by_district;

                $myTotalArray['id'] = $r->my_id;
                foreach ($dist_array as $key => $dist_name) {
                    if ($key == $r->my_id) {
                        $data['d' . $r->my_id . '_total'] = $r->clusters_by_district;
                        $myTotalArray['district'] = $dist_name;
                    }
                }
                $clusters_by_district[] = $myTotalArray;
            }

            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;


            // echo '<pre>';print_r($totalClusters_district);exit;

            /*==============Completed Clusters List==============*/
            $completedClusters_district = $MLinelisting->completedClusters_district($district, $sub_district, $level);


            //echo '<pre>';print_r($completedClusters_district);die;
            if (isset($district) && $district != '') {
                foreach ($dist_array as $k => $dist_name) {
                    $data['total'][$dist_name] = 0;
                    $data['completed'][$dist_name] = 0;
                    $data['ip'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['total'][$dist_name] = 0;
                        $data['completed'][$dist_name] = 0;
                        $data['ip'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;

                    }
                }
            }

            $data['total']['total'] = 0;
            $data['completed']['total'] = 0;
            $data['ip']['total'] = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key && $row->collecting_tabs != '' && $row->collecting_tabs != 0) {
                        $data['total']['total']++;
                        $data['total'][$dist_name]++;
                        if ($row->collecting_tabs == $row->completed_tabs) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        } else {
                            $data['ip'][$dist_name]++;
                            $data['ip']['total']++;
                        }
                    }
                }
            }

            /*==============Remaining Clusters List==============*/
            $data['r']['total'] = 0;


            foreach ($totalClusters_district as $row2) {
                $ke = $row2->my_id;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        $data['r'][$dist_name] = $row2->clusters_by_district - $data['total'][$dist_name];
                        $data['r']['total'] += $data['r'][$dist_name];
                    }
                }
            }
            
            

            $formated_data=$this->linelisting_new_dashboard();
                         
         
            $data['per']=$formated_data;
               /* echo "<pre>";
              print_r($data['completed']);
             echo "</pre>";DIE;*/
      
            $sum=$this->calculateTotal($data['completed'],$data['ip'],$data['r']);
          
            $data['sum']=$sum;


          //  echo $this->encrypt->decode($_SESSION['login']['prcode']);die;
          
            /*  echo "<pre>";
              print_r($data);
              echo "</pre>";*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('linelisting_new', $data);
            //  $this->load->view('linelisting_old', $data);

            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "LineListing Province Dashboard",
            "action" => "View LineListing Province Dashboard -> Function: Dashboard/linelisting_dashboard()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function calculateTotal($completed,$ip,$total){

        //    echo "<pre>";
        //      print_r($completed);
        //      echo "</pre>";
         
        $sum=[
            'total'=>0,
            // 'remaining'=>0,
            'ip'=>0,
            'completed'=>0
        ];
        // $sum['completed']=$completed;

        foreach ($completed as $k => $d) {
            if($k=='total')continue;
            $sum['completed'] += $d;
        }
        foreach ($ip as $k => $d) {
             if($k=='total')continue;
            $sum['ip'] += $d;
        }
        foreach ($total as $k => $d) {
            
          if($k=='total' || $k=='Training' || $k=='ISLAMABAD')continue;
         
            $sum['total'] += $d;
        }
        // foreach ($total as $district => $data) {
        //  $sum['total'] += isset($data['total']) ? $data['total'] : 0;
        // $sum['total']=$total;
        // }
      

        return $sum;

    }
    function linelisting_new_dashboard()
    {
        $data = array();
        $MSettings = new MSettings();

        $district = '';
        $sub_district = '';
        $level = 1;
        $MLinelisting = new MLinelisting();
        /*==============Total Clusters List==============*/
        $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);

        $n = [];
        foreach ($totalClusters_district as $v) {
            $n[] = [
                'my_id' => $v->my_id,
                'my_name' => $v->my_name,
                'total' => $v->clusters_by_district,
                'completed' => 0,
                'pending' => 0,
                'remaining' => 0,
            ];
        }

        /*==============Completed Clusters List==============*/
        $completedClusters_district = $MLinelisting->completedClusters_district($district, $sub_district, $level);
        foreach ($n as $key => $v) {

            foreach ($completedClusters_district as $row) {
                if ($row->provinceId == $v['my_id'] && $row->collecting_tabs != '' && $row->collecting_tabs != 0) {
                    if ($row->collecting_tabs == $row->completed_tabs) {
                        $n[$key]['completed']++;
                    } else {
                        $n[$key]['pending']++;
                    }
                }
            }
            $n[$key]['remaining'] = $v['total'] - $n[$key]['completed'] - $n[$key]['pending'];
        }

     
            // echo "<pre>";
            // var_dump($n);

            $per = [];

            foreach ($n as $item) {

                $name = $item['my_name'];

                if (!isset($per[$name])) {
                    $per[$name] = [
                        'total' => 0,
                        'completed' => 0,
                        'percentage' => 0,
                        'remaining' => 0,
                        'pending' => 0
                    ];
                }

                // Add values (merge duplicates)
                $per[$name]['total'] += $item['total'];
                $per[$name]['completed'] += $item['completed'];
                $per[$name]['pending'] += $item['pending'];
                $per[$name]['remaining'] += $item['remaining'];
            }

            // Calculate final percentages
            foreach ($per as $name => $data) {
                $per[$name]['percentage'] = $data['total'] > 0    ? round(($data['completed'] / $data['total']) * 100,2) : 0;
                $per[$name]['remaining'] = $data['total'] > 0  ? round(($data['remaining'] / $data['total']) * 100,2) : 0;
                $per[$name]['pending'] = $data['total'] > 0 ? round(($data['pending'] / $data['total']) * 100,2) : 0;
            }
            //  echo "<pre>";
            // var_dump($per);
            // exit();

        return $per;

    }


    public function dashboard_index($districtId = null)
    {
        // echo "</pre>";
        // print_r($districtId);
        // exit();

        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights(
            $this->encrypt->decode($_SESSION['login']['idGroup']),
            '',
            'dashboard/linelisting_dashboard'
        );

        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {

            $sub_district = '';
            $level = 2;

            if (
                isset($data['permission'][0]->CanViewAllDetail) &&
                $data['permission'][0]->CanViewAllDetail != 1 &&
                isset($_SESSION['login']['district']) &&
                $this->encrypt->decode($_SESSION['login']['district']) != 0
            ) {
                $u_district = $this->encrypt->decode($_SESSION['login']['district']);
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $u_district = '';
            }

            $district = $districtId; // Use the ID sent via AJAX

            $MLinelisting = new MLinelisting();
            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);

            $dist_array = array();
            foreach ($getClustersProvince as $v) {
                $dist_array[$v->my_id] = $v->my_name;
            }
            $data['dist_array'] = $dist_array;




            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);
            $totalcluster = 0;
            $clusters_by_district = [];
            foreach ($totalClusters_district as $r) {
                $myTotalArray = array();
                $myTotalArray['clusters_by_district'] = $r->clusters_by_district;
                $totalcluster += $r->clusters_by_district;

                $myTotalArray['id'] = $r->my_id;
                $myTotalArray['district'] = isset($dist_array[$r->my_id]) ? $dist_array[$r->my_id] : '';
                $data['d' . $r->my_id . '_total'] = $r->clusters_by_district;

                $clusters_by_district[] = $myTotalArray;
            }
            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

          

            /*==============Completed & In Progress Clusters==============*/
            $completedClusters_district = $MLinelisting->completedClusters_district($district, $sub_district, $level);

            foreach ($dist_array as $dist_name) {
                $data['total'][$dist_name] = 0;
                $data['completed'][$dist_name] = 0;
                $data['ip'][$dist_name] = 0;
                $data['r'][$dist_name] = 0;
            }
            $data['total']['total'] = 0;
            $data['completed']['total'] = 0;
            $data['ip']['total'] = 0;

            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key && $row->collecting_tabs != '' && $row->collecting_tabs != 0) {
                        $data['total']['total']++;
                        $data['total'][$dist_name]++;
                        if ($row->collecting_tabs == $row->completed_tabs) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        } else {
                            $data['ip'][$dist_name]++;
                            $data['ip']['total']++;
                        }
                    }
                }
            }

            /*==============Remaining Clusters List==============*/
            $data['r']['total'] = 0;
            foreach ($totalClusters_district as $row2) {
                $ke = $row2->my_id;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        $data['r'][$dist_name] = $row2->clusters_by_district - $data['total'][$dist_name];
                        $data['r']['total'] += $data['r'][$dist_name];
                    }
                }
            }

          
             $per = [];
            // Step 1: Add total values
            foreach ($data['totalcluster']['list'] as $dist) {
                $per[$dist['district']] = [
                    'total' => $dist['clusters_by_district'],
                    'id' => $dist['id'],
                    'completed' => 0,        // default, will update later
                    'percentage' => 0
                ];
            }

            // Step 2: Add completed values
            foreach ($data['completed'] as $distName => $completedValue) {
                if (isset($per[$distName])) {
                    $per[$distName]['completed'] = $completedValue;
                }
            }

            // Step 3: Calculate percentage
            foreach ($per as $district => $value) {
                $total = $value['total'];
                $completed = $value['completed'];

                $per[$district]['percentage'] = ($total > 0)
                    ? intval(($completed / $total) * 100)  // no decimal
                    : 0;
            }

            $data['per']=$per;

         
            // Send JSON response for AJAX
            $this->output
                ->set_content_type('application/json')
                 ->set_output(json_encode( $data ));
            return; // important: stop execution here

        } else {
            // Not authorized
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Not authorized']));
            return;
        }
    }


    function dashboard_dt()
    {

        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'dashboard/linelisting_dashboard');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $district = '';
            }
                 $sub_district = $this->input->get('district_id'); // <- here
                 $cluster_type = $this->input->get('status'); 
                 $data['cluster_type'] = $this->input->get('status');

             
            $MLinelisting = new MLinelisting();

            // $district_cluster_type = $this->uri->segment(3);
            // $sub_district = '';
            // $cluster_type = '';
            // if (!empty($district_cluster_type)) {
            //     $sub_district_cluster_type = $this->uri->segment(4);
            //     if (!empty($sub_district_cluster_type)) {
            //         $sub_district = substr($sub_district_cluster_type, 1, 5);
            //     }
            //     $district = substr($district_cluster_type, 1, 3);
            //     $cluster_type = substr($district_cluster_type, 5, 1);
            // }
            // $data['sub_district'] = $sub_district;
            //    echo "<pre>";
            //      var_dump($data, $sub_district,$cluster_type);
            //      exit();
            /*============== Linelisting Data table ==============*/

            $data['cluster_type'] = $cluster_type;
            if ($cluster_type == 'c' || $cluster_type == 'ip' || $cluster_type == 'r') {

                $get_linelisting_table = $MLinelisting->get_linelisting_table($district, $cluster_type, $sub_district);
             
            } else {
                $get_linelisting_table = $MLinelisting->get_linelisting_table($district, '', $sub_district);
            }

            $get_ll_structures = $MLinelisting->get_ll_structures($district, $sub_district, '');
            $get_ll_res_structures = $MLinelisting->get_ll_res_structures($district, $sub_district, '');

           // echo '<pre>';print_r($get_ll_res_structures);die;


            $res = array();
            foreach ($get_linelisting_table as $key => $value) {
                $res[$value->cluster_no]['geoarea'] = $value->geoarea;
                $res[$value->cluster_no]['district'] = $value->district;
                $res[$value->cluster_no]['province'] = $value->province;
                $res[$value->cluster_no]['geoarea'] = $value->geoarea;
                $res[$value->cluster_no]['dist_code'] = $value->dist_code;
                $res[$value->cluster_no]['cluster_no'] = $value->cluster_no;
                $res[$value->cluster_no]['data_collected'] = $value->data_collected;
                $res[$value->cluster_no]['dist_id'] = $value->dist_id;
                $res[$value->cluster_no]['target_children'] = $value->target_children;
                $res[$value->cluster_no]['no_of_children'] = $value->no_of_children;
                $res[$value->cluster_no]['collecting_tabs'] = $value->collecting_tabs;
                $res[$value->cluster_no]['completed_tabs'] = $value->completed_tabs;
                $res[$value->cluster_no]['startActivity'] = $value->startActivity;
                $res[$value->cluster_no]['endActivity'] = $value->endActivity;
                $res[$value->cluster_no]['status'] = $value->status;
                $res[$value->cluster_no]['planning'] = $value->planning;
                $res[$value->cluster_no]['exphh'] = $value->exphh;
                $res[$value->cluster_no]['structures'] = 0;
                $res[$value->cluster_no]['randomized'] =$value->randomized;
                $res[$value->cluster_no]['residential_structures'] = 0;
            }
            foreach ($get_ll_structures as $structure) {
                if (isset($res[$structure->cluster_no]) && $res[$structure->cluster_no] != '') {
                    $res[$structure->cluster_no]['structures'] += $structure->structure;
                }
            }
            foreach ($get_ll_res_structures as $res_structure) {
                if (isset($res[$res_structure->cluster_no]) && $res[$res_structure->cluster_no] != '') {
                    $res[$res_structure->cluster_no]['residential_structures'] += 1;
                }
            }
            $data['get_linelisting_table'] = $res;
           
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('linelisting_datatable', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "LineListing Datatable Dashboard",
            "action" => "View LineListing Datatable Dashboard -> Function: Dashboard/dashboard_dt()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function systematic_randomizer()
    {
        $sample = 13;
        if (isset($_POST['cluster_no']) && $_POST['cluster_no'] != '') {
            $cluster = $_POST['cluster_no'];
            $MLinelisting = new MLinelisting();
            $get_rand_cluster = $MLinelisting->get_rand_cluster($cluster);
            $randomization_status = $get_rand_cluster[0]->randomized;

            $get_resdential_hh = $MLinelisting->get_resdential_hh($cluster);

         //   echo count($get_resdential_hh);die;

            if ($randomization_status == 1) {
                echo 2;
                $track_msg = 'Cluster is Already Randomized';
            }else if(count($get_resdential_hh) < 60) {
                echo 112;
                $track_msg = 'Not enough Residentials Households';
            }else {
                $chked = 0;
                $chkDuplicateTabs = $MLinelisting->chkDuplicateTabs($cluster);
                if (isset($chkDuplicateTabs) && count($chkDuplicateTabs) >= 1) {
                    $chked = 1;
                }
                /*$custom_dup_chk = array();
                foreach ($chkDuplicateTabs as $chk) {
                    if (in_array($custom_dup_chk[$chk->hltab], $custom_dup_chk)) {
                        $chked = 1;
                    } else {
                        $custom_dup_chk[$chk->hltab][] = $chk->deviceid;
                    }
                }*/

                if ($chked == 0) {
                    $get_systematic_rand = $MLinelisting->get_systematic_rand($cluster);
                    $cnt = count($get_systematic_rand);
                    if ($cnt >= 1) {

                        $cntData = count($get_systematic_rand);
                        $quotient = $this->_get_quotient($cntData, $sample);

                        $random_start = $this->_get_random_start($quotient);
                        $random_point = $random_start;
                        $index = floor($random_start);
                        if ($cntData > $sample) {
                            $ll = $sample;
                        } else {
                            $ll = $cntData;
                        }
                        $counter = 0;
                        for ($i = 0; $i < $ll; $i++) {
                            $form_data = array(
                                'updDt' => date('Y-m-d h:i:s'),
                                'randDT' => date('Y-m-d h:i:s'),
                                'uid' => $get_systematic_rand[$index - 1]->_uid,
                                'sno' => $i + 1,
                                'hhid' => $get_systematic_rand[$index - 1]->hhid,
                                'ssno' => $i + 1,
                                'hh02' => $get_systematic_rand[$index - 1]->cluster_no,
                                        'hl09' => $get_systematic_rand[$index - 1]->structure_no,
                                'hl10' => $get_systematic_rand[$index - 1]->hl02,
                                'hl11' => $get_systematic_rand[$index - 1]->hl14,
                                'hl12' => $get_systematic_rand[$index - 1]->hl12,
                                'total' => $cntData,
                                'randno' => $random_start,
                                'randomPick' => $index - 1,
                                'quot' => $quotient,
                                'dist_id' => $get_systematic_rand[$index - 1]->dist_code,
                                'compid' => $get_systematic_rand[$index - 1]->cluster_no . '-' . $get_systematic_rand[$index - 1]->hltab . "-" . str_pad($get_systematic_rand[$index - 1]->structure_no, 3, "0", STR_PAD_LEFT) . "-" . str_pad($get_systematic_rand[$index - 1]->hl02, 2, "0", STR_PAD_LEFT),
                                'hltab' => $get_systematic_rand[$index - 1]->hltab,
                                'user_id' => $this->encrypt->decode($_SESSION['login']['username'])
                            );

                            $MLinelisting->insert_blrandomize($form_data, 'Randomised');
                            $random_point = $random_point + $quotient;
                            $index = floor($random_point);
                            $counter = $counter + 1;
                        }
                        $updateCluster = array();
                        $updateCluster['randomized'] = 1;
                        $editData = $MLinelisting->update_cluster($updateCluster, 'cluster_no', $cluster, 'clusters');
                        if ($editData) {
                            echo 1;
                            $track_msg = 'Successfully inserted';
                        } else {
                            echo 2;
                            $track_msg = 'Error in saving data';
                        }
                    } else {
                        echo 3;
                        $track_msg = 'Cluster has Zero Households';
                    }
                } else {
                    echo 7;
                    $track_msg = 'Duplicate Household Found in Cluster, Please coordinate with DMU';
                }


            }
        } else {
            $track_msg = 'Invalid Cluster No';
            echo 4;
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Randomization",
            "action" => "Add Randomization -> Function: Dashboard/systematic_randomizer()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }


    private function _get_quotient($dataset, $sample)
    {
        if ($dataset > $sample) {
            $quotient = $dataset / $sample;
        } else {
            $quotient = 1;
        }
        return $quotient;
    }

    private function _get_random_start($quotient)
    {
        $random_start = rand(1, $quotient);
        return $random_start;
    }

    function make_pdf()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);

        if (isset($data['cluster']) && $data['cluster'] != '') {

            $this->load->library('tcpdf');
            $MLinelisting = new MLinelisting();

            $data['cluster_data'] = $MLinelisting->get_bl_randomized($data['cluster']);
            $data['randomization_date'] = substr($data['cluster_data'][0]->randDT, 0, 10);

            // Create PDF
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TPVICS SHRUC Round 4');
            $pdf->SetTitle('Cluster No: ' . $data['cluster']);
            $pdf->SetSubject('TPVICS SHRUC Round 4');

            // Header Data
            $geoarea = explode('|', $data['cluster_data'][0]->geoarea);

            $header = '<strong>TPVICS Round 3 - Cluster No: ' . $data['cluster'] . '</strong><br>
        Province: ' . $geoarea[0] . '<br>
        District: ' . $geoarea[1] . '<br>
        Tehsil: ' . $geoarea[2] . '<br>
        Area: ' . $data['cluster_data'][0]->geoarea . '<br>
        Planned Collection Date: ' . $data['cluster_data'][0]->collection_date . '
        --- Collector Name: ' . $data['cluster_data'][0]->collector_name . '
        --- Tablet ID: ' . $data['cluster_data'][0]->tablet_id;

            $pdf->setHtmlHeader('<p style="font-size:12px;border-bottom:1px solid black;">' . $header . '</p>');

            // Margins & Settings
            $pdf->SetMargins(10, 35, 10);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(10);
            $pdf->SetAutoPageBreak(TRUE, 10);

            $pdf->AddPage();

            // Randomization Date
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Write(0, 'Randomization Date: ' . $data['randomization_date'], '', 0, 'R', true);

            $pdf->SetFont('helvetica', '', 9);

            // Table Start
            $tbl = '<br><br><br><table border="1" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10%" align="center"><b>Serial No</b></th> 
                <th width="20%" align="center"><b>Household No</b></th>
                <th width="20%" align="center"><b>Head of Household</b></th>
                <th width="10%" align="center"><b>Assigned D/C</b></th>
                <th width="40%" align="center"><b>Remarks</b></th>
            </tr>';

            foreach ($data['cluster_data'] as $row) {

                $tbl .= '<tr>
                <td align="center">' . $row->sno . '</td> 
                <td align="center">' . $row->hltab . '-' . substr($row->compid, 12, 8) . '</td>
                <td align="center">' . ucfirst($row->hl11) . '</td>
                <td align="center" height="25"></td>
                <td align="center" height="25"></td>
            </tr>';
            }

            $tbl .= '</table>';

            // Write Table
            $pdf->writeHTML($tbl, true, false, false, false, '');

            // ✅ ADD IMAGE AT END (BEST METHOD)
            $image_path = FCPATH . 'assets/images/note.png';

            if (file_exists($image_path)) {
                $pdf->Ln(5); // space
                $pdf->Image($image_path, 15, $pdf->GetY(), 180, 0);            }

            // Output PDF
            $pdf->Output('cluster_' . $data['cluster'] . '.pdf', 'I');
        }
    }


    function make_log()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);

        if (isset($data['cluster']) && $data['cluster'] != '') {
            $this->load->library('tcpdf');

            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TPVICS Round 4');
            $pdf->SetTitle('Cluster No: ' . $data['cluster']);

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(TRUE, 10);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->AddPage();

            $query = $this->db->query("SELECT district, province, uc_name, area  FROM Clusters  WHERE cluster_no = ?", [$data['cluster']]);
            $result = $query->row();

            $province = '';
            $district = '';
            $uc       = '';
            $area     = '';

            if ($result) {
                $province = $result->province;
                $district = $result->district;
                $uc       = $result->uc_name;
                $area     = $result->area;
            }



            $html = '
        <style>
            .center { text-align: center; }
            .bold { font-weight: bold; }
            table.main-table { border-collapse: collapse; width: 100%; }
            table.main-table td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        </style>

        <div class="center">
            <span class="bold" style="font-size: 15pt;">Third Party Verification of Vaccine Immunization</span><br>
             <span class="bold" style="font-size: 15pt;">Coverage Survey (TPVICS-R3)</span><br>
            <span style="font-size: 11pt;">Cluster History Sheet</span><br>
            <span class="bold" style="font-size: 12pt;">Cluster Number - '.$data['cluster'].'</span>
        </div>

        <br><br>
        <table width="100%" cellpadding="2">
            <tr>
                <td width="50%">Province: ' . $province . '</td>
                <td width="50%">District Name: ' . $district . '</td>
            </tr>
            <tr>
                <td width="100%" colspan="2">UC Name : ' . $uc . '</td>
            </tr>
            <tr>
                <td width="100%" colspan="2">Area : ______________________________________________________________________</td>
            </tr>
        </table>

        <br>
                <br>
        <b style="font-size: 11pt;">Line Listing</b>
        <br>
        <br>
        <table class="main-table" cellpadding="5">
            <tr>
                <td width="20%">Tablet Number1<br>Tablet Number2</td>
                <td width="30%"></td>
                <td width="25%">Line Listing<br>Starting Date</td>
                <td width="25%"></td>
            </tr>
            <tr>
                <td>Data Collector Name1</td>
                <td></td>
                <td>Data Collector Name2</td>
                <td><i style="font-size: 7pt;">(If data collected in two tabs)</i></td>
            </tr>
            <tr>
                <td rowspan="2">Area/Village Name</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3" class="center"><i style="font-size: 7pt;">(Area name with land mark)</i></td>
            </tr>
            <tr>
                <td colspan="4"><b>Any Comments</b><br><br></td>
            </tr>
            <tr class="center">
                <td width="18%" class="bold">Total Structures</td>
                <td width="18%" class="bold">Total Households</td>
                <td width="18%" class="bold">Total Targeted Households</td>
                <td width="23%" class="bold">Listing Completion Date</td>
                <td width="23%" class="bold">Randomization Date</td>
            </tr>
            <tr height="30">
                <td height="30"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <br><br>
        <span>_________________________________</span><br>
        <span>Supervisor Name & Signature</span>

        <br><br>
        <div class="center">................................................................................................................................................................</div>

        <br>
        <b style="font-size: 11pt;">Data Collection</b>
        <table class="main-table" cellpadding="5">
            <tr>
                <td width="20%">Tablet Number</td>
                <td width="30%"></td>
                <td width="25%">Data Collection Starting Date</td>
                <td width="25%"></td>
            </tr>
            <tr>
                <td>Data Collector Name</td>
                <td></td>
                <td>Data Collector Name</td>
                <td></td>
            </tr>
        </table>

        <br><br>
        <span>_________________________________</span><br>
        <span>Supervisor Name & Signature</span>

        <br><br>
        <b>Any Observation/Comments:</b> ___________________________________________________________<br>
        ______________________________________________________________________________________
        ';

            if (ob_get_contents()) ob_end_clean();
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('TPVICS_Form_'.$data['cluster'].'.pdf', 'I');

        } else {
            echo 'Invalid Cluster';
        }
    }

    function cluster_p()
    {
        $this->load->library('tcpdf');


        $data = array();
        $data['cluster'] = $this->uri->segment(3);

        // Set page to Portrait, A4
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TPVICS');
        $pdf->SetTitle('Empty Survey Form');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins to match a standard form
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        // Use freeserif for Urdu character support
        $pdf->SetFont('freeserif', '', 9);
        $pdf->AddPage();

        $query = $this->db->query("SELECT district, province, uc_name, area  FROM Clusters  WHERE cluster_no = ?", [$data['cluster']]);
        $result = $query->row();

        $province = '';
        $district = '';
        $uc       = '';
        $area     = '';

        if ($result) {
            $province = $result->province;
            $district = $result->district;
            $uc       = $result->uc_name;
            $area     = $result->area;
        }


        $html = '
        <style>
            .center { text-align: center; }
            .bold { font-weight: bold; }
            table.main-table { border-collapse: collapse; width: 100%; }
            table.main-table td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        </style>

        <div class="center">
            <span class="bold" style="font-size: 15pt;">Third Party Verification of Vaccine Immunization</span><br>
            <span class="bold" style="font-size: 15pt;">Coverage Survey (TPVICS-R3)</span><br>
            <span style="font-size: 11pt;">Cluster Profile Sheet</span><br>
            <span class="bold" style="font-size: 12pt;">Cluster Number - '.$data['cluster'].'</span>
        </div>

        ';

        $html .= '
    <style>
        table { border-collapse: collapse; width: 100%; }
        td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        .header-text { text-align: right; font-size: 10pt; }
        .bg-grey { background-color: #f2f2f2; font-weight: bold; }
        .center { text-align: center; }
        .small-text { font-size: 8pt; }
        .box { width: 20px; height: 20px; border: 1px solid #000; display: inline-block; }
         table td {
        padding: 8px 6px;
        height: 25px;
        vertical-align: middle;
    }
    </style>

    <div class="header-text">
     
    <br>

    <table>
        <tr>
            <td width="15%" class="bg-grey">Province</td><td width="35%;" class="center">'.$province.'</td>
           <td width="15%" class="bg-grey">District</td><td width="35%;" class="center">'.$district.'</td>
        </tr>
        <tr>
            <td class="bg-grey">Tehsil</td><td></td>
           <td width="15%" class="bg-grey">Uc</td><td width="35%;" class="center">'.$uc.'</td>
        </tr>
        <tr>
            <td class="bg-grey">Area/Village</td><td></td>
            <td class="bg-grey">Is this cluster segmented?</td>
            <td>Yes [ ] &nbsp;&nbsp; No [ ]</td>
        </tr>
        <tr>
            <td class="bg-grey">Starting Point</td><td></td>
            <td rowspan="2" class="bg-grey">If yes, Number of households in each segment?</td>
            <td>
                <table width="100%" border="1" cellpadding="2">
                    <tr class="center"><td>A</td><td>B</td><td>C</td><td>D</td></tr>
                    <tr height="20"><td></td><td></td><td></td><td></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="bg-grey">End Point</td><td></td>
            <td>
                <table width="100%" border="1" cellpadding="2">
                   <tr height="20"><td></td><td></td><td></td><td></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bg-grey">Which segment is selected for line listings?</td>
            <td colspan="2">
                 <table width="40%" border="1" cellpadding="2" align="right">
                   <tr height="20"><td width="25%"></td><td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr class="bg-grey"><td colspan="4" style="background-color: #d9e1f2;">Community Representative</td></tr>
        <tr>
            <td width="15%">Name</td><td width="35%"></td>
            <td width="20%">Contact Number</td><td width="30%"></td>
        </tr>
        <tr>
            <td>Nearest Health Facility Name</td>
            <td></td>
            <td>Type of Facility</td>
            <td class="small-text">
                [ ] DHQ &nbsp; [ ] THQ &nbsp; [ ] RHC<br>
                [ ] BHU &nbsp; [ ] GD &nbsp; [ ] Private
            </td>
        </tr>
        <tr>
            <td>Polio Worker Name</td><td></td>
            <td colspan="2">
                <table width="100%" border="0" cellpadding="0">
                    <tr>
                        <td border="0" width="30%">Vaccinator Name</td>
                        <td border="1" width="70%" height="20"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="small-text">LHW/CHW/Community Health Inspectors/Social Mobilizer Name</td>
            <td colspan="2"></td>
        </tr>
    </table>

    <br>

    <table class="small-text">
        <tr class="bg-grey center">
            <td width="33.3%">Frequency of polio workers\' visits in the area</td>
            <td width="33.3%">Frequency of the vaccinator\'s visits in the area</td>
            <td width="33.4%">Frequency of LHW/CHW/Community Health Inspectors/Social Mobilizers\' visits in the area</td>
        </tr>
        <tr>
            <td>' . $this->get_frequency_list() . '</td>
            <td>' . $this->get_frequency_list() . '</td>
            <td>' . $this->get_frequency_list() . '</td>
        </tr>
    </table>
    ';

        if (ob_get_contents()) ob_end_clean();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Survey_Form_Empty.pdf', 'I');
    }

// Helper function to generate the repeated list
    private function get_frequency_list() {
        return '
        1 &nbsp; Monthly <br>
        2 &nbsp; Quarterly <br>
        3 &nbsp; Twice a Year <br>
        4 &nbsp; Once a Year <br>
        5 &nbsp; During Campaign <br>
        6 &nbsp; Un-Covered Area <br>
        97 Not visited
    ';
    }


    function get_excel()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MLinelisting = new MLinelisting();
            $data['cluster_data'] = $MLinelisting->get_bl_randomized($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('get_excel', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Linelisting datatable excel",
            "action" => "Linelisting Excel -> Function: Dashboard/get_excel()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function addPlanning()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['planning_cluster']) || $_POST['planning_cluster'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            die();
        }

        if (!isset($_POST['planning_dist']) || $_POST['planning_dist'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            die();
        }

        if (!isset($_POST['listing_date']) || $_POST['listing_date'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            die();
        }
        if (!isset($_POST['dc1']) || $_POST['dc1'] == '' || $_POST['dc1'] == '0') {
            $flag = 1;
            $result = 5;
            echo $result;
            die();
        }
        if ($flag == 0) {
            $cluster = $_POST['planning_cluster'];
            $Custom = new Custom();
            $formArray = array();

            $formArray['listing_date'] = date('Y-m-d', strtotime($_POST['listing_date']));
            $formArray['tablets'] = $_POST['tablet_using'];
            $formArray['dc1'] = $_POST['dc1'];
            $formArray['dc2'] = $_POST['dc2'];
            $formArray['status'] = 1;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');

            $M = new MLinelisting();
            $data = $M->get_planning($cluster);
            if (isset($data) && $data[0]->cluster_no != '') {
                $InsertData = $Custom->Edit($formArray, 'cluster_no', $cluster, 'planning');
            } else {
                $formArray['cluster_no'] = $cluster;
                $formArray['province'] = substr($_POST['planning_cluster'], 0, 1);
                $formArray['dist'] = $_POST['planning_dist'];
                $InsertData = $Custom->Insert($formArray, 'id', 'planning', 'N');
            }


            if ($InsertData) {
                $result = 1;
            } else {
                $result = 6;
            }
            $trackarray = array("action" => "Dashboard/ Add Planning before randomization -> Function: addPlanning() Add Planning before linelisting randomization ",
                "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 4;
        }
        echo $result;
    }

    function add_dc_Planning()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['planning_cluster']) || $_POST['planning_cluster'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            die();
        }

        if (!isset($_POST['collection_date']) || $_POST['collection_date'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            die();
        }
        if (!isset($_POST['collector_name']) || $_POST['collector_name'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            die();
        }
        if (!isset($_POST['tablet_id']) || $_POST['tablet_id'] == '') {
            $flag = 1;
            $result = 7;
            echo $result;
            die();
        }
        if ($flag == 0) {
            $cluster = $_POST['planning_cluster'];
            $Custom = new Custom();
            $formArray = array();

            $formArray['collector_name'] = $_POST['collector_name'];
            $formArray['collection_date'] = date('Y-m-d', strtotime($_POST['collection_date']));
            $formArray['tablet_id'] = $_POST['tablet_id'];
            $formArray['status'] = 2;
            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');

            $M = new MLinelisting();
            $data = $M->get_planning($cluster);

            if (isset($data) && $data[0]->cluster_no != '') {
                $InsertData = $Custom->Edit($formArray, 'cluster_no', $cluster, 'planning');
            } else {
                $formArray['cluster_no'] = $cluster;
                $formArray['province'] = substr($_POST['planning_cluster'], 0, 1);
                $formArray['dist'] = (isset($_POST['planning_dist']) && $_POST['planning_dist'] != '' ? $_POST['planning_dist'] : substr($_POST['planning_cluster'], 0, 3));
                $InsertData = $Custom->Insert($formArray, 'id', 'planning', 'N');
            }


            if ($InsertData) {
                $result = 1;
            } else {
                $result = 6;
            }
            $trackarray = array("action" => "Dashboard/ Add Planning after randomization -> Function: addPlanning() Add Planning after dc randomization ",
                "result" => $InsertData, "PostData" => $formArray);
            $Custom->trackLogs($trackarray, "user_logs");
        } else {
            $result = 4;
        }
        echo $result;
    }

    function viewPlanning()
    {
        $M = new MLinelisting();
        $data = $M->get_planning($_POST['cluster']);
        echo json_encode($data, true);
    }


    /*Setting Page, User Rights*/
    function getMenuData()
    {
        $this->load->model('msettings');
        $idGroup = $this->encrypt->decode($_SESSION['login']['idGroup']);
        $Menu = '';
        $Msetting = new MSettings();
        $getDataRights = $Msetting->getUserRights($idGroup, '1', '');

        if (isset($getDataRights) && count($getDataRights) >= 1) {

            $myresult = array();
            foreach ($getDataRights as $key => $value) {
                if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                    $mykey = strtolower($value->idParent);
                    $myresult[strtolower($mykey)]->myrow_options[] = $value;
                } else {
                    $mykey = strtolower($value->idPages);
                    $myresult[strtolower($mykey)] = $value;
                }
            }
            foreach ($myresult as $pages) {
                if ($pages->isParent == 1) {
                    $Menu .= '<li class=" nav-item   ' . $pages->menuClass . ' has-sub">
                                      <a href="javascript:void(0)"> 
                                         <i class="feather ' . $pages->menuIcon . '"></i>
                                          <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                       </a>
                                       <ul class="menu-content"> ';
                    if (isset($pages->myrow_options) && $pages->myrow_options != '') {
                        foreach ($pages->myrow_options as $options) {
                            $Menu .= ' <li class="' . $options->menuClass . '">
                                        <a href="' . base_url('index.php/' . $options->pageUrl) . '">
                                            <i class="feather ' . $options->menuIcon . '"></i>
                                            <span class="menu-item" data-i18n="' . $options->pageName . '">' . $options->pageName . '</span> 
                                        </a>
                                      </li>';
                        }
                    }
                    $Menu .= ' </ul></li>';
                } else {
                    $Menu .= '<li class=" nav-item ' . $pages->menuClass . '">
                                    <a href="' . base_url('index.php/' . $pages->pageUrl) . '" class="">
                                        <i class="feather ' . $pages->menuIcon . '"></i>
                                        <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                    </a>
                              </li>';
                }
            }
        } else {
            $Menu = '';
        }
        $Menu .= ' <li class=" nav-item">
                <a href="javascript:void(0)" onclick="logout()">
                    <i class="feather icon-power"></i>
                    <span class="menu-title" data-i18n="Logout">Logout</span>
                </a>
            </li>';
        echo $Menu;
    }

    function getDistrictByProvince()
    {
        $Custom = new Custom();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $sub_district = '';
        if (isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
            $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
        }
        $data = $Custom->getProvince_District($province, $sub_district);
        echo json_encode($data, true);
    }

    function getUCsByDistrict()
    {
        $Custom = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $arms = (isset($_REQUEST['arms']) && $_REQUEST['arms'] != '' && $_REQUEST['arms'] != 0 ? $_REQUEST['arms'] : 0);
        $uc = '';
        if (isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
            $uc = $this->encrypt->decode($_SESSION['login']['district']);
        }
        $data = $Custom->getUcs_District($district, $uc, $arms);
        echo json_encode($data, true);
    }

    function getClustersByUCs()
    {
        $Custom = new Custom();
        $ucs = (isset($_REQUEST['ucs']) && $_REQUEST['ucs'] != '' && $_REQUEST['ucs'] != 0 ? $_REQUEST['ucs'] : 0);
        if (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '1') {
            $randomized = '1';
        } elseif (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '0') {
            $randomized = '0';
        } else {
            $randomized = '';
        }
        $data = $Custom->getClusters_UC($ucs, $randomized);
        echo json_encode($data, true);
    }

    function getClustersByDistrict()
    {
        $Custom = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        if (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '1') {
            $randomized = '1';
        } elseif (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '0') {
            $randomized = '0';
        } else {
            $randomized = '';
        }
        $data = $Custom->getClusters_District($district, $randomized);
        echo json_encode($data, true);
    }

    function getClustersData()
    {
        $Custom = new Custom();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $data = $Custom->getClustersData($cluster);
        echo json_encode($data, true);
    }
}

?>