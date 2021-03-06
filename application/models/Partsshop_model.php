<?php
class Partsshop_model extends CI_Model {
	public function add_fuel($name) {
		$this->db->insert('fuel_type', $name);
		return $this->db->insert_id();
	}
	function count_shop($data) {
		$this->db->select('*');
		if ($data['shop_open'] == true) {
			date_default_timezone_set('Egypt');
			$time = date("H:i");
			$day = date('l');

			$this->db->Where('opening_hours<=', $time);
			$this->db->Where('closing_hours>=', $time);
			$this->db->not_like('off_day', $day);
		}
		if ($data['search'] != '') {
			$this->db->like("serch_tag", $data['search']);
			$this->db->or_like("serch_tag_arabic", $data['search']);
			$this->db->or_like("address", $data['search']);
			$this->db->or_like("name", $data['search']);
			$this->db->or_like("arabic_name", $data['search']);
			$this->db->or_like("service_tag_string", $data['search']);
		}
		$q = $this->db->get("partshop");
		if ($q->num_rows() > 0) {
			return $q->num_rows();
		}
		return 0;
	}

	function get_shop($data, $start, $limit) {
		// $this->db->limit($limit,$start);
		$this->db->select("*,'partshop' as shop_type");

		if ($data['shop_open'] == true) {
			date_default_timezone_set('Egypt');
			$time = date("H:i");
			$day = date('l');

			$this->db->Where('opening_hours<=', $time);
			$this->db->Where('closing_hours>=', $time);
			$this->db->not_like('off_day', $day);
		}
//		if($data['sort']){
		//			$this->db->order_by($data['sort'], $data['sort_type']);
		//		}
		if ($data['search'] != '') {
			$this->db->like("serch_tag", $data['search']);
			$this->db->or_like("serch_tag_arabic", $data['search']);
			$this->db->or_like("address", $data['search']);
			$this->db->or_like("name", $data['search']);
			$this->db->or_like("arabic_name", $data['search']);
			$this->db->or_like("service_tag_string", $data['search']);
		}
		$this->db->from("partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return array();
	}

	function get_partshop($data, $start, $limit) {
		// $this->db->limit($limit,$start);
		$this->db->select("*,'partshop' as shop_type");
		if ($data['search'] != '') {
			$this->db->like("serch_tag", $data['search']);
			$this->db->or_like("serch_tag_arabic", $data['search']);
			$this->db->or_like("address", $data['search']);
			$this->db->or_like("name", $data['search']);
			$this->db->or_like("arabic_name", $data['search']);
			$this->db->or_like("service_tag_string", $data['search']);
		}
		$q = $this->db->get("partshop");
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return array();
	}

	function get_all_partshop() {

		$this->db->select('*');
		$this->db->from("partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return 0;
	}

	function get_details($id) {
		$this->db->select('*');
		$this->db->where("id", $id);
		$this->db->from("partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->row();
		}
	}
	public function manage_brand() {
		$this->db->select('*');
		$this->db->from('brands');
		$q = $this->db->get();
		return $q->result();
	}
	public function manage_part_shop() {
		$this->db->select('*');
		$this->db->order_by("id", "desc");
		$this->db->from('partshop');
		$q = $this->db->get();
		return $q->result();
	}
	public function add_part_shop($data) {
		$this->db->insert('partshop', $data);
		return $this->db->insert_id();
	}

	public function get_by_id($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('brands');
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return false;
	}

	public function get_by_name($name) {
		$this->db->select('*');
		$this->db->where('name', $name);
		$this->db->from('brands');
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return false;
	}

	public function get_service_tag_by_id($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('service_tag');
		$this->db->where('shop_type', "partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return false;
	}

	public function get_service_tag_by_name($name) {
		$this->db->select('*');
		$this->db->where('name', $name);
		$this->db->from('service_tag');
		$this->db->where('shop_type', "partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return false;
	}

	public function partshop_del($id) {
		$this->db->where('id', $id);
		$this->db->delete('partshop');
		return $this->db->affected_rows();
	}
	public function edit_part_shop($id) {
		$this->db->where('id', $id);
		$this->db->from('partshop');
		$q = $this->db->get();
		return $q->row();
	}
	public function update_part_shop($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('partshop', $data);

	}
	public function service_manage() {
		$this->db->select('*');
		$this->db->from('services');
		$this->db->order_by('sorting', 'asc');
		$q = $this->db->get();
		return $q->result();
	}
	public function manage_part_group() {
		$this->db->select('*');
		$this->db->from('part_group');
		$q = $this->db->get();
		return $q->result();
	}
	public function total_partshop() {
		return $this->db->count_all('partshop');
	}
	public function total_membership() {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('memberships_users', 'memberships_users.user_id = users.id');
		$this->db->where('memberships_users.status', 'approve');
		$q = $this->db->get();
		return $q->result();
	}

	public function memberships_users_fun() {
		$this->db->select('*');
		$this->db->from('memberships_users');
		$q = $this->db->get();
		return $q->result();
	}

	public function memberships_fun() {
		$this->db->select('*');
		$this->db->from('memberships');
		$q = $this->db->get();
		return $q->result();
	}
	public function total_carowners() {
		$this->db->select('*');
		$this->db->from('users_groups');
		$this->db->where('group_id', 2);
		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return false;
		}
	}

	function fetch_data() {
		$this->db->select(array("name", "arabic_name", "web_link", "city", "country", "location_latitude", "location_longitude", "opening_hours", "closing_hours", "part_type", "off_day", "phone", "facebok_link", "address", "serch_tag", "serch_tag_arabic", "created_date", "email", "tweeter", "brand", "service_tag"));
		$this->db->from("partshop");
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return 0;
	}
}
?>