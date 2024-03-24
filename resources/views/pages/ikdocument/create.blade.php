@extends('layout.main')
@section('pagetitle', 'IK Documents')

@section('content')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<!--begin::Container-->
			<div id="kt_content_container" class="container-xxl">
				<!--begin::Navbar-->
				<!--end::Navbar-->
				<!--begin::Card-->
				<div class="card">
					<!--begin::Card header-->
					<div class="card-header">
						<!--begin::Card title-->
						<div class="card-title fs-3 fw-bolder">Create Data</div>
						<!--end::Card title-->
					</div>
					<!--end::Card header-->
					<!--begin::Form-->
					@if (isset($data))
	                    {!! Form::model($data, ['route' => ['ikdocument.store'], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
	                @else
	                    {!! Form::open(['url' => route('ikdocument.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
	                @endif
						<!--begin::Card body-->
						<div class="card-body p-9">
							<!-- notifikasi -->
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
								<label class="fs-6 fw-bold mt-2 mb-3">Upload Dokumen IK</label>
								{!! Form::file('doc', ['class'=>'form-control', 'accept' => '.pdf']) !!}
								<div class="form-text">pdf file type only.</div>
							</div>
						</div>
						<!--end::Card body-->
						<!--begin::Card footer-->
						<div class="card-footer d-flex justify-content-end py-6 px-9">
							<a href="{{ route('ikdocument.index') }}" class="btn btn-light btn-active-light-primary me-2">Back</a>
							<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Save">
						</div>
						<!--end::Card footer-->
					</form>
					<!--end:Form-->
				</div>
				<!--end::Card-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->
@endsection