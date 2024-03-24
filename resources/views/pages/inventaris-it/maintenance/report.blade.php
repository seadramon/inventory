@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Report Maintenance IT</h3>
				</div>
				
				{!! Form::open(['url' => route('report.maintenance-it'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}

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
							<label class="fs-6 fw-bold mt-2 mb-3">Perangkat</label>
							{!! Form::select('no_inventaris', $perangkat, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'no_inventaris']) !!}
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