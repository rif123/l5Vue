@extends('layouts.main')
@section('content')
<div class="box" id="bersih">
	<div class="box-body">
		<div class="row" v-if="kamar == null">
			<div class="col-sm-3" v-for="room in kamar">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>@{{room.nomor_kamar}}</h3>
						<p>@{{room.typekamar.nama}}</p>
					</div>
					<div class="icon">
						<i class="fa fa-bed"></i>
					</div>
					<a class="small-box-footer" href="" @click.prevent="bersihkan(room.id)">Bersihkan Kamar</a>
				</div>
			</div>
		</div>
		<div class="alert alert-warning" v-else>
				<h4>Mohon Maaf</h4>
				Untuk sementara, tidak ada kamar yang sedang kotor.
		</div>
	</div>
</div>
@endsection
@push('script')
<script>
	var bersih = new Vue({
		el: '#bersih',
		data: {
			kamar : null,
		},
		methods: {
			ambilKamar:function(){
				axios.get(base_url+'/api/getkamarkotor').then(response => {
					this.kamar = response.data;
				}).catch(errors=>{

				})
			},
			bersihkan:function(id){
				axios.get(base_url+'/admin/transaksilayanan/'+id+'/edit').then(response =>{
					this.ambilKamar();
				}).catch(errors => {
					console.error(errors);
				});
			}
		},
		created(){
			this.ambilKamar();
		}

	})
</script>
@endpush