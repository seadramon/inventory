@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data</h3>
			</div>
			@if (isset($data))
                {!! Form::model($data, ['route' => ['master.kantor.nama.inventory.update', $data->id], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
            @else
                {!! Form::open(['url' => route('master.kantor.nama.inventory.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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

			</div>
			<div class="card-footer">
				<a href="{{ route('master.kantor.nama.inventory.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
			</div>
		</div>
	</div>
</div>
@endsection