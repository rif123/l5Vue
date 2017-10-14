@extends('layouts.main')
@section('content')
<div class="row" id="berita">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-info" data-toggle="modal" data-target="#tambah-data">Tambah Berita</button>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 350px;">
                  <input type="text" v-model="cari" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="cariberita"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Tanggal</th>
                  <th>Dibuat Oleh</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                <tr v-for="news in berita">
                  <td>@{{news.created_at}}</td>
                  <td>@{{news.user.name}}</td>
                  <td>@{{news.title}}</td> 
                  <td>
                    <div v-if="news.status == 0">
                      <span class="label label-success">BIASA</span>
                    </div>
                    <div v-else>
                      <span class="label label-danger">PENTING</span>
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-info btn-xs" @click.prevent="editberita(news)">Edit</button>
                    <button class="btn btn-danger btn-xs" @click.prevent="hapusberita(news.id)">Delete</button>
                  </td>
                </tr>
              </table>

                <vue-pagination  v-bind:pagination="pagination"
                     v-on:click.native="ambilberita(pagination.current_page)"
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="tambahberita">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Tambah Data @{{dataBaru.title}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Title / Judul:</label>
                  <input type="text" name="title" class="form-control" v-model="dataBaru.title" />
                  <span v-if="errorForm['title']" class="error text-danger">@{{ errorForm['title'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="isi_berita" v-model="dataBaru.isi_berita"></textarea>
                  <span v-if="errorForm['isi_berita']" class="error text-danger">@{{ errorForm['isi_berita'] }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Status:</label>
                    <select class="form-control" name="status" v-model="dataBaru.status">
                      <option value="0">BIASA</option>
                      <option value="1">PENTING</option>
                    </select>
                    <span v-if="errorForm['status']" class="error text-danger">@{{ errorForm['status'] }}</span>
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
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="ubahberita(dataEdit.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">Edit Data @{{dataEdit.title}}</h4>
              </div>
               <div class="modal-body">
                <div class="form-group">
                  <label for="name">Title / Judul:</label>
                  <input type="text" name="title" class="form-control" v-model="dataEdit.title" />
                  <span v-if="errorForm['title']" class="error text-danger">@{{ errorForm['title'] }}</span>
                </div>
                <div class="form-group">
                  <label for="name">Keterangan:</label>
                  <textarea class="form-control" name="isi_berita" v-model="dataEdit.isi_berita"></textarea>
                  <span v-if="errorForm['isi_berita']" class="error text-danger">@{{ errorForm['isi_berita'] }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Status:</label>
                    <select class="form-control" name="status" v-model="dataEdit.status">
                      <option value="0">BIASA</option>
                      <option value="1">PENTING</option>
                    </select>
                    <span v-if="errorForm['status']" class="error text-danger">@{{ errorForm['status'] }}</span>
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
                <button type="submit" class="btn btn-primary" @click.prevent="hapuskonfirmberita(hapus_id)">O K</button>
              </div>
            </div>
          </div>
        </div>

      </div>

@push('script')
<script>
  var news = new Vue({
  el: '#berita',
  data: {
    berita: null,
    dataBaru: {'status':0},
    errorForm:{},
    dataEdit: {'status':0},
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

    ambilberita:function(page){
      var cari = this.cari ? this.cari : '';
      axios.get(base_url+'/api/berita?cari='+cari+'&page='+page).then(response => {
          this.berita = response.data.data;
          this.pagination = response.data;
          console.log(this.berita);
        }).catch(errors => {
          console.error(errors);
        })
    },

    tambahberita:function(){
      var input = this.dataBaru;
      axios.post(base_url+'/admin/berita',input).then(response=>{
        this.dataBaru = {'status':0};
        $("#tambah-data").modal('hide');
        this.ambilberita(this.berita.current_page);
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

    editberita:function(berita){
      this.dataEdit.id = berita.id;
      this.dataEdit.title = berita.title;
      this.dataEdit.isi_berita = berita.isi_berita;
      this.dataEdit.status = berita.status;
      $('#edit-data').modal('show');
    },

    ubahberita:function(id){
      var input = this.dataEdit;
      axios.patch(base_url+'/admin/berita/'+id,input).then(response => {
        $('#edit-data').modal('hide');
        this.ambilberita(this.berita.current_page);
      }).catch(errors=>{
        console.error(errros);
      })
    },

    hapusberita:function(id){
      this.hapus_id = id;
      $('#hapus-data').modal('show');
    },

    hapuskonfirmberita:function(id){
      axios.delete(base_url+'/admin/berita/'+id).then(response => {
        this.ambilberita(this.berita.current_page);
        $('#hapus-data').modal('hide');
      }).catch(errors=>{
        console.error(errors);
      })
    },

    cariberita:function(){
      axios.get(base_url+'/api/berita?cari='+this.cari).then(response => {
        this.berita = response.data;
        this.pagination = response.data;
        console.log(this.pagination);
      }).catch(errors=>{
        console.error(errors);
      })
    }

  },
  created(){
    this.ambilberita(this.pagination.current_page);
  }
});

</script>
@endpush
@endsection
