<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pempek extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Pempek_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data['title'] = "Beranda";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['dashboard'] = $this->db->get('dashboard')->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pempek/index', $data);
		$this->load->view('templates/footer');
	}

	public function pempek()
	{
		$data['title'] = "Data Pempek";
		$this->db->select('*, pempek.id AS pid');
		$this->db->join('kategori', 'pempek.id_kategori=kategori.id');
		$data['pempek'] = $this->db->get_where('pempek', ['aktif' => 1])->result_array();
		$data['kategori'] = $this->db->get('kategori')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('kode_pempek', 'Pempek Code', 'trim|required');
		$this->form_validation->set_rules('nama_pempek', 'Pempek Code', 'trim|required');
		$this->form_validation->set_rules('merk', 'Brand', 'trim|required');
		$this->form_validation->set_rules('id_kategori', 'Category ID', 'trim|required');
		$this->form_validation->set_rules('stok', 'Stock', 'trim|required');
		$this->form_validation->set_rules('harga_jual', 'Price', 'trim|required');
		$this->form_validation->set_rules('harga_beli', 'Price', 'trim|required');
		$this->form_validation->set_rules('deskripsi', 'Description', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pempek/pempek', $data);
			$this->load->view('templates/footer');
		} else{
			$upload_image = $_FILES['gambar']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
				$config['upload_path'] = './assets/img/pempek';
				$config['max_size']     = '2048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('gambar')) {
					$new_image = $this->upload->data('file_name');
					$this->db->insert('pempek', [
						'kode_pempek' => htmlspecialchars($this->input->post('kode_pempek', true)),
						'nama_pempek' => htmlspecialchars($this->input->post('nama_pempek', true)),
						'merk' => htmlspecialchars($this->input->post('merk', true)),
						'id_kategori' => htmlspecialchars($this->input->post('id_kategori', true)),
						'stok' => htmlspecialchars($this->input->post('stok', true)),
						'harga_jual' => htmlspecialchars($this->input->post('harga_jual', true)),
						'harga_beli' => htmlspecialchars($this->input->post('harga_beli', true)),
						'deskripsi' => $this->input->post('deskripsi'),
						'gambar' => $new_image,
						'aktif' => 1,
					]);
					$this->db->select('MAX(id) AS max_id');
					$max_id = $this->db->get('pempek')->row_array();
					$sub_total_harga = $this->input->post('harga_beli')*$this->input->post('stok');
					$this->db->insert('pasokan', [
						// 'pemasok' => htmlspecialchars($this->input->post('pemasok', true)),
						'pemasok' => 'Pempek Resto',
						'id_petugas' => $data['user']['id'],
						'id_pempek' => $max_id['max_id'],
						'jumlah' => htmlspecialchars($this->input->post('stok', true)),
						'sub_total_harga' => $sub_total_harga,
						'waktu_transaksi' => date("Y-m-d H:i:s")
					]);
					
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						New Pempek Added!
						</div>');
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				}
				redirect('Pempek/pempek');
			}
		}
	}

	public function laporan($bulan = null)
	{
		$data['title'] = "Laporan Penjualan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, pesanan.id AS idp');
		$this->db->join('checkout', 'checkout.id = pesanan.id_checkout');
		$this->db->join('user', 'checkout.id_user = user.id');
		$this->db->join('pempek', 'pempek.id = pesanan.id_pempek');
		$this->db->order_by('idp','DESC');
		$data['pesanan'] = $this->db->get_where('pesanan',['checkout.status !=' => 'Pesanan dibatalkan'])->result_array();

		$this->db->select('*, transaksi.id AS idt');
		$this->db->join('pempek', 'transaksi.id_pempek = pempek.id');
		$this->db->join('user', 'transaksi.id_kasir = user.id');
		if ($bulan) {
			$data['print_by_bulan'] = $bulan;
			$y = explode("-", $bulan);
			$this->db->where("MONTH(waktu_transaksi)", $y[0]);
			$this->db->where("YEAR(waktu_transaksi)", $y[1]);
		} else{
			$data['print_by_bulan'] = null;
		}
		$this->db->order_by('idt','DESC');
		$data['transaksi'] = $this->db->get('transaksi')->result_array();

		$this->db->distinct();
		$this->db->select("CONCAT(MONTH(waktu_transaksi),'-',YEAR(waktu_transaksi)) AS bulan");
		$data['bulan'] = $this->db->get('transaksi')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pempek/pempek-terjual', $data);
		$this->load->view('templates/footer');
	}

	public function deletePempek($id)
	{
		$this->db->where('id', $id);
		$this->db->update('pempek',['aktif' => 0]);
		// $this->db->delete('pempek', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pempek Deleted!
			</div>');
		redirect('Pempek/pempek');
	}

	public function updatePempek()
	{
		$this->form_validation->set_rules('nama_pempek', 'Pempek Name', 'trim|required');
		$pempek = $this->db->get_where('pempek', ['id' => $this->input->post('id')])->row_array();
		if ($this->form_validation->run() == false) {
			redirect('Pempek/pempek');
		} else{
			$upload_image = $_FILES['gambar']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg';
				$config['upload_path'] = './assets/img/pempek';
				$config['max_size']     = '2048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('gambar')) {
					$old_image = $pempek['gambar'];
					if ($old_image !='default.jpg') {
						unlink(FCPATH.'assets/img/pempek/'.$old_image);
					} 
					$new_image = $this->upload->data('file_name');
					$this->db->set('gambar', $new_image);
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('Pempek/pempek');
				}
			}
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('pempek', [
				'kode_pempek' => $this->input->post('kode_pempek'),
				'nama_pempek' => $this->input->post('nama_pempek'),
				'merk' => $this->input->post('merk'),
				'id_kategori' => $this->input->post('id_kategori'),
				'stok' => $this->input->post('stok'),
				'harga_jual' => $this->input->post('harga_jual'),
				'harga_beli' => $this->input->post('harga_beli'),
				'deskripsi' => $this->input->post('deskripsi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Pempek Updated!
				</div>');
			redirect('Pempek/pempek');
		}
	}
	public function printLaporan($bulan = null)
	{
		$data['title'] = "Pempek Terjual";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->db->select('*, pesanan.id AS idp');
		$this->db->join('checkout', 'checkout.id = pesanan.id_checkout');
		$this->db->join('user', 'checkout.id_user = user.id');
		$this->db->join('pempek', 'pempek.id = pesanan.id_pempek');
		$data['pesanan'] = $this->db->get_where('pesanan',['checkout.status !=' => 'Pesanan dibatalkan'])->result_array();
		if ($bulan) {
			$data['print_by_bulan'] = $bulan;
			$y = explode("-", $bulan);
			$this->db->where("MONTH(waktu_transaksi)", $y[0]);
			$this->db->where("YEAR(waktu_transaksi)", $y[1]);
		}
		$this->db->select('*, transaksi.id AS idt');
		$this->db->join('pempek', 'transaksi.id_pempek = pempek.id');
		$this->db->join('user', 'transaksi.id_kasir = user.id');
		$data['transaksi'] = $this->db->get('transaksi')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('pempek/print-laporan', $data);
		$this->load->view('templates/footer');
	}

	public function tambahPempek()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$id_petugas = $data['user']['id'];
		$data = array(
			'pemasok' => 'Pempek Resto',
			'id_petugas' => $id_petugas,
			'id_pempek' => $this->input->post('pasok_id'),
			'jumlah' => $this->input->post('pasok_stok'),
			'sub_total_harga' => $this->input->post('pasok_harga_beli'),
			'waktu_transaksi' => date("Y-m-d H:i:s")
		);
		$this->db->insert('pasokan', $data);
		$pempek = $this->db->get_where('pempek',['id' => $this->input->post('pasok_id')])->row_array();
		$new_stok = $pempek['stok'] + $this->input->post('pasok_stok');
		$this->db->where('id', $this->input->post('pasok_id'));
		$this->db->update('pempek',['stok' => $new_stok]);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Stok Berhasil ditambahkan
			</div>');
		redirect("Pempek/pempek/");
	}

	public function pasokPempek($id = '', $rowid = '', $pemasok='')
	{
		if (!$this->session->userdata('cart_supply', 'cart_supply')) {
			$this->session->unset_userdata('cart_checkout');
			$this->session->set_userdata('cart_supply', 'cart_supply');
			$this->cart->destroy();
		}
		$pempek = $this->Pempek_model->getPempekById($id);
		$id = $this->input->post('pasok_id');
		$name = $this->input->post('pasok_nama_pempek');
		$qty = $this->input->post('pasok_stok');
		$price = $this->input->post('pasok_harga_beli');
		$gambar = $this->input->post('gambar');
		$pemasok = 'Pempek Resto';
		// if ($this->input->post('save')) {
		// } elseif($pempek){
		// 	$id = $pempek['id'];
		// 	$name = $pempek['nama_pempek'];
		// 	$qty = 1;
		// 	$price = $pempek['harga_beli'];
		// 	$gambar = $pempek['gambar'];
		// } else{
		// 	$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
		// 		Data Pempek Tidak Valid!
		// 		</div>');
		// 	redirect('Pempek/pempek');
		// }
		$data = array(
	        'id'      => $id,
	        'qty'     => $qty,
	        'price'   => $price,
	        'name'    => $name,
	        'gambar'    => $gambar,
	        'pemasok'    => $pemasok
    	);
    	$this->cart->insert($data);
    	redirect('Pempek/pempek');
	}


	public function kurangPasokan($rowid, $qty)
	{
		$data = array(
	        'rowid' => $rowid,
	        'qty'   => ($qty-1)
	    );
		$this->cart->update($data);
    	redirect('Pempek/pempek');
	}
	public function tambahPasokan($rowid, $qty)
	{
		$data = array(
	        'rowid' => $rowid,
	        'qty'   => ($qty+1)
	    );
		$this->cart->update($data);
    	redirect('Pempek/pempek');
	}
	public function bersihkanPasokan()
	{
		$this->cart->destroy();
		$this->session->unset_userdata('cart_supply');
    	redirect('Pempek/pempek');
	}

	public function hapusItem($rowid)
	{
		$this->cart->remove($rowid);
    	redirect('Pempek/pempek');
	}

	public function pasokan()
	{
		$data['title'] = "Riwayat Produksi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->join('user', 'user.id = pasokan.id_petugas');
		$this->db->join('pempek', 'pempek.id = pasokan.id_pempek');
		$data['pasokan'] = $this->db->get('pasokan')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pempek/pasokan', $data);
		$this->load->view('templates/footer');
	}

	public function supply()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$id_petugas = $data['user']['id'];
		foreach ($this->cart->contents() as $item) {
			$data = array(
				'pemasok' => 'Pempek Resto',
				'id_petugas' => $id_petugas,
				'id_pempek' => $item['id'],
				'jumlah' => $item['qty'],
				'sub_total_harga' => $item['subtotal'],
				'waktu_transaksi' => date("Y-m-d H:i:s")
			);
			$this->db->insert('pasokan', $data);
			$pempek = $this->db->get_where('pempek',['id' => $item['id']])->row_array();
			$new_stok = $pempek['stok'] + $item['qty'];
			$this->db->where('id', $item['id']);
			$this->db->update('pempek',['stok' => $new_stok]);
		}
		$this->cart->destroy();
		$this->session->unset_userdata('cart_supply');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Stok Berhasil ditambahkan
			</div>');
		redirect("Pempek/pempek/");
	}

	public function labaRugi()
	{
		$data['title'] = "Laba dan Rugi";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$transaksi_hari_ini = [
			'DATE(waktu_transaksi)' => date('Y-m-d')
		];
		$transaksi_bulan_ini = [
			'MONTH(waktu_transaksi)' => date('m'),
			'YEAR(waktu_transaksi)' => date('Y')
		];
		$transaksi_tahun_ini = [
			'YEAR(waktu_transaksi)' => date('Y')
		];
		$pemesanan_hari_ini = [
			'DATE(waktu_pemesanan)' => date('Y-m-d')
		];
		$pemesanan_bulan_ini = [
			'MONTH(waktu_pemesanan)' => date('m'),
			'YEAR(waktu_pemesanan)' => date('Y')
		];
		$pemesanan_tahun_ini = [
			'YEAR(waktu_pemesanan)' => date('Y')
		];
		$beban_hari_ini = [
			'DATE(tanggal)' => date('Y-m-d')
		];
		$beban_bulan_ini = [
			'MONTH(tanggal)' => date('m'),
			'YEAR(tanggal)' => date('Y')
		];
		$beban_tahun_ini = [
			'YEAR(tanggal)' => date('Y')
		];
		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_beli_today'] = $this->db->get_where('pasokan', $transaksi_hari_ini)->row_array();
		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_beli_month'] = $this->db->get_where('pasokan', $transaksi_bulan_ini)->row_array();
		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_beli_year'] = $this->db->get_where('pasokan', $transaksi_tahun_ini)->row_array();
		
		$this->db->select('SUM(sub_total_harga) AS total, DATE(waktu_transaksi) AS hari');
		$this->db->group_by('DATE(waktu_transaksi)');
		$data['sum_beli_dayly'] = $this->db->get('pasokan')->result_array();
		$this->db->select('SUM(sub_total_harga) AS total, MONTH(waktu_transaksi) AS bulan, YEAR(waktu_transaksi) AS tahun, waktu_transaksi');
		$this->db->group_by('MONTH(waktu_transaksi)');
		$data['sum_beli_monthly'] = $this->db->get('pasokan')->result_array();
		$this->db->select('SUM(sub_total_harga) AS total, YEAR(waktu_transaksi) AS tahun');
		$this->db->group_by('YEAR(waktu_transaksi)');
		$data['sum_beli_annual'] = $this->db->get('pasokan')->result_array();


		$this->db->select('SUM(total_harga) AS total');
		$data['sum_jual_today'] = $this->db->get_where('checkout', $pemesanan_hari_ini)->row_array();
		$this->db->select('SUM(total_harga) AS total');
		$data['sum_jual_month'] = $this->db->get_where('checkout', $pemesanan_bulan_ini)->row_array();
		$this->db->select('SUM(total_harga) AS total');
		$data['sum_jual_year'] = $this->db->get_where('checkout', $pemesanan_tahun_ini)->row_array();
		
		$this->db->select('SUM(total_harga) AS total, DATE(waktu_pemesanan) AS hari');
		$this->db->group_by('DATE(waktu_pemesanan)');
		$data['sum_jual_dayly'] = $this->db->get('checkout')->result_array();
		$this->db->select('SUM(total_harga) AS total, MONTH(waktu_pemesanan) AS bulan, YEAR(waktu_pemesanan) AS tahun, waktu_pemesanan');
		$this->db->group_by('MONTH(waktu_pemesanan)');
		$data['sum_jual_monthly'] = $this->db->get('checkout')->result_array();
		$this->db->select('SUM(total_harga) AS total, YEAR(waktu_pemesanan) AS tahun');
		$this->db->group_by('YEAR(waktu_pemesanan)');
		$data['sum_jual_annual'] = $this->db->get('checkout')->result_array();


		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_jual_today_offline'] = $this->db->get_where('transaksi', $transaksi_hari_ini)->row_array();
		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_jual_month_offline'] = $this->db->get_where('transaksi', $transaksi_bulan_ini)->row_array();
		$this->db->select('SUM(sub_total_harga) AS total');
		$data['sum_jual_year_offline'] = $this->db->get_where('transaksi', $transaksi_tahun_ini)->row_array();
		
		$this->db->select('SUM(sub_total_harga) AS total, DATE(waktu_transaksi) AS hari');
		$this->db->group_by('DATE(waktu_transaksi)');
		$data['sum_jual_dayly_offline'] = $this->db->get('transaksi')->result_array();
		$this->db->select('SUM(sub_total_harga) AS total, MONTH(waktu_transaksi) AS bulan, YEAR(waktu_transaksi) AS tahun, waktu_transaksi');
		$this->db->group_by('MONTH(waktu_transaksi)');
		$data['sum_jual_monthly_offline'] = $this->db->get('transaksi')->result_array();
		$this->db->select('SUM(sub_total_harga) AS total, YEAR(waktu_transaksi) AS tahun');
		$this->db->group_by('YEAR(waktu_transaksi)');
		$data['sum_jual_annual_offline'] = $this->db->get('transaksi')->result_array();

		$this->db->select('SUM(biaya_beban) AS total');
		$data['sum_beban_today'] = $this->db->get_where('beban', $beban_hari_ini)->row_array();
		$this->db->select('SUM(biaya_beban) AS total');
		$data['sum_beban_month'] = $this->db->get_where('beban', $beban_bulan_ini)->row_array();
		$this->db->select('SUM(biaya_beban) AS total');
		$data['sum_beban_year'] = $this->db->get_where('beban', $beban_tahun_ini)->row_array();
		
		$this->db->select('SUM(biaya_beban) AS total, DATE(tanggal) AS hari');
		$this->db->group_by('DATE(tanggal)');
		$data['sum_beban_dayly'] = $this->db->get('beban')->result_array();
		$this->db->select('SUM(biaya_beban) AS total, MONTH(tanggal) AS bulan, YEAR(tanggal) AS tahun, tanggal');
		$this->db->group_by('MONTH(tanggal)');
		$data['sum_beban_monthly'] = $this->db->get('beban')->result_array();
		$this->db->select('SUM(biaya_beban) AS total, YEAR(tanggal) AS tahun');
		$this->db->group_by('YEAR(tanggal)');
		$data['sum_beban_annual'] = $this->db->get('beban')->result_array();

		$this->db->select('SUM(sub_total_harga) AS total');
		$profit_offline = $this->db->get('transaksi')->row_array();

		$this->db->select('SUM(total_harga) AS total');
		$profit_online = $this->db->get('checkout')->row_array();

		$this->db->select('SUM(sub_total_harga) AS total');
		$loss_modal = $this->db->get('pasokan')->row_array();


		$this->db->select('SUM(biaya_beban) AS total');
		$loss_beban = $this->db->get('beban')->row_array();


		$profit = $profit_offline['total'] + $profit_online['total'];

		$hasil = $profit - $loss_modal['total'] - $loss_beban['total'];

		$data['persentase_hasil'] = $hasil/$loss_modal['total']*100;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('pempek/laba-rugi', $data);
		$this->load->view('templates/footer');
	}
	
	public function getUpdatePempek(){
		echo json_encode($this->Pempek_model->getPempekById($this->input->post('id')));
	}

}