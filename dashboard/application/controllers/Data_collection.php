<?php ob_start();

class Data_collection extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('MData_collection');
        $this->load->model('minterviewstatus');
        $this->load->model('MListing');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();

        $data['country_id']=$_SESSION['login']['check_country'];//$this->uri->segment(3);

        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'Data_collection');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 2;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $u_district = $_SESSION['login']['district'];
                $sub_district = $_SESSION['login']['district'];
            } else {
                $u_district = '';
            }
            $MLinelisting = new MListing();
            $MData_collection = new MData_collection();

            $dist_array=$MLinelisting->get_districtBycountry($data['country_id']);
            $data['dist_array']=$dist_array;
            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($data['country_id']);


            $totalcluster=0;
            $clusters_by_district=[];
            foreach ($totalClusters_district as $t){
                $totalcluster +=$t['clusters_by_district'];
                $clusters_by_district[$dist_array[$t['district_id']]]=array('clusters_by_district'=>$t['clusters_by_district'],'id'=>$t['district'],'district_id'=>$t['district_id']);
            }

            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

            /*==============Completed Clusters List==============*/
            $completedClusters_district = $MData_collection->completedClusters_district($data['country_id']);
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
                $district_id = substr($row->cluster_no, 0, 2);
                foreach ($dist_array as $key => $dist_name) {
                    if($district_id==$key  && $row->form_count >= 15){
                        $data['total'][$dist_name]++;
                        $data['completed'][$dist_name]++;
                        $data['completed']['total']++;

                    }
                    if($district_id==$key  && $row->form_count  < 15 && $row->form_count > 0){
                        $data['ip'][$dist_name]++;
                        $data['ip']['total']++;
                    }
                }
            }
            /*==============Remaining Clusters List==============*/

            $data['r']['total'] = 0;
            foreach ($totalClusters_district as $row2) {
                $ke = $row2['district_id'];
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        $data['r'][$dist_name] = isset($row2['clusters_by_district'])?$row2['clusters_by_district'] - $data['total'][$dist_name]-$data['ip'][$dist_name]:0;
                        $data['r']['total'] += $data['r'][$dist_name];
                    }
                }
            }
            /*
             *  echo '<pre>';
                    print_r($totalClusters_district);
                    print_r($dist_array);
                    print_r($data['ip']);
                die;
            */
            /*==============Remaining Clusters List==============*/
            $data['r']['total']=$data['r']['total'];//-$data['ip']['total'];
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_collection', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
    }

    function dashboard_dt()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'Data_collection');
        if (1 == 1) {
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $district = '';
            }
            $minterviewstatus = new minterviewstatus();
            $MLinelisting = new MListing();

           // $data['country_id']=2;
            $data['district_cluster_type'] = $this->uri->segment(3);
            $data['sub_district_cluster_type'] = $this->uri->segment(4);
            $data['country_id'] = $this->uri->segment(5);
            $dist_array=$MLinelisting->get_districtBycountry($data['country_id']);
            $data['dis_name']=$dist_array[$this->uri->segment(3)];



            /*============== Linelisting Data table ==============*/

            // $data['cluster_type'] = $cluster_type;

            $data['data'] = $minterviewstatus->getdata($data['district_cluster_type'], $data['country_id'],$data['sub_district_cluster_type']);

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('interview_status', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }

    }



} ?>