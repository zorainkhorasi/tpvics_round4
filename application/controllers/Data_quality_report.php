<?php
//error_reporting(0);

class Data_quality_report extends CI_controller
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
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', '');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 1;

            $data['dist_id']     = $this->input->get('dist_id');
            $data['uc_id']          = $this->input->get('uc_id');

            //district

            $query = $this->db->query("SELECT * FROM districts");
            $data['districts'] = $query->result_array();

            $where = "";

            if (!empty($data['dist_id']) && !empty($data['uc_id'])) {
                $where = "WHERE district = '" . $data['dist_id'] . "' AND uc_name = '" . $data['uc_id'] . "'";
            } elseif (!empty($data['dist_id'])) {
                $where = "WHERE district = '" . $data['dist_id'] . "'";
            } elseif (!empty($data['uc_id'])) {
                $where = "WHERE uc_name = '" . $data['uc_id'] . "'";
            }

            $query = $this->db->query("SELECT * FROM data_quality_report $where");
            $result = $query->result_array();


            $data['columns'] = $query->list_fields(); // get column names
            $data['rows'] = $result;
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('data_quality_report_view', $data);
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
            "action" => "View Data_quality_report Province dashboard -> Function: Data_quality_report/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    public function getUcs()
    {
        $dist_id = $this->input->post('dist_id'); // CI way
        if (!empty($dist_id)) {
            $query = $this->db->query("SELECT distinct ucCode,ucName FROM Ucs WHERE district = '" .$dist_id."'");
        } else {
            $query = $this->db->query("SELECT distinct ucCode,ucName FROM Ucs ");
        }
        echo json_encode($query->result_array());
        exit;
    }




}