@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data</h3>
			</div>
			@if (isset($data))
				{!! Form::model($data, ['route' => ['perawatan-assign.update', $data->id], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
			@else
				{!! Form::open(['url' => route('perawatan-assign.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
					<label class="fs-6 fw-bold mt-2 mb-3">Form Perawatan</label>
					{!! Form::select('form_perawatan_id', $forms, $data->form_perawatan_id ?? null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'form_perawatan_id']) !!}
				</div>
				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">PAT/PPU</label>
					{!! Form::select('kd_pat', $pat, $data->kd_pat ?? null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_pat']) !!}
				</div>
				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">Periode Awal</label>
					<div class="col-lg-12">
						<div class="input-group date">
							{!! Form::text('periode_awal', $data != null ? date('Y-m-d', strtotime($data->periode_awal)) : null, ['class'=>'form-control datepicker', 'id'=>'periode_awal']) !!}
							<div class="input-group-append">
								<span class="input-group-text" style="display: block">
									<i class="la la-calendar-check-o"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">Periode Akhir</label>
					<div class="col-lg-12">
						<div class="input-group date">
							{!! Form::text('periode_akhir', $data != null ? date('Y-m-d', strtotime($data->periode_akhir)) : null, ['class'=>'form-control datepicker', 'id'=>'periode_akhir']) !!}
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
				<a href="{{ route('perawatan-assign.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
		</div>
	</div>
</div>
@endsection
@section('extra-js')
<script>
	$(".datepicker").daterangepicker({
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 1901,
	    autoApply: true,
	    locale: {
	      format: 'YYYY-MM-DD'
	    }
	});
</script>
	
@endsection