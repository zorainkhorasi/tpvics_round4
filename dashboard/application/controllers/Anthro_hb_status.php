<?php ob_start();

class Anthro_hb_status extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('manthro');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $manthro = new manthro();
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'anthro_hb_status');

        if(isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1){

            $data['country_id']=$_SESSION['login']['check_country'];
            $data['data'] = $manthro->getdata($data['country_id']);

            $Custom = new Custom();
            $trackarray = array("action" => "View anthro_hb_status Page",
                "result" => "View anthro_hb_status page. Fucntion: index()");
            $Custom->trackLogs($trackarray, "user_logs");
            /*==========Log=============*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('anthro_status', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        }else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
    }

    function getdetails()
    {
        $manthro = new manthro();
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'anthro_hb_status');

        if(isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1){

            $cluster_no=$this->uri->segment(3);
            $data['country_id']=$_SESSION['login']['check_country'];
            $data['data'] = $manthro->getdataDetails($cluster_no,$data['country_id']);

            $Custom = new Custom();
            $trackarray = array("action" => "View anthro_hb_status Page",
                "result" => "View anthro_hb_status page. Fucntion: index()");
            $Custom->trackLogs($trackarray, "user_logs");
            /*==========Log=============*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('anthro_details.php', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        }else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
    }




} ?>