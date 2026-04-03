<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MAnthro extends CI_Model
{

    function getdata($country_id)
    {
        return $this->db->query("SELECT SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2) AS district,
    c.cluster_no,
       (SELECT COUNT(*) FROM form f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0)) AS HHvisited,
       (SELECT COUNT(*) FROM Family_Members f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and h214=1) AS present_members,
       (SELECT COUNT(*) FROM Family_Members f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.h214=1 and f.h204=2 and f.h208=1 and f.h206y between 15 and 49 ) AS MWRAs,
       (SELECT COUNT(*) FROM Family_Members f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.h214=1  and f.h206y between 0 and 4 ) AS U5,
       (SELECT COUNT(*) FROM Family_Members f  WHERE c.cluster_no = f.clustercode and (f.colFlag is null or f.colFlag=0) and f.h214=1  and f.h204=2 and f.h208!=1 and h206y between 10 and 19  ) AS Fem_Adolescent,
       (SELECT COUNT(*) FROM Family_Members f left join anthro an on f.clustercode=an.clustercode and f.hhid=an.hhid and f.memberlineno=an.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h204=2 and  f.h208=1 and f.h206y between 15 and 49 and an.d102 is not null and (f.colFlag is null or f.colFlag=0) ) AS AN_MWRAs,
       (SELECT COUNT(*) FROM Family_Members f left join anthro an on f.clustercode=an.clustercode and f.hhid=an.hhid and f.memberlineno=an.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h206y between 0 and 4 and an.d102 is not null and (f.colFlag is null or f.colFlag=0)) AS AN_U5,
       (SELECT COUNT(*) FROM Family_Members f left join anthro an on f.clustercode=an.clustercode and f.hhid=an.hhid and f.memberlineno=an.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h204=2 and f.h208!=1 and f.h206y between 10 and 19 and an.d102 is not null and (f.colFlag is null or f.colFlag=0)) AS AN_Adolescent,
       (SELECT COUNT(*) FROM Family_Members f left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and f.memberlineno=h.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h206y between 0 and 4 and h.e101=1 and (f.colFlag is null or f.colFlag=0)) AS HB_IndexChild,
       (SELECT COUNT(*) FROM Family_Members f left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and f.memberlineno=h.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h204=2 and  f.h208=1 and f.h206y between 15 and 49 and h.e101=1 and (f.colFlag is null or f.colFlag=0)) AS HB_MWRAs,
              (SELECT COUNT(*) FROM Family_Members f left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and f.memberlineno=h.memberlineno
       WHERE  c.cluster_no = f.clustercode and f.h214=1 and f.h204=2 and f.h208!=1 and f.h206y between 10 and 19 and h.e101=1 and (f.colFlag is null or f.colFlag=0)) AS hb_Adolescent
       FROM clusters c 
        Where  c.cluster_no not like '7000%' and c.country_id='$country_id'
       GROUP BY SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2), c.cluster_no
")->result();
    }

    function getdataDetails($cluster_no,$country_id)
    {
        return $this->db->query("select f.h101 as country,SUBSTRING(c.geoarea, CHARINDEX('| ', c.geoarea) + 1, CHARINDEX('|', c.geoarea) - 2) AS district, f.h107 as hh_id,f.h110 as hh_res,c.cluster_no, f.istatus as status,
           (SELECT COUNT(*) FROM Family_Members fm  WHERE fm.clusterCode = f.clustercode and (fm.colFlag is null or fm.colFlag=0) and h214=1 and fm.hhid=f.h107) AS present_members,
		   (SELECT COUNT(*) FROM Family_Members fm  WHERE fm.clusterCode = f.clustercode and (fm.colFlag is null or fm.colFlag=0) and fm.h214=1 and fm.h204=2 and fm.h208=1 and fm.h206y between 15 and 49 and fm.hhid=f.h107) AS MWRAs,
		   (SELECT COUNT(*) FROM Family_Members fm  WHERE fm.clusterCode = f.clustercode and (fm.colFlag is null or fm.colFlag=0) and fm.h214=1  and fm.h206y between 0 and 4 and fm.hhid=f.h107) AS U5,
		   (SELECT COUNT(*) FROM Family_Members fm  WHERE fm.clusterCode = f.clustercode and (fm.colFlag is null or fm.colFlag=0) and fm.h214=1  and fm.h204=2 and fm.h208!=1 and h206y between 10 and 19  and fm.hhid=f.h107) AS Fem_Adolescent,
		   (SELECT COUNT(*) FROM Family_Members fm left join anthro an on fm.clustercode=an.clustercode and fm.hhid=an.hhid and fm.memberlineno=an.memberlineno
		   WHERE  fm.clusterCode = f.clustercode and fm.h214=1 and fm.h204=2 and  fm.h208=1 and fm.h206y between 15 and 49 and an.d102 is not null and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS AN_MWRAs,
		   (SELECT COUNT(*) FROM Family_Members fm left join anthro an on fm.clustercode=an.clustercode and fm.hhid=an.hhid and fm.memberlineno=an.memberlineno
		   WHERE  fm.clustercode = f.clustercode and fm.h214=1 and fm.h206y between 0 and 4 and an.d102 is not null and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS AN_U5,
		   (SELECT COUNT(*) FROM Family_Members fm left join anthro an on f.clustercode=an.clustercode and f.hhid=an.hhid and fm.memberlineno=an.memberlineno
		   WHERE fm.clustercode = f.clustercode and fm.h214=1 and fm.h204=2 and fm.h208!=1 and fm.h206y between 10 and 19 and an.d102 is not null and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS AN_Adolescent,
		   (SELECT COUNT(*) FROM Family_Members fm left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and fm.memberlineno=h.memberlineno
		   WHERE  fm.clustercode = f.clustercode and fm.h214=1 and fm.h206y between 0 and 4 and h.e101=1 and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS HB_IndexChild,
		   (SELECT COUNT(*) FROM Family_Members fm left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and fm.memberlineno=h.memberlineno
		   WHERE  fm.clustercode = f.clustercode and fm.h214=1 and fm.h204=2 and  fm.h208=1 and fm.h206y between 15 and 49 and h.e101=1 and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS HB_MWRAs,
				  (SELECT COUNT(*) FROM Family_Members fm left join Hemoglobin h on f.clustercode=h.clustercode and f.hhid=h.hhid and fm.memberlineno=h.memberlineno
		   WHERE  fm.clustercode= f.clustercode and fm.h214=1 and fm.h204=2 and fm.h208!=1 and fm.h206y between 10 and 19 and h.e101=1 and fm.hhid=f.h107 and (fm.colFlag is null or fm.colFlag=0)) AS hb_Adolescent
	   from clusters c 
	   inner join form f  on f.clustercode=c.cluster_no
	   where f.clusterCode=$cluster_no and c.country_id='$country_id'")->result();
    }

}