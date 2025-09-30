<?php

class Survey_report extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('msurveyreport');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $uc = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
            }

            $MCustom = new Custom();
            $dist_list = $MCustom->getDistricts($district);
            $data['dist'] = $dist_list;


            if (isset($_GET['d']) && $_GET['d'] != '') {
                $district = $_GET['d'];
                $uc = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
            } else {
                $district = '';
            }

            $data['slug_district'] = $district;
            $data['slug_uc'] = $uc;

            $MSettings = new MSettings();
            $MSurveyReport = new MSurveyReport();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
            $data['myData'] = $MSurveyReport->getData($district, $uc);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('survey_report', $data);
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
            "activityName" => "Survey_report",
            "action" => "View Survey_report -> Function: Survey_report/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function getHousehold()
    {
        $cluster = $_POST['cluster'];
        $formDate = $_POST['formDate'];
        $MSurveyReport = new MSurveyReport();
        $data = $MSurveyReport->getHouseholdSurvey($cluster, $formDate);
        echo json_encode($data);
    }


}