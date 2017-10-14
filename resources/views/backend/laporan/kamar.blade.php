@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@endpush
@section('content')
<div id="laporan">

	<form action="" method="post" @submit.prevent="getLaporan('{{Request::segment(3)}}')">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<input id="tgl_awal" data-date-format="yyyy-mm-dd" class="form-control" name="tanggal-start" placeholder="Dari Tanggal" v-model="dataInput.tgl_awal">
					<span v-if="errorForm['tgl_awal']" class="error text-danger">@{{ errorForm['tgl_awal'] }}</span>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<input id="tgl_akhir" data-date-format="yyyy-mm-dd" class="form-control" name="tanggal-end" placeholder="Sampai Tanggal" v-model="dataInput.tgl_akhir">
					<span v-if="errorForm['tgl_akhir']" class="error text-danger">@{{ errorForm['tgl_akhir'] }}</span>
				</div>
			</div>
			<div class="col-sm-3">
				<button class="btn btn-success" type="submit" name="laporan-transaksi">Lihat Laporan</button>
			</div>
		</div>
	</form>
		<div class="box">
		<div class="box-body">
			<table class="table table-striped"  v-if="type == 'kamar'">
				<thead>
					<tr>
						<th>Tanggal Transaksi</th>
						<th>Nomor Invoice</th>
						<th>Total Biaya Kamar</th>
					</tr>
				</thead>
				<tbody >
					<tr v-for="lap in laporan">
						<td>@{{lap.tgl_checkin}}</td>
						<td>@{{lap.invoice_id}}</td>
						<td>@{{lap.total_biaya_format}}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><span class="lead">Total Pendapatan : <b>@{{total}}</b></span></td>
					</tr>
				</tfoot>
			</table>
			<table v-else class="table table-striped">
				<thead>
					<tr>
						<th>Tanggal / Waktu</th>
						<th>Operator</th>
						<th>Nomor Kamar</th>
						<th>Produk / Layanan</th>
						<th>Harga Satuan</th>
						<th>Jumlah</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody >
					<tr v-for="lap in laporan">
						<td>@{{lap.created_at}}</td>
						<td>@{{lap.user.name}}</td>
						<td>@{{lap.transaksikamar.kamar.nomor_kamar}}</td>
						<td>@{{lap.layanan.nama_layanan}}</td>
						<td>@{{lap.layanan.harga_format}}</td>
						<td>@{{lap.jumlah}}</td>
						<td>@{{lap.total_format}}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><span class="lead">Total Pendapatan : <b>@{{total}}</b></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
@push('script')
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
	var laporan = new Vue({
		el : '#laporan',
		data: {
			dataInput : {
				tgl_akhir : '',
				tgl_awal : ''
			},
			laporan : null,
			total : 0,
			errorForm : {},
			type : '{{Request::segment(3)}}'
		},
		methods: {
			getLaporan: function(type){
				var input = this.dataInput;
				axios.post(base_url+'/api/getlaporan/'+type,input).then(response => {
					this.laporan = response.data.laporan;
					this.total = response.data.total;
				}).catch(errors => {
					if(errors.response){
			          if(errors.response.status = 422){
			            this.errorForm = errors.response.data;
			          }
			        } else {
			          console.error(errors);
			        }
				})
			}
		}
	});
	$('#tgl_akhir').datepicker({
      autoclose: true,
      enableOnReadonly: true,
    }).on('hide', function(e) {
        laporan.$data.dataInput.tgl_akhir = $("#tgl_akhir").val();
    });
	$('#tgl_awal').datepicker({
      autoclose: true,
      enableOnReadonly: true,
    }).on('hide', function(e) {
        laporan.$data.dataInput.tgl_awal = $("#tgl_awal").val();
    });
</script>
@endpush