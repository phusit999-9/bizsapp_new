<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }

    public function get_districts() {
        $province_id = $this->input->post('province_id');
        $query = $this->db->get_where('districts', ['province_id' => $province_id]);

        echo '<option value="">- เลือกอำเภอ -</option>';
        foreach ($query->result() as $row) {
            echo "<option value='{$row->id}'>{$row->name_in_thai}</option>";
        }
    }

    public function get_subdistricts() {
        $district_id = $this->input->post('district_id');
        $query = $this->db->get_where('subdistricts', ['district_id' => $district_id]);
      
        $result = [];
        foreach ($query->result() as $row) {
          $result[] = [
            'id' => $row->id,
            'name_in_thai' => $row->name_in_thai,
            'zip_code' => $row->zip_code,
          ];
        }
      
        echo json_encode($result);
      }
      
}
