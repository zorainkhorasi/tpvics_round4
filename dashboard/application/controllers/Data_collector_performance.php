<?php ob_start();

class Data_collector_performance extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdata_collector_performance');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', uri_string());


        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View App Users Page",
            "result" => "View App Users page. Fucntion: index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/

        $M = new Mdata_collector_performance();
        $data['getData'] = $M->getData();


        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('data_collector_performance', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

} ?>