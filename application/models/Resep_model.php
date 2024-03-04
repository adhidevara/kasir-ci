<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep_model extends CI_Model {

	private $table = 'resep';

	public function create($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function read()
	{
		$this->db->from($this->table);
		return $this->db->get();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function updateDetailResep($id_bahan, $id_resep, $data)
	{
		$this->db->where('id_bahan', $id_bahan);
		$this->db->where('id_resep', $id_resep);
		return $this->db->update('detail_resep', $data);
	}

	public function delete($tbl, $where_id, $val)
	{
		$this->db->where($where_id, $val);
		return $this->db->delete($tbl);
	}

	public function delete_detail_resep($id_resep, $id_bahan)
	{
		// Query untuk menghapus data berdasarkan id_resep dan id_bahan
		$this->db->where('id_resep', $id_resep);
		$this->db->where('id_bahan', $id_bahan);
		$this->db->delete('detail_resep');

		// Mengembalikan jumlah baris yang terpengaruh oleh operasi penghapusan
		return $this->db->affected_rows();
	}

	public function getResep($id)
	{
		$this->db->select('
			resep.id AS id_resep,
			resep.nama AS nama_resep, 
			resep.cost_resep AS HPP,
			bahan.id AS id_bahan, 
			bahan.nama AS nama_bahan, 
			detail_resep.qty AS qty, 
			detail_resep.isBahanUtama,
			bahan.unit_cost AS harga_satuan, 
			satuan_produk.satuan');
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

	function getDetailResep($id){
		$this->db->select('dr.id AS Id_Detail_Resep,b.nama AS Nama_Bahan, r.nama AS Nama_Resep, sp.satuan AS Satuan, b.unit_cost AS Harga_per_Item, dr.qty AS Proporsi_Bahan_Baku, r.cost_resep AS HPP, dr.bahan_utama AS is_Bahan_Utama');
		$this->db->from('satuan_produk sp');
		$this->db->join('bahan b','sp.id = b.unit');
		$this->db->join('detail_resep dr','b.id = dr.id_bahan');
		$this->db->join('resep r','dr.id_resep = r.id');
		$this->db->where('r.id', $id);
		return $this->db->get();
	}
}

/* End of file Bahan_model.php */
/* Location: ./application/models/Bahan_model.php */
