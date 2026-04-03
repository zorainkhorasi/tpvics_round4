<?php ob_start();

class Household_status extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mhousehold_status');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', uri_string());

        $M = new MHousehold_status();
        $data['getData'] = $M->getData();

        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View App Users Page",
            "result" => "View App Users page. Fucntion: index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('household_status', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

} ?>