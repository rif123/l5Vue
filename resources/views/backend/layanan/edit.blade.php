@extends('layouts.main')
@section('content')
<div class="box" id="layanan">
	<div class="box-header">
		<h3 class="box-title">PESANAN KAMAR : 
			<b>{{$guest->kamar->nomor_kamar}}</b> - 
			<b>{{$guest->tamu->nama_lengkap}}</b>
		</h3>
		<a class="btn btn-warning pull-right" href="{{route('transaksilayanan.index')}}">Batal</a>
	</div>
	<div class="box-body">
		<!-- Pilih Produk Layanan -->
					<!-- Pilih Kategori Layanan -->
		<div class="row">
			@foreach($layanan as $service)
			<div class="col-sm-3">
				<button class="btn btn-lg btn-block btn-primary" @click.prevent="tambahLayanan({{$service->id}})">{{$service->nama_layanan_kategori}}</button>
			</div>
			@endforeach
		</div>
	</div>

	<div class="modal fade" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="simpanLayanan">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Pesan Layanan</h4>
              </div>
              <div class="modal-body">
              	<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Nama Produk / Layanan</th>
							<th>Harga</th>
							<th>Jumlah Pesanan</th>
						</tr>
					</thead>
					<tbody>
						<input type="hidden" v-model="dataInput.transaksi_kamar_id">
						<tr v-for="serve in service">
							<td>@{{serve.nama_layanan}}</td>
							<td>@{{serve.harga_format}} / @{{serve.satuan}}</td>
							<td>
								<div class="row">
									<div class="col-sm-4">
										<input class="form-control" name="jumlah" v-model="dataInput.layanan.jumlah[serve.id]">
										<input type="hidden" name="harga" v-model="dataInput.layanan.harga[serve.id] = serve.harga">
									</div>
									<div class="col-sm-8">
										@{{serve.satuan}}								
									</div>
								</div>
							</td>
						</tr>		
					</tbody>
				</table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
              </div>
              </form>
            </div>
          </div>
        </div>
</div>
@endsection
@push('script')
<script>
	var layanan = new Vue({
		el : '#layanan',
		data: {
			service: null,
			dataInput : {
				transaksi_kamar_id : '{{$guest->id}}',
				layanan : {harga:[],jumlah:[]}
			},
		},
		methods:{
			getLayanan:function(id){
				axios.get(base_url+'/api/getlayanan/'+id).then(response => {
	    			this.service = response.data;
	    			//console.log(this.service);
	    		}).catch(errors => {
	    			console.error(errors);
	    		})
			},
			simpanLayanan:function(){
				var input = this.dataInput;
				axios.post(base_url+'/admin/transaksilayanan',input).then(response => {
					if(response.data){
						$('#tambah-data').modal('hide');
						this.dataInput.layanan = {harga:[],jumlah:[]};
					}
				}).catch(errors => {
					console.error(errors);
				})
			},
			tambahLayanan : function(id){
				this.getLayanan(id);
				$('#tambah-data').modal('show');
			},
		}
	})
</script>
@endpush