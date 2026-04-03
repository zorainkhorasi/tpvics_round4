<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdata_collector_performance extends CI_Model
{

    function getData()
    {
        $sql_query = "SELECT
	users.full_name, 
	COUNT (f.username) AS hh_surveyed, 
	SUM ( CASE WHEN f.chg1 = 1 THEN 1 ELSE 0 END ) AS dia, 
	SUM ( CASE WHEN f.arih3 = 1 THEN 1 ELSE 0 END ) AS ari
FROM
	dbo.form AS f
LEFT JOIN dbo.users ON f.username = dbo.users.username
WHERE
	(f.istatus = 1) AND (f.colFlag = 0)  AND (f.username != 'dmu@aku' AND f.username not like '000%' AND f.username not like 'test%')
GROUP BY
	users.full_name";
        $query = $this->db->query($sql_query);
        return $query->result();

    }

}