<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('resep_model');
	}

	public function index()
	{
		$this->load->view('resep');
	}

	public function read()
	{
		header('Content-type: application/json');
		if ($this->resep_model->read()->num_rows() > 0) {
			foreach ($this->resep_model->read()->result() as $resep) {
				$data[] = array(
					'nama' => $resep->nama,
					'cost' => "Rp.".number_format($resep->cost_resep, 0, ',', '.').",-",
					'action' => '<button class="btn btn-sm btn-success" onclick="edit('.$resep->id.')">Edit</button> <button class="btn btn-sm btn-danger" onclick="remove('.$resep->id.')">Delete</button>'
				);
			}
		} else {
			$data = array();
		}
		$produk = array(
			'data' => $data
		);
		echo json_encode($produk);
	}

	public function add()
	{
		$input = $this->input->post();
		$data = array(
			'nama' => $input['nama'],
			'cost_resep' => $input['total']
		);
		$id = $this->resep_model->create('resep', $data);
		
		foreach($input['menuItems'] as $bahan){
			$bahan = array(
				'id_bahan' => $bahan['id'],
				'id_resep' => $id,
				'qty' => $bahan['qty'],
				'isBahanUtama' => ($bahan['isBahanUtama'] == 'true') ? '1' : '0',
				'total_cost' => $bahan['subtotalcost'],
			);
			$this->resep_model->create('detail_resep', $bahan);
		}
		echo json_encode($data);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->resep_model->delete('resep', 'id', $id)) {
			$this->resep_model->delete('detail_resep', 'id_resep', $id);
			echo json_encode('sukses');
		}
	}

	public function edit()
	{
		$inp = $this->input->post();

		$dataResep = array(
			'nama' => $inp['nama'],
			'cost_resep' => $inp['total']
		);
		$this->resep_model->update($inp['id'], $dataResep);

		foreach($inp['menuItems'] as $bahan){
			$dataBahan = array(
				'id_bahan' => $bahan['id'],
				'id_resep' => $inp['id'],
				'qty' => $bahan['qty'],
				'isBahanUtama' => ($bahan['isBahanUtama'] == 'true') ? '1' : '0',
				'total_cost' => $bahan['subtotalcost'],
			);

			if($bahan['id_bahan_before'] == 0){
				$this->resep_model->create('detail_resep', $dataBahan);
			}
			else{
				if($bahan['id_bahan_before'] != $bahan['id']){
					$update = $this->resep_model->updateDetailResep($bahan['id_bahan_before'], $inp['id'], $dataBahan);
				}
				else{
					$update = $this->resep_model->updateDetailResep($bahan['id_bahan_before'], $inp['id'], $dataBahan);
				}
			}
		}
		echo json_encode('sukses');
	}

	public function delete_detail_resep()
	{
		$inp = $this->input->post();

		$delete = $this->resep_model->delete_detail_resep($inp['id_resep'], $inp['id_bahan']);
		echo json_encode('sukses, affected_rows: '.$delete);
	}

	public function get_resep()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		$res = $this->resep_model->getResep($id);
		$resep = $res->row();
		$bahan = $res->result();

		foreach($bahan as $bh){
			$datBahan[] = array(
				'id_bahan' => $bh->id_bahan,
				'nama_bahan' => $bh->nama_bahan,
				'harga_satuan' => $bh->harga_satuan,
				'qty' => $bh->qty,
				'satuan' => $bh->satuan,
				'isBahanUtama' => $bh->isBahanUtama
			);
		}

		$datResep = array(
			'id_resep' => $resep->id_resep,
			'nama_resep' => $resep->nama_resep,
			'total_cost' => $resep->HPP,
			'bahan' => $datBahan
		);

		echo json_encode($datResep);
	}

	public function get_barcode()
	{
		header('Content-type: application/json');
		$barcode = $this->input->post('barcode');
		$search = $this->produk_model->getBarcode($barcode);
		foreach ($search as $barcode) {
			$data[] = array(
				'id' => $barcode->id,
				'text' => $barcode->barcode,
				'harga' => $barcode->harga,
				'satuan' => $barcode->satuan,
				'satuanText' => " ".$barcode->satuanText,
				'stok' => $barcode->stok,
				'imageUrl' => $barcode->imageUrl,
			);
		}
		echo json_encode($data);
	}

	public function get_nama()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getNama($id));
	}

	public function get_stok()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getStok($id));
	}

	public function produk_terlaris()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->produkTerlaris();
		foreach ($produk as $key) {
			$label[] = $key->nama_produk;
			$data[] = $key->terjual;
		}
		$result = array(
			'label' => $label,
			'data' => $data,
		);
		echo json_encode($result);
	}

	public function data_stok()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->dataStok();
		echo json_encode($produk);
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
