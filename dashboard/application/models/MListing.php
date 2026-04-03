<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MListing extends CI_Model
{
    function get_districtBycountry($country_id)
    {
        $sql_query = "SELECT * FROM clusters where country_id='$country_id' and cluster_no not like '7000%' ";
        $query = $this->db->query($sql_query);
        $dis=[];
        foreach($query->result() as $key =>$q){
             $g=explode('|',$q->geoarea);
             $district=rtrim(ltrim($g[1]));
             $district_id = substr($q->cluster_no, 0, 2);
             $dis[$district_id]=$district;
        }
        return $dis;
    }

    function getData()
    {
        $sql_query = "SELECT
  l.hh02,
  count(*) as hh,
  SUM(CASE WHEN l.hl09 IS NOT NULL AND l.hl09 != '' AND l.hl09 != 'null' AND ISNUMERIC(l.hl09) = 1  THEN 1 ELSE 0 END) AS hl09,
  SUM(CASE WHEN l.hl14 IS NOT NULL AND l.hl14 != '' AND l.hl14 != 'null' AND ISNUMERIC(l.hl14) = 1 AND CAST(l.hl14 AS INT) < 5 THEN 1 ELSE 0 END) AS under_five,
   (case  when r.hh02 is null then 0 else 1 end) as is_random
FROM listings as l
left join bl_randomised r on r.hh02=l.hh02 and (r.colflag is null OR r.colflag = '0' OR r.colflag = 0)
where  (l.colflag is null OR l.colflag = '0' OR l.colflag = 0)
group by l.hh02  ,(case  when r.hh02 is null then 0 else 1 end)";
        $query = $this->db->query($sql_query);
        return $query->result_array();
    }



    function get_systematic_rand($cluster)
    {
        $sql_query = "select * from listings 
		where username not in('dmu@aku','user0001','user0002','test1234')
		and hh02 = '$cluster' AND (colflag is null OR colflag = '0' OR colflag = 0) and  hl14 IS NOT NULL AND hl14 != '' AND hl14 != 'null' AND ISNUMERIC(hl14) = 1 AND CAST(hl14 AS INT) < 5   
		order by hltab, deviceid, cast(structure_no as int), cast(hl02 as int)";
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
)
GROUP BY (hltab + '-' + structure_no + '-' + hl02)
HAVING (COUNT (hltab + '-' + structure_no + '-' + hl02)) > 1";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function insert_blrandomize($Data, $table)
    {
        $insert = $this->db->insert($table, $Data);
        if ($insert) {
            return 1;
        } else {
            return FALSE;
        }
    }


    function totalClusters_district($country_id)
    {

        $sql_query = "SELECT * FROM clusters where country_id='$country_id'  and cluster_no not like '7000%' ";
        $query = $this->db->query($sql_query);
        $dis=[];
        foreach($query->result() as $key =>$q){
            $g=explode('|',$q->geoarea);
            $district=trim($g[1]);
            $district_id = substr($q->cluster_no, 0, 2);
            $dis[$district_id]=$district;
        }
        $send_array=[];
        foreach($dis as $dist_id =>$d){

            $dist_count=0;
            foreach($query->result() as $q){
                $district_id = substr($q->cluster_no, 0, 2);
                if($district_id==$dist_id){
                    $dist_count++;
                }
            }
            $send_array[]=['district'=>trim($d),'clusters_by_district'=>$dist_count,'district_id'=>$dist_id];
        }
        return $send_array;

    }

    function completedClusters_district($country_id)
    {
        $sql_query = "SELECT * FROM clusters where country_id='$country_id' and randomized=1  and cluster_no not like '7000%' ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
    function get_randomized_cluster($district_cluster_type, $country_id,$sub_district_cluster_type)
    {
        if ($sub_district_cluster_type == 'c' ) {
            $sql_query = "SELECT * FROM clusters where country_id=$country_id and randomized=1 and cluster_no like '$district_cluster_type%'";
        }elseif ($sub_district_cluster_type == 'r' ){
            $sql_query = "SELECT * FROM clusters where country_id=$country_id and (randomized=0 or randomized is null)   and cluster_no like '$district_cluster_type%'";

        }elseif ($sub_district_cluster_type == 't'){
            $sql_query = "SELECT * FROM clusters where country_id=$country_id  and cluster_no like '$district_cluster_type%'";
        }
        $query = $this->db->query($sql_query);
        return $query->result();
    }
    function get_bl_randomized($cluster_no)
    {
        $sql_query = "SELECT * FROM bl_randomised LEFT JOIN clusters c ON bl_randomised.hh02 = c.cluster_no where hh02=$cluster_no  and (bl_randomised.colFlag is null or bl_randomised.colFlag=0) " ;
        $query = $this->db->query($sql_query);
        return $query->result();
    }




}