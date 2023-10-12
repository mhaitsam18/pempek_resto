<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Member_model');
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
		$this->load->view('member/index', $data);
		$this->load->view('templates/footer');
	}

	public function pempekResto()
	{
		$data['title'] = "Pempek Resto";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['kurir'] = $this->db->get('kurir')->result_array();
		$config['base_url'] = base_url('Member/pempekResto/');
		// $config['total_rows'] = $this->Pempek_model->countAllPempek();
		if ($this->input->post('keyword')) {
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('keyword', $data['keyword']);
		} else{
			// $data['keyword'] = null;
			$data['keyword'] = $this->session->set_userdata('keyword');
		}
		if ($this->input->post('kategori')) {
			if ($this->input->post('kategori') != 'All Category') {
				$data['pilih_kategori'] = $this->input->post('kategori');
				$this->session->set_userdata('pilih_kategori', $data['pilih_kategori']);
			} else{
				$data['pilih_kategori'] = null;
				$this->session->set_userdata('pilih_kategori', $data['pilih_kategori']);
			}
		} else{
			// $data['pilih_kategori'] = null;
			$data['pilih_kategori'] = $this->session->userdata('pilih_kategori');
		}
		$this->db->like('nama_pempek', $data['keyword']);
		$this->db->like('id_kategori', $data['pilih_kategori']);
		$this->db->from('pempek');
		$this->db->where('aktif', 1);
		$config['total_rows'] = $this->db->count_all_results();
		$data['total_rows'] = $config['total_rows'];
		$config['per_page'] = 3;
		$config['num_links'] = 2;

		//styling
		$config['full_tag_open'] = '<nav aria-label="pagination"><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</nav></ul>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		if ($config['total_rows']-$this->uri->segment(3)>7) {
		  $config['next_link'] = '&raquo';
		} else{
		  $config['next_link'] = 'Next';
		}
		$config['next_tag_open'] = '
								<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		if ($this->uri->segment(3)>7) {
		  $config['prev_link'] = '&laquo';
		} else{
		  $config['prev_link'] = 'Prev';
		}
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		if (empty($this->uri->segment(3))) {
			$prev = '<li class="page-item disabled"><span class="page-link">Prev</span></li>';
			$next = '';
		} elseif ($config['total_rows']-$this->uri->segment(3)<3) {
			$prev = '';
			$next = '<li class="page-item disabled"><span class="page-link">Next</span></li>';
		} else {
			$next = '';
			$prev = '';
		}
		$config['cur_tag_open'] = $prev.'<li class="page-item active" aria-current="page"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>'.$next;

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = array('class' => 'page-link');

		// $config['display_pages'] = TRUE;
		// $config['attributes']['rel'] = FALSE;
		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);
		$data['pempek'] = $this->Pempek_model->getPempekByLimit($config['per_page'],$data['start'], $data['keyword'], $data['pilih_kategori']);
		$data['kategori'] = $this->db->get('kategori')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/pempek-resto', $data);
		$this->load->view('templates/footer');
	}
	public function tambahKeranjang($id, $rowid = '',$area = '')
	{
		if (!$this->session->userdata('cart_checkout', 'cart_checkout')) {
			$this->session->unset_userdata('cart_supply');
			$this->session->set_userdata('cart_checkout', 'cart_checkout');
			$this->cart->destroy();
		}
		$pempek = $this->Pempek_model->getPempekById($id);
		$keranjang = $this->cart->get_item($rowid);
		$rowid2 = get_rowid_cart($id);
		$keranjang2 = $this->cart->get_item($rowid2);
		if ($keranjang) {
			if ($pempek['stok'] <= $keranjang['qty']) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Mohon Maaf, Stok Pempek tidak mencukupi!
					</div>');
				if ($area == 'keranjang') {
					redirect('Member/keranjang');
				}
				redirect('Member/pempekResto');
			}
		} elseif ($pempek['stok'] <= 0) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Mohon Maaf, Stok Pempek tidak mencukupi!
				</div>');
			if ($area == 'keranjang') {
				redirect('Member/keranjang');
			}
			redirect('Member/pempekResto');
		} elseif ($keranjang2) {
			if ($pempek['stok'] <= $keranjang2['qty']) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Mohon Maaf, Stok Pempek tidak mencukupi!
					</div>');
				if ($area == 'keranjang') {
					redirect('Member/keranjang');
				}
				redirect('Member/pempekResto');
			}
		}
		$data = array(
	        'id'      => $pempek['id'],
	        'qty'     => 1,
	        'price'   => $pempek['harga_jual'],
	        'name'    => $pempek['nama_pempek'],
	        'gambar'    => $pempek['gambar']
	        // 'options' => array('Size' => 'L', 'Color' => 'Red')
    	);
    	$this->cart->insert($data);
		if ($area == 'keranjang') {
			redirect('Member/keranjang');
		}
    	redirect('Member/pempekResto');
	}

	public function kurangKeranjang($rowid, $qty, $area = '')
	{
		$data = array(
	        'rowid' => $rowid,
	        'qty'   => ($qty-1)
	    );
		$this->cart->update($data);
		if ($area == 'keranjang') {
			redirect('Member/keranjang');
		}
    	redirect('Member/pempekResto');
	}
	public function bersihkanKeranjang($area = '')
	{
		$this->cart->destroy();
		if ($area == 'keranjang') {
			redirect('Member/keranjang');
		}
    	redirect('Member/pempekResto');
	}

	public function hapusItem($rowid, $area = '')
	{
		$this->cart->remove($rowid);
		if ($area == 'keranjang') {
			redirect('Member/keranjang');
		}
    	redirect('Member/pempekResto');
	}

	public function checkout()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$kode_bayar = strtoupper(bin2hex(random_bytes(16)));
		$data = array(
			'id_user' => $data['user']['id'],
			'kode_bayar' => $kode_bayar,
			'nama_penerima' => $this->input->post('nama_penerima'),
			'no_hp_penerima' => $this->input->post('no_hp_penerima'),
			'alamat_penerima' => $this->input->post('alamat_penerima'),
			'id_kurir' => $this->input->post('id_kurir'),
			'total_harga' => $this->input->post('total_harga'),
			'total_harga' => $this->input->post('total_harga'),
			'id_metode_bayar' => $this->input->post('id_metode_bayar'),
			'waktu_pemesanan' => date("Y-m-d H:i:s"),
			'Status' => 'Belum dibayar',
		);
		$this->db->insert('checkout', $data);
		$checkout = $this->db->get_where('checkout', ['kode_bayar' => $kode_bayar])->row_array();
		foreach ($this->cart->contents() as $item) {
			$kode_pesanan = strtoupper(bin2hex(random_bytes(16)));
			$data = array(
				'id_checkout' => $checkout['id'],
				'id_pempek' => $item['id'],
				'kode_pesanan' => $kode_pesanan,
				'jumlah' => $item['qty'],
				'sub_total_harga' => $item['subtotal']
			);
			$this->db->insert('pesanan', $data);
			$pempek = $this->db->get_where('pempek',['id' => $item['id']])->row_array();
			$new_stok = $pempek['stok'] - $item['qty'];
			$this->db->where('id', $item['id']);
			$this->db->update('pempek',['stok' => $new_stok]);
		}
		$this->cart->destroy();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pemesanan Anda berhasil! Silahkan mengisi Form Bukti Pembayaran
			</div>');
		redirect("Member/pembayaran/$kode_bayar");
	}

	public function keranjang()
	{
		$data['title'] = "Keranjang";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['kurir'] = $this->db->get('kurir')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/keranjang', $data);
		$this->load->view('templates/footer');
	}

	public function pesanan()
	{
		$data['title'] = "Pesanan Saya";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, checkout.id AS idc');
		$this->db->join('metode_bayar', 'checkout.id_metode_bayar = metode_bayar.id');
		$data['checkout'] = $this->db->get_where('checkout', ['id_user' => $data['user']['id']])->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/pesanan-saya', $data);
		$this->load->view('templates/footer');
	}

	public function detailPesanan($id)
	{
		$data['title'] = "Detail Pesanan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, checkout.id AS idc');
		$this->db->join('metode_bayar', 'checkout.id_metode_bayar = metode_bayar.id');
		$this->db->join('kurir', 'checkout.id_kurir = kurir.id');
		$this->db->join('user', 'checkout.id_user = user.id');
		$data['checkout'] = $this->db->get_where('checkout', ['checkout.id' => $id])->row_array();

		$this->db->join('pempek', 'pempek.id = pesanan.id_pempek');
		$data['pesanan'] = $this->db->get_where('pesanan', ['id_checkout' => $id])->result_array();
		
		$this->db->select('*, bukti_transfer.id AS idbt, bukti_transfer.status AS sbt');
		$this->db->join('checkout', 'bukti_transfer.id_checkout = checkout.id');
		$this->db->join('user', 'checkout.id_user = user.id');
		$this->db->join('rekening', 'bukti_transfer.id_rekening_tujuan = rekening.id');
		$data['bukti_transfer'] = $this->db->get_where('bukti_transfer',['id_checkout' => $id])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/detail-pesanan', $data);
		$this->load->view('templates/footer');
	}

	public function updateStatusPesanan($id, $status = '')
	{
		$this->db->where('id', $id);
		$this->db->update('checkout', ['status' => 'Pesanan '.$status]);
		if ($status == 'dibatalkan') {
			$pesanan = $this->db->get_where('pesanan', ['id_checkout' => $id])->result_array();
			foreach ($pesanan as $row) {
				$pempek = $this->db->get_where('pempek',['id' => $row['id_pempek']])->row_array();
				$new_stok = $pempek['stok'] + $row['jumlah'];
				$this->db->where('id', $row['id_pempek']);
				$this->db->update('pempek',['stok' => $new_stok]);
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Pesanan telah '.$status.'
			</div>');
		redirect('Member/pesanan');
	}

	public function pembayaran($kode_bayar = '')
	{
		$data['title'] = "Pembayaran";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['rekening_tujuan'] = $this->db->get('rekening')->result_array();
		$data['kode_bayar'] = $kode_bayar;
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/pembayaran', $data);
		$this->load->view('templates/footer');
	}

	public function uploadBuktiTransfer()
	{
		$checkout = $this->db->get_where('checkout', ['kode_bayar' => $this->input->post('kode_bayar')])->row_array();
		$upload_image = $_FILES['bukti_pembayaran']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
			$config['upload_path'] = './assets/img/bukti_pembayaran';
			$config['max_size']     = '2048';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('bukti_pembayaran')) {
				$new_image = $this->upload->data('file_name');
				$data = array(
					'id_checkout' => $checkout['id'],
					'id_rekening_tujuan' => $this->input->post('id_rekening_tujuan'),
					'rekening_pengirim' => $this->input->post('rekening_pengirim'),
					'bank_pengirim' => $this->input->post('bank_pengirim'),
					'nama_pengirim' => $this->input->post('nama_pengirim'),
					'waktu_transfer' => $this->input->post('tanggal_transfer').' '.$this->input->post('waktu_transfer'),
					'nominal_transfer' => $this->input->post('nominal_transfer'),
					'bukti_pembayaran' => $new_image,
					'catatan' => $this->input->post('catatan'),
					'status' => 'Belum dikonfirmasi',
				);
				$this->db->insert('bukti_transfer', $data);

				$this->db->where('id', $checkout['id']);
				$this->db->update('checkout', ['status' => 'Menunggu konfirmasi pembayaran']);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Bukti Pembayaran Terkirim
					</div>');
				redirect('Member/pesanan');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
				redirect('Member/pembayaran');
			}
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Bukti Pembayaran Wajib diupload
				</div>');
			redirect('Member/pembayaran');
		}
	}

	public function riwayatPembayaran($id_checkout = '')
	{
		$data['title'] = "Riwayat Pembayaran";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($id_checkout) {
			$where = ['id_user' => $data['user']['id'], 'id_checkout' => $id_checkout];
		} else{
			$where = ['id_user' => $data['user']['id']];
		}
		$this->db->select('*, bukti_transfer.id AS idbt, bukti_transfer.status AS sbt');
		$this->db->join('checkout', 'bukti_transfer.id_checkout = checkout.id');
		$this->db->join('user', 'checkout.id_user = user.id');
		$this->db->join('rekening', 'bukti_transfer.id_rekening_tujuan = rekening.id');
		$data['bukti_transfer'] = $this->db->get_where('bukti_transfer',$where)->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('member/riwayat-pembayaran', $data);
		$this->load->view('templates/footer');
	}

	public function online()
	{
		redirect('Member/pesanan');
	}
	
}