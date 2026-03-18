<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MLinelisting extends CI_Model
{
    public $globalWhere = '';
    public $global_listing_Where = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) {
            $this->globalWhere = ' ';
            $this->global_listing_Where = ' ';
        } else {
            $this->globalWhere = ' AND c.geoarea not like \'test%\' and c.dist_id not like  \'9%\' ';
            $this->global_listing_Where = ' AND (l.username not in(\'dmu@aku\',\'user0001\',\'user0002\',\'test1234\') or (l.username is NULL)) and l.geoArea not like \'test%\' ';
        }
    }

    /*============================ LineListing Province & District Start ============================*/


    function getClustersProvince($district, $sub_district = '', $pageLevel = '1')
    {
        $dist_where = 'where (c.colflag is null OR c.colflag = \'0\' OR c.colflag = 0) ' . $this->globalWhere;
        if (isset($district) && $district != '' && $pageLevel=2) {
            $dist_where .= " and prcode = '$district' ";
        }
        

         if ($pageLevel == 2) {

            $selectQ = " dist_id as my_id,district as my_name, COUNT (*) clusters_by_district ";
            $groupQ = "  dist_id,district";
            $orderQ = " dist_id asc ";

             if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['district']))) {

                 $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
                 $districts_sql = "'" . implode("','", $districts) . "'";
                 $dist_where .= "and c.dist_id IN ($districts_sql)";
             }

           
        } else {
           $selectQ = "prcode as my_id,province as my_name, COUNT (*) clusters_by_district ";
            $groupQ = "prcode,province";
            $orderQ = " province asc ";

             if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['prcode']))) {

                 $prcode =$this->encrypt->decode($_SESSION['login']['prcode']);
                 $dist_where .= "and c.prcode =$prcode";
             }
        }


        $sql_query = "SELECT  $selectQ FROM clusters c $dist_where GROUP BY  $groupQ ";


       /// echo $sql_query;die;
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function totalClusters_district($district, $sub_district = '', $pageLevel = 1)
    {
        $dist_where = 'where (c.colflag is null OR c.colflag = \'0\' OR c.colflag = 0) ' . $this->globalWhere;
       
        if (isset($district) && $district != '' && $pageLevel=2) {
            $dist_where .= " and prcode = '$district' ";
        }

        if ($pageLevel == 2) {

            $selectQ = " dist_id as my_id,district as my_name, COUNT (*) clusters_by_district ";
            $groupQ = "  dist_id,district";
            $orderQ = " dist_id asc ";
            if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['district']))) {

                $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
                $districts_sql = "'" . implode("','", $districts) . "'";
                $dist_where .= "and c.dist_id IN ($districts_sql)";
            }
        } else {
           $selectQ = "prcode as my_id,province as my_name, COUNT (*) clusters_by_district ";
            $groupQ = "prcode,province";
            $orderQ = " province asc ";

            if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['prcode']))) {
                $prcode =$this->encrypt->decode($_SESSION['login']['prcode']);
                $dist_where .= "and c.prcode =$prcode";
            }
        }




        $sql_query = "SELECT $selectQ FROM clusters c $dist_where   GROUP BY $groupQ order by $orderQ ";

       // echo $sql_query;die;
        $query = $this->db->query($sql_query);
        //    echo'<pre>';
        //             var_dump($query->result());
        //             die();
        return $query->result();
    }

    function completedClusters_district($district, $sub_district = '', $pageLevel = 1)
    {
        $dist_where = $this->globalWhere;
        /*if (isset($district) && $district != '' ) {
            $dist_where .= " and c.dist_id = '$district' ";
        }*/
       if (isset($district) && $district != '' && $pageLevel=2) {
            $dist_where .= " and prcode = '$district' ";
        }
        if ($pageLevel == 2) {
            $str = 'c.dist_id';
        } else {
            $str = 'c.prcode';
        }
        if ($this->encrypt->decode($_SESSION['login']['idGroup']) != 1 && !empty($this->encrypt->decode($_SESSION['login']['district']))) {

            $districts = explode(',', $this->encrypt->decode($_SESSION['login']['district']));
            $districts_sql = "'" . implode("','", $districts) . "'";
            $dist_where .= "and c.dist_id IN ($districts_sql)";
        }
//       where l.username not in('dmu@aku','user0001','user0002','test1234') AND
        $sql_query = "select c.geoArea,c.cluster_no,c.district, l.cluster_no, $str AS provinceId,
			(select count(distinct deviceid) from listings where cluster_no = l.cluster_no    AND (colflag is null OR colflag = '0' OR colflag = 0)) as collecting_tabs,
			(select count(distinct deviceid) from listings where cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0) AND hl10='8') as completed_tabs
			from clusters c
			left join listings l on l.cluster_no = c.cluster_no
			where (l.colflag is null OR l.colflag = '0' OR l.colflag = 0)  
			 AND (c.colflag is null OR c.colflag = '0' OR c.colflag = 0)
			$dist_where
			group by c.district,c.cluster_no,c.geoArea, l.cluster_no,c.dist_id,$str 
			order by c.geoArea,l.cluster_no asc ";
          /*   echo $sql_query;
             die;*/
        $query = $this->db->query($sql_query);
        
        return $query->result();
    }

    /*============================ LineListing Province & District END ============================*/
    /*============================ LineListing Datatable Start ============================*/
    function get_ll_structures($district, $sub_district = '', $sysdate = '')
    {
        $where = ' 1=1 ' . $this->global_listing_Where;
        if (isset($district) && $district != '') {
            $where .= " and l.dist_code= '$district' ";
        }
        /*elseif (isset($sub_district) && $sub_district != '') {
            $where .= " and l.dist_code = '".substr($sub_district,0,3)."' ";
        }*/

        if (isset($sysdate) && $sysdate != '') {
            $where = " and  l.sysdate like '$sysdate%'  ";
        }

        $sql_query = "SELECT MAX(CAST(l.structure_no AS INT)) as structure,	l.cluster_no,	l.hltab FROM	listings l  WHERE   $where
        AND (l.colflag is null OR l.colflag = '0' OR l.colflag = 0) 
        GROUP BY 	l.hltab,l.cluster_no,l.colflag  ORDER BY	l.hltab ASC";
        $query = $this->db->query($sql_query);
        return $query->result();

    }

    function get_ll_res_structures($district, $sub_district = '', $sysdate = '')
    {
        $where = $this->global_listing_Where;
       /* if (isset($district) && $district != '' && $sub_district == '') {
            $where .= " and SUBSTRING (l.dist_code, 1, 1) = '$district' ";
        } elseif (isset($sub_district) && $sub_district != '') {
            $where .= " and l.dist_code = '".substr($sub_district,0,3)."' ";
        }*/
        if (isset($district) && $district != '') {
            $where .= " and l.dist_code= '$district' ";
        }

        if (isset($sysdate) && $sysdate != '') {
            $where = " and  l.sysdate like '$sysdate%'  ";
        }

        $sql_query = "SELECT DISTINCT l.structure_no, l.hl02, l.hltab,l.cluster_no FROM listings l WHERE l.hl11 = '1' and hl14 !='Deleted'  
                                                                 AND (l.colflag is null OR l.colflag = '0' OR l.colflag = 0)  $where";

        //echo $sql_query;die;
        $query = $this->db->query($sql_query);
        return $query->result();

    }

    function get_linelisting_table($district, $cluster_type = '', $sub_district = '', $sysdate = '')
    {
        $dist_where = $this->globalWhere;
        if (! $sub_district == '') {
            $dist_where .= " and c.dist_id = '$sub_district' ";
        } 
     
        if ((isset($_SESSION['login']['idGroup']) && $this->encrypt->decode($_SESSION['login']['idGroup']) == 1) || $district=='901' ) {
            $users = '  ';
        } else {
            $users = ' and ( l.username NOT IN ( \'dmu@aku\', \'user0001\', \'user0002\', \'test1234\' ) OR l.username IS NULL ) ';
        }

        if (isset($cluster_type) && $cluster_type == 'c') {
            $users = ' and (l.username not in(\'dmu@aku\',\'user0001\',\'user0002\',\'test1234\'))';
            $cluster_type_where = " and c.randomized='1'";
        } elseif (isset($cluster_type) && $cluster_type == 'ip') {
            $cluster_type_where = " and (select count(distinct deviceid) from listings where cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0)) != 
					(select count(distinct deviceid) from listings where cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0) AND hl10='8')";
        } elseif (isset($cluster_type) && $cluster_type == 'r') {
            $cluster_type_where = " and  (select count(distinct deviceid) from listings where cluster_no = l.cluster_no AND (colflag is null OR colflag = '0' OR colflag = 0) )=0 ";
        } else {
            $cluster_type_where = '';
        }

        if (isset($sysdate) && $sysdate != '') {
            $sysdate_where = " and  l.sysdate like '$sysdate%'  ";
        } else {
            $sysdate_where = '';
        }


        $sql_query = "SELECT c.randomized, c.geoarea, c.cluster_no,c.exphh,	c.dist_id ,'App' as data_collected ,   
            sum(case when hl22a = '1'  then 1 else 0 end) as target_children,
            (select SUM(CAST(hl22 as int)) from listings where hl22a='1' and (hl22!='null' or hl22 is not null)  and cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0)) as no_of_children,
            (select count(distinct deviceid) from listings where cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0)) as collecting_tabs,
            (select count(distinct deviceid) from listings where cluster_no = l.cluster_no  AND (colflag is null OR colflag = '0' OR colflag = 0) AND hl10='8') as completed_tabs,
            (select top 1 cast (ll.sysdate  as datetime)  from Listings ll where ll.cluster_no = l.cluster_no order by ll.sysdate asc) as startActivity,
            (select top 1 cast (ll.sysdate  as datetime)  from Listings ll where ll.cluster_no = l.cluster_no order by ll.sysdate desc) as endActivity,
            (select  cc.randomized  from clusters cc where  cluster_no = l.cluster_no  group by cc.cluster_no,cc.randomized  ) as status,
            ( SELECT p.status FROM planning p WHERE (p.colflag is null OR p.colflag = '0' OR p.colflag = 0) AND p.cluster_no = c.cluster_no and  p.status!=0 group by p.status  ) AS planning 
                                        from clusters c
                            left join listings l on c.cluster_no=l.cluster_no  AND (l.colflag is null OR l.colflag = '0' OR l.colflag = 0) 
                              where   1=1  $users
                            
                             AND (c.colflag is null OR c.colflag = '0' OR c.colflag = 0)
                              $dist_where  $cluster_type_where $sysdate_where
                            group by c.randomized,c.geoarea,	c.exphh,l.cluster_no,c.cluster_no,  c.dist_id 
                            order by c.geoArea,c.cluster_no";


      //  echo $sql_query;die;

        $query = $this->db->query($sql_query);
        return $query->result();

    }
    /*============================ LineListing Datatable END ============================*/

    /*Systematic Randomization*/

    function get_rand_cluster($cluster)
    {
        $sql_query = "select randomized from clusters where cluster_no = '$cluster' AND (colflag is null OR colflag = '0' OR colflag = 0)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_resdential_hh($cluster)
    {
        $sql_query = "select DISTINCT l.structure_no, l.hl02, l.hltab from listings l  WHERE l.hl11 = '1' and l.hl22a='1' and hl14 !='Deleted'   and cluster_no = '$cluster' AND (l.colflag is null OR l.colflag = '0' OR l.colflag = 0) ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function get_systematic_rand($cluster)
    {
        $sql_query = "select * from listings 
		where username not in('dmu@aku','user0001','user0002','test1234')
		and hl11 = '1' and hl22a = '1'  and cluster_no = '$cluster' AND (colflag is null OR colflag = '0' OR colflag = 0)   order by hltab, deviceid, cast(structure_no as int), cast(hl02 as int)";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function chkDuplicateTabs($cluster)
    {
        $sql_query = "SELECT
	COUNT ((hltab + '-' + structure_no + '-' + hl02)) AS duplicates,
	(hltab + '-' + structure_no + '-' + hl02) AS hh
    FROM
        listings
    WHERE
        cluster_no = '$cluster' and hl10 not in (7,8,9)
    AND (
        colflag IS NULL
        OR colflag = '0'
        OR colflag = 0 
    )
    AND username NOT IN (
        'dmu@aku',
        'user0001',
        'user0002',
        'test1234'
    ) AND istatus=1
    GROUP BY (hltab + '-' + structure_no + '-' + hl02)
    HAVING (COUNT (hltab + '-' + structure_no + '-' + hl02)) > 1";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function chkDuplicateTabs_($cluster)
    {
        $sql_query = "select   deviceid,hltab from listings  
where cluster_no='$cluster' AND (colflag is null OR colflag = '0' OR colflag = 0 ) and username not in('dmu@aku','user0001','user0002','test1234') group by deviceid,hltab ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*function get_residential_structures($cluster)
    {
        $sql_query = "select distinct hl09, hltab from listings where cluster_no = '$cluster' and hl11 = '1' and hl20='1' AND (colflag is null OR colflag = '0')  ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }*/

    function insert_blrandomize($Data, $table)
    {
        $insert = $this->db->insert($table, $Data);
        if ($insert) {
            return 1;
        } else {
            return FALSE;
        }
    }

    function update_cluster($Data, $key, $value, $table)
    {
        $this->db->where($key, $value);
        $update = $this->db->update($table, $Data);
        if ($update) {
            return 1;
        } else {
            return 0;
        }
    }


    /*Make PDF & get Excel*/
    function get_bl_randomized($cluster)
    {
        $dist_where = ' and clusters.geoarea not like \'test%\' ';
        $sql_query = "select Randomised.randDT,
	Randomised.sno,
	Randomised.hh02,
	Randomised.hl09,
	--Randomised.hl02,
	Randomised.hl10,
	Randomised.hl11,
	Randomised.hl12,
--	Randomised.hhss,
	Randomised.compid,
	Randomised.total,
	Randomised.randno,
	Randomised.quot,
	Randomised.ssno,
--	Randomised.hhdt,
	Randomised.dist_id,
	Randomised.hltab,
	planning.collection_date,
    planning.collector_name,
    planning.tablet_id,
	clusters.geoarea
FROM
	Randomised
LEFT JOIN clusters ON Randomised.hh02 = clusters.cluster_no
LEFT JOIN planning ON clusters.cluster_no = planning.cluster_no
 where Randomised.hh02 = '$cluster' AND ( Randomised.colflag IS NULL OR Randomised.colflag = '0' OR Randomised.colflag = 0) 
   AND (clusters.colflag is null OR clusters.colflag = '0' OR clusters.colflag = 0)  AND (Randomised.colflag is null OR Randomised.colflag = '0' OR Randomised.colflag = 0) $dist_where";


     //   echo $sql_query;die;
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /*Planning*/

    function get_planning($cluster)
    {
        $this->db->select('*');
        $this->db->from('planning');
        $this->db->where('status!=0');
        $this->db->where("(colflag IS NULL OR colflag = '0')");
        $this->db->where('cluster_no', $cluster);
        $query = $this->db->get();
        return $query->result();
    }

}