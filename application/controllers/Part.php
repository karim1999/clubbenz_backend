<?php
class part extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('upload');
		$this->load->helper(array('form', 'url'));
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->model('Service_tag_model', 'service_tag');
		$this->load->model('Serviceshop_model', 'serviceshop');
		$this->load->model('Part_model', 'part');
		$this->load->model('Part_photos_model', 'partphotos');
		$this->load->model('location_model', 'location');
		$this->load->model('Provider_model', 'provider');
		$this->load->model('Car_model', 'car');
		$this->load->model('provider_model');

		$this->load->model('acl_model');
		$this->load->model('Users_model');

		$this->load->library('session');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		}

		if ($this->input->get('error')) {
			$this->data['error'] = $this->input->get('error');
		}
		if ($this->input->get('success')) {
			$this->data['success'] = $this->input->get('success');
		}
	}
	public function index() {

		$identity = $this->session->userdata('identity');
		$this->data['rec'] = $this->part->manage_part($identity);
		$this->data['providers'] = $this->provider_model->select_provider();
		$this->data['cars'] = $this->car->get_classes();
		$this->load->view('manage_part', $this->data);
	}
	public function add_part() {

		if ($this->input->post()) {

//			if(empty($this->input->post('username'))){
			//				$user = $this->ion_auth->user()->row();
			//				$usname = $user->username;
			//			}
			//			else{
			//				$usname = $this->input->post('username');
			//
			//			}
			/*$brand=implode(',',$this->input->post('part_brand'));*/
			$rules = array(
				array(
					'field' => 'price',
					'label' => 'Price',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'title',
					'label' => 'Titile',
					'rules' => 'trim',
				),

				array(
					'field' => 'datepicker',
					'label' => 'Set Date of Listing',
					'rules' => 'trim',
				),
				array(
					'field' => 'chassis',
					'label' => 'chassis',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_category',
					'label' => 'part_category',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_sub_category',
					'label' => 'Part Sub Category',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_case',
					'label' => 'Part Status',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_brand[]',
					'label' => 'Part Brand',
					'rules' => 'trim|required',
				),
			);

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				$file_name = $_FILES['image']['name'];

				$part_brand = ($this->input->post('part_brand') != '') ? implode(',', $this->input->post('part_brand')) : "";
				//$part_case = ($this->input->post('part_case')!='') ? implode(',',$this->input->post('part_case')) : "";
				$title = $this->input->post('title');
				$arabicTitle = $this->input->post('title_arabic');

				if ($this->input->post('title') == "") {
					$title = $arabicTitle;
				} elseif ($this->input->post('title_arabic') == "") {
					$arabicTitle = $title;
				}
				$new_array = array(
					'title' => $title,
					'title_arabic' => $arabicTitle,
					'part_number' => $this->input->post('part_number'),
					'part_category' => $this->input->post('part_category'),
					'part_sub_category' => $this->input->post('part_sub_category'),
					'price' => $this->input->post('price'),
					'discount' => $this->input->post('discount'),
					'part_case' => $this->input->post('part_case'),
					'part_brand' => $part_brand,
					'add_date' => $this->input->post('add_date'),
					'description' => $this->input->post('description'),

//					'location_latitude'	 =>   $this->input->post('location_lat'),
					//					'location_longitude' =>   $this->input->post('location_lon'),

					'location_zone' => $this->input->post('location_zone'),
					'username' => $this->session->userdata("user_name"),
					'email' => $this->session->userdata("user_email"),
					'phone' => $this->session->userdata("user_mobile"),
					'chassis_id' => $this->input->post('chassis'),
//					'sort_order' => $this->input->post('sort_order'),
					'available_location' => $this->input->post('available_location'),
					'date_active' => $this->input->post('date_active'),
					'date_expire' => $this->input->post('date_expire'),
					'num_stock' => $this->input->post('num_stock'),
					'provider_id' => $this->input->post('provider_id'),
					'status' => $this->input->post('status'),
				);
				$result = $this->part->add_part($new_array);

				$photo_array = array(

					'part_id' => $result,

				);

				$dataInfo = array();
				$files = $_FILES;
				$cpt = count($_FILES['image']['name']);
				for ($i = 0; $i < $cpt; $i++) {

					$_FILES['file']['name'] = $files['image']['name'][$i];
					$_FILES['file']['type'] = $_FILES['image']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['image']['error'][$i];
					$_FILES['file']['size'] = $_FILES['image']['size'][$i];
					$config = array();
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->upload->initialize($config);
					if ($this->upload->do_upload('file')) {
						$dataInfo[] = $this->upload->data();
					}
				}

				for ($i = 0; $i < sizeof($dataInfo); $i++) {

					if ($i == 0) {
						$photo_array['is_default'] = "yes";
						$photo_array['photo_name'] = $dataInfo[0]['file_name'];
					} else {
						$photo_array['is_default'] = "no";
						$photo_array['photo_name'] = $dataInfo[$i]['file_name'];
					}
					$this->partphotos->add_part_photos($photo_array);

				}
				if ($result) {

					redirect(base_url('Part/?success=Added successfully!'));
				} else {
//					print_r($new_array);

					redirect(base_url('Part/?error=Unknown error!'));
				}
			} else {
				$error = validation_errors();
				$this->data['error'] = $error;
			}
		}

		$this->data['user'] = $this->part->get_user($this->session->userdata('user_email'));
		$this->data['chassis'] = $this->part->get_chassis();
		$this->data['location'] = $this->location->manage_location();
		$this->data['parts_category'] = $this->part->manage_parts_cat();
		$this->data['parts_sub_cat'] = $this->part->manage_parts_sub_cat();
		$this->data['brand'] = $this->part->manage_brand();
		$this->data['model_name'] = $this->car->get_classes();
		$this->data['providers'] = $this->provider->select_provider();

		$this->load->view('add_part', $this->data);
	}
	public function del_part($id) {
		$id = $this->part->del_part($id);
		if ($id) {
			redirect(base_url('part/?success= Delete successfully!'));
		} else {
			redirect(base_url('part/?error=Some error!'));
		}
	}
	public function edit_part($id) {

		$user = $this->ion_auth->user()->row();
		$usname = $user->username;

		if ($this->input->post()) {

			$rules = array(
				array(
					'field' => 'price',
					'label' => 'Price',
					'rules' => 'trim|required',
				),

				array(
					'field' => 'add_date',
					'label' => 'Date Of Add',
					'rules' => 'trim',
				),
				array(
					'field' => 'part_category',
					'label' => 'part_category',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_sub_category',
					'label' => 'Part Sub Category',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'discount',
					'label' => 'Discount',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_case',
					'label' => 'Part Case',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'part_brand[]',
					'label' => 'Part Brand',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'description',
					'label' => 'Description',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'phone',
					'label' => 'Phone',
					'rules' => 'trim|required',
				),
			);

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				$file_name = $_FILES['image']['name'];
				$part_brand = ($this->input->post('part_brand') != '') ? implode(',', $this->input->post('part_brand')) : "";
				//$part_case = ($this->input->post('part_case')!='') ? implode(',',$this->input->post('part_case')) : "";
				$title = $this->input->post('title');
				$model_id = !empty($this->input->post('model_id')) ? implode(',', $this->input->post('model_id')) : "";
				$arabicTitle = $this->input->post('title_arabic');

				if ($this->input->post('title') == "") {
					$title = $arabicTitle;
				} elseif ($this->input->post('title_arabic') == "") {
					$arabicTitle = $title;
				}
				if ($this->input->post('updated_date')) {
					$addDate = $this->input->post('updated_date');
				} else {
					$addDate = $this->input->post('add_date');
				}

				$new_array = array(
					'title' => $title,
					'title_arabic' => $arabicTitle,
					'part_number' => $this->input->post('part_number'),
					'part_category' => $this->input->post('part_category'),
					'part_sub_category' => $this->input->post('part_sub_category'),
					'price' => $this->input->post('price'),
					'discount' => $this->input->post('discount'),
					'part_case' => $this->input->post('part_case'),
					'part_brand' => $part_brand,
					'add_date' => $addDate,
					'model_id' => $model_id,
					'description' => $this->input->post('description'),

					'location_latitude' => $this->input->post('location_lat'),
					'location_longitude' => $this->input->post('location_lon'),

					'location' => $this->input->post('location'),
					'location_zone' => $this->input->post('location_zone'),
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'chassis_id' => $this->input->post('chassis'),
					'provider_id' => $this->input->post('provider_id'),
					'status' => $this->input->post('status'),

				);

				$val = $this->part->update_part($new_array, $id);

				$photo_array = array(

					'part_id' => $id,

				);

				$dataInfo = array();
				$files = $_FILES;
				$cpt = count($_FILES['image']['name']);
				for ($i = 0; $i < $cpt; $i++) {

					$_FILES['file']['name'] = $files['image']['name'][$i];
					$_FILES['file']['type'] = $_FILES['image']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['image']['error'][$i];
					$_FILES['file']['size'] = $_FILES['image']['size'][$i];
					$config = array();
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->upload->initialize($config);
					if ($this->upload->do_upload('file')) {
						$dataInfo[] = $this->upload->data();
					}
				}

				for ($i = 0; $i < sizeof($dataInfo); $i++) {

					if ($i == 0) {
						$photo_array['is_default'] = "yes";
						$photo_array['photo_name'] = $dataInfo[0]['file_name'];
					} else {
						$photo_array['is_default'] = "no";
						$photo_array['photo_name'] = $dataInfo[$i]['file_name'];
					}
					$this->partphotos->add_part_photos($photo_array);

				}

				$this->data['success'] = "Updated successfully!";
			} else {
				$error = validation_errors();
				$this->data['error'] = $error;
			}
		}
		$photos_array = $this->partphotos->manage_part_photos($id);
		$photo_array_count = count($photos_array);
		$remaining_count = 10 - $photo_array_count;
		$this->data['chassis_number'] = $this->part->get_chassis();
		$this->data['usname'] = $usname;
		$this->data['location'] = $this->location->manage_location();
		$this->data['rec'] = $this->part->edit_part($id);
		$this->data['part_photos'] = $photos_array;
		$this->data['remaining_count'] = $remaining_count;
		$this->data['brand'] = $this->part->manage_brand();
		$this->data['parts_category'] = $this->part->manage_parts_cat();
		$this->data['parts_sub_cat'] = $this->part->manage_parts_sub_cat();
		$this->data['providers'] = $this->provider->select_provider();
		$this->data['model_name'] = $this->car->get_classes();
		$this->data['part_id'] = $id;

		$this->load->view('edit_part', $this->data);
	}
	public function sub_cat() {

		$id = $this->input->post('id');
		echo $this->part->part_sub_cat($id);
	}

}
