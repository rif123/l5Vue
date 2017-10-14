@extends('layouts.main')
@section('content')
<!-- @push('header')
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
</ol>
@endpush -->
<div class="row" id="tamu">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah  Tamu</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="caritamu"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th style="white-space: nowrap;">Nama  Tamu</th>
                  <th>Warga Negara</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for=" guest in tamu.data">
                  <td>@{{guest.nama_lengkap}}</td>
                  <td>@{{guest.warga_negara}}</td>
                  <td>@{{guest.nomor_telp}}</td>
                  <td>@{{guest.email}}</td>
                  <td style="white-space: nowrap;">
                  	<button class="btn btn-info btn-xs" @click.prevent="edittamu(guest)">Edit</button>
						        <button class="btn btn-danger btn-xs" @click.prevent="hapustamu(guest.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambiltamu(pagination.current_page)"
                     :offset="4">
                </vue-pagination>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" enc="multipart/form-data" v-on:submit.prevent="tambahtamu">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data @{{dataBaru.prefix}} @{{dataBaru.nama_depan}} @{{dataBaru.nama_belakang}}</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Nama Tamu</label>
                      <div class="row">
                        <div class="col-sm-3">
                         <input class="form-control" name="prefix" placeholder="prefix"  v-model="dataBaru.prefix">
                          <span v-if="errorForm['prefix']" class="error text-danger">@{{ errorForm['prefix'] }}</span>
                        </div>
                        <div class="col-sm-4">
                          <input class="form-control" name="nama_depan" placeholder="Nama Depan"  v-model="dataBaru.nama_depan">
                           <span v-if="errorForm['nama_depan']" class="error text-danger">@{{ errorForm['nama_depan'] }}</span>
                        </div>
                        <div class="col-sm-4">
                          <input class="form-control" name="nama_belakang" placeholder="Nama Belakang"  v-model="dataBaru.nama_belakang">
                           <span v-if="errorForm['nama_belakang']" class="error text-danger">@{{ errorForm['nama_belakang'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Identitas</label>
                      <div class="row">
                        <div class="col-sm-3">
                          <select class="form-control" name="tipe_identitas" v-model="dataBaru.tipe_identitas">
                            <option value="KTP">KTP</option>
                            <option value="KTP">SIM</option>
                            <option value="KTP">PASSPORT</option>
                          </select>
                           <span v-if="errorForm['tipe_identitas']" class="error text-danger">@{{ errorForm['tipe_identitas'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" name="nomor_identitas" placeholder="Nomor Identitas"  v-model="dataBaru.nomor_identitas">
                           <span v-if="errorForm['nomor_identitas']" class="error text-danger">@{{ errorForm['nomor_identitas'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Warga Negara</label>
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" name="warga_negara" v-model="dataBaru.warga_negara">
                           <span v-if="errorForm['warga_negara']" class="error text-danger">@{{ errorForm['warga_negara'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea class="form-control" name="alamat_jalan" v-model="dataBaru.alamat_jalan"></textarea>
                       <span v-if="errorForm['alamat_jalan']" class="error text-danger">@{{ errorForm['alamat_jalan'] }}</span>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <input class="form-control" name="alamat_kabupaten" placeholder="Kabupaten / Kota" v-model="dataBaru.alamat_kabupaten">
                           <span v-if="errorForm['alamat_kabupaten']" class="error text-danger">@{{ errorForm['alamat_kabupaten'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" name="alamat_provinsi" placeholder="Provinsi" v-model="dataBaru.alamat_provinsi">
                           <span v-if="errorForm['alamat_provinsi']" class="error text-danger">@{{ errorForm['alamat_provinsi'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Nomor Telp / Handphone</label>
                          <input class="form-control" name="nomor_telp"  v-model="dataBaru.nomor_telp">
                           <span v-if="errorForm['nomor_telp']" class="error text-danger">@{{ errorForm['nomor_telp'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <label>Email</label>
                          <input class="form-control" name="email" v-model="dataBaru.email">
                           <span v-if="errorForm['email']" class="error text-danger">@{{ errorForm['email'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Model Edit -->
        <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" enc="multipart/form-data" v-on:submit.prevent="ubahtamu(dataEdit.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data @{{dataEdit.prefix}} @{{dataEdit.nama_depan}} @{{dataEdit.nama_belakang}}</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Nama Tamu</label>
                      <div class="row">
                        <div class="col-sm-3">
                          
                         <input class="form-control" name="prefix" placeholder="prefix"  v-model="dataEdit.prefix">
                          <span v-if="errorForm['prefix']" class="error text-danger">@{{ errorForm['prefix'] }}</span>
                        </div>
                        <div class="col-sm-4">
                          <input class="form-control" name="nama_depan" placeholder="Nama Depan"  v-model="dataEdit.nama_depan">
                           <span v-if="errorForm['nama_depan']" class="error text-danger">@{{ errorForm['nama_depan'] }}</span>
                        </div>
                        <div class="col-sm-4">
                          <input class="form-control" name="nama_belakang" placeholder="Nama Belakang"  v-model="dataEdit.nama_belakang">
                           <span v-if="errorForm['nama_belakang']" class="error text-danger">@{{ errorForm['nama_belakang'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Identitas</label>
                      <div class="row">
                        <div class="col-sm-3">
                          <select class="form-control" name="tipe_identitas" v-model="dataEdit.tipe_identitas">
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="PASSPORT">PASSPORT</option>
                          </select>
                           <span v-if="errorForm['tipe_identitas']" class="error text-danger">@{{ errorForm['tipe_identitas'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" name="nomor_identitas" placeholder="Nomor Identitas"  v-model="dataEdit.nomor_identitas">
                           <span v-if="errorForm['nomor_identitas']" class="error text-danger">@{{ errorForm['nomor_identitas'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Warga Negara</label>
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" name="warga_negara" v-model="dataEdit.warga_negara">
                           <span v-if="errorForm['warga_negara']" class="error text-danger">@{{ errorForm['warga_negara'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea class="form-control" name="alamat_jalan" v-model="dataEdit.alamat_jalan"></textarea>
                       <span v-if="errorForm['alamat_jalan']" class="error text-danger">@{{ errorForm['alamat_jalan'] }}</span>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <input class="form-control" name="alamat_kabupaten" placeholder="Kabupaten / Kota" v-model="dataEdit.alamat_kabupaten">
                           <span v-if="errorForm['alamat_kabupaten']" class="error text-danger">@{{ errorForm['alamat_kabupaten'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" name="alamat_provinsi" placeholder="Provinsi" v-model="dataEdit.alamat_provinsi">
                           <span v-if="errorForm['alamat_provinsi']" class="error text-danger">@{{ errorForm['alamat_provinsi'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Nomor Telp / Handphone</label>
                          <input class="form-control" name="nomor_telp"  v-model="dataEdit.nomor_telp">
                           <span v-if="errorForm['nomor_telp']" class="error text-danger">@{{ errorForm['nomor_telp'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <label>Email</label>
                          <input class="form-control" name="email" v-model="dataEdit.email">
                           <span v-if="errorForm['email']" class="error text-danger">@{{ errorForm['email'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="hapus-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Hapus Data</h4>
              </div>
              <div class="modal-body">
                Yakin ingin menghapus data ?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">N O</button>
                <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirmtamu(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
	var tamu = new Vue({
	el: '#tamu',
	data: {
    tamu: null,
    dataBaru: {'prefix':'','tipe_identitas':'KTP','nama_depan':'','nama_belakang':''},
    errorForm:{},
    dataEdit: {'prefix':'','tipe_identitas':'KTP','nama_depan':'','nama_belakang':''},
    cari: null,
    counter: 0,
    pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1
    },
    offset: 4,
    hapus_id:null
	 },
	methods: {

		ambiltamu:function(page){
      var cari = this.cari ? this.cari : '';
      this.errorForm = {};
 			axios.get(base_url+'/api/tamu?cari='+cari+'&page='+page).then(response => {
    			this.tamu = response.data;
          this.pagination = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    tambahtamu:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/tamu',input).then(response=>{
        this.dataBaru = {'prefix':'','tipe_identitas':'KTP'};
        $("#tambah-data").modal('hide');
        this.ambiltamu(this.tamu.current_page);
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

    edittamu:function(tamu){
      this.dataEdit = tamu
      $('#edit-data').modal('show');
    },

    ubahtamu:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/tamu/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambiltamu(this.tamu.current_page);
      }).catch(errors=>{
        console.error(errros);
      })
    },

    hapustamu:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmtamu:function(id){
      axios.delete(base_url+'/admin/tamu/'+id).then(response => {
        this.ambiltamu(this.tamu.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    caritamu:function(){
      axios.get(base_url+'/api/tamu?cari='+this.cari).then(response => {
        this.tamu = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

	},
	created(){
		this.ambiltamu(this.pagination.current_page);
	}
});

</script>
@endpush
@endsection
