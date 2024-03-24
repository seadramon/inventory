@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data Merk IT</h3>
			</div>
			@if (isset($data))
                {!! Form::model($data, ['route' => ['master.merk.it.update', $data->kd_merk], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['url' => route('master.merk.it.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
					<label class="fs-6 fw-bold mt-2 mb-3">Kode</label>
					@if (isset($data))
						{!! Form::text('kd_merk', null, ['class'=>'form-control form-control-solid', 'id'=>'kd_merk', 'readonly']) !!}
					@else
						{!! Form::text('kd_merk', null, ['class'=>'form-control', 'id'=>'kd_merk']) !!}
					@endif
				</div>

				<div class="form-group">
					<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
					{!! Form::text('ket', null, ['class'=>'form-control', 'id'=>'ket']) !!}
				</div>
			</div>
			<div class="card-footer">
				<a href="{{ route('master.merk.it.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
		</div>
	</div>
</div>
@endsection