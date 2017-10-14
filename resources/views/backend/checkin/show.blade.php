@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@endpush
@section('content')
<div class="box" id="checkin">
	<div class="box-header">
		<h3 class="box-title">KAMAR NOMOR : <b>{{$transaksi->nomor_kamar}}</b></h3>
	</div>
	<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="ubahCheckin({!!$transaksi->id!!})">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label># INVOICE</label>
						<input class="form-control" name="invoice_id" value="{{$transaksi->invoice_id}}" v-model="dataInput.invoice_id" readonly>
					</div>
					<div class="alert alert-info">
						<h4>STANDART</h4>
						<ul class="list-unstyled">
							<li>Harga / Malam : <b>{{$transaksi->kamar->typekamar->harga_malam_format}}</b></li>
							<li>Maximal Orang Dewasa : <b>{{$transaksi->kamar->max_dewasa}} Orang</b></li>
							<li>Maximal Anak-anak : <b>{{$transaksi->kamar->max_anak}} Orang</b></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Nama Tamu</label>
						<select class="form-control nama_tamu" name="tamu_id" v-model="dataInput.tamu_id">
							<option selected="selected" value="0">--Pilih--</option>
							@foreach($tamu as $key => $guest)
							<option value="{{$key}}">{{$guest}}</option>
							@endforeach
						</select>
					</div>
					<div class="well">
						<a href="{{route('tamu.index')}}"><b>Klik disini</b></a> jika nama tamu yang dimaksud tidak ditemukan untuk ditambah pada daftar buku tamu.
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label>Jumlah Tamu</label>
						<div class="row">
							<div class="col-sm-6">
								<select class="form-control" name="jumlah_dewasa" v-model="dataInput.jumlah_dewasa">
									<option value="0">- Dewasa -</option>
									@for($i= 1;$i <= $transaksi->kamar->max_dewasa;$i++)
									<option value="{{$i}}">{{$i}} Orang</option>
									@endfor
								</select>
							</div>
							<div class="col-sm-6">
								<select class="form-control" name="jumlah_anak" v-model="dataInput.jumlah_anak">
									<option value="0">- Anak-anak -</option>
									@for($i= 1;$i <= $transaksi->kamar->max_anak;$i++)
									<option value="{{$i}}">{{$i}} Orang</option>
									@endfor
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Tanggal / Waktu Check-In</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control" name="tgl_checkin" value="{{date('Y-m-d')}}" readonly="" v-model="dataInput.tgl_checkin">
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="waktu_checkin" value="{{date('h:i')}}" readonly="" v-model="dataInput.waktu_checkin">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Tanggal / Waktu Check-Out</label>
						<div class="row">
							<div class="col-sm-6">
								<input id="checkout" class="form-control" name="tgl_checkout" data-date-format="yyyy-mm-dd" v-model="dataInput.tgl_checkout" readonly>
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="waktu_checkout" value="12:00" readonly v-model="dataInput.waktu_checkout">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Jumlah Deposit (Rp)</label>
						<input type="number" class="form-control" name="deposit" v-model="dataInput.deposit">
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" name="kamar_id" v-model="dataInput.kamar_id">
			<button class="btn btn-success" type="submit" name="checkin">Ubah</button>
			<a class="btn btn-warning" href="{{route('checkin.index')}}">Batal</a>
		</div>
	</form>
</div>
@endsection
@push('script')
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    var transaksi = new Vue({
    	el : '#checkin',
    	data : {
    		dataInput : {
    			'invoice_id' : '{{$transaksi->invoice_id}}',
    			'tamu_id' : '{{$transaksi->tamu_id}}',
    			'kamar_id' : '{{$transaksi->kamar_id}}',
    			'jumlah_dewasa' : '{{$transaksi->jumlah_dewasa}}',
    			'jumlah_anak' : '{{$transaksi->jumlah_anak}}',
    			'tgl_checkin' : '{{date("Y-m-d",strtotime($transaksi->tgl_checkin))}}',
    			'waktu_checkin' : '{{date("H:i",strtotime($transaksi->tgl_checkin))}}',
    			'tgl_checkout' : '{{date("Y-m-d",strtotime($transaksi->tgl_checkout))}}',
    			'waktu_checkout' : '12:00',
    			'deposit' : '{{$transaksi->deposit}}'
    		},
    		errorForm:{},
    	},

    	methods: {
    		ubahCheckin:function(id){
		      var input = this.dataInput;
		      axios.patch(base_url+'/admin/checkin/'+id,input).then(response=>{
		      	
		      		if(response.data)
		      		 	window.location.href = '{{route("checkin.tamu")}}';
		      }).catch(errors=>{
		        if(errors.response){
		          if(errors.response.status = 422){
		            this.errorForm = errors.response.data;
		          }
		        } else {
		          console.error(errors);
		        }
		      })
		    },
    	}
    });
   	$('#checkout').datepicker({
      autoclose: true,
      startDate: '{{date("Y-m-d",strtotime("+1 day"))}}',
      enableOnReadonly: true,
    }).on('hide', function(e) {
        transaksi.$data.dataInput.tgl_checkout = $("#checkout").val();
    });
</script>
@endpush