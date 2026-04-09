<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Cluster_Profile_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->model('Cluster_Profile_Model');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['partners'] = $this->Cluster_Profile_Model->getDistinct('Partner');
        $data['columns']  = $this->Cluster_Profile_Model->getColumns();
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('cluster_profile_report', $data);
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

        $provinceList = $this->Cluster_Profile_Model->getDistinct('Province', ['Partner'=>$partner]);
        $districtList = $this->Cluster_Profile_Model->getDistinct('District', $where);

        echo json_encode([
            'province'    => $provinceList,
            'district'    => $districtList,
        ]);
    }

    public function getData()
    {
        $filters = $this->input->post();
        $data = $this->Cluster_Profile_Model->getData($filters);

        echo json_encode(['data' => $data]);
    }
}