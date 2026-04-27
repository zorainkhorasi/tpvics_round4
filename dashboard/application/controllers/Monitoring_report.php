<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Monitoring_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->model('Monitoring_report_Model');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['partners'] = $this->Monitoring_report_Model->getDistinct('Partner');
        $data['columns'] = $this->Monitoring_report_Model->getColumns();

        $trackarray = array(
            "activityName" => "Users",
            "action" => "View Users -> Function: Monitoring_report/index()",
            "result" => "View Users success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom = new Custom();
        $Custom->trackLogs($trackarray, "all_logs");

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('monitoring_report', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');

    }

    public function getFilters()
    {
        $partner = $this->input->post('Partner');
        $province = $this->input->post('Province');
        $district = $this->input->post('District');

        $where = [];

        if (!empty($partner)) {
            $where['Partner'] = $partner;
        }

        if (!empty($province) && $province != 'All') {
            $where['Province'] = $province;
        }

        if (!empty($district) && $district != 'All') {
            $where['District'] = $district;
        }

        $provinceList = $this->Monitoring_report_Model->getDistinct('Province', ['Partner' => $partner]);
        $districtList = $this->Monitoring_report_Model->getDistinct('District', $where);

        echo json_encode([
            'province' => $provinceList,
            'district' => $districtList,
        ]);
    }

    public function getData()
    {
        $filters = $this->input->post();
        $data = $this->Monitoring_report_Model->getData($filters);

        echo json_encode(['data' => $data]);
    }
}