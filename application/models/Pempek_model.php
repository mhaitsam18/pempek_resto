<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pempek_model extends CI_Model {
	
	public function getPempekById($id)
	{
		return $this->db->get_where('pempek', ['id' => $id])->row_array();
	}
	public function countAllPempek()
	{
		return $this->db->get('pempek')->num_rows();
	}
	public function getAllPempek()
	{
		return $this->db->get_where('pempek', ['aktif' => 1])->result_array();
	}
	public function getPempekByLimit($limit, $start, $keyword = null, $kategori = null)
	{
		if ($keyword) {
			$this->db->like('nama_pempek', $keyword);
		}
		if ($kategori) {
			$this->db->like('id_kategori', $kategori);
		}
		$this->db->order_by('id', 'ASC');
		return $this->db->get('pempek', $limit, $start)->result_array();
	}
	
}
