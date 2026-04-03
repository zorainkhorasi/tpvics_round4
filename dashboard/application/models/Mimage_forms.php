<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mimage_forms extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getDataImages($cluster, $hhno, $child)
    {
        $this->db->select("*");
        $this->db->from('vac_details');
        $this->db->where('f01  !=', '');
        $this->db->where('cluster_code', $cluster);
        $this->db->where('hhno', $hhno);
        $this->db->where('ec13', $child);
        $this->db->where("REPLACE(f01, ';', '|') NOT LIKE '%|%'");

        $query = $this->db->get();
        return $query->result();
    }


    function getProvince_District_($pro)
    {
        if (isset($pro) && $pro != '') {
            $this->db->where("clusters.dist_id like '" . $pro . "%' ");
        }
        $this->db->select("vac_details.cluster_code,clusters.geoarea,clusters.dist_id");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'INNER');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('vac_details.cluster_code !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where('clusters.geoarea not like \'test%\' ');
        $this->db->group_by('vac_details.cluster_code');
        $this->db->group_by('clusters.dist_id');
        $this->db->group_by('clusters.geoarea');
        $query = $this->db->get();
        return $query->result();
    }

    function getProvince_District($pro)
    {
        $dist_where = '';

        if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 &&
            !empty($this->encrypt->decode($_SESSION['login']['district']))) {
            $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
            $this->db->where_in('clusters.dist_id', $districts);
        }

        $this->db->select("clusters.dist_id, clusters.district");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'INNER');

        // Existing conditions
        $this->db->where("(clusters.colflag IS NULL OR clusters.colflag = '0')");
        $this->db->where('vac_details.cluster_code !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where("(vac_details.im02 = 0 OR vac_details.im02 = 1)");
        $this->db->where("clusters.geoarea NOT LIKE 'test%'");

        // NOT EXISTS condition
        $this->db->where("NOT EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE); // FALSE tells CodeIgniter not to escape

        $this->db->group_by('vac_details.cluster_code');
        $this->db->group_by('clusters.dist_id');
        $this->db->group_by('clusters.district');

        $query = $this->db->get();
        return $query->result();
    }
    function getProvince_District_two($pro)
    {
        $dist_where = '';

        if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 &&
            !empty($this->encrypt->decode($_SESSION['login']['district']))) {
            $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
            $this->db->where_in('clusters.dist_id', $districts);
        }

        $this->db->select("clusters.dist_id, clusters.district");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'INNER');

        // Existing conditions
        $this->db->where("(clusters.colflag IS NULL OR clusters.colflag = '0')");
        $this->db->where('vac_details.cluster_code !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where("(vac_details.im02 = 0 OR vac_details.im02 = 1)");
        $this->db->where("clusters.geoarea NOT LIKE 'test%'");

        // NOT EXISTS condition
        $this->db->where(" EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE); // FALSE tells CodeIgniter not to escape

        $this->db->group_by('vac_details.cluster_code');
        $this->db->group_by('clusters.dist_id');
        $this->db->group_by('clusters.district');

        $query = $this->db->get();
        return $query->result();
    }

    function getClusters($dist)
    {
        $this->db->select("vac_details.cluster_code");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'LEFT');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('vac_details.cluster_code  !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where("clusters.dist_id = '" . $dist . "' ");
        $this->db->where("NOT EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('vac_details.cluster_code');
        $query = $this->db->get();
        return $query->result();
    }




    function gethhnoByClust($cluster_code)
    {
        $this->db->select("hhno");
        $this->db->from('vac_details');
        $this->db->where('im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->where("NOT EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('hhno');
        $query = $this->db->get();
        return $query->result();
    }

    function getChildByHH($cluster_code, $hh)
    {
        $this->db->select("ec13");
        $this->db->from('vac_details');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->where('hhno', $hh);
        $this->db->where("NOT EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('ec13');
        $query = $this->db->get();
        return $query->result();
    }

    function getClusters_two($dist)
    {
        $this->db->select("vac_details.cluster_code");
        $this->db->from('vac_details');
        $this->db->join('clusters', 'vac_details.cluster_code = clusters.cluster_no', 'LEFT');
        $this->db->where(" (clusters.colflag is null OR clusters.colflag = '0') ");
        $this->db->where('vac_details.cluster_code  !=', '');
        $this->db->where('vac_details.im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where("clusters.dist_id = '" . $dist . "' ");
        $this->db->where("EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('vac_details.cluster_code');
        $query = $this->db->get();
        return $query->result();
    }


    function gethhnoByClust_two($cluster_code)
    {
        $this->db->select("hhno");
        $this->db->from('vac_details');
        $this->db->where('im01', '1');
        $this->db->where(' (vac_details.im02=0 or vac_details.im02=1) ');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->where(" EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('hhno');
        $query = $this->db->get();
        return $query->result();
    }

    function getChildByHH_two($cluster_code, $hh)
    {
        $this->db->select("ec13");
        $this->db->from('vac_details');
        $this->db->where('cluster_code', $cluster_code);
        $this->db->where('hhno', $hh);
        $this->db->where(" EXISTS (
                SELECT 1
                FROM vac_details_edit e
                WHERE e.cluster_code = vac_details.cluster_code
                  AND e.hhno = vac_details.hhno
                  AND e.ec13 = vac_details.ec13
            )", NULL, FALSE);
        $this->db->group_by('ec13');
        $query = $this->db->get();
        return $query->result();
    }

    function checkExistData($cluster, $hhno, $childNo = '')
    {
        if (isset($childNo) && $childNo != '') {
            $this->db->where("ec13", $childNo);
        }
        $this->db->select("*");
        $this->db->from('image_feedback');
        $this->db->where('cluster_no', $cluster);
        $this->db->where('household', $hhno);
        $this->db->order_by('id_Image_feedback','asc');
        $query = $this->db->get();
        return $query->result();
    }

}