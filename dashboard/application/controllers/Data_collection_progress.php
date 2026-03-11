<?php
//error_reporting(0);

class Data_collection_progress extends CI_controller
{

    

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdata_collection');
        $this->load->model('mlinelisting');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 1;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            }


            $MLinelisting = new MLinelisting();
            $MData_collection = new MData_collection();

            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);
            $dist_array = array();
            foreach ($getClustersProvince as $k => $v) {
                $my_id = $v->my_id;
                $dist_array[$my_id] = $v->my_name;
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

            /*==============Randomization Clusters List==============*/
            $randomization = $MData_collection->total_rand_clusters($district, $sub_district, $level);
            $data['randomization']['total'] = 0;
            foreach ($randomization as $key => $val) {
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $val->my_id) {
                        $data['randomization'][$dist_name] = $val->randomized_c;
                        $data['randomization']['total'] += $val->randomized_c;
                    }
                }
            }

            /*==============Completed & Pending Clusters List==============*/
            $completedClusters_district = $MData_collection->completed_rand_Clusters_district($district, $sub_district);
            if (isset($district) && $district != '') {
                $i = $district;
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $i) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                        $data['ip'][$dist_name] = 0;
                    }
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                        $data['ip'][$dist_name] = 0;
                    }
                }
            }
            $data['completed']['total'] = 0;
            $data['r']['total'] = 0;
            $data['ip']['total'] = 0;
            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        if ($row->hh_collected >= 13 && $row->sampled==1) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        }elseif($row->hh_collected < 13  &&  $row->hh_collected > 0 && $row->sampled==1) {
                            $data['ip'][$dist_name]++;
                            $data['ip']['total']++;
                        } else {
                            if( $row->sampled==1 &&  $row->hh_collected == 0){
                                $data['r'][$dist_name]++;
                                $data['r']['total']++;
                            }

                        }
                    }
                }
            }

                 $totalList = $data['totalcluster']['list'];
                $completedList = $data['completed'];
                  $remainingList = $data['r'];
                    $inprogressList = $data['ip'];

                // STEP 1: Sum totals by province
               $totalsByProvince = [];

                foreach ($totalList as $item) {
                    $province = $item['district'];
                    $clusters = $item['clusters_by_district'];

                    if (!isset($totalsByProvince[$province])) {
                        $totalsByProvince[$province] = 0;
                    }

                    $totalsByProvince[$province] += $clusters;
                }

                /*
                |--------------------------------------------------------------------------
                | STEP 2: CALCULATE PERCENTAGE (completed / total * 100)
                |--------------------------------------------------------------------------
                */
                $percentageByProvince = [];
                $remainingPercentageByProvince = [];
                $inprogressPercentageByProvince = [];
            

     
                // foreach ($totalsByProvince as $province => $total) {
                //     $completed = $completedList[$province] ?? 0;
                //     $percentage = ($total > 0) ? ($completed / $total) * 100 : 0;
                //     $percentageByProvince[$province] = round($percentage, 2);
                //     //  echo "<pre>";
                //     // var_dump($percentageByProvince);
                //     $remaining = $remainingList[$province] ?? 0;
                //     $remainingPercentage = ($total > 0) ? ($remaining / $total) * 100 : 0;
                //     $remainingPercentageByProvince[$province] = round($remainingPercentage, 2);

                //     $inprogress = $inprogressList[$province] ?? 0;
                //     $inprogressPercentage = ($total > 0) ? ($inprogress / $total) * 100 : 0;
                //     $inprogressPercentageByProvince[$province] = round($inprogressPercentage, 2);

                // }
                //   echo "<pre>";
                //     var_dump($totalsByProvince);
                //     echo "</pre>";
                    // die();
                
                 foreach ($totalsByProvince as $province => $total) {
                    $completed = $completedList[$province] ?? 0;
                    $percentage = ($total > 0) ? ($completed / $total) * 100 : 0;
                    $percentageByProvince[$province]['completed'] = round($percentage, 2);
                
                    $remaining = $remainingList[$province] ?? 0;
                    $remainingPercentage = ($total > 0) ? ($remaining / $total) * 100 : 0;
                    $percentageByProvince[$province]['remaining'] = round($remainingPercentage, 2);

                    $inprogress = $inprogressList[$province] ?? 0;
                    $inprogressPercentage = ($total > 0) ? ($inprogress / $total) * 100 : 0;
                    $percentageByProvince[$province]['inprogress'] = round($inprogressPercentage, 2);

                 }
                    // echo "<pre>";
                    // var_dump($percentageByProvince);
                    // echo "</pre>";
                    // die();
                /*
                |--------------------------------------------------------------------------
                | STEP 3: NORMALIZE KEYS FOR SAFE USE IN VIEW
                |--------------------------------------------------------------------------
                */
                function normalizeKey($str)
                {
                    $str = str_replace('&', 'and', $str);           // replace & with and
                    $str = preg_replace('/[^a-zA-Z0-9]/', '_', $str); // convert special chars to _
                    $str = preg_replace('/_+/', '_', $str);         // remove multiple underscores
                    return strtolower(trim($str, '_'));             // cleanup
                }

                $normalizedPercentage = [];

                foreach ($percentageByProvince as $province => $percent) {
                    $key = normalizeKey($province);
                    $normalizedPercentage[$key] = $percent;
                }
          
            $data['per']=$normalizedPercentage;
        
            $data['remaining_per']=$remainingPercentageByProvince;
            $data['inprogress_per']=$inprogressPercentageByProvince;
        
              $sum=$this->calculateTotal($data['completed'],$data['ip'],$data['r']);
          
            $data['sum']=$sum;

            // echo "<pre>";
            // var_dump($data);
            // echo "</pre>";
            // die();

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/data_collection_new', $data);
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
            "activityName" => "DataCollection Main",
            "action" => "View DataCollection Province dashboard -> Function: Data_collection_progress/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }
     function calculateTotal($completed,$ip,$r){

    
        $sum=[
            'total'=>0,
            // 'remaining'=>0,
            'ip'=>0,
            'completed'=>0
        ];

        foreach ($completed as $k => $d) {
            $sum['completed'] += $d;
        }
        foreach ($ip as $k => $d) {
            $sum['ip'] += $d;
        }
          foreach ($r as $k => $d) {
            $sum['total'] += $d;
        }
        // foreach ($total as $district => $data) {
        //  $sum['total'] = isset($total) ? $total : 0;
        // }
      

        return $sum;

    }

    function dc_index($district = null)
    {

    
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {

            // $district = '';
            $sub_district = '';
            $level = 2;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $u_district = $this->encrypt->decode($_SESSION['login']['district']);
                $sub_district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $u_district = '';
            }

       


            $MLinelisting = new MLinelisting();
            $MData_collection = new MData_collection();

            $getClustersProvince = $MLinelisting->getClustersProvince($district, $sub_district, $level);
            $dist_array = array();
            foreach ($getClustersProvince as $k => $v) {
                $my_id = $v->my_id;
                $dist_array[$my_id] = $v->my_name;
            }
            $data['dist_array'] = $dist_array;

            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($district, $sub_district, $level);
            $totalcluster = 0;
            foreach ($totalClusters_district as $k => $r) {
                $dist = $r->my_id;
                $distPro = $r->my_name;
                $totalcluster = $totalcluster + $r->clusters_by_district;
                if (isset($clusters_by_district[$distPro]) && $clusters_by_district[$distPro] != '') {
                    $clusters_by_district[$distPro]['clusters_by_district'] += $r->clusters_by_district;
                } else {
                    $clusters_by_district[$distPro]['clusters_by_district'] = $r->clusters_by_district;
                }
                $clusters_by_district[$distPro]['id'] = $dist;
            }

            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

            /*==============Randomization Clusters List==============*/
            $randomization = $MData_collection->total_rand_clusters($district, $sub_district, $level);

            $data['randomization']['total'] = 0;
            foreach ($randomization as $key => $val) {
                foreach ($dist_array as $k => $dist_name) {
                    if ($k == $val->my_id) {
                        $data['randomization'][$dist_name] = $val->randomized_c;
                        $data['randomization']['total'] += $val->randomized_c;
                    }
                }
            }

            /*==============Completed & Pending Clusters List==============*/
            $completedClusters_district = $MData_collection->completed_rand_Clusters_district($district, $sub_district, $level);
           
            if (isset($district) && $district != '') {
                foreach ($dist_array as $k => $dist_name) {
                    $data['completed'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;
                    $data['ip'][$dist_name] = 0;
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['completed'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;
                        $data['ip'][$dist_name] = 0;
                    }
                }
            }
            $data['completed']['total'] = 0;
            $data['r']['total'] = 0;
            $data['ip']['total'] = 0;

            foreach ($completedClusters_district as $row) {
                $ke = $row->provinceId;
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        if ($row->hh_collected >= 13 && $row->sampled==1) {
                            $data['completed'][$dist_name]++;
                            $data['completed']['total']++;
                        }elseif($row->hh_collected < 13  &&  $row->hh_collected > 0 && $row->sampled==1) {
                            $data['ip'][$dist_name]++;
                            $data['ip']['total']++;
                        } else {
                            if( $row->sampled==1 &&  $row->hh_collected == 0){
                                $data['r'][$dist_name]++;
                                $data['r']['total']++;
                            }

                        }
                    }
                }
            }

        
             $per = [];
            // Step 1: Add total values
            foreach ($data['totalcluster']['list'] as $district => $dist) {
            //           echo "<pre>";
            //    var_dump($key);
            //     die();

                $per[$district] = [
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

            //     echo "<pre>";
            //    var_dump($data['per']);
            //     die();
                $this->output
                ->set_content_type('application/json')
                 ->set_output(json_encode( $data ));
            return;
            // $this->load->view('include/header');
            // $this->load->view('include/top_header');
            // $this->load->view('include/sidebar');
            // $this->load->view('data_collection/data_collection_districtLists', $data);
            // $this->load->view('include/customizer');
            // $this->load->view('include/footer');
            // $track_msg = 'Success';
        } else {
            // $track_msg = 'errors/page-not-authorized';
            // $this->load->view('errors/page-not-authorized', $data);
              $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Not authorized']));
            return;
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection Disrtict Dashboard",
            "action" => "View DataCollection Disrtict Dashboard page -> Function: Data_collection_progress/dc_index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function dc_dt()
    {
        
        // var_dump()
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'data_collection_progress');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {

            $MData_collection = new MData_collection();
             $district = $this->input->get('district_id'); // <- here
                 $cluster_type = $this->input->get('status'); 

            // $district_cluster_type = $this->uri->segment(3);
            // $district = '';
            // $sub_district = '';
            // $cluster_type = '';
            // if (!empty($district_cluster_type)) {
            //     $sub_district_cluster_type = $this->uri->segment(4);
            //     if (!empty($sub_district_cluster_type)) {
            //         $sub_district = substr($sub_district_cluster_type, 1, 5);
            //     }
            //     $district = substr($district_cluster_type, 1, 3);
            //     $cluster_type = substr($district_cluster_type, 3, 1);
            // }

        //    echo $cluster_type;die;

            if ($cluster_type == 't' || $cluster_type == 'c' || $cluster_type == 'ip' || $cluster_type == 'r') {
                $data['get_linelisting_table'] = $MData_collection->get_data_collection_rand_table($district, $cluster_type, $sub_district='');
            } else {
                $data['get_linelisting_table'] = $MData_collection->get_data_collection_rand_table($district, 'r', $sub_district='');
            }
               
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/data_collection_dt', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
                 // Send JSON response for AJAX
            
        } else {
         
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "DataCollection Datatable Dashboard",
            "action" => "View DataCollection Datatable Dashboard page -> Function: Data_collection_progress/dc_dt()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function randomized_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $r_hh = $MData_collection->get_randomizedHH($data['cluster']);
            $data['data'] = $r_hh;
            foreach ($r_hh as $k => $v) {
                $sa = $MData_collection->get_HH_status($data['cluster'], $v->hhno);
                $data['data'][$k]->istatus = (isset($sa[0]->istatus) && $sa[0]->istatus != '' ? $sa[0]->istatus : 0);
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/randomized_hh', $data);
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
            "activityName" => "DataCollection randomized_household",
            "action" => "View DataCollection randomized_household -> Function: Data_collection_progress/randomized_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function collected_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_collectedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/collected_hh', $data);
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
            "activityName" => "DataCollection collected_household",
            "action" => "View DataCollection collected_household -> Function: Data_collection_progress/collected_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function completed_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_completedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/completed_hh', $data);
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
            "activityName" => "DataCollection completed_household",
            "action" => "View DataCollection completed_household -> Function: Data_collection_progress/completed_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function refused_household()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $MData_collection = new MData_collection();
            $data['data'] = $MData_collection->get_refusedHH($data['cluster']);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection/refused_hh', $data);
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
            "activityName" => "DataCollection refused_household",
            "action" => "View DataCollection refused_household -> Function: Data_collection_progress/refused_household()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

}