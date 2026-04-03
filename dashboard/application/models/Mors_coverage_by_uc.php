<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mors_coverage_by_uc extends CI_Model
{

    function getData()
    {
        $sql_query = "SELECT * FROM [dbo].[uc_ors_pie] order by uc_name, ors desc";
        $query = $this->db->query($sql_query);
        return $query->result();

    }

}