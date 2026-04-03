<?php error_reporting(0);

class Card_edit_two extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcard_edit');
        $this->load->model('mimage_forms');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }



    function edit_form_new()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Card_edit');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1 || 1==1) {

            $Mimage_forms = new Mimage_forms();

            $province = $Mimage_forms->getProvince_District_two('');
            $p = array();
            foreach ($province as $k => $v) {
                $key = $v->dist_id;
                $p[$key] = $v->district;
            }
            $data['province'] = $p;
            $M = new MCard_edit();

            if (isset($_GET['c']) && $_GET['c'] != '') {
                $cluster = $_GET['c'];
            } else {
                $cluster = '0';
            }
            if (isset($_GET['dis']) && $_GET['dis'] != '') {
                $dis = $_GET['dis'];
            } else {
                $dis = '0';
            }
            if (isset($_GET['h']) && $_GET['h'] != '') {
                $hhno = $_GET['h'];
            } else {
                $hhno = '0';
            }

            if (isset($_GET['ec']) && $_GET['ec'] != '') {
                $ec = $_GET['ec'];
            } else {
                $ec = '1';
            }

            $vac_details = $M->vac_details($cluster, $hhno, $ec);
            $vac_details_edit = $M->vac_details_edit($cluster, $hhno, $ec);

            $data['vac_details'] = $vac_details;
            $data['vac_details_edit'] = $vac_details_edit;
            $data['vac_details_edit_names'] =$M->getCreatedByNames($cluster, $hhno, $ec);


           // echo '<pre>';print_r($data['vac_details_edit']);die;
            $data['cluster'] = $cluster;
            $data['hhno'] = $hhno;
            $data['ec'] = $ec;
            $data['dis'] = $dis;

            // echo '<pre>';print_r($data);die;

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('card_edit_form_new_two', $data);
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
            "activityName" => "Card_edit Form",
            "action" => "View Card_edit edit_form -> Function: Card_edit/edit_form()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    public function fetch_vaccine_data_ajax() {
        $cluster_code = $this->input->post('cluster_code');
        $hhno = $this->input->post('hhno');

        $this->db->where('cluster_code', $cluster_code);
        $this->db->where('hhno', $hhno);
        $vac_details = $this->db->get('vac_details')->row();

        $this->db->where('cluster_code', $cluster_code);
        $this->db->where('hhno', $hhno);
        $this->db->order_by('id','DESC');
        $vac_details_edit = $this->db->get('vac_details_edit')->row();

        if($vac_details) {
            $vaccines = [
                "bcg","opv0","opv1","opv2","opv3",
                "penta1","penta2","penta3",
                "pcv","pcv2","pcv3",
                "rv1","rv2",
                "ipv","ipv2",
                "measles1","measles2",
                "hep_b","tcv"
            ];

            $old = $new = [];
            foreach($vaccines as $v) {
                $old[$v] = $vac_details->$v ?? '';
                $new[$v] = $vac_details_edit->$v ?? $old[$v];
            }

            echo json_encode([
                'status' => 'success',
                'old' => $old,
                'vaccines' => $new
            ]);
        } else {
            echo json_encode(['status'=>'error']);
        }
    }

    public function save_vaccines_ajax() {
        $response = ['status' => 'error', 'message' => 'Something went wrong'];

        if($this->input->is_ajax_request()){
            $post = $this->input->post();
            //echo '<pre>';print_r($post['pcv1']);die;
            $dataToSave = [];
            $vaccines = [
                "bcg","opv0","opv1","opv2","opv3",
                "penta1","penta2","penta3",
                "pcv","pcv2","pcv3",
                "rv1","rv2",
                "ipv","ipv2",
                "measles1","measles2","tcv"
               // "hep_b","tcv"

            ];
            $dataToSave['card_correction']='0';
            foreach($vaccines as $v){

                if($v=='measles1'){
                    $dataToSave['measles1'] = $post['mr1'] ?? null; // value from dropdown or 98
                }elseif ($v=='measles2'){
                    $dataToSave['measles2'] = $post['mr2'] ?? null; // value from dropdown or 98
                }elseif ($v=='pcv'){
                    $dataToSave['pcv'] = $post['pcv1'] ?? null; // value from dropdown or 98
                }else{
                    $dataToSave[$v] = $post[$v] ?? null; // value from dropdown or 98
                }
            }

            // Additional info
            $dataToSave['cluster_code'] = $post['cluster_code'];
            $dataToSave['hhno'] = $post['hhno'];
            $dataToSave['ec13'] = $post['ec13'];
            $dataToSave['image_status'] = $post['image_status'];
            $dataToSave['dob'] = $post['dob'];
            $dataToSave['dobstatus'] = $post['dobstatus'];
            $dataToSave['card_condition'] = $post['card_condition'];
            $dataToSave['vac_status'] = $post['vac_status'];
            $dataToSave['image_comments'] = $post['image_comments'];
            $dataToSave['dob_type'] = $post['dob_type'];
            $dataToSave['createdBy']=$this->encrypt->decode($_SESSION['login']['username']);
            $dataToSave['createddateTime']=date('Y-m-d H:i:s');
            foreach($vaccines as $v){
                if(trim($dataToSave[$v])!='-'){
                    $dataToSave['card_correction']='1';
                }
            }

            $Custom = new Custom();
            $saved = $Custom->Insert($dataToSave, 'id', 'vac_details_edit', 'N');

            if($saved){
                $response['status'] = 'success';
            } else {
                $response['message'] = 'DB insert failed';
            }
        }
        echo json_encode($response);
    }
    public function show_image($filename)
    {
        $imagePath = 'E:/PortalFiles/TPVICS_R3/uploads/'.$filename;
        if (!file_exists($imagePath)) {
            show_404();
        }
        // Get mime type
        $mime = mime_content_type($imagePath);
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($imagePath));
        readfile($imagePath);
        exit;
    }


    function getClustersByDist()
    {
        $Mimage_forms = new Mimage_forms();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $Mimage_forms->getClusters_two($district);
        echo json_encode($data, true);
    }

    function getHhnoByCluster()
    {
        $Mimage_forms = new Mimage_forms();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $data = $Mimage_forms->gethhnoByClust_two($cluster);
        echo json_encode($data, true);
    }

    function getChildNoByHH()
    {
        $Mimage_forms = new Mimage_forms();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $hh = (isset($_REQUEST['hh']) && $_REQUEST['hh'] != '' ? $_REQUEST['hh'] : 0);
        $data = $Mimage_forms->getChildByHH_two($cluster, $hh);
        echo json_encode($data, true);
    }
}

?>