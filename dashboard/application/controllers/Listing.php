<?php ob_start();

class Listing extends CI_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('MListing');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function dashboard_index()
    {
        $data = array();
        $MSettings = new MSettings();

        $data['country_id']=$_SESSION['login']['check_country'];//$this->uri->segment(3);

        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'listing/dashboard_index');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $district = '';
            $sub_district = '';
            $level = 2;

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $u_district = $_SESSION['login']['district'];
                $sub_district = $_SESSION['login']['district'];
            } else {
                $u_district = '';
            }
            $MLinelisting = new MListing();

            $dist_array=$MLinelisting->get_districtBycountry($data['country_id']);
            $data['dist_array']=$dist_array;
            /*==============Total Clusters List==============*/
            $totalClusters_district = $MLinelisting->totalClusters_district($data['country_id']);


            $totalcluster=0;
            $clusters_by_district=[];
            foreach ($totalClusters_district as $t){
                $totalcluster +=$t['clusters_by_district'];
                $clusters_by_district[$dist_array[$t['district_id']]]=array('clusters_by_district'=>$t['clusters_by_district'],'id'=>$t['district'],'district_id'=>$t['district_id']);
            }

            $data['totalcluster']['total'] = $totalcluster;
            $data['totalcluster']['list'] = $clusters_by_district;

            /*==============Completed Clusters List==============*/
            $completedClusters_district = $MLinelisting->completedClusters_district($data['country_id']);
            //echo '<pre>';print_r($completedClusters_district);die;


            if (isset($district) && $district != '') {
                foreach ($dist_array as $k => $dist_name) {
                    $data['total'][$dist_name] = 0;
                    $data['completed'][$dist_name] = 0;
                    $data['ip'][$dist_name] = 0;
                    $data['r'][$dist_name] = 0;
                }
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    foreach ($dist_array as $key => $dist_name) {
                        $data['total'][$dist_name] = 0;
                        $data['completed'][$dist_name] = 0;
                        $data['ip'][$dist_name] = 0;
                        $data['r'][$dist_name] = 0;

                    }
                }
            }


            $data['total']['total'] = 0;
            $data['completed']['total'] = 0;
            $data['ip']['total'] = 0;
            foreach ($completedClusters_district as $row) {
                $district_id = substr($row->cluster_no, 0, 2);
                foreach ($dist_array as $key => $dist_name) {
                    if($district_id==$key){
                        $data['total'][$dist_name]++;
                        $data['completed'][$dist_name]++;
                        $data['completed']['total']++;

                    }
                }
            }
            /*==============Remaining Clusters List==============*/
            $data['r']['total'] = 0;
            foreach ($totalClusters_district as $row2) {
                $ke = $row2['district_id'];
                foreach ($dist_array as $key => $dist_name) {
                    if ($ke == $key) {
                        $data['r'][$dist_name] = isset($row2['clusters_by_district'])?$row2['clusters_by_district'] - $data['total'][$dist_name]:0;
                        $data['r']['total'] += $data['r'][$dist_name];
                    }
                }
            }
            /*==============Remaining Clusters List==============*/
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('linelisting', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }

    }

    function dashboard_dt()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($_SESSION['login']['idGroup'], '', 'dashboard/linelisting_dashboard');
        if (1 == 1) {
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
            } else {
                $district = '';
            }
            $MLinelisting = new MListing();


            $data['district_cluster_type'] = $this->uri->segment(3);
            $data['sub_district_cluster_type'] = $this->uri->segment(4);
            $data['country_id'] = $this->uri->segment(5);
            $dist_array=$MLinelisting->get_districtBycountry($data['country_id']);
            $data['dis_name']=$dist_array[$this->uri->segment(3)];



            /*============== Linelisting Data table ==============*/

           // $data['cluster_type'] = $cluster_type;
            if ($data['sub_district_cluster_type'] == 'c' ) {
                $data['get_cluster_table'] = $MLinelisting->get_randomized_cluster($data['district_cluster_type'], $data['country_id'],$data['sub_district_cluster_type']);
            }elseif ( $data['sub_district_cluster_type'] == 'r' ){
                $data['get_cluster_table'] = $MLinelisting->get_randomized_cluster($data['district_cluster_type'], $data['country_id'],$data['sub_district_cluster_type']);

            }elseif ( $data['sub_district_cluster_type'] == 't' ){
                $data['get_cluster_table'] = $MLinelisting->get_randomized_cluster($data['district_cluster_type'], $data['country_id'],$data['sub_district_cluster_type']);
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('linelisting_datatable', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }

    }


    function make_pdf()
    {
        $data = array();
        $data['cluster'] = $this->uri->segment(3);
        if (isset($data['cluster']) && $data['cluster'] != '') {
            $this->load->library('tcpdf');
            $MLinelisting = new MListing();
            $data['cluster_data'] = $MLinelisting->get_bl_randomized($data['cluster']);
            //print_r($data['cluster_data']);die;

            $data['randomization_date'] = substr($data['cluster_data'][0]->randDT, 0, 10);
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('CASI-ML');
            $pdf->SetTitle('Cluster No: ' . $data['cluster']);
            $pdf->SetSubject('CASI-ML');
            $pdf->SetKeywords('CASI-ML');


            $geoarea = explode('|', $data['cluster_data'][0]->geoarea);

            $header = '<strong>CASI-ML - Cluster No: ' . $data['cluster'] . '</strong><br>
            Geoarea: ' . $data['cluster_data'][0]->geoarea  ;
            $pdf->setHtmlHeader('<p style="font-size: 12px;  border-bottom: 1px solid black;">' . $header . '</p>');
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetTopMargin(18);
            $pdf->setPrintHeader(true);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);;
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . ' / lang / eng . php')) {
                require_once(dirname(__FILE__) . ' / lang / eng . php');
            }
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->AddPage();
            $pdf->Write(0, 'Randomization Date: ' . $data['randomization_date'], '', 0, 'R', true, 0, false, false, 0);
            $pdf->SetFont('helvetica', '', 9);
            $tbl = '<table border="1" cellpadding="0" cellspacing="0" width="100%"  style="text-align:center; padding: 2px">
                 <tr>
                 <th width="10%" style="text-align:center"><b>Serial No</b></th> 
                  <th width="12%" style="text-align:center"><b>HHid</b></th>
                   <th width="20%" style="text-align:center"><b>Head of Household</b></th>
                   <th width="50%" style="text-align:center; "><b>Remarks</b></th>
             
                 </tr>';
            $sno = 1;
            $c_6_11 = 0;
            $c_12_23 = 0;
            foreach ($data['cluster_data'] as $row) {

                $hhid=$row->hl09.'-'.$row->hl10;

                $tbl .= '<tr  border="0"><td  border="0" style="text-align:center">' . $sno++ . '</td> 
            <td style="text-align:center">' . $hhid.'</td>
            <td style="text-align:center">' . ucfirst($row->hl11) . '</td>
            <td style="text-align:center; height: 27px"  border="0"> </td>
            </tr>';
            }
            $tbl .= '</table>';


            $pdf->writeHTML($tbl, true, false, true, false, '');



           // $pdf->writeHTML($footer, true, false, true, false, '');

            $pdf->Output('randmozied.pdf', 'I');
            ob_end_flush();
            ob_end_clean();
            $track_msg = 'Success';
        } else {
            $track_msg = 'Invalid Cluster';
            echo 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Linelisting datatable pdf",
            "action" => "Linelisting PDF -> Function: Dashboard/make_pdf()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }






} ?>