<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DataQualityModel extends CI_Model
{
    public function getDistinct($column, $where = [])
    {
        $this->db->distinct();
        $this->db->select($column);

        if (!empty($where)) {
            $this->db->where($where);
        }

        return $this->db->get('data_quality_issues')->result_array();
    }

    public function getColumns()
    {
        return $this->db->list_fields('data_quality_issues');
    }

    public function getData($filters)
    {
        $this->db->from('data_quality_issues');

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

        if (!empty($filters['Observation']) && $filters['Observation'] != 'All') {
            $this->db->where('Observation', $filters['Observation']);
        }

        return $this->db->get()->result_array();
    }
}