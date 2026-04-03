<?php ob_start();

class Ors_coverage_by_uc extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mors_coverage_by_uc');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', uri_string());

        $M = new Mors_coverage_by_uc();
        $getData = $M->getData();
        $result=array();
        foreach ($getData as $d){
            $result[$d->uc]['uc']=$d->uc;
            $result[$d->uc]['uc_name']=$d->uc_name;
            if($d->ors=='no'){
                $result[$d->uc]['ors_no']=$d->total_ors;
            }
            if($d->ors=='yes'){
                $result[$d->uc]['ors_yes']=$d->total_ors;
            }

        }
        $data['getData'] =$result;



        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View App Users Page",
            "result" => "View App Users page. Fucntion: index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('ors_coverage_by_uc', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

} ?>