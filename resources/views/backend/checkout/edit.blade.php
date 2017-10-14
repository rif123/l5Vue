@extends('layouts.main')
@section('content')
<div class="box" id="check-out">
	<div class="box-header">
			<h3 class="box-title">KAMAR NOMOR : <b>{{$transaksi->kamar->nomor_kamar}}</b></h3>
	</div>
	<form action="" method="post">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-3">						
					<div class="alert alert-info">
						<h4>{{$transaksi->kamar->typekamar->nama}}</h4>
						<ul class="list-unstyled">
							<li>Harga / Malam : <b>{{$transaksi->kamar->typekamar->harga_malam_format}}</b></li>
							<li>Maximal Orang Dewasa : <b>{{$transaksi->kamar->max_dewasa}} Orang</b></li>
							<li>Maximal Anak-anak : <b>{{$transaksi->kamar->max_anak}} Orang</b></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label># INVOICE</label>
						<input class="form-control" name="nomor_invoice" value="{{$transaksi->invoice_id}}" readonly="">
					</div>
					<div class="form-group">
						<label>Nama Tamu</label>
						<input class="form-control" value="{{$transaksi->tamu->nama_lengkap}}" readonly="">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label>Jumlah Tamu</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control" value="{{$transaksi->jumlah_dewasa}} Dewasa" readonly="">
							</div>
							<div class="col-sm-6">
								<input class="form-control" value="{{$transaksi->jumlah_anak}} Anak-anak" readonly="">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Tanggal / Waktu Check-In</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control" value="{{date('Y-m-d',strtotime($transaksi->tgl_checkin))}}" readonly="">
							</div>
							<div class="col-sm-6">
								<input class="form-control" value="{{date('H:i:s',strtotime($transaksi->tgl_checkin))}}" readonly="">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Tanggal / Waktu Check-Out</label>
						<div class="row">
							<div class="col-sm-6">
								<input id="checkout" class="form-control" name="tanggal_checkout" data-date-format="yyyy-mm-dd" value="{{date('Y-m-d',strtotime($tgl_checkout))}}" readonly="">
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="waktu_checkout" value="{{date('H:i:s',strtotime($tgl_checkout))}}" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
			<h3>Rincian Tagihan</h3>
			<hr>
			<table class="table table-striped">
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
						<td>Room reserved type : {{$transaksi->kamar->typekamar->nama}} ROOM</td>
						<td class="pull-right">{{$transaksi->kamar->typekamar->harga_malam_format}}</td>
						<td class="text-center">{{$jumlah_hari ? $jumlah_hari : 1}} Hari</td>
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
					<tr>
						<td rowspan="4"></td>
						<td colspan="2"><b>Sub-Total</b></td>
						<td class="pull-right"><b>Rp. {{number_format($sub_total,2)}}</b></td>
					</tr>
					<tr>							
						<td colspan="2">PPn 10%</td>
						<?php $ppn = round($sub_total * (1/10)); ?>
						<td class="pull-right">Rp {{number_format($ppn,2)}}</td>
					</tr>
					<tr>							
						<td colspan="2">Jumlah Deposit</td>
						<td class="text-red pull-right" >{{$transaksi->deposit_format}}</td>
					</tr>
					<tr>							
						<?php $total = ($sub_total + $ppn) - $transaksi->deposit ; ?>
						<td colspan="2"><b>Grand Total</b></td>
						<td class="pull-right"><b>Rp {{number_format($total,2)}}</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="box-footer">

			<button class="btn btn-success" type="submit" v-on:click.prevent="simpanCheckout(transaksi_id)"name="checkout">Check Out</button>

			<a class="btn btn-primary" href="{{route('checkin.checkoutprint',$transaksi->id)}}" target="_blank">Cetak Invoice</a>
			<a class="btn btn-warning" href="{{route('checkin.checkout')}}">Batal</a>
		</div>
	</form>
</div>
@endsection
@push('script')
<script>
	var checkout = new Vue({
		el : '#check-out',
		data : {
			transaksi_id : '{{$transaksi->id}}'
		},
		methods: {
			simpanCheckout:function(id){
				var input = {id: id}
				axios.post(base_url+'/admin/checkout',input).then(response => {
					if(response.data)
						window.location.href : '{{route("checkin.checkout")}}';
				}).catch(errors => {
					console.error(errors);
				})
			}
		}
	});
</script>
@endpush