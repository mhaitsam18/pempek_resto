	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
		<?= $this->session->flashdata('message'); ?>
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Data Beban"></div>
		<?= form_error('nama_beban','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('biaya_beban','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<?= form_error('tanggal','<div class="alert alert-danger" role="alert">','</div>'); ?>
		<div class="row">
			<div class="col-lg-8">
				<a href="" class="btn btn-primary mb-3 newBebanModalButton" data-toggle="modal" data-target="#newBebanModal">Tambah Beban</a>
				<table class="table table-hover" id="dataTable">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">ID Beban</th>
							<th scope="col">Nama Beban</th>
							<th scope="col">Biaya Beban</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; ?>
						<?php foreach ($beban as $key): ?>
							<tr>
								<th scope="row"><?= $no ?></th>
								<td><?= $key['id'] ?></td>
								<td><?= $key['nama_beban'] ?></td>
								<td><?= $key['biaya_beban'] ?></td>
								<td><?= $key['tanggal'] ?></td>
								<td>
									<a href="<?= base_url("DataMaster/updateBeban/$key[id]"); ?>" class="badge badge-success updateBebanModalButton" data-toggle="modal" data-target="#newBebanModal" data-id="<?=$key['id']?>">Edit</a>
									<a href="<?= base_url("DataMaster/deleteBeban/$key[id]"); ?>" class="badge badge-danger tombol-hapus" data-hapus="Beban">Delete</a>
								</td>
							</tr>
							<?php $no++; ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="newBebanModal" tabindex="-1" aria-labelledby="newBebanModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newBebanModalLabel">Add New Load</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('Transaksi/beban') ?>" method="post">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group">
						<label for="nama_beban">Nama Beban</label>
						<input type="text" class="form-control" id="nama_beban" name="nama_beban">
						<?= form_error('nama_beban','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="biaya_beban">Biaya Beban</label>
						<input type="number" class="form-control" id="biaya_beban" name="biaya_beban">
						<?= form_error('biaya_beban','<small class="text-danger pl-3">','</small>'); ?>
					</div>
					<div class="form-group">
						<label for="tanggal">Tanggal Transaksi</label>
						<input type="date" class="form-control" id="tanggal" name="tanggal">
						<?= form_error('tanggal','<small class="text-danger pl-3">','</small>'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>