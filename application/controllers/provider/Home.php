<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Home extends CI_Controller {
	public $data = [];

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->model('Provider_model');
		$this->load->model('Part_model');
		$this->load->model('Shipping_model');
		$this->load->model('Provider_plan_model');
		$this->load->model('Favorite_model');
		$this->load->model('Plan_model');
		$this->load->model('Acl_model');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->library('session');
		$this->lang->load('auth');
		if (!$this->session->userdata("id")) {
			redirect('/provider');
		}

		$this->load->helper('language');
		$this->lang->load('provider/left_nav', $this->session->userdata('site_lang') == "arabic" ? "arabic" : "english");
		$this->lang->load('provider/home', $this->session->userdata('site_lang') == "arabic" ? "arabic" : "english");

	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */

	public function index() {
		$provider_id = $this->session->userdata("id");
		$data['parts'] = $this->Provider_model->get_parts($provider_id);
		$data['active_parts'] = array_filter($this->Provider_model->get_parts($provider_id), function ($part) {
			return $part->active == 1 ? true : false;
		});
		$data["current_plan"] = $this->Provider_plan_model->get_current_plan_with_details_by_provider($provider_id);
		$data["requests"] = $this->Shipping_model->select_shipping_by_provider($provider_id);
		$data["partviews"] = $this->Part_model->get_parts($provider_id);
		$data["partsid"] = $this->Part_model->get_parts_id();
		$data["favorites"] = $this->Favorite_model->get_favorites();
		$data['title'] = 'Dashboard';
		$this->load->view('provider/dashboard', $data);
	}

	/**
	 * Log the user out
	 */
	public function logout() {
		$this->session->sess_destroy();
		redirect('provider', 'refresh');
	}
}
