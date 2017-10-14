@extends('layouts.main')
@section('content')
<div class="box">
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th># Kamar</th>
						<th>Nama Tamu</th>
						<th>Tanggal Check-In</th>
						<th>Tanggal Check-Out</th>
						<th>Jumlah Deposit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transaksi as $tamu)
					<tr>
						<td>{{$tamu->kamar->nomor_kamar}}</td>
						<td>{{$tamu->tamu->nama_lengkap}}</td>
						<td>{{date('Y-m-d',strtotime($tamu->tgl_checkin))}}</td>
						<td>{{date('Y-m-d',strtotime($tamu->tgl_checkout))}}</td>
						<td>{{$tamu->deposit_format}}</td>
						<td><a class="btn btn-xs btn-primary" href="{{route('checkin.show',$tamu->id)}}">Ubah</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection