<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Card_review_summary_Model extends CI_Model
{
    public function getDistinct($column, $where = [])
    {
        $this->db->distinct();
        $this->db->select($column);

        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('tot_cards IS NOT NULL', null, false);
        return $this->db->get('card_review_Summary')->result_array();
    }

    public function getColumns()
    {
        return $this->db->list_fields('card_review_Summary');
    }

    public function getData($filters)
    {
        $this->db->from('card_review_Summary');

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
        $this->db->where('tot_cards IS NOT NULL', null, false);
        $this->db->order_by('Province', 'ASC');
        $this->db->order_by('District', 'ASC');

        return $this->db->get()->result_array();
    }
}