@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Report Inventaris Kantor</h3>
				</div>
				
				{!! Form::open(['url' => route('report.inventaris-kantor'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}

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
						<div class="col-lg-4">
							<label class="fs-6 fw-bold mt-2 mb-3">Format</label>
							{!! Form::select('format', ['pdf' => 'PDF', 'excel' => 'Excel'], 'pdf', ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'merk']) !!}
						</div>
                    </div>
				</div>

                <div class="card-footer">
					<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Download Export">
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