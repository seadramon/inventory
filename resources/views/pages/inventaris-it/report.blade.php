@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Report Inventaris IT</h3>
				</div>
				
				{!! Form::open(['url' => route('report.inventaris-it'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}

				<div class="card-body">
					@if (count($errors) > 0)
						@foreach($errors->all() as $error)
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Error!</strong> {{ $error }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endforeach
					@endif
					
					<div class="form-group row">
						<div class="col-lg-12">
							<label class="fs-6 fw-bold mt-2 mb-3">Pat</label>
							{!! Form::select('kd_pat', $pat, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_pat']) !!}
						</div>
                    </div>

                    <div class="form-group row">
						<div class="col-lg-12">
							<label class="fs-6 fw-bold mt-2 mb-3">Tipe Perangkat</label>
							{!! Form::select('kd_tipe_pc', $tipepc, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'kd_tipe_pc']) !!}
						</div>
                    </div>
				</div>

                <div class="card-footer">
					<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Download Report">
				</div>
            </div>
        </div>	
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