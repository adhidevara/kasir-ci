<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_model extends CI_Model {

	private $table = 'bahan';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		$this->db->select('bahan.id, bahan.nama as nama, bahan.unit_cost as unit_cost, satuan_produk.satuan as unit, bahan.unit as unitr');
		$this->db->from($this->table);
		$this->db->join('satuan_produk', 'bahan.unit = satuan_produk.id');
		return $this->db->get();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getBahan($id)
	{
		$this->db->select('bahan.id, bahan.nama, bahan.unit, satuan_produk.satuan, bahan.unit_cost');
		$this->db->from($this->table);
		$this->db->join('satuan_produk', 'bahan.unit = satuan_produk.id');
		$this->db->where('bahan.id', $id);
		return $this->db->get();
	}

	public function search($search="")
	{
		$this->db->like('nama', $search);
		return $this->db->get($this->table)->result();
	}
}

/* End of file Bahan_model.php */
/* Location: ./application/models/Bahan_model.php */
