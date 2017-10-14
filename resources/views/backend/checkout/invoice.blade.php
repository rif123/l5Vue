<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <meta id="token" name="token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/css/app.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/AdminLTE.min.css">

  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  @stack('css')
</head>
<body onload="window.print();">
    <!-- Site wrapper -->
    <div class="wrapper">
      <section class="invoice">
        <h2 class="page-header">
          {{config('settings.nama_hotel')}}
          <span class="small"></span>
          <span class="lead text-red pull-right"><b>INVOICE</b></span>
        </h2>
        <h6>
          {{config('settings.alamat_jalan').','.config('settings.alamat_kabupaten').','.config('settings.alamat_provinsi')}}<br><b>Telp :</b> {{config('settings.nomor_telp')}} -  <b>Fax :</b> {{config('settings.nomor_fax')}} -  <b>Email :</b> {{config('settings.email')}}          <br><b>{{config('settings.website')}}</b>
        </h6>
        <br>
        <br>

        <!-- Report Content -->
        
<div class="row">
	<div class="col-sm-6">
		Ditujukan Kepada :
		<address>
			<strong>{{$transaksi->tamu->nama_lengkap}}</strong><br>
			{{$transaksi->tamu->alamat_jalan}}<br>
			{{$transaksi->tamu->alamat_kabupaten.' - '.$transaksi->tamu->alamat_provinsi}}<br>
			<br>
			Nomor Telp : {{$transaksi->tamu->nomor_telp}}<br>
		</address>
	</div>
	<div class="col-sm-6">
		<b>NOMOR INVOICE : </b><br>
		<span class="lead">{{$transaksi->invoice_id}}</span><br><br>
		<b>Tanggal Terbit :</b><br>
		<span class="lead">{{date('d F Y')}}</span>
	</div>
</div>

<h3>RINCIAN TAGIHAN</h3>
<table class="table table-bordered table-striped table-responsive">
	<thead>
		<tr>
			<th>Keterangan Layanan / Produk</th>
			<th class="pull-right">Harga</th>
			<th class="text-center">Qty</th>
			<th class="pull-right">Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Room Type : {{$transaksi->kamar->typekamar->nama}}</td>
			<td class="pull-right">{{$transaksi->kamar->typekamar->harga_malam_format}}</td>
			<td class="text-center">{{$jumlah_hari ? $jumlah_hari : 1}} Malam</td>
			<td class="pull-right">Rp. {{number_format($transaksi->kamar->typekamar->harga_malam * ($jumlah_hari ? $jumlah_hari : 1),2)}}</td>
			<?php $sub_total = $transaksi->kamar->typekamar->harga_malam * ($jumlah_hari ? $jumlah_hari : 1); ?>
		</tr>
		@foreach($layanan as $service)
		<tr>
			<td>{{$service->layanan->nama_layanan}}</td>
			<td class="pull-right">{{$service->layanan->harga_format}}</td>
			<td class="text-center">{{$service->jumlah.' '.$service->layanan->satuan}}</td>
			<td class="pull-right">{{$service->total_format}}</td>
			<?php $sub_total = $sub_total + $service->total; ?>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="row">
	<div class="col-sm-6">
		<p class="text-muted well well-sm no-shadow">
			<b>Catatan :</b> Mohon simpan bukti pembayaran ini sebaik mungkin. Pihak hotel tidak akan melayani keluhan-keluhan tamu yang tidak memiliki bukti pembayaran resmi oleh Pihak Hotel
		</p>
	</div>
	<div class="col-sm-6">
		<table class="table table-bordered table-responsive">
			<tbody>
			<tr>
				<td><b>Sub-Total</b></td>
				<td class="pull-right">Rp. {{number_format($sub_total,2)}}</td>
			</tr>
			<tr>
				<td>PPn 10%</td>
				<?php $ppn = round($sub_total * (1/10)); ?>
				<td class="pull-right">Rp {{number_format($ppn,2)}}</td>
			</tr>
			<tr>
				<td><b>Grand Total</b></td>
				<?php $total = ($sub_total + $ppn) - $transaksi->deposit ; ?>
				<td class="pull-right"><b>Rp {{number_format($total,2)}}</b></td>
			</tr>
		</tbody></table>
	</div>
</div>
        <!-- end:Report -->
      </section>
    </div>

 <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
</script>
<script type="text/javascript" src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.1/vue-resource.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>
<script>  var base_url = "{{ url('/') }}";</script>
@stack('script')
</body>
</html> 

</body>