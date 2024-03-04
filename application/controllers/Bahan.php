<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('bahan_model');
	}

	public function index()
	{
		$this->load->view('bahan');
	}

	public function add()
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'unit' => $this->input->post('satuan'),
			'unit_cost' => $this->input->post('cost'),
			'stok_bahan' => $this->input->post('stok')
		);		
		if ($this->bahan_model->create($data)) {
			echo json_encode($data);
		}
	}

	public function read()
	{
		header('Content-type: application/json');
		if ($this->bahan_model->read()->num_rows() > 0) {
			foreach ($this->bahan_model->read()->result() as $bahan) {
				$data[] = array(
					'nama' => $bahan->nama,
					'cost' => "Rp.".number_format($bahan->unit_cost, 0, ',', '.').",-",
					'stok_bahan' => $bahan->stok_bahan,
					'unit' => $bahan->unit,
					'action' => '<button class="btn btn-sm btn-success" onclick="edit('.$bahan->id.')">Edit</button> <button class="btn btn-sm btn-danger" onclick="remove('.$bahan->id.')">Delete</button>'
				);
			}
		} else {
			$bahan = array();
		}
		$bahan = array(
			'data' => $data
		);
		echo json_encode($bahan);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->bahan_model->delete($id)) {
			echo json_encode('sukses');
		}
	}

	public function get_bahan()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		$kategori = $this->bahan_model->getBahan($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

	public function edit()
	{
		$id = $this->input->post('id');
		$data = array(
			'nama' => $this->input->post('nama'),
			'unit' => $this->input->post('satuan'),
			'stok_bahan' => $this->input->post('stok'),
			'unit_cost' => $this->input->post('cost')
		);
		if ($this->bahan_model->update($id,$data)) {
			echo json_encode('sukses');
		}
	}

	public function search()
	{
		header('Content-type: application/json');
		$bahan = $this->input->post('bahan');
		$search = $this->bahan_model->search($bahan);
		foreach ($search as $bahan) {
			$data[] = array(
				'id' => $bahan->id,
				'text' => $bahan->nama,
				'satuan' => $bahan->satuan,
				'cost' => $bahan->unit_cost
			);
		}
		echo json_encode($data);
	}
}
