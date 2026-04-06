<?php

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Card_review_summary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('muser');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->model('Card_review_summary_Model');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['partners'] = $this->Card_review_summary_Model->getDistinct('Partner');
        $data['columns']  = $this->Card_review_summary_Model->getColumns();
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('card_review_summary', $data);
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

        $provinceList = $this->Card_review_summary_Model->getDistinct('Province', ['Partner'=>$partner]);
        $districtList = $this->Card_review_summary_Model->getDistinct('District', $where);

        echo json_encode([
            'province'    => $provinceList,
            'district'    => $districtList,
        ]);
    }

    public function getData()
    {
        $filters = $this->input->post();
        $data = $this->Card_review_summary_Model->getData($filters);

        echo json_encode(['data' => $data]);
    }
}