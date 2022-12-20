@extends('layouts.main')
@section('container')

@if (session()->has('loginError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" >
      {{ session('loginError') }}
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" >
      {{ session('success') }}
    </div>
@endif
 <div class="card">
            <div class="card-header" style="background-color: aqua">
              <h3 class="card-title">Data Apdet SiKecil</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="background-color: #212529; color: white;" >

<table class="table table-bordered table-sm" id="example1">
	<thead>
		<tr>
			<th width="5%">NO</th>
			<th width="15%">Nama Ayah</th>
      <th width="15%">Nama Ibu</th>
      <th width="15%">No KK</th>
      <th width="15%">Alamat</th>
			<th>ACTION</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($data as $item )
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $item['nama_ayah']}}</td>
      <td>{{ $item['nama_ibu']}}</td>
      <td>{{ $item['no_kk']}}</td>
      <td>{{ $item['alamat']}}</td>
			<td>
				<a type="button" class="btn btn-primary position-relative" href="/export/{{ $item->no_kk }}">
					Export EXCEL
      </a>
				
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<!-- /header -->
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aktivasi Akun Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin ingin mengaktifkan akun Driver?
      </div>
      <div class="modal-footer">
		<form id="formAktivasi" action="" method="post">
			@csrf
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
			<button type="submit" class="btn btn-primary" id="btnSubmit" value="">Ya</button>
		</form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="nonAktif" tabindex="-1" aria-labelledby="nonAktifLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aktivasi Akun Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin ingin banned akun Driver?
      </div>
      <div class="modal-footer">
		<form id="formNotAktivasi" action="" method="post">
			@csrf
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
			<button type="submit" class="btn btn-primary" id="btnSubmit" value="">Ya</button>
		</form>
      </div>
    </div>
  </div>
</div>

{{-- insert --}}
 <div class="modal fade bd-example-modal-xl" id="insert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Tambah Driver</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="formEdit" action="" method="post" >
           @method('put')
           @csrf
             <div class="form-group">
              <input type="hidden" class="form-control" name="kode_dokter" id="kode_dokter" placeholder="Kode Dokter">
            </div>
            <div class="form-group">
              <label for="name">NAMA DRIVER</label>
              <input type="text" name="nameDriver" class="form-control" id="nameDriver" placeholder="Nama Driver">
            </div>
            <div class="form-group">
              <label for="email">EMAIL</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="No Hand phone">
          </div>
          <div class="form-group">
            <label for="nohp">NO HP</label>
            <input type="text" class="form-control" id="nohp" name="nohp" placeholder="No Hand phone">
          </div>
          <div class="form-group">
            <label for="nomorstnk">NOMOR STNK</label>
            <input type="text" class="form-control" id="nomorstnk" name="nomorstnk" placeholder="Nomor STNK">
          </div>
          <div class="form-group">
            <label for="platkendaraan">PLAT KENDARAAN</label>
            <input type="text" class="form-control" id="platkendaraan" name="nomor_kendaraan" placeholder="Plat Kendaraan">
          </div>
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
          </div>
        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- insert --}}

<script>
$(function() {
	$(document).on('click','#notAktif',function(){
		$('#formAktivasi').attr('action','/drivers/'+$(this).data('id-driver')+'/1')
	})
	$(document).on('click','#Aktif',function(){
		console.log();
		$('#formNotAktivasi').attr('action','/drivers/'+$(this).data('id-driver')+'/0')
	})

  $(document).on('click','#edit',function(){
    const name = $(this).data('driver-name');
    const email = $(this).data('driver-email');
    const phone = $(this).data('driver-phone');
    const stnk = $(this).data('driver-stnk');
    const plat = $(this).data('driver-plat');
    const nik = $(this).data('driver-nik');

    console.log(plat);
    $("#nameDriver").val(name);
    $("#email").val(email);
    $("#nohp").val(phone);
    $("#nomorstnk").val(stnk);
    $("#platkendaraan").val(plat);
    $("#nik").val(nik);
    $('#formEdit').attr('action','/drivers/'+$(this).data('driver-id'));
	})
});
</script>
@endsection


