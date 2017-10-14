@extends('layouts.main')
@section('content')
<div class="box">
	<div class="box-body">
		<div class="row">
		@foreach($guest as $service)
			<div class="col-sm-3">
				<div class="small-box bg-blue">
					<div class="inner">
						<h3>{{$service->kamar->nomor_kamar}}</h3>
						<p>{{$service->tamu->nama_lengkap}}</p>
					</div>
					<div class="icon">
						<i class="fa fa-bed"></i>
					</div>
					<a class="small-box-footer" href="{{route('transaksilayanan.show',$service->id)}}">Masukan Pesanan Layanan</a>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection