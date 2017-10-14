@extends('layouts.main')
@section('content')
<!-- @push('header')
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
</ol>
@endpush -->
<div class="row" id="perusahaan">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
      
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" enc="multipart/form-data" v-on:submit.prevent="ubahperusahaan(perusahaan.id)">
              <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Nama Hotel</label>
                          <input class="form-control" name="Nama Pengguna" placeholder="Nama Pengguna"  v-model="perusahaan.nama_hotel">
                          <span v-if="errorForm['nama_hotel']" class="error text-danger">@{{ errorForm['nama_hotel'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <label>Nama Perusahaan</label>
                          <input class="form-control" name="nama_perusahaan" placeholder="perusahaanname"  v-model="perusahaan.nama_perusahaan">
                           <span v-if="errorForm['nama_perusahaan']" class="error text-danger">@{{ errorForm['nama_perusahaan'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Alamat</label>
                          <textarea class="form-control" name="password" placeholder="Alamat"  v-model="perusahaan.alamat_jalan">@{{perusahaan.alamat_jalan}}</textarea>
                           <span v-if="errorForm['password']" class="error text-danger">@{{ errorForm['password'] }}</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Alamat Kota</label>
                          <input class="form-control" name="alamat_kabupaten" placeholder="Kabupaten"  v-model="perusahaan.alamat_kabupaten">
                           <span v-if="errorForm['alamat_kabupaten']" class="error text-danger">@{{ errorForm['alamat_kabupaten'] }}</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Alamat Provinsi</label>
                          <input class="form-control" name="alamat_provinsi" placeholder="Provinsi"  v-model="perusahaan.alamat_provinsi">
                           <span v-if="errorForm['alamat_provinsi']" class="error text-danger">@{{ errorForm['alamat_provinsi'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-3">
                          <label>Nomor Telp / Handphone</label>
                          <input class="form-control" name="nomor_telp"  v-model="perusahaan.nomor_telp">
                           <span v-if="errorForm['nomor_telp']" class="error text-danger">@{{ errorForm['nomor_telp'] }}</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Nomor Fax</label>
                          <input class="form-control" name="nomor_fax"  v-model="perusahaan.nomor_fax">
                           <span v-if="errorForm['nomor_fax']" class="error text-danger">@{{ errorForm['nomor_fax'] }}</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Website</label>
                          <input class="form-control" name="Website"  v-model="perusahaan.website">
                           <span v-if="errorForm['website']" class="error text-danger">@{{ errorForm['website'] }}</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" v-model="perusahaan.email">
                           <span v-if="errorForm['email']" class="error text-danger">@{{ errorForm['email'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                  </div>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

      </div>

@push('script')
<script>
	var perusahaan = new Vue({
	el: '#perusahaan',
	data: {
    perusahaan: {'nama_hotel' : ''},
    errorForm:{},
	 },
	methods: {

		ambilperusahaan:function(){
      var cari = this.cari ? this.cari : '';
      this.errorForm = {};
 			axios.get(base_url+'/admin/perusahaan/1/edit').then(response => {
    			this.perusahaan = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    ubahperusahaan:function(id){
      var input = this.perusahaan;
      axios.patch(base_url+'/admin/perusahaan/'+id,input).then(response => {
        this.ambilperusahaan();
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

	},
	created(){
		this.ambilperusahaan();
	}
});

</script>
@endpush
@endsection
