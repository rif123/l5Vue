@extends('layouts.main')
@section('content')
<div class="row" id="typekamar">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah Type kamar</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="caritypekamar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Type Kamar</th>
                  <th>Harga / Malam</th>
                  <th>Harga / Orang</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for="type in typekamar.data">
                  <td>@{{type.nama}}</td>
                  <td>@{{type.harga_malam_format}}</td>
                  <td>@{{type.harga_orang_format}}</td> 
                  <td>
                  	<button class="btn btn-info btn-xs" @click.prevent="edittypekamar(type)">Edit</button>
						        <button class="btn btn-danger btn-xs" @click.prevent="hapustypekamar(type.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambiltypekamar(pagination.current_page)"
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="tambahtypekamar">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data @{{dataBaru.nama}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama Type Kamar:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataBaru.nama" />
                  <span v-if="errorForm['nama']" class="error text-danger">@{{ errorForm['nama'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Harga / Malam:</label>
                  <input type="number" name="harga_malam" class="form-control" v-model.number="dataBaru.harga_malam" />
                  <span v-if="errorForm['harga_malam']" class="error text-danger">@{{ errorForm['harga_malam'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Harga / Orang:</label>
                  <input type="number" name="harga_orang" class="form-control" v-model.number="dataBaru.harga_orang" />
                  <span v-if="errorForm['harga_orang']" class="error text-danger">@{{ errorForm['harga_orang'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="keterangan" v-model="dataBaru.keterangan"></textarea>
                  <span v-if="errorForm['keterangan']" class="error text-danger">@{{ errorForm['keterangan'] }}</span>
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="ubahtypekamar(dataEdit.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data @{{dataEdit.nama}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nama Type Kamar:</label>
                  <input type="text" name="nama" class="form-control" v-model="dataEdit.nama" />
                  <span v-if="errorForm['nama']" class="error text-danger">@{{ errorForm['nama'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Harga / Malam:</label>
                  <input type="number" name="harga_malam" class="form-control" v-model.number="dataEdit.harga_malam" />
                  <span v-if="errorForm['harga_malam']" class="error text-danger">@{{ errorForm['harga_malam'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Harga / Orang:</label>
                  <input type="number" name="harga_orang" class="form-control" v-model.number="dataEdit.harga_orang" />
                  <span v-if="errorForm['harga_orang']" class="error text-danger">@{{ errorForm['harga_orang'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="keterangan" v-model="dataEdit.keterangan"></textarea>
                  <span v-if="errorForm['keterangan']" class="error text-danger">@{{ errorForm['keterangan'] }}</span>
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
                <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirmtypekamar(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
	var typekamar = new Vue({
	el: '#typekamar',
	data: {
    typekamar: null,
    dataBaru: {'nama':'','harga_malam':0,'harga_orang':0},
    errorForm:{},
    dataEdit: {'nama':'','harga_malam':0,'harga_orang':0},
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

		ambiltypekamar:function(page){
      var cari = this.cari ? this.cari : '';
			axios.get(base_url+'/api/typekamar?cari='+cari+'&page='+page).then(response => {
    			this.typekamar = response.data;
          this.pagination = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    tambahtypekamar:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/typekamar',input).then(response=>{
        this.dataBaru = {'type_id':0,'harga_malam':1,'harga_orang':1};
        $("#tambah-data").modal('hide');
        this.ambiltypekamar(this.typekamar.current_page);
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

    edittypekamar:function(typekamar){
      this.dataEdit.id = typekamar.id;
      this.dataEdit.nama = typekamar.nama;
      this.dataEdit.harga_malam = typekamar.harga_malam;
      this.dataEdit.harga_orang = typekamar.harga_orang;
      $('#edit-data').modal('show');
    },

    ubahtypekamar:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/typekamar/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambiltypekamar(this.typekamar.current_page);
      }).catch(errors=>{
        console.error(errros);
      })
    },

    hapustypekamar:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmtypekamar:function(id){
      axios.delete(base_url+'/admin/typekamar/'+id).then(response => {
        this.ambiltypekamar(this.typekamar.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    caritypekamar:function(){
      axios.get(base_url+'/api/typekamar?cari='+this.cari).then(response => {
        this.typekamar = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

	},
	created(){
		this.ambiltypekamar(this.pagination.current_page);
	}
});

</script>
@endpush
@endsection
