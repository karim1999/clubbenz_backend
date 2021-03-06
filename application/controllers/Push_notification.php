<?php
ob_start();
class Push_notification extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->library('upload');
		$this->load->helper(array('form', 'url'));
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->model('Service_tag_model', 'service_tag');
		$this->load->model('Fuel_model', 'fuel');
		$this->load->model('Years_model', 'year');
		$this->load->model('Classes_model', 'classes');
		$this->load->model('Advertisement_model', 'advertisement');
		$this->load->model('Push_notification_model', 'notification');
		$this->load->model('Reviews_model', 'review');
		$this->load->model("Users_model");
		$this->load->model('acl_model');
		$this->load->model('Users_model');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		}

		if ($this->input->get('error')) {
			$this->data['error'] = $this->input->get('error');
		}
		if ($this->input->get('success')) {
			$this->data['success'] = $this->input->get('success');
		}

		define('FIREBASE_API_KEY', 'AAAAFGlvySM:APA91bEGYmrBnqQ42KtKRTZUhwNQBD7VXifw1JDOTfAkUcrFnhRz3TQ-0duk4bFqqCdjubuv0gBNvbivDA0SK5Ydl3S6oy7HebFPRIRj-R0IWKsuqq2EMTcExpDtEZH3nj3qfWmuq7qD');
	}

	public function send_notification() {
		/*ini_set('display_errors', 1);
        error_reporting(1);*/
		$this->data['class'] = $this->classes->model_manage();
		$this->data['year'] = $this->year->year_manage();
		$this->data['fuel'] = $this->fuel->fuel_manage();
		$this->data['chassis'] = $this->Users_model->get_all_chassis();
		$this->data['title'] = 'Send Notification';
		$this->load->view('push_notification', $this->data);

	}
	public function manage_notification() {
		$this->data['rec'] = $this->notification->manage_notification();
		$this->data['class'] = $this->classes->model_manage();
		$this->data['chassis'] = $this->Users_model->get_all_chassis();
		$this->data['title'] = 'Manage Notification';
		$this->load->view('manage_notification', $this->data);
	}
	public function cars() {
		$class_id = $this->input->post('class_id');
		$fuel_id = $this->input->post('fuel_id');
		$year_id = $this->input->post('year_id');
		$chassis_id = $this->input->post('chassis_id');
		$year = $this->year->get_year_by_id($year_id);

		echo $this->notification->get_cars($fuel_id, $year, $class_id, $chassis_id);
	}

	public function multi_cars() {
		$class_id = $this->input->post('class_id');
		$fuel_id = $this->input->post('fuel_id');
		$year_id = $this->input->post('year_id');
		$chassis_id = $this->input->post('chassis_id');
		$year = $this->year->get_year_by_id($year_id);

		echo $this->notification->multi_get_cars($fuel_id, $year, $class_id, $chassis_id);
	}

	public function shops() {
		$type = $this->input->post('type');
		echo $this->notification->get_shops($type);
	}

	public function send_push_notification() {
		if ($this->input->post()) {
			$this->load->library('firebase');
			$posted_data = $this->input->post();
			//$shop_name = $this->review->get_shop_name($posted_data['shop_id'], $posted_data['type_name']);

			$payload = array();
			$payload['body'] = $posted_data['text'];
			$payload['title'] = $posted_data['title']; //$this->post('name');
			$payload['message'] = $posted_data['text'];
			$payload['shop_id'] = $posted_data['shop_id'];
			$payload['shop_type'] = $posted_data['type_name'];
			$payload['badge'] = 1;
			$payload['priority'] = "high";
			$payload['icon'] = "ic_stat";
			$payload['created_at'] = date("yy-m-d H:i:s");
			$payload['show_in_foreground'] = true;

			// print_r($posted_data);
			// return $this->input->post("chassiss");

			// $payload['data']['body'] 	= $posted_data['text'];
			// $payload['data']['title'] 	= $posted_data['title']; //$this->post('name');
			// $payload['data']['message'] = $posted_data['text'];
			// $payload['data']['shop_id'] = $posted_data['shop_id'];
			// $payload['data']['shop_type'] = $posted_data['type_name'];
			// $payload['data']['badge'] = 1;
			$data['body'] = $posted_data['text'];
			$data['title'] = $posted_data['title']; //$this->post('name');
			$data['message'] = $posted_data['text'];
			$data['shop_id'] = $posted_data['shop_id'];
			$data['shop_type'] = $posted_data['type_name'];
			$data['badge'] = 1;
			$data['priority'] = "high";
			$data['icon'] = "ic_stat";
			$data['created_at'] = date("yy-m-d H:i:s");
			$data['show_in_foreground'] = true;

			$result = $this->notification->get_all_users($posted_data);
			$show_admin = true;

			if (!empty($result)) {
				foreach ($result as $value) {
					if ($value->fcm_token != "") {
						$response = '';
						$response = $this->firebase->send($value->fcm_token, $payload, $data);
						$response = $this->firebase->sendGoogleCloudMessage($payload, $value->fcm_token);
						$d['data'] = json_encode($response);
						$this->db->insert("data_logs", $d);
						$data['user_id'] = $value->id;
//						print_r($value);
						$data['show_admin'] = $show_admin;
						$show_admin = false;
						$this->db->insert("notifications", $data);
					}
				}
				redirect(base_url('push_notification/manage_notification/?success=Notifications sent successfully!'));
			} else {
				redirect(base_url('push_notification/send_notification/?error=no user found!'));
			}
		}
	}

	public function notification_setting() {
		$this->data['rec'] = $this->notification->notification_setting();
		$this->data['title'] = 'Manage Notification Setting';
		$this->load->view('manage_notification_setting', $this->data);
	}

	public function edit_notification_setting($id) {

		$data['rec'] = $this->notification->edit_notification_setting($id);
		$data['title'] = 'Edit Notification Setting';
		$this->load->view('edit_notification_setting', $data);

	}

	public function update_notification_setting() {

		$id = $this->input->post('id');
		if ($this->input->post()) {

			$rules = array(
				array(
					'field' => 'interval_hours',
					'label' => 'interval_hours',
					'rules' => 'trim|required',
				),
			);

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				$new_array['interval_hours'] = $this->input->post('interval_hours');
				$new_array['max_distance'] = $this->input->post('max_distance');
				$new_array['message'] = $this->input->post('message');

				$val = $this->notification->update_notification_setting($new_array, $id);
				if ($val) {
					redirect(base_url('push_notification/notification_setting/?success=Update  successfully!'));
				} else {
					redirect(base_url('push_notification/notification_setting/?success=Update  successfully!'));
				}
			} else {
				$error = validation_errors();
				redirect(base_url('push_notification/edit_notification_setting/' . $id . '?error=' . $error));
			}
		}
	}

}
?>
