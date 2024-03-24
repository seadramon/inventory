@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data IT Software</h3>
			</div>
			@if (isset($data))
                {!! Form::model($data, ['route' => ['master.it-software.update', $data->id], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['url' => route('master.it-software.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
				<!-- ./notifikasi -->

				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
					{!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama']) !!}
				</div>
				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">Jenis Lisensi</label>
					{!! Form::select('jenis_lisensi', $jenis_lisensi, null, ['class'=>'form-select select-software', 'data-control'=>'select2', 'id'=>'jenis_lisensi']) !!}
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
							{!! Form::text('expired', isset($data) ? date('d-m-Y', strtotime($data->expired)) : null, ['class'=>'form-control datepicker', 'id'=>'expired']) !!}
							<div class="input-group-append">
								<span class="input-group-text" style="display: block">
									<i class="la la-calendar-check-o"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<a href="{{ route('master.it-software.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
		</div>
	</div>
</div>
@endsection
@section('extra-js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$( document ).ready(function() {
	if($("#jenis_lisensi").val() == 'software'){
		$(".software-additional").removeClass('hide');
	}else{
		$(".software-additional").addClass('hide');
	}
	$(".datepicker").daterangepicker({
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 2000,
	    autoApply: true,
	    locale: {
	      format: 'DD-MM-YYYY'
	    }
	});
	$("#jenis_lisensi").trigger('change');
	$("#jenis_lisensi").change(function(){
		if($("#jenis_lisensi").val() == 'software'){
			$(".software-additional").removeClass('hide');
		}else{
			$(".software-additional").addClass('hide');
		}
	})
});
</script>
@endsection