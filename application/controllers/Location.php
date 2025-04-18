<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }

    // โหลดข้อมูลอำเภอโดย province_id
    public function get_districts() {
        $province_id = $this->input->post('province_id');
        $query = $this->db->get_where('districts', ['province_id' => $province_id]);
        // ส่งข้อมูลเป็น <option> กลับให้ JS
        if ($query->num_rows() > 0) {
            echo '<option value="">- เลือกอำเภอ -</option>';
            foreach ($query->result() as $row) {
                echo "<option value='{$row->id}'>{$row->name_in_thai}</option>";
            }
        } else {
            echo '<option value="">- ไม่พบข้อมูล -</option>';
        }
    }

    // โหลดข้อมูลตำบลโดย district_id
    public function get_subdistricts() {
        $district_id = $this->input->post('district_id');
        $query = $this->db->get_where('subdistricts', ['district_id' => $district_id]);
        // ส่งข้อมูลเป็น <option> กลับให้ JS
        if ($query->num_rows() > 0) {
            echo '<option value="">- เลือกตำบล -</option>';
            foreach ($query->result() as $row) {
                echo "<option value='{$row->id}'>{$row->name_in_thai}</option>";
            }
        } else {
            echo '<option value=\"\">- ไม่พบข้อมูล -</option>';
        }
    }
}
