@extends('layouts.main')
@section('content')
<div class="box" id="user">
	<div class="box-body">
		<div class="alert alert-success" role="alert" v-if="notif.success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>@{{notif.message}}</div>
		<form method="POST" enc="multipart/form-data" v-on:submit.prevent="ubahuser({{$user->id}})">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Nama User</label>
                      <div class="row">
                        <div class="col-sm-6">
                         <input class="form-control" name="Nama Pengguna" placeholder="Nama Pengguna"  v-model="dataEdit.name">
                          <span v-if="errorForm['name']" class="error text-danger">@{{ errorForm['name'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" name="username" placeholder="Username"  v-model="dataEdit.username" disabled>
                           <span v-if="errorForm['username']" class="error text-danger">@{{ errorForm['username'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Batasan Akses</label>
                      <div class="row">
                        <div class="col-sm-6">
                          <select class="form-control" name="role_id" v-model="dataEdit.role_id">
                            <option value="0" >Pilih Role</option>
                            @foreach($user_roles as $key=>$role)
                            <option value="{{$key}}">{{$role}}</option>
                            @endforeach
                          </select>
                           <span v-if="errorForm['role_id']" class="error text-danger">@{{ errorForm['role_id'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="password" placeholder="Password"  v-model="dataEdit.password">
                           <span v-if="errorForm['password']" class="error text-danger">@{{ errorForm['password'] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Jabatan</label>
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" name="jabatan" v-model="dataEdit.jabatan">
                           <span v-if="errorForm['jabatan']" class="error text-danger">@{{ errorForm['jabatan'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Nomor Telp / Handphone</label>
                          <input class="form-control" name="no_telp"  v-model="dataEdit.no_telp">
                           <span v-if="errorForm['no_telp']" class="error text-danger">@{{ errorForm['no_telp'] }}</span>
                        </div>
                        <div class="col-sm-6">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" v-model="dataEdit.email">
                           <span v-if="errorForm['email']" class="error text-danger">@{{ errorForm['email'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </form>
	</div>
</div>

@endsection
@push('script')
<script>
	var user = new Vue({
	el: '#user',
	data: {
	    user: null,
	    errorForm:{},
	    dataEdit: {
	    	'name':'{{$user->name}}',
	    	'role_id':'{{$user->role_id}}',
	    	'username':'{{$user->username}}',
	    	'jabatan' :'{{$user->jabatan}}',
	    	'no_telp' : '{{$user->no_telp}}',
	    	'email' : '{{$user->email}}'
	    },
	    notif: {success:false,message:''},
	},
	methods: {

	    ubahuser:function(id){
	      var input = this.dataEdit;
	      axios.patch(base_url+'/admin/user/'+id,input).then(response => {
	      	if(response.data.success)
	      		this.notif = response.data;
	      }).catch(errors=>{
	        console.error(errros);
	      })
	    },


	},
});

</script>
@endpush