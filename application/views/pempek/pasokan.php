<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-12">
			<h3 class="h3 mt-5">Riwayat Penyetokan Pempek</h3>
			<!-- <a href="<?= base_url('Pempek/pempek') ?>" class="btn btn-sm btn-info">Tambah Stok Pempek</a> -->
			<table class="table table-bordered" style="background-color: white;" id="dataTable">
				<thead>
					<tr>
						<th scope="col">No</th>
						<!-- <th scope="col">Pemasok</th> -->
						<th scope="col">Nama Petugas</th>
						<th scope="col">Kode Pempek</th>
						<th scope="col">Nama Pempek</th>
						<th scope="col">Jumlah</th>
						<th scope="col">Modal</th>
						<th scope="col">Sub Total</th>
						<th scope="col">Waktu Produksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=0; ?>
					<?php foreach ($pasokan as $row): ?>
						<tr>
							<th scope="row"><?= ++$no ?></th>
							<!-- <td><?= $row['pemasok'] ?></td> -->
							<td><?= $row['name'] ?></td>
							<td><?= $row['kode_pempek'] ?></td>
							<td><?= $row['nama_pempek'] ?></td>
							<td><?= $row['jumlah'] ?></td>
							<td><?= 'Rp.'.number_format(($row['sub_total_harga']/$row['jumlah']),2,',','.') ?></td>
							<td><?= 'Rp.'.number_format($row['sub_total_harga'],2,',','.') ?></td>
							<td><?= $row['waktu_transaksi'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->