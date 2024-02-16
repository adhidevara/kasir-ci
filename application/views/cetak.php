<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cetak</title>
	<style>
		hr {
			border: none; /* Menghapus garis bawaan */
			border-top: 3px solid #000; /* Ketebalan dan warna garis */
			height: 3px; /* Ketebalan garis */
		}
	</style>
</head>
<body>
	<div style="width: auto;font-size: 10px;font-family: 'Verdana';font-weight: bold;">
		<br>
		<center>
			<?php echo $this->session->userdata('toko')->nama; ?><br>
			<?php echo $this->session->userdata('toko')->alamat; ?><br><hr>
			<table width="100%">
				<tr>
					<td>No.Order : <?php echo $id ?></td>
					<td align="right">Tanggal</td>
				</tr>
				<tr>
					<td>Kasir : <?php echo $kasir ?></td>
					<td align="right"><?php echo $tanggal ?></td>
				</tr>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="5%"></td>
					<td width="50%"><b>Item</b></td>
					<td width="3%" align="left"></td>
					<td width="10%" align="center"><b>Qty</b></td>
					<td width="17%" align="center"><b>@Harga</b></td>
					<td align="right" width="17%"><b>Jumlah</b></td>
				</tr>
				<?php foreach ($produk as $key): ?>
					<tr>
						<td width="5%"><?php echo $i += 1 ?>.</td>
						<td align="left"><?php echo $key->nama_produk ?></td>
						<td></td>
						<td align="center"><?php echo $key->total ?></td>
						<td width="17%" align="center">Rp.<?php echo ($key->harga/$key->total) ?></td>
						<td align="right">Rp.<?php echo $key->harga ?></td>
					</tr>
				<?php endforeach ?>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="76%" align="right">
						Subtotal
					</td>
					<td width="23%" align="right">
						Rp.<?php echo $total ?>
					</td>
				</tr>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="76%" align="right">
						<b>Total</b>
					</td>
					<td width="23%" align="right">
						<b>Rp.<?php echo $total ?></b>
					</td>
				</tr>
				<tr>
					<td width="76%" align="right">
						Bayar
					</td>
					<td width="23%" align="right">
						Rp.<?php echo $bayar ?>
					</td>
				</tr>
				<tr>
					<td width="76%" align="right">
						<i>Kembalian</i>
					</td>
					<td width="23%" align="right">
						<i>Rp.<?php echo $kembalian ?></i>
					</td>
				</tr>
			</table>
			<hr>
			~Terima Kasih~<br>
			Atas Kunjungan Anda<br><br>
			<?php echo $this->session->userdata('toko')->nama; ?>
		</center>
	</div>
	<script>
		window.print()
	</script>
</body>
</html>