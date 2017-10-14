@extends('layouts.main')
@section('content')
<div class="row" id="kamar">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah Kamar</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="cariKamar"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>#Kamar</th>
                  <th>Tipe Kamar</th>
                  <th>Harga / Malam</th>
                  <th>Max Dewasa</th>
                  <th>Max Anak-Anak</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for="room in kamar.data">
                  <td>@{{room.nomor_kamar}}</td>
                  <td><span v-show="room.typekamar.nama">@{{room.typekamar.nama}}</span></td>
                  <td><span vshow="room.typekamar.harga_malam">@{{room.typekamar.harga_malam_format}}</span></td>
                  <td>@{{room.max_dewasa}}</td>
                  <td>@{{room.max_anak}}</td>
                  <td>
                    <div v-if="room.status == 0">
                      <span class="label label-success">KOSONG</span>
                    </div>
                    <div v-else-if="room.status == 2">
                      <span class="label label-warning">KOTOR</span>
                    </div>
                    <div v-else>
                      <span class="label label-danger">TERPAKAI</span>
                    </div>
                  </td>
                  <td>
                  	<button class="btn btn-info btn-xs" @click.prevent="editKamar(room)">Edit</button>
						        <button class="btn btn-danger btn-xs" @click.prevent="hapusKamar(room.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambilKamar(pagination.current_page)"
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="tambahKamar">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nomor Kamar:</label>
                  <input type="text" name="nomor_kamar" class="form-control" v-model="dataBaru.nomor_kamar" />
                  <span v-if="errorForm['nomor_kamar']" class="error text-danger">@{{ errorForm['nomor_kamar'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Type Kamar:</label>
                  <select class="form-control" name="type_id" v-model="dataBaru.type_id">
                    <option selected value="0">Pilih Type</option>
                    @foreach($kamar_type as $key=>$type)
                    <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                  <span v-if="errorForm['type_id']" class="error text-danger">@{{ errorForm['type_id'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Maximal Orang Dewasa:</label>
                  <select class="form-control" name="max_dewasa" v-model="dataBaru.max_dewasa">
                    <option v-for="max in 5" v-bind:value="max">@{{max}} Orang</option>
                  </select>
                  <span v-if="errorForm['max_dewasa']" class="error text-danger">@{{ errorForm['max_dewasa'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Maximal Anak Anak:</label>
                  <select class="form-control" name="max_anak" v-model="dataBaru.max_anak">
                    <option v-for="max in 5" v-bind:value="max">@{{max}} Orang</option>
                  </select>
                  <span v-if="errorForm['max_anak']" class="error text-danger">@{{ errorForm['max_anak'] }}</span>
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="ubahKamar(dataEdit.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Nomor Kamar:</label>
                  <input type="text" name="nomor_kamar" class="form-control" v-model="dataEdit.nomor_kamar" />
                  <span v-if="errorForm['nomor_kamar']" class="error text-danger">@{{ errorForm['nomor_kamar'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Type Kamar:</label>
                  <select class="form-control" name="type_id" v-model="dataEdit.type_id">
                    <option selected value="0">Pilih Type</option>
                    @foreach($kamar_type as $key=>$type)
                    <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                  </select>
                  <span v-if="errorForm['type_id']" class="error text-danger">@{{ errorForm['type_id'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Maximal Orang Dewasa:</label>
                  <select class="form-control" name="max_dewasa" v-model="dataEdit.max_dewasa">
                    <option v-for="max in 5" v-bind:value="max">@{{max}} Orang</option>
                  </select>
                  <span v-if="errorForm['max_dewasa']" class="error text-danger">@{{ errorForm['max_dewasa'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Maximal Anak Anak:</label>
                  <select class="form-control" name="max_anak" v-model="dataEdit.max_anak">
                    <option v-for="max in 5" v-bind:value="max">@{{max}} Orang</option>
                  </select>
                  <span v-if="errorForm['max_anak']" class="error text-danger">@{{ errorForm['max_anak'] }}</span>
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
                <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirmKamar(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
	var kamar = new Vue({
	el: '#kamar',
	data: {
    kamar: null,
    type_kamar: null,
    dataBaru: {'type_id':0,'max_dewasa':1,'max_anak':1},
    errorForm:{},
    dataEdit: {'type_id':0,'max_dewasa':1,'max_anak':1},
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

		ambilKamar:function(page){
      var cari = this.cari ? this.cari : '';
			axios.get(base_url+'/api/kamar?cari='+cari+'&page='+page).then(response => {
    			this.kamar = response.data;
          this.pagination = response.data;
    		}).catch(errors => {
    			console.error(errors);
    		})
		},

    tambahKamar:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/kamar',input).then(response=>{
        this.dataBaru = {'type_id':0,'max_dewasa':1,'max_anak':1};
        $("#tambah-data").modal('hide');
        this.ambilKamar(base_url+'/api/kamar?page='+this.kamar.current_page);
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

    editKamar:function(kamar){
      this.dataEdit.id = kamar.id;
      this.dataEdit.type_id = kamar.type_id;
      this.dataEdit.nomor_kamar = kamar.nomor_kamar;
      this.dataEdit.max_dewasa = kamar.max_dewasa;
      this.dataEdit.max_anak = kamar.max_anak;
      $('#edit-data').modal('show');
    },

    ubahKamar:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/kamar/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambilKamar(this.kamar.current_page);
      }).catch(errors=>{
        console.error(errros);
      })
    },

    hapusKamar:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmKamar:function(id){
      axios.delete(base_url+'/admin/kamar/'+id).then(response => {
        this.ambilKamar(this.kamar.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    cariKamar:function(){
      axios.get(base_url+'/api/kamar?cari='+this.cari).then(response => {
        this.kamar = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

	},
	created(){
		this.ambilKamar(this.pagination.current_page);
	}
});

</script>
@endpush
@endsection
