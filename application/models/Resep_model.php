<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep_model extends CI_Model {

	private $table = 'resep';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		$this->db->select('resep.nama AS nama_produk, resep.cost_resep AS HPP, detail_resep.qty AS proporsi_resep, bahan.nama AS nama_bahan, bahan.unit_cost AS harga_satuan, satuan_produk.satuan');
		$this->db->from($this->table);
		$this->db->join('detail_resep', 'resep.id = detail_resep.id_resep');
		$this->db->join('bahan', 'bahan.id = detail_resep.id_bahan');
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

	public function getResep($id)
	{
		$this->db->select('resep.nama AS nama_produk, resep.cost_resep AS HPP, detail_resep.qty AS proporsi_resep, bahan.nama AS nama_bahan, bahan.unit_cost AS harga_satuan, satuan_produk.satuan');
		$this->db->from($this->table);
		$this->db->join('detail_resep', 'resep.id = detail_resep.id_resep');
		$this->db->join('bahan', 'bahan.id = detail_resep.id_bahan');
		$this->db->join('satuan_produk', 'bahan.unit = satuan_produk.id');
		$this->db->where('resep.id', $id);
		return $this->db->get();
	}

    function getBahanBaku(){
        $this->db->from('bahan');
		return $this->db->get();
    }
}

/* End of file Bahan_model.php */
/* Location: ./application/models/Bahan_model.php */
