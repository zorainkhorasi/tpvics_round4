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
            //     echo "<pre>";
            //  print_r($data);
            //  echo "</pre>";
      
            $sum=$this->calculateTotal($data['completed'],$data['ip'],$data['r']);
          
            $data['sum']=$sum;


          //  echo $this->encrypt->decode($_SESSION['login']['prcode']);die;
          
            //  echo "<pre>";
            //  print_r($data);
            //  echo "</pre>";
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
            }

            // Calculate final percentages
            foreach ($per as $name => $data) {
                $per[$name]['percentage'] = $data['total'] > 0
                    ? round(($data['completed'] / $data['total']) * 100)
                    : 0;
                      $per[$name]['remaining'] = $data['total'] > 0
                    ? round(($data['remaining'] / $data['total']) * 100)
                    : 0;
                      $per[$name]['pending'] = $data['total'] > 0
                    ? round(($data['pending'] / $data['total']) * 100)
                    : 0;
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
            $res = array();
            foreach ($get_linelisting_table as $key => $value) {
                $res[$value->cluster_no]['geoarea'] = $value->geoarea;
                $res[$value->cluster_no]['enumcode'] = $value->enumcode;
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
                $res[$value->cluster_no]['residential_structures'] = 0;
            }
            foreach ($get_ll_structures as $structure) {
                if (isset($res[$structure->hh01]) && $res[$structure->hh01] != '') {
                    $res[$structure->hh01]['structures'] += $structure->structure;
                }
            }
            foreach ($get_ll_res_structures as $res_structure) {
                if (isset($res[$res_structure->hh01]) && $res[$res_structure->hh01] != '') {
                    $res[$res_structure->hh01]['residential_structures'] += 1;
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
            if ($randomization_status == 1) {
                echo 2;
                $track_msg = 'Cluster is Already Randomized';
            } else {
                $chked = 0;
                $chkDuplicateTabs = $MLinelisting->chkDuplicateTabs($cluster);
                if (isset($chkDuplicateTabs) && count($chkDuplicateTabs) >= 1) {
                    $chked = 1;
                }
                /*$custom_dup_chk = array();
                foreach ($chkDuplicateTabs as $chk) {
                    if (in_array($custom_dup_chk[$chk->tabNo], $custom_dup_chk)) {
                        $chked = 1;
                    } else {
                        $custom_dup_chk[$chk->tabNo][] = $chk->deviceid;
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
                                'ssno' => $i + 1,
                                'hh02' => $get_systematic_rand[$index - 1]->hh01,
                                'hh03' => $get_systematic_rand[$index - 1]->hh04,
                                'hh07' => $get_systematic_rand[$index - 1]->hh05,
                                'hh08' => $get_systematic_rand[$index - 1]->hh11,
                                'hh09' => $get_systematic_rand[$index - 1]->hh09,
                                'total' => $cntData,
                                'randno' => $random_start,
                                'randomPick' => $index - 1,
                                'quot' => $quotient,
                                'dist_id' => $get_systematic_rand[$index - 1]->enumcode,
                                'compid' => $get_systematic_rand[$index - 1]->hh01 . '-' . $get_systematic_rand[$index - 1]->tabNo . "-" . str_pad($get_systematic_rand[$index - 1]->hh04, 4, "0", STR_PAD_LEFT) . "-" . str_pad($get_systematic_rand[$index - 1]->hh05, 3, "0", STR_PAD_LEFT),
                                'tabNo' => $get_systematic_rand[$index - 1]->tabNo,
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
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TPVICS SHRUC Round 4');
            $pdf->SetTitle('Cluster No: ' . $data['cluster']);
            $pdf->SetSubject('TPVICS SHRUC Round 4');
            $pdf->SetKeywords('TPVICS SHRUC Round 4');


            $geoarea = explode('|', $data['cluster_data'][0]->geoarea);

            $header = '<strong>TPVICS  Round 3 - Cluster No: ' . $data['cluster'] . '</strong><br>
Province: ' . $geoarea[0] . '<br>
District: ' . $geoarea[1] . '<br>
Tehsil: ' . $geoarea[2] . '<br>
Area: ' . $data['cluster_data'][0]->geoarea . '<br>
Planned Collection Date: ' . $data['cluster_data'][0]->collection_date .
                ' --- Collector Name: ' . $data['cluster_data'][0]->collector_name .
                ' --- Tablet ID: ' . $data['cluster_data'][0]->tablet_id;
            $pdf->setHtmlHeader('<p style="font-size: 12px;  border-bottom: 1px solid black;">' . $header . '</p>');
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetTopMargin(35);
            $pdf->setPrintHeader(true);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);;
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . ' / lang / eng . php')) {
                require_once(dirname(__FILE__) . ' / lang / eng . php');
            }
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->AddPage();
            $pdf->Write(0, 'Randomization Date: ' . $data['randomization_date'], '', 0, 'R', true, 0, false, false, 0);
            $pdf->SetFont('helvetica', '', 9);
            $tbl = '<table border="1" cellpadding="0" cellspacing="0" >
                 <tr>
                  <th width="10%" style="text-align:center"><b>Serial No</b></th> 
                  <th width="20%" style="text-align:center"><b>Household No</b></th>
                  <th width="20%" style="text-align:center"><b>Head of Household</b></th>
                  <th width="50%" style="text-align:center; "><b>Remarks</b></th>
                 </tr>';
            foreach ($data['cluster_data'] as $row) {
                $tbl .= '<tr  border="0"><td  border="0" style="text-align:center">' . $row->sno . '</td> 
<td style="text-align:center">' . $row->tabNo . '-' . substr($row->compid, 12, 8) . '</td>
<td style="text-align:center">' . ucfirst($row->hh08) . '</td>
<td style="text-align:center; height: 27px"  border="0"> </td>
</tr>';
            }
            $tbl .= '</table>';
            $pdf->writeHTML($tbl, true, false, true, false, '');
            $pdf->Output('randmozied.pdf', 'I');
            ob_end_flush();
            ob_end_clean();
            $track_msg = 'Success';
        } else {
            $track_msg = 'Invalid Cluster';
            echo 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Linelisting datatable pdf",
            "action" => "Linelisting PDF -> Function: Dashboard/make_pdf()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
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