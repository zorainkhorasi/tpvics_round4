<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MFormStatus extends CI_Model
{

    function getForms()
    {
        $this->db->select('form.elb8a AS village_id,
	form.elb8 AS village_name,
	form.elb11 AS household_id,
	form.istatus AS activity_status,
	form.deviceid AS device_tag_id,
	users.full_name');
        $this->db->from('form');
        $this->db->join('users', 'form.username = users.username', 'left');
        $this->db->where("form.username != 'test1234'");
        $this->db->where("form.username != 'dmu@aku'");
        $this->db->where("form.username != '0000'");
        $this->db->where("form.colFlag", 0);
        $this->db->order_By("(form.elb8a + '-' + form.elb11)", 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

}