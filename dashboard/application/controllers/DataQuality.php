<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class DataQuality extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->model('DataQualityModel');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['partners'] = $this->DataQualityModel->getDistinct('Partner');
        $data['columns']  = $this->DataQualityModel->getColumns();
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('data_quality_view', $data);
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

        $provinceList = $this->DataQualityModel->getDistinct('Province', ['Partner'=>$partner]);
        $districtList = $this->DataQualityModel->getDistinct('District', $where);
        $obsList      = $this->DataQualityModel->getDistinct('Observation', $where);

        echo json_encode([
            'province'    => $provinceList,
            'district'    => $districtList,
            'observation' => $obsList
        ]);
    }

    public function getData()
    {
        $filters = $this->input->post();
        $data = $this->DataQualityModel->getData($filters);

        echo json_encode(['data' => $data]);
    }
}