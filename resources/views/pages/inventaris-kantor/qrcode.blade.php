@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">Generate Inventaris Kantor Qr Code</h3>
			</div>
			{!! Form::open(['url' => route('inventaris-kantor.qrcode'), 'class' => 'form', 'id' => 'f_qrcode', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Kode Lokasi</label>
							{!! Form::select('kd_pat', $pat, null, ['class'=>'form-select', 'id'=>'kd_pat', 'data-control' => 'select2']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<input type="submit" class="btn btn-primary" id="kt_project_settings_submit" value="Generate">
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
      format: 'YYYY-MM-DD'
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