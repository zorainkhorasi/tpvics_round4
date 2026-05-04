<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MData_collection extends CI_Model
{
    public $globalWhere = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            $this->globalWhere = ' ';
        } else {
            $this->globalWhere = ' AND c.geoarea not like \'test%\' and c.dist_id not like  \'9%\' ';
        }
    }

    /*============================ Data Collection Province & District Start ============================*/
    function total_rand_clusters($district, $sub_district = '', $pageLevel = 1)
    {
        $dist_where = 'where  (c.colflag is null OR c.colflag = \'0\')   ' . $this->globalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " and prcode = '$district' ";
        }
        if (isset($sub_district) && $sub_district != '') {
            $exp = explode(',', $sub_district);
            $dist_where_clause = ' and (';
            foreach ($exp as $k => $d) {
                if ($k == 0) {
                    $or = '  ';
                } else {
                    $or = ' or ';
                }
                $dist_where_clause .= " $or dist_id = '" . substr(trim($d), 0, 3) . "' ";
            }
            $dist_where_clause .= ')';
            $dist_where .= $dist_where_clause;
        }

        if ($pageLevel == 2) {
            $selectQ = "  c.dist_id as my_id, district as my_name,";
            $groupQ = " dist_id,district ";
            $orderQ = " dist_id asc ";

            if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['district']))) {

                $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
                $districts_sql = "'" . implode("','", $districts) . "'";
                $dist_where .= "and c.dist_id IN ($districts_sql)";
            }

        } else {
            $selectQ = " prcode as my_id,province as my_name, ";
            $groupQ = " prcode,province ";
            $orderQ = " prcode asc ";

            if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['prcode']))) {
                //$prcode =$this->encrypt->decode($_SESSION['login']['prcode']);
               // $dist_where .= "and c.prcode =$prcode";

                $prcode = explode(',', $this->encrypt->decode($_SESSION['login']['prcode']));
                $prcode_sql = "'" . implode("','", $prcode) . "'";
                $dist_where .= "and c.prcode IN ($prcode_sql)";
            }





        }

        $sql_query = "SELECT $selectQ
SUM ( CASE WHEN randomized = '1' THEN 1 ELSE 0 END ) randomized_c
FROM clusters c $dist_where
GROUP BY $groupQ
ORDER BY $orderQ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function completed_rand_Clusters_district($district, $sub_district = '', $pageLevel = 1)
    {
    
        $dist_where = $this->globalWhere;
        if (isset($district) && $district != '') {
            $dist_where .= " and c.prcode = '$district' ";
        }
     

        if ($pageLevel == 2) {
            $str = 'c.dist_id';
            if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['district']))) {

                $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
                $districts_sql = "'" . implode("','", $districts) . "'";
                $dist_where .= "and c.dist_id IN ($districts_sql)";
            }

        } else {
            $str = 'c.prcode';
              if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['prcode']))) {
               // $prcode =$this->encrypt->decode($_SESSION['login']['prcode']);
               // $dist_where .= "and c.prcode =$prcode";

                  $prcode = explode(',', $this->encrypt->decode($_SESSION['login']['prcode']));
                  $prcode_sql = "'" . implode("','", $prcode) . "'";
                  $dist_where .= "and c.prcode IN ($prcode_sql)";
            }

        }
        $sql_query = "select $str as provinceId, c.cluster_no, c.sampled,
			(select count(*) from Randomised where dist_id = c.dist_id and hh02 = c.cluster_no  AND (Randomised.colflag is null OR Randomised.colflag = '0')) as hh_randomized,
			( SELECT 	COUNT (distinct f.hhid)  FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid = bl.hhid
            WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no ) AS hh_collected
			from clusters c where (c.colflag is null OR c.colflag = '0')   $dist_where  order by c.dist_id";
           //  echo $sql_query;
          //  die;
            $query = $this->db->query($sql_query);
            // var_dump($query->result());
            // die();
        return $query->result();
    }

    /*============================ Data Collection Province & District End ============================*/


    function get_data_collection_rand_table($district, $cluster_type = '', $sub_district = '', $sysdate = '')
    {

        $dist_where = ' and  c.geoarea not like \'test%\' ';
        if (isset($district) && $district != '' && $sub_district == '') {
            $dist_where .= " and c.dist_id = '$district' ";
        } 
        // elseif (isset($sub_district) && $sub_district != '') {
        //     $dist_where .= " and c.uc_id = '$sub_district' ";
        // }
       

        if (isset($cluster_type) && $cluster_type == 't') {
            $cluster_type_where = " ";
        } elseif (isset($cluster_type) && $cluster_type == 'c') {
            $cluster_type_where = " AND ( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid =bl.hhid
         WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no   ) >=13 ";
                } elseif (isset($cluster_type) && $cluster_type == 'r') {
                    $cluster_type_where = " AND (SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid = bl.hhid
         WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no  )=0 ";
                } elseif (isset($cluster_type) && $cluster_type == 'ip') {
                    $cluster_type_where = " AND ( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid = bl.hhid
         WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no   ) < 13 and  ( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid = bl.hhid
         WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no   ) > 0";
        } else {
            $cluster_type_where = '';
        }

        // if (isset($sysdate) && $sysdate != '') {
        //     $sysdate_join = " left join  forms ff on  ff.clustercode = c.cluster_no ";
        //     $sysdate_where = " and  ff.sysdate like '$sysdate%'  ";
        // } else {
        //     $sysdate_join = '';
        //     $sysdate_where = '';
        // }
        $sql_query = "select c.district, c.province,c.dist_id as dist_code, c.cluster_no as hh02,
        (select count(*) from Randomised where dist_id = c.dist_id and hh02 = c.cluster_no  AND (Randomised.colflag is null OR Randomised.colflag = '0')) as randomized_households,
        
        ( SELECT COUNT (distinct f.hhid) FROM forms f LEFT JOIN Randomised bl ON f.clustercode = bl.hh02 AND f.hhid = bl.hhid
        WHERE bl.dist_id = c.dist_id AND ( f.colflag IS NULL OR f.colflag = '0' ) AND f.clustercode = c.cluster_no ) as collected_forms,   
        (select count(distinct hhid) from forms where  clustercode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus=1 ) as completed_forms, 
        (select count(distinct hhid) from forms where  clustercode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus=4 ) as refused_forms, 
        (select count(distinct hhid) from forms where  clustercode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus=7 ) as not_elig, 
        (select count(distinct hhid) from forms where  clustercode = c.cluster_no AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (2,3,5,6,96)) as remaining_forms,
        (SELECT count(distinct fa.hhid) FROM forms fa left join children cb on fa.clustercode=cb.clustercode and fa.hhid=cb.hhid 
        where cb.hhid!='NULL' AND cb.colflag is null AND fa.colflag is null AND left(fa.username,3) not in ('dmu@aku','user0001','user0002','test1234') 
        and left(cb.username,3) not in  ('dmu@aku','user0001','user0002','test1234') and cb.ec22=1 and fa.clustercode = c.cluster_no GROUP BY fa.clustercode ) as one_child  
        from clusters c 
        where  (c.colflag is null OR c.colflag = '0')  
        $dist_where $cluster_type_where 
        group by c.dist_id, c.cluster_no,c.district, c.province
        order by c.dist_id,c.cluster_no";


        $query = $this->db->query($sql_query);
   
        return $query->result();
    }

    public function getDataCollectionProgress($filters = [])
    {
        $this->db->from('data_collection_progress');

        // Optional filters
        if (!empty($filters['district'])) {
            $this->db->where('dist_id', $filters['district']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('Status', $filters['status']);
        }

        return $this->db->get()->result();
    }

    function get_randomizedHH($cluster)
    {
        $sql_query = "select hh02, sno,  hhid AS hhno from Randomised 
where hh02 = '$cluster'  AND (Randomised.colflag is null OR Randomised.colflag = '0') order by cast(sno as int)";


        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_HH_status($cluster, $hhno)
    {
        $sql_query = "SELECT istatus  FROM forms WHERE clustercode = '$cluster' AND hhid = '$hhno' 
AND username NOT IN ( 'dmu@aku','user0001','user0002','test1234' )  AND (forms.colflag is null OR forms.colflag = '0') 
ORDER BY col_id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_collectedHH($cluster)
    {
        $sql_query = "select distinct clustercode, hhid,istatus from forms 
where clustercode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (1,2,3,4,5,6,7,96)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_completedHH($cluster)
    {
        $sql_query = "select distinct clustercode, hhid,istatus from forms 
where clustercode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus in (1)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_refusedHH($cluster)
    {
        $sql_query = "select distinct clustercode, hhid,istatus from forms 
where clustercode = '$cluster' AND (forms.colflag is null OR forms.colflag = '0')  and istatus =4";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}