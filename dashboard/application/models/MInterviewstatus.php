<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MInterviewstatus extends CI_Model
{

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

    function getdata($district_cluster_type, $country_id,$sub_district_cluster_type)
    {
        $where='';
        $where_second='';
       if($sub_district_cluster_type == 'c' ){
           $where=" Where  c.cluster_no not like '7000%' and c.country_id='$country_id' and cluster_no like '$district_cluster_type%'";
           $where_second=" Where  n.HHvisited >14 ";
       }elseif ($sub_district_cluster_type == 'i' ){
           $where_second=" Where  n.HHvisited < 15   and n.HHvisited > 0";
           $where=" Where  c.cluster_no not like '7000%' and c.country_id='$country_id' and cluster_no like '$district_cluster_type%' ";
       }elseif ($sub_district_cluster_type == 't'){
           $where=" Where  c.cluster_no not like '7000%' and c.country_id='$country_id' and cluster_no like '$district_cluster_type%'";
       }elseif ($sub_district_cluster_type == 'r'){
           $where=" Where  c.cluster_no not like '7000%' and c.country_id='$country_id' and cluster_no like '$district_cluster_type%' and (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0))=0";
       }
        return $this->db->query(" select * from(SELECT SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2) AS district,
            c.cluster_no,
            (SELECT COUNT(*) FROM bl_randomised r  WHERE c.cluster_no = r.hh02  and (r.colFlag is null or r.colFlag=0)  ) AS randomizedHH,
               (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0)) AS HHvisited,
               (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.istatus=1)  AS Completed,
               (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.istatus=4)  AS Refused,
               (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.istatus in(2,3,5,6,96))  AS Others,
               (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w113=1)  AS MWRAEntered,
               (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w301 is not null)  AS ANC_Filled,
               (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w401 is not null)  AS DPC_Filled,
               (SELECT COUNT(*) FROM Child cd  WHERE c.cluster_no = cd.clustercode and (cd.colFlag is null or cd.colFlag=0) and cd.c202 is not null)  AS IYCF_Filled,
               (SELECT COUNT(*) FROM Child cd  WHERE c.cluster_no = cd.clustercode  and (cd.colFlag is null or cd.colFlag=0) and cd.c401 is not null)  AS Immunization
               FROM clusters c 
               $where
               GROUP BY SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2), c.cluster_no) n  $where_second;
        ")->result();
    }
    function getdataDetails($cluster_no,$country_id)
    {


        return $this->db->query("select 
    f.h101 as country,SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2) AS district, f.h107 as hh_id,f.h110 as hh_res,c.cluster_no, f.istatus as status,
	   (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w113=1 and f.h107=m.hhid)  AS MWRAEntered,
       (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w301 is not null and f.h107=m.hhid)  AS ANC_Filled,
       (SELECT COUNT(*) FROM mwra m  WHERE c.cluster_no = m.clustercode and (m.colFlag is null or m.colFlag=0) and m.w401 is not null and f.h107=m.hhid)  AS DPC_Filled,
	   (SELECT COUNT(*) FROM Child cd  WHERE c.cluster_no = cd.clustercode and (cd.colFlag is null or cd.colFlag=0) and cd.c202 is not null and f.h107=cd.c107)  AS IYCF_Filled,
       (SELECT COUNT(*) FROM Child cd  WHERE c.cluster_no = cd.clustercode and (cd.colFlag is null or cd.colFlag=0) and cd.c401 is not null and  f.h107=cd.c107)  AS Immunization,
        '0' as not_visited 
	   from clusters c 
	   inner join form f  on f.clustercode=c.cluster_no and (f.colFlag is null or f.colFlag=0)
	   where f.clusterCode=$cluster_no and c.country_id='$country_id' 
	   union
	    select  SUBSTRING(c.geoarea, 1, CHARINDEX('|', c.geoarea) - 2) AS district,
			 SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2) AS district,
			 CONCAT(r.hl09,'-',r.hl10) as hh_id,
			'0' as hh_res,
			 c.cluster_no, 
			'121' as status,
			'0'  AS MWRAEntered,
			'0'  AS ANC_Filled,
			'0'  AS DPC_Filled,
			'0'  AS IYCF_Filled,
			'0' AS Immunization	,
			'1' as not_visited 
			from bl_randomised r 
		inner join clusters c on c.cluster_no=r.hh02
			where r.hh02 = '$cluster_no' and c.country_id='$country_id'  and  (r.colflag=0 or r.colflag is null)
		and CONCAT(r.hl09,'-',r.hl10) not in (select h107 from form where clusterCode = r.hh02  and (form.colFlag is null or form.colFlag=0))

	   ")->result();

    }

}