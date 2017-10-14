@extends('layouts.main')
@section('content')
<div class="row" id="kategorilayanan">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah Kategori Layanan</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input kategori="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button kategori="submit" class="btn btn-default" @click.prevent="carikategorilayanan"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th style="white-space: nowrap;">Nama Kategori Layanan</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for="kategori in kat_layanan.data">
                  <td>@{{kategori.nama_layanan_kategori}}</td>
                  <td>@{{kategori.keterangan}}</td>
                  <td style="white-space: nowrap;">
                  	<button class="btn btn-info btn-xs" @click.prevent="editkategorilayanan(kategori)">Edit</button>
						        <button class="btn btn-danger btn-xs" @click.prevent="hapuskategorilayanan(kategori.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambilkategorilayanan(pagination.current_page)"
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
              <form method="POST" enckategori="multipart/form-data" v-on:submit.prevent="tambahkategorilayanan">

              <div class="modal-header">
                <button kategori="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data @{{dataBaru.nama_layanan_kategori}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama Kategori Layanan:</label>
                  <input kategori="text" name="nama" class="form-control" v-model="dataBaru.nama_layanan_kategori" />
                  <span v-if="errorForm['nama_layanan_kategori']" class="error text-danger">@{{ errorForm['nama_layanan_kategori'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="keterangan" v-model="dataBaru.keterangan"></textarea>
                  <span v-if="errorForm['keterangan']" class="error text-danger">@{{ errorForm['keterangan'] }}</span>
                </div>
              </div>
              <div class="modal-footer">
                <button kategori="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button kategori="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Model Edit -->
        <div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" enckategori="multipart/form-data" v-on:submit.prevent="ubahkategorilayanan(dataEdit.id)">

              <div class="modal-header">
                <button kategori="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data @{{dataEdit.nama_layanan_kategori}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama Kategori Layanan:</label>
                  <input kategori="text" name="nama" class="form-control" v-model="dataEdit.nama_layanan_kategori" />
                  <span v-if="errorForm['nama_layanan_kategori']" class="error text-danger">@{{ errorForm['nama_layanan_kategori'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="keterangan" v-model="dataEdit.keterangan"></textarea>
                  <span v-if="errorForm['keterangan']" class="error text-danger">@{{ errorForm['keterangan'] }}</span>
                </div>
              </div>
              <div class="modal-footer">
                <button kategori="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button kategori="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="hapus-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button kategori="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Hapus Data</h4>
              </div>
              <div class="modal-body">
                Yakin ingin menghapus data ?
              </div>
              <div class="modal-footer">
                <button kategori="button" class="btn btn-default" data-dismiss="modal">N O</button>
                <button kategori="submit" class="btn btn-primary" @click.prevent="hapuskonfirmkategorilayanan(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
	var kategorilayanan = new Vue({
	el: '#kategorilayanan',
	data: {
    kat_layanan: null,
    dataBaru: {'nama_layanan_kategori':'','keterangan':''},
    errorForm:{},
    dataEdit: {'nama_layanan_kategori':'','keterangan':''},
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

		ambilkategorilayanan:function(page){
      var cari = this.cari ? this.cari : '';
      this.errorForm = {};
 			axios.get(base_url+'/api/kategorilayanan?cari='+cari+'&page='+page).then(response => {
    			this.kat_layanan = response.data;
          this.pagination = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    tambahkategorilayanan:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/kategorilayanan',input).then(response=>{
        this.dataBaru = {'kategori_id':0,'harga_malam':1,'harga_orang':1};
        $("#tambah-data").modal('hide');
        this.ambilkategorilayanan(this.kat_layanan.current_page);
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

    editkategorilayanan:function(kat_layanan){
      this.dataEdit.id = kat_layanan.id;
      this.dataEdit.nama_layanan_kategori = kat_layanan.nama_layanan_kategori;
      this.dataEdit.keterangan = kat_layanan.keterangan;
      $('#edit-data').modal('show');
    },

    ubahkategorilayanan:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/kategorilayanan/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambilkategorilayanan(this.kat_layanan.current_page);
      }).catch(errors=>{
        console.error(errros);
      })
    },

    hapuskategorilayanan:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmkategorilayanan:function(id){
      axios.delete(base_url+'/admin/kategorilayanan/'+id).then(response => {
        this.ambilkategorilayanan(this.kat_layanan.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    carikategorilayanan:function(){
      axios.get(base_url+'/api/kategorilayanan?cari='+this.cari).then(response => {
        this.kat_layanan = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

	},
	created(){
		this.ambilkategorilayanan(this.pagination.current_page);
	}
});

</script>
@endpush
@endsection
