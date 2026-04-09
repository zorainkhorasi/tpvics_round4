<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class District_Wise_Progress_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->model('District_Wise_Progress_Model');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['partners'] = $this->District_Wise_Progress_Model->getDistinct('Partner');
        $data['columns']  = $this->District_Wise_Progress_Model->getColumns();
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('district_wise_progress_report', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');

    }

    public function getFilters()
    {
        $partner   = $this->input->post('Partner');
        $province  = $this->input->post('Province');
        $district  = $this->input->post('District');

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

        $provinceList = $this->District_Wise_Progress_Model->getDistinct('Province', ['Partner'=>$partner]);
        $districtList = $this->District_Wise_Progress_Model->getDistinct('District', $where);

        echo json_encode([
            'province'    => $provinceList,
            'district'    => $districtList,
        ]);
    }

    public function getData()
    {
        $filters = $this->input->post();
        $data = $this->District_Wise_Progress_Model->getData($filters);

        echo json_encode(['data' => $data]);
    }
}