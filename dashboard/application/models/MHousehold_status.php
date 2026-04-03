<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MHousehold_status extends CI_Model
{

    function getData()
    {
        $sql_query = "SELECT
	f.elb7,
	COUNT (0) AS hh_surveyed, 
	SUM ( CASE WHEN f.bfj1ca !='' OR f.bfj1ca is not null THEN 1 ELSE 0 END ) AS u2,
	SUM ( CASE WHEN f.elc6 = 1 THEN 1 ELSE 0 END ) AS with_u5,
	SUM ( CASE WHEN f.elc6 != 1 THEN 1 ELSE 0 END ) AS without_u5,
	SUM ( CASE WHEN f.chg1 = 1 THEN 1 ELSE 0 END ) AS dia,
	SUM ( CASE WHEN f.arih3 = 1 THEN 1 ELSE 0 END ) AS ari,
	SUM ( CASE WHEN f.chg1 = 1 AND f.arih3 = 1  THEN 1 ELSE 0 END ) AS both_dia_ari
FROM
	dbo.form AS f
WHERE
	(f.istatus = 1) AND (f.colFlag = 0)
 AND (f.username != 'dmu@aku' AND f.username not like '000%' AND f.username not like 'test%')
GROUP BY
	f.elb7 ";
        $query = $this->db->query($sql_query);
        return $query->result();

    }

}