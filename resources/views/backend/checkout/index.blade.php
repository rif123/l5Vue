@extends('layouts.main')
@section('content')
<div class="box">
	<div class="box-body">
		<div class="row">
			@foreach($kamar as $room)
			<div class="col-sm-3">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{$room->nomor_kamar}}</h3>
						<p>{{$room->transaksi->tamu->nama_lengkap}}</p>
					</div>
					<div class="icon">
						<i class="fa fa-bed"></i>
					</div>
					<a class="small-box-footer" href="{{route('checkin.checkoutedit',$room->transaksi->id)}}">Pilih Kamar</a>
					</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection