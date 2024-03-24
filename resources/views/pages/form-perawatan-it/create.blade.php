@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		@if (isset($data))
			{!! Form::model($data, ['route' => ['form-perawatan-it.update', $data->id], 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
		@else
			{!! Form::open(['url' => route('form-perawatan-it.store'), 'class' => 'form', 'id' => 'kt_project_settings_form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
		@endif

		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Data</h3>
				</div>

				<div class="card-body">
					@if (count($errors) > 0)
						@foreach($errors->all() as $error)
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Error!</strong> {{ $error }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endforeach
					@endif

					<div class="form-group">
						<div class="col-lg-12">
							<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
							{!! Form::text('nama', null, ['class'=>'form-control']) !!}
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a href="{{ route('form-perawatan-it.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
					<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Simpan">
				</div>
			</div>
		</div>

		@if(isset($data))
			<div class="col-12">
				<div class="card card-xl-stretch mb-5 mb-xl-8">
					<div class="card-header">
						<h3 class="card-title">List Form {{ $data->nama }}</h3>
					</div>
					
					<div class="card-body">
						<div id="form_perawatan_detail">
							<div class="form-group">
								<div data-repeater-list="form_perawatan_detail">
									@if(blank($data->detail))
										<div data-repeater-item>
											<div class="form-group row">
												<div class="col-md-3">
													<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
													{!! Form::text('nama_detail', null, ['class'=>'form-control', 'required']) !!}
												</div>
												<div class="col-md-2">
													<label class="fs-6 fw-bold mt-2 mb-3">Jenis</label>
													{!! Form::select('jenis', ['text' => 'Text', 'checkbox'=>'Chekbox'], 'text', ['class'=>'form-control form-select-solid jenis-detail', 'id'=>'jenis-0', 'data-control'=>'select2', 'required']) !!}
												</div>
												<div class="col-md-3" id="pilihan-form-0" style="display: none;">
													<label class="fs-6 fw-bold mt-2 mb-3">Pilihan</label>
													{!! Form::text('pilihan', null, ['class'=>'form-control pilihan-detail', 'id'=>'pilihan-0']) !!}
												</div>
												<div class="col-md-3" id="pilihan-form-temp-0"></div>
												<div class="col-md-1">
													<label class="fs-6 fw-bold mt-2 mb-3" style="display: block; white-space: nowrap;">Foto</label>
													{!! Form::checkbox('foto_needed', null, false) !!}
												</div>
												<div class="col-md-1">
													<label class="fs-6 fw-bold mt-2 mb-3" style="display: block; white-space: nowrap;">Keterangan</label>
													{!! Form::checkbox('keterangan_needed', null, false) !!}
												</div>
												<div class="col-md-2">
													<a href="javascript:;" data-repeater-delete class="btn btn-md btn-light-danger mt-3 mt-md-11">
														<i class="la la-trash-o"></i>Delete
													</a>
												</div>
											</div>
										</div>
									@else
										@foreach ($data->detail as $key => $detail)
											<div data-repeater-item>
												<div class="form-group row">
													<input type="hidden" name="id_detail" value="{{ $detail->id }}">
													<div class="col-md-3">
														<label class="fs-6 fw-bold mt-2 mb-3">Nama</label>
														{!! Form::text('nama_detail', $detail->nama, ['class'=>'form-control', 'required']) !!}
													</div>
													<div class="col-md-2">
														<label class="fs-6 fw-bold mt-2 mb-3">Jenis</label>
														{!! Form::select('jenis', ['text' => 'Text', 'checkbox'=>'Chekbox'], $detail->jenis, ['class'=>'form-control form-select-solid jenis-detail', 'id'=>'jenis-'.$key, 'data-control'=>'select2', 'required']) !!}
													</div>
													@if($detail->jenis == 'checkbox')
														<div class="col-md-3" id="pilihan-form-{{ $key }}">
															<label class="fs-6 fw-bold mt-2 mb-3">Pilihan</label>
															{!! Form::text('pilihan', $detail->pilihan ? str_replace('|', ',', $detail->pilihan) : null, ['class'=>'form-control pilihan-detail', 'id'=>'pilihan-'.$key]) !!}
														</div>
														<div class="col-md-3" id="pilihan-form-temp-{{ $key }}" style="display: none;"></div>
													@else
														<div class="col-md-3" id="pilihan-form-{{ $key }}" style="display: none;">
															<label class="fs-6 fw-bold mt-2 mb-3">Pilihan</label>
															{!! Form::text('pilihan', $detail->pilihan ? str_replace('|', ',', $detail->pilihan) : null, ['class'=>'form-control pilihan-detail', 'id'=>'pilihan-'.$key]) !!}
														</div>
														<div class="col-md-3" id="pilihan-form-temp-{{ $key }}"></div>
													@endif
													<div class="col-md-1">
														<label class="fs-6 fw-bold mt-2 mb-3" style="display: block; white-space: nowrap;">Foto</label>
														{!! Form::checkbox('foto_needed', null, $detail->foto_needed ? true : false) !!}
													</div>
													<div class="col-md-1">
														<label class="fs-6 fw-bold mt-2 mb-3" style="display: block; white-space: nowrap;">Keterangan</label>
														{!! Form::checkbox('keterangan_needed', null, $detail->keterangan_needed ? true : false) !!}
													</div>
													<div class="col-md-2">
														<a href="javascript:;" data-repeater-delete class="btn btn-md btn-light-danger mt-3 mt-md-11" id="button-delete">
															<i class="la la-trash-o"></i>Delete
														</a>
													</div>
												</div>
											</div>
										@endforeach
									@endif
								</div>
							</div>
						
							<div class="form-group mt-5">
								<div class="col-md-3">
									<a href="javascript:;" data-repeater-create class="btn btn-light-primary" id="button-add">
										<i class="la la-plus"></i>Add
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection

@section('extra-js')
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
	<script type="text/javascript">
		var jenisRow = 0;
		var pilihanRow = 0;

		$(document).ready(function() {
			document.querySelectorAll('.jenis-detail').forEach(function(data) {
				pilihanRow++;

				if(data.id && $('#' + data.id).val() == 'checkbox'){
					var jenisId = data.id;
        			jenisRow = jenisId.substr(jenisId.length - 1);

					new Tagify(document.querySelector("#pilihan-" + jenisRow));
				}
			});

			pilihanRow = pilihanRow / 2;
		});

		$(document).on('change', '.jenis-detail', function(){
			var jenisId = $(this).attr('id');
        	jenisRow = jenisId.substr(jenisId.length - 1);

			if($('#' + jenisId).val() == 'checkbox'){
				$("#pilihan-form-" + jenisRow).css('display', 'block');
				$("#pilihan-form-temp-" + jenisRow).css('display', 'none');

				new Tagify(document.querySelector("#pilihan-" + jenisRow));
			}else{
				$("#pilihan-form-" + jenisRow).css('display', 'none');
				$("#pilihan-form-temp-" + jenisRow).css('display', 'block');
			}
		});

		$('#form_perawatan_detail').repeater({
			initEmpty: false,

			show: function () {
				$(this).slideDown();

				$(this).find('[data-control="select2"]').select2();
				$(this).find('[data-control="select2"]').val('text').trigger('change');
			},

			hide: function (deleteElement) {
				$(this).slideUp(deleteElement);
			}
		});

		$('#button-add').on('click', function(){
			var i = 0;

			document.querySelectorAll('#jenis-0').forEach(function(data) {
				i++;
				
				if(i==2){
					data.id = 'jenis-' + pilihanRow;
				}
			});

			i = 0;

			document.querySelectorAll('#pilihan-0').forEach(function(data) {
				i++;
				
				if(i==2){
					data.id = 'pilihan-' + pilihanRow;
				}
			});

			i = 0;

			document.querySelectorAll('#pilihan-form-0').forEach(function(data) {
				i++;
				
				if(i==2){
					data.id = 'pilihan-form-' + pilihanRow;

					$("#pilihan-form-" + pilihanRow).css('display', 'none');
				}
			});

			i = 0;

			document.querySelectorAll('#pilihan-form-temp-0').forEach(function(data) {
				i++;
				
				if(i==2){
					data.id = 'pilihan-form-temp-' + pilihanRow;

					$("#pilihan-form-temp-" + pilihanRow).css('display', 'block');
				}
			});

			pilihanRow++;
		});

		$('#button-delete').on('click', function(){
			if(pilihanRow) pilihanRow--;
		});
	</script>
@endsection