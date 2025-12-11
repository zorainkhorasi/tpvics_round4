<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MUser_app extends CI_Model
{
    function getAllUserApp()
    {
        $this->db->select('*');
        $this->db->from('AppUser');
        $this->db->where('enabled', 1);
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $this->db->order_By('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getEditUser($idUser)
    {
        $this->db->select('*');
        $this->db->from('AppUser');
        $this->db->where('id', $idUser);
        $query = $this->db->get();
        return $query->result();
    }

    function checkUsername($username)
    {
        $this->db->select('*');
        $this->db->from('AppUser');
        $this->db->where('username', $username);
        $this->db->where('enabled', 1);
        $this->db->where(" (colflag is null OR colflag = '0') ");
        $query = $this->db->get();
        return $query->result();
    }

    function getAppUserByDist($dist_id)
    {
        if (isset($dist_id) && $dist_id != '') {
            $this->db->where("dist_id like  '" . $dist_id . "%' ");
        }
        $this->db->select('*');
        $this->db->from('AppUser');
        $this->db->where('enabled', 1);
        $this->db->where("(colflag is null OR colflag = '0') ");
        $this->db->order_By('username', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}