@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-9">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Buat @endif Inventaris Perangkat</h3>
			</div>
			@if (isset($data))
                {!! Form::model($data, ['route' => ['inventaris-it.update', $data->no_inventaris], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['url' => route('inventaris-it.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            @endif
			<div class="card-body">
				@if (count($errors) > 0)
					@foreach($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error!</strong> {{ $error }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endforeach
				@endif

				{!! Form::hidden('no_inventaris', $data->no_inventaris) !!}
				
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">No Inventaris</label>
							{!! Form::text('no_inventaris', $data->no_inventaris, ['class'=>'form-control', 'disabled']) !!}
						</div>
					</div>
				</div>

				@include('pages.inventaris-it.header')
			</div>
			<div class="card-footer">
				<a href="{{ route('inventaris-it.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-3">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">QR Code</h3>
			</div>

			<div class="card-body">
				{!! QrCode::size(250)->generate('IT|' . $data->no_inventaris ); !!}
			</div>
		</div>
	</div>

	<!-- Detail Section -->
	@if (isset($data))
		<!-- datatable part -->
		<div class="col-8">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Detail Inventaris</h3>
				</div>
				<div class="card-body">
					<table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="tabel_tipe_pc">
						<thead>
							<tr class="text-start text-gray-800 fw-bolder fs-7 text-uppercase">
								<th>Item</th>
								<th>Merk</th>
								<th>Spesifikasi</th>
								<th>Tipe</th>
								<th>Kapasitas</th>
								<th>Satuan</th>
								<th>Menu</th>
							</tr>
						</thead>
						<tbody class="fw-bold text-gray-600">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-4" id="detail-section">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Tambah/Edit Detail Inventaris Perangkat</h3>
				</div>

				{!! Form::open(['url' => route('inventaris-it-detail.store'), 'class' => 'form', 'id' => 'f_detail', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
				<div class="card-body">
					<div class="alert alert-danger alert-dismissible fade" id="alert-detail" role="alert"></div>
					<div class="alert alert-success alert-dismissible fade" id="success-detail" role="alert"></div>
					<!-- ./notifikasi -->
					{!! Form::hidden('no_inventaris', $data->no_inventaris) !!}

					{!! Form::hidden('no_urut', null, ['id' => 'no_urut']) !!}
					<div class="row">
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Item/Perangkat Keras/Hardware</label>
							{!! Form::select('kd_item', $itempc, null, ['class'=>'form-select selectdetail', 'data-control'=>'select2', 'id'=>'kd_item']) !!}
						</div>
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Spesifikasi</label>
							{!! Form::text('spesifikasi', null, ['class'=>'form-control', 'id'=>'spesifikasi']) !!}
						</div>
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Kapasitas/Ukuran</label>
							{!! Form::number('kapasitas', null, ['class'=>'form-control', 'id'=>'kapasitas']) !!}
						</div>
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Merk</label>
							{!! Form::select('kd_merk', $merk, null, ['class'=>'form-select selectdetail', 'data-control'=>'select2', 'id'=>'kd_merk_detail']) !!}
						</div>
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Tipe/Jenis</label>
							{!! Form::text('tipe', null, ['class'=>'form-control', 'id'=>'tipe']) !!}
						</div>
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Satuan</label>
							{!! Form::select('satuan', $satuan, null, ['class'=>'form-select selectdetail', 'data-control'=>'select2', 'id'=>'satuan']) !!}
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a href="#" id="reset-detail" class="btn btn-light btn-active-light-primary me-2">Reset</a>
					<input type="submit" class="btn btn-primary" value="Simpan">
				</div>
				{!! Form::close() !!}
			</div>
		</div>

		<!-- Detail Software -->
		<div class="col-8">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Detail Software</h3>
				</div>
				<div class="card-body">
					<table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="tabel_software">
						<thead>
							<tr class="text-start text-gray-800 fw-bolder fs-7 text-uppercase">
								<th>Nama</th>
								<th>Lisensi</th>
								<th>Tipe</th>
								<th>Expired</th>
								<th>Email</th>
								<th>Serial</th>
								<th>Menu</th>
							</tr>
						</thead>
						<tbody class="fw-bold text-gray-600">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-4" id="software-section">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Tambah/Edit Detail Software</h3>
				</div>

				{!! Form::open(['url' => route('inventaris-it-software.store'), 'class' => 'form', 'id' => 'f_software', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
				<div class="card-body">
					<div class="alert alert-danger alert-dismissible fade" id="alert-software" role="alert"></div>
					<div class="alert alert-success alert-dismissible fade" id="success-software" role="alert"></div>
					
					{!! Form::hidden('no_inventaris', $data->no_inventaris) !!}
					{!! Form::hidden('pc_software_id', null, ['id' => 'pc_software_id']) !!}

					<div class="row">
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Software</label>
							{!! Form::select('software_id', $software, null, ['class'=>'form-select select-software', 'data-control'=>'select2', 'id'=>'software_id']) !!}
						</div>
						<div class="form-group software-additional hide">
							<label class="fs-6 fw-bold mt-2 mb-3">Tipe Langganan</label>
							{!! Form::select('tipe_langganan', $tipe_langganan, null, ['class'=>'form-select select-software', 'data-control'=>'select2', 'id'=>'tipe_langganan']) !!}
						</div>
						<div class="form-group software-additional hide">
							<label class="fs-6 fw-bold mt-2 mb-3">Email Lisensi</label>
							{!! Form::text('email', null, ['class'=>'form-control', 'id'=>'email']) !!}
						</div>
						<div class="form-group software-additional hide">
							<label class="fs-6 fw-bold mt-2 mb-3">Serial Key</label>
							{!! Form::text('serial_key', null, ['class'=>'form-control', 'id'=>'serial_key']) !!}
						</div>
						<div class="form-group software-additional hide">
							<label class="fs-6 fw-bold mt-2 mb-3">Expired</label>
							<div class="col-lg-12">
								<div class="input-group date">
									{!! Form::text('expired', null, ['class'=>'form-control datepicker', 'id'=>'expired']) !!}
									<div class="input-group-append">
										<span class="input-group-text" style="display: block">
											<i class="la la-calendar-check-o"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a href="#" id="reset-software" class="btn btn-light btn-active-light-primary me-2">Reset</a>
					<input type="submit" class="btn btn-primary" value="Simpan">
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	@endif
</div>
@endsection

@section('extra-js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script type="text/javascript">

$( document ).ready(function() {
	$("#alert-detail").hide();
	$("#success-detail").hide();

	$("#alert-software").hide();
	$("#success-software").hide();

	$(".datepicker").daterangepicker({
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 1901,
	    autoApply: true,
	    locale: {
	      format: 'DD-MM-YYYY'
	    }
	});

	$("#software_id").change(function(){
		tipe = $("#software_id").val().split('#')
		if(tipe[1] == 'perangkat'){
			$(".software-additional").removeClass('hide');
		}else{
			$(".software-additional").addClass('hide');
		}
	})

	if($('#tipe_pengguna').val() == 'personal'){
		$('#form-pengguna').css("display", "block");

		$('#pengguna').val('{!! $data->employee_id !!}').trigger('change');
	}else{
		$('#form-pengguna').css("display", "none");
	}

	var status = {!! json_encode($data->status) !!} == 'Aktif'? 1 : 0;

	$('#status').val(status).trigger('change');

	"use strict";

	// Class definition
	var KTDatatablesServerSide = function () {
	    // Shared variables
	    var table;
	    var tabel_software;
	    var dt;
		var dt_software;

	    // Private functions
	    var initDatatable = function () {
	        dt = $("#tabel_tipe_pc").DataTable({
				language: {
  					lengthMenu: "Show _MENU_",
 				},
 				dom:
					"<'row'" +
					"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
					"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
					">" +

					"<'table-responsive'tr>" +

					"<'row'" +
					"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
					"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
					">",
	            searchDelay: 500,
	            processing: true,
	            serverSide: true,
	            order: [[0, 'desc']],
	            stateSave: true,
	            ajax: "{{ route('inventaris-it-detail.data', ['id' => str_replace('/', '|', $data->no_inventaris)]) }}",
	            columns: [
	                {data: 'item.ket', name: 'kd_item', defaultContent: '-', orderable: false, searchable: false},
	                {data: 'merk.ket', name: 'kd_merk', defaultContent: '-', orderable: false, searchable: false},
	                {data: 'spesifikasi', name: 'spesifikasi', defaultContent: '-'},
	                {data: 'tipe', name: 'tipe', defaultContent: '-'},
	                {data: 'kapasitas', name: 'kapasitas', defaultContent: '-'},
	                {data: 'satuan', name: 'satuan', defaultContent: '-'},
	                {data: 'menu', orderable: false, searchable: false}
	            ],
	        });

	        table = dt.$;

			dt_software = $("#tabel_software").DataTable({
				language: {
  					lengthMenu: "Show _MENU_",
 				},
 				dom:
					"<'row'" +
					"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
					"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
					">" +

					"<'table-responsive'tr>" +

					"<'row'" +
					"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
					"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
					">",
	            searchDelay: 500,
	            processing: true,
	            serverSide: true,
	            order: [[0, 'desc']],
	            stateSave: true,
	            ajax: "{{ route('inventaris-it-software.data', ['id' => str_replace('/', '|', $data->no_inventaris)]) }}",
	            columns: [
					{data: 'software.nama', name: 'software.nama', defaultContent: '-', orderable: false, searchable: false},
	                {data: 'software.jenis_lisensi', name: 'software.jenis_lisensi', defaultContent: '-'},
	                {data: 'tipe_langganan', name: 'tipe_langganan', defaultContent: '-'},
	                {data: 'expired', name: 'expired', defaultContent: '-'},
	                {data: 'email', name: 'email', defaultContent: '-'},
	                {data: 'serial_key', name: 'serial_key', defaultContent: '-'},
	                {data: 'menu', orderable: false, searchable: false}
	            ],
	        });

	        tabel_software = dt_software.$;
	    }
	    
	    // Public methods
	    return {
	        init: function () {
	            initDatatable();
	        }
	    }
	}();

	// On document ready
	KTUtil.onDOMContentLoaded(function () {
	    KTDatatablesServerSide.init();
	});

	function manageNotif()
	{
		$("#alert-detail").empty();
		$("#success-detail").empty();
		$("#alert-detail").hide();
		$("#success-detail").hide();
	}

	$("#reset-detail").click(function(e) {
		e.preventDefault();

		$('#kd_item').prop('disabled', false);
		$("#f_detail")[0].reset();
		$('.selectdetail').val(null).trigger('change');
		
		$("#no_urut").val('');
		manageNotif();
	});

	$("#f_detail").submit(function(e) {
		e.preventDefault();

		$('#kd_item').prop('disabled', false);
		manageNotif();

		var data = $(this).serialize();
		var target = document.querySelector("#detail-section");
		var blockUI = new KTBlockUI(target, {
		    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Processing...</div>',
		});

		blockUI.block();

		$.ajax({
			url: "{{ route('inventaris-it-detail.store') }}",
			type: "POST",
			data: data,
			success: function(result) {
				$("#success-detail").show();
				$("#success-detail").addClass("show");
				$("#success-detail").empty();

				$("#success-detail").append('<strong>Success!</strong> Detail saved succesfully!');
				$("#success-detail").append("<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>");

				$('#tabel_tipe_pc').DataTable().ajax.url("{{ route('inventaris-it-detail.data', ['id' => $data->no_inventaris]) }}").load();

				blockUI.release();
				blockUI.destroy();

				$('#kd_item').prop('disabled', true);
			},
			error: function(data) {
				$("#alert-detail").show();
				$("#alert-detail").addClass("show");
				$("#alert-detail").empty();

				if (data.status == 422) {
					var errors = $.parseJSON(data.responseText);

					$.each(errors.errors, function (key, value) {
						$("#alert-detail").append(value + '<br>');
					});
				} else {
					$("#alert-detail").append('<strong>Error!</strong> Oops, there is something wrong');
				} 
				$("#alert-detail").append("<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>");
				blockUI.release();
				blockUI.destroy();

				$('#kd_item').prop('disabled', true);
			}
		});
	});

	$('body').on('click', '.delete-detail', function () {
		manageNotif();

		if (confirm("Delete Record?") == true) {
			var id = $(this).data('id');
			var item = $(this).data('item');
			var urut = $(this).data('urut');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('inventaris-it-detail/destroy') }}",
				data: {id : id, item:item, urut:urut, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_tipe_pc').DataTable().ajax.url("{{ route('inventaris-it-detail.data', ['id' => $data->no_inventaris]) }}").load();
					}
				}
			});
		}
	});

	$('body').on('click', '.edit-detail', function () {
		manageNotif();
		var id = $(this).data('id');
		var jsonnya = $(this).data('json');

		var tmp = JSON.parse('{"' + decodeURI(jsonnya.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');

		$("#kd_item").val(tmp.kd_item);
		$('#kd_item').trigger('change');
		$('#kd_item').prop('disabled', true);
		$("#kd_merk_detail").val(tmp.kd_merk);
		$('#kd_merk_detail').trigger('change');
		$("#satuan").val(tmp.satuan);
		$('#satuan').trigger('change');
		$("#spesifikasi").val(tmp.spesifikasi);
		$("#tipe").val(tmp.tipe);
		$("#kapasitas").val(tmp.kapasitas);
		$("#no_urut").val(tmp.no_urut);
	});

	$('#tipe_pengguna').on('change', function(){
		if($('#tipe_pengguna').val() == 'personal'){
			$('#form-pengguna').css("display", "block");
		}else{
			$('#form-pengguna').css("display", "none");
		}
	});

	function manageNotifSoftware() {
		$("#alert-software").empty();
		$("#success-software").empty();
		$("#alert-software").hide();
		$("#success-software").hide();
	}

	$("#reset-software").click(function(e) {
		e.preventDefault();

		$('#software_id').prop('disabled', false);
		$("#f_software")[0].reset();
		$('.select-software').val(null).trigger('change');
		$("#pc_software_id").val('');
		$(".software-additional").addClass('hide');

		manageNotifSoftware();
	});

	$("#f_software").submit(function(e) {
		e.preventDefault();

		$('#software_id').prop('disabled', false);
		manageNotifSoftware();

		var data = $(this).serialize();
		var target = document.querySelector("#software-section");
		var blockUI = new KTBlockUI(target, {
		    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Processing...</div>',
		});

		blockUI.block();

		$.ajax({
			url: "{{ route('inventaris-it-software.store') }}",
			type: "POST",
			data: data,
			success: function(result) {
				$("#success-software").show();
				$("#success-software").addClass("show");
				$("#success-software").empty();

				$("#success-software").append('<strong>Success!</strong> Software saved succesfully!');
				$("#success-software").append("<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>");

				$('#tabel_software').DataTable().ajax.url("{{ route('inventaris-it-software.data', ['id' => $data->no_inventaris]) }}").load();

				blockUI.release();
				blockUI.destroy();

				$('#software_id').prop('disabled', true);
				$("#reset-software").trigger('click')
			},
			error: function(data) {
				$("#alert-software").show();
				$("#alert-software").addClass("show");
				$("#alert-software").empty();

				if (data.status == 422) {
					var errors = $.parseJSON(data.responseText);

					$.each(errors.errors, function (key, value) {
						$("#alert-software").append(value + '<br>');
					});
				} else {
					$("#alert-software").append('<strong>Error!</strong> Oops, there is something wrong');
				} 

				$("#alert-software").append("<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>");
				
				blockUI.release();
				blockUI.destroy();

				$('#software_id').prop('disabled', true);
			}
		});
	});

	$('body').on('click', '.delete-software', function () {
		manageNotifSoftware();

		if (confirm("Delete Record?") == true) {
			var id = $(this).data('id');
			var item = $(this).data('item');
			var urut = $(this).data('urut');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('inventaris-it-software/destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_software').DataTable().ajax.url("{{ route('inventaris-it-software.data', ['id' => $data->no_inventaris]) }}").load();
					}
				}
			});
		}
	});

	$('body').on('click', '.edit-software', function () {
		manageNotifSoftware();

		var id = $(this).data('id');
		var jsonnya = $(this).data('json');
		var tmp = JSON.parse('{"' + decodeURI(jsonnya.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');

		if(tmp.jenis_lisensi == 'perangkat'){
			$(".software-additional").removeClass('hide');
		}else{
			$(".software-additional").addClass('hide');
		}
		$("#pc_software_id").val(id);
		$("#software_id").val(tmp.software_id + '#' + tmp.jenis_lisensi);
		$('#software_id').trigger('change');
		$('#software_id').prop('disabled', true);
		$("#jenis_lisensi").val(tmp.jenis_lisensi);
		$('#jenis_lisensi').trigger('change');
		$("#tipe_langganan").val(tmp.tipe_langganan);
		$('#tipe_langganan').trigger('change');
		$("#email").val(tmp.email.replace("%40", "@"));
		$("#serial_key").val(tmp.serial_key);
		$("#expired").val(tmp.expired.split('+')[0]);
		$('#expired').trigger('change');
	});


	// starting select2 Ajax
	function formatPersonal(repo) {
		if (repo.loading) return repo.text;
		var markup = "<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__meta'>" +
			"<div class='select2-result-repository__title'>" + repo.text + "</div>";
		if (repo.description) {
			markup += "<div class='select2-result-repository__description'>" + repo.full_name + "</div>";
		}
		markup += "<div class='select2-result-repository__statistics'>" +
					"<div class='select2-result-repository__forks'><i class='fa fa-flash'></i>[" +repo.id + "] " + repo.full_name + "</div>" +
					"</div>" +
					"</div></div>";
		return markup;
	}

	function formatPersonalSelection(repo) {
		return  repo.full_name || repo.text;
	}

	// firing 3 char
	$("#pengguna").select2({
		placeholder: "pilih pengguna..",
		allowClear: true,
		ajax: {
			type: "POST",
			url: "{{ route('inventaris-it.get.personal.data') }}",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			delay: 250,
			data: function(params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data) {
				var arr = []
				$.each(data, function (index, value) {
					arr.push({
						id: value.employee_id,
						text: value.first_name,
						full_name: value.first_name + ' ' + value.last_name
					});
					// console.log(value.first_name);
				})
				return {
					results: arr
				};
			},
			cache: true
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		minimumInputLength: 3,
		templateResult: formatPersonal,
		templateSelection: formatPersonalSelection
	});
});
</script>
@endsection