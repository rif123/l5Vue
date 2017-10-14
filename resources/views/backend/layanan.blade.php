@extends('layouts.main')
@section('content')
<div class="row" id="layanan">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah  Layanan</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="carilayanan"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th style="white-space: nowrap;">Nama  Layanan</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for=" lay in layanan.data">
                  <td>@{{lay.nama_layanan}}</td>
                  <td>@{{lay.layanankategori.nama_layanan_kategori}}</td>
                  <td>@{{lay.satuan}}</td>
                  <td>@{{lay.harga}}</td>
                  <td style="white-space: nowrap;">
                  	<button class="btn btn-info btn-xs" @click.prevent="editlayanan(lay)">Edit</button>
						        <button class="btn btn-danger btn-xs" @click.prevent="hapuslayanan(lay.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambillayanan(pagination.current_page)"
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
              <form method="POST" enc="multipart/form-data" v-on:submit.prevent="tambahlayanan">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data @{{dataBaru.nama_layanan}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama  Layanan:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataBaru.nama_layanan" />
                  <span v-if="errorForm['nama_layanan']" class="error text-danger">@{{ errorForm['nama_layanan'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Kategori:</label>
                  <select class="form-control" name="layanan_kategori_id" v-model="dataBaru.layanan_kategori_id">
                    <option selected value="0">Pilih Type</option>
                    @foreach($layanan_kategori as $key=>$kategori)
                    <option value="{{$key}}">{{$kategori}}</option>
                    @endforeach
                  </select>
                  <span v-if="errorForm['layanan_kategori_id']" class="error text-danger">@{{ errorForm['layanan_kategori_id'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Satuan:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataBaru.satuan" />
                  <span v-if="errorForm['satuan']" class="error text-danger">@{{ errorForm['satuan'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Harga:</label>
                  <input type="number" name="harga" class="form-control" v-model.number="dataBaru.harga" />
                  <span v-if="errorForm['harga']" class="error text-danger">@{{ errorForm['harga'] }}</span>
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
              <form method="POST" enc="multipart/form-data" v-on:submit.prevent="ubahlayanan(dataEdit.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data @{{dataEdit.nama_layanan_}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama  Layanan:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataEdit.nama_layanan" />
                  <span v-if="errorForm['nama_layanan']" class="error text-danger">@{{ errorForm['nama_layanan'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Kategori:</label>
                  <select class="form-control" name="layanan_kategori_id" v-model="dataEdit.layanan_kategori_id">
                    <option selected value="0">Pilih Type</option>
                    @foreach($layanan_kategori as $key=>$kategori)
                    <option value="{{$key}}">{{$kategori}}</option>
                    @endforeach
                  </select>
                  <span v-if="errorForm['layanan_kategori_id']" class="error text-danger">@{{ errorForm['layanan_kategori_id'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Satuan:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataEdit.satuan" />
                  <span v-if="errorForm['satuan']" class="error text-danger">@{{ errorForm['satuan'] }}</span>
                </div>
                 <div class="form-group">
                  <label for="name">Harga:</label>
                  <input type="number" name="harga" class="form-control" v-model.number="dataEdit.harga" />
                  <span v-if="errorForm['harga']" class="error text-danger">@{{ errorForm['harga'] }}</span>
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
                <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirmlayanan(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
	var layanan = new Vue({
	el: '#layanan',
	data: {
    layanan: null,
    dataBaru: {'nama_layanan':'','layanan_kategori_id':'0','satuan':'','harga':0},
    errorForm:{},
    dataEdit: {'nama_layanan':'','layanan_kategori_id':'0','satuan':'','harga':0},
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

		ambillayanan:function(page){
      var cari = this.cari ? this.cari : '';
      this.errorForm = {};
 			axios.get(base_url+'/api/layanan?cari='+cari+'&page='+page).then(response => {
    			this.layanan = response.data;
          this.pagination = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    tambahlayanan:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/layanan',input).then(response=>{
        this.dataBaru = {'nama_layanan':'','layanan_kategori_id':'0','satuan':'','harga':0};
        $("#tambah-data").modal('hide');
        this.ambillayanan(this.layanan.current_page);
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

    editlayanan:function(layanan){
      this.dataEdit.id = layanan.id;
      this.dataEdit.nama_layanan = layanan.nama_layanan;
      this.dataEdit.layanan_kategori_id = layanan.layanan_kategori_id;
      this.dataEdit.satuan = layanan.satuan;
      this.dataEdit.harga = layanan.harga;
      $('#edit-data').modal('show');
    },

    ubahlayanan:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/layanan/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambillayanan(this.layanan.current_page);
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

    hapuslayanan:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmlayanan:function(id){
      axios.delete(base_url+'/admin/layanan/'+id).then(response => {
        this.ambillayanan(this.layanan.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    carilayanan:function(){
      axios.get(base_url+'/api/layanan?cari='+this.cari).then(response => {
        this.layanan = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

	},
	created(){
		this.ambillayanan(this.pagination.current_page);
	}
});

</script>
@endpush
@endsection
