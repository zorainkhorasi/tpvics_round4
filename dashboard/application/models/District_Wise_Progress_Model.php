<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class District_Wise_Progress_Model extends CI_Model
{
    public function getDistinct($column, $where = [])
    {
        $this->db->distinct();
        $this->db->select($column);

        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->get('District_Wise_Progress')->result_array();
    }

    public function getColumns()
    {
        return $this->db->list_fields('District_Wise_Progress');
    }

    public function getData($filters)
    {
        $this->db->from('District_Wise_Progress');

        // Mandatory
        if (!empty($filters['Partner'])) {
            $this->db->where('Partner', $filters['Partner']);
        }

        // Optional filters
        if (!empty($filters['Province']) && $filters['Province'] != 'All') {
            $this->db->where('Province', $filters['Province']);
        }

        if (!empty($filters['District']) && $filters['District'] != 'All') {
            $this->db->where('District', $filters['District']);
        }
        $this->db->order_by('Province', 'ASC');
        $this->db->order_by('District', 'ASC');

        return $this->db->get()->result_array();
    }
}