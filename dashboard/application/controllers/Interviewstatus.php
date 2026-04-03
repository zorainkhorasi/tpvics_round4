<?php ob_start();

class Interviewstatus extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('minterviewstatus');
        $this->load->model('msettings');
        $this->load->library('session');
        $this->load->helper('string');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $minterviewstatus = new minterviewstatus();
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'interviewstatus');

        if(isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1){
            $data['country_id']=$_SESSION['login']['check_country'];
            $data['data'] = $minterviewstatus->getdata($data['country_id']);

            $Custom = new Custom();
            $trackarray = array("action" => "View App Users Page",
                "result" => "View App Users page. Fucntion: index()");
            $Custom->trackLogs($trackarray, "user_logs");
            /*==========Log=============*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('interview_status', $data);
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
        $minterviewstatus = new minterviewstatus();
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'interviewstatus/getdetails');

        if(1==1){

            $cluster_no=$this->uri->segment(3);
            $data['country_id']=$_SESSION['login']['check_country'];
            $data['data'] = $minterviewstatus->getdataDetails($cluster_no,$data['country_id']);

            $Custom = new Custom();
            $trackarray = array("action" => "View anthro_hb_status Page",
                "result" => "View anthro_hb_status page. Fucntion: index()");
            $Custom->trackLogs($trackarray, "user_logs");
            /*==========Log=============*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('interview_status_details', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        }else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
    }
} ?>