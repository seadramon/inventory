@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Buat @endif Inventaris Perangkat</h3>
			</div>
			@if (isset($data))
                {!! Form::model($data, ['route' => ['inventaris-it.update', $data->id], 'class' => 'form', 'id' => 'f_header', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['url' => route('inventaris-it.store'), 'class' => 'form', 'id' => 'f_header', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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

				@include('pages.inventaris-it.header')
			</div>
			<div class="card-footer">
				<a href="{{ route('inventaris-it.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

@section('extra-js')
<script type="text/javascript">

$(".datepicker").daterangepicker({
	singleDatePicker: true,
	showDropdowns: true,
	minYear: 1901,
	autoApply: true,
	locale: {
		format: 'DD-MM-YYYY'
	}
});

$('#tipe_pengguna').on('change', function(){
	if($('#tipe_pengguna').val() == 'personal'){
		$('#form-pengguna').css("display", "block");
	}else{
		$('#form-pengguna').css("display", "none");
	}
});

</script>
@endsection