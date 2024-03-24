@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		@if (isset($data))
			<div class="col-9">
		@else
			<div class="col-12">
		@endif
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data</h3>
				</div>
				
				@if (isset($data))
					{!! Form::model($data, ['route' => ['inventaris-kantor.update', $data->id], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
				@else
					{!! Form::open(['url' => route('inventaris-kantor.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
					
					@if (isset($data))
						<div class="form-group row">
							<div class="col-lg-12">
								<label class="fs-6 fw-bold mt-2 mb-3">Kode Inventaris</label>
								{!! Form::text('kode', null, ['class'=>'form-control', 'id'=>'kode', 'readonly']) !!}
							</div>
						</div>
					@endif

					<div class="form-group row">

						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
							{!! Form::select('nama', $nama, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'nama']) !!}
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Merk</label>
							{!! Form::select('merk', $merk, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'merk']) !!}
						</div>

						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Tipe</label>
							{!! Form::text('tipe', null, ['class'=>'form-control', 'id'=>'tipe']) !!}
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Spesifikasi</label>
							{!! Form::text('spek', null, ['class'=>'form-control', 'id'=>'spek']) !!}
						</div>

						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Tahun Perolehan</label>
							<div class="col-lg-12">
								<div class="input-group date">
									{!! Form::text('tahun_perolehan', null, ['class'=>'form-control', 'id'=>'tahun_perolehan']) !!}
									<div class="input-group-append">
										<span class="input-group-text" style="display: block">
											<i class="la la-calendar-check-o"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Ruangan</label>
							{!! Form::select('ruangan_id', $ruangan, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'ruangan_id']) !!}
						</div>

						<div class="col-lg-6">
							<label class="fs-6 fw-bold mt-2 mb-3">Jenis</label>
							{!! Form::select('jenis_id', $jenis, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_id']) !!}
						</div>
					</div>

					<div class="form-group">
						<label class="fs-6 fw-bold mt-2 mb-3">PAT/PPU</label>
						{!! Form::select('kode_lokasi', $pat, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'kode_lokasi']) !!}
					</div>
				</div>
				<div class="card-footer">
					<a href="{{ route('inventaris-kantor.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
					<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
				</div>
			</div>
		</div>

		@if (isset($data))
			<div class="col-3">
				{{-- Card qrcode --}}
				<div class="card card-xl-stretch mb-5 mb-xl-8">
					<div class="card-body">
						{!! QrCode::size(250)->generate('OFFICE|' . $data->kode ); !!}
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection

@section('extra-js')
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	<script type="text/javascript">
		$("#tahun_perolehan").flatpickr({
			dateFormat: "Y",
		});
	</script>
@endsection