@extends('layout.main')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">Dashboard IT</h3>
			</div>
			
			<div class="card-body">

				<div class="row">
					<div class="col-4">
						<div class="form-group">
							<label class="fs-6 fw-bold mt-2 mb-3">Tipe Perangkat</label>
							{!! Form::select('tipe_pc', $tipe_pc, null, ['class'=>'form-select', 'data-control'=>'select2', 'id'=>'tipe_pc']) !!}
						</div>
					</div>
					<div class="col-12">
						<!-- Inventaris -->
						<div id="inventaris-container" class="charts">Fusion Charts will render here</div>
					</div>

					<div class="col-12">
						<!-- Software -->
						<div id="software-container" class="charts">Fusion Charts will render here</div>
					</div>
				</div>
				
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
@endsection

@section('extra-js')
<script type="text/javascript" src="{{ asset('assets/fusion/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fusion/js/themes/fusioncharts.theme.fusion.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/fusion/js/jquery-fusioncharts.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		loadPC();
		$("#tipe_pc").change(function(){
			loadPC();
		})

    	$.get("{{ route('api.dashboard.software', ['kdwil' => session('TMP_KDWIL')]) }}", function(data, status) {
    		if (status == "success") {
    			$("#software-container").insertFusionCharts(data);
    		}
    	});
	});

	function loadPC(){
		$.get("{{ route('api.dashboard.it-inventaris', ['kdwil' => session('TMP_KDWIL')]) }}" + "?tipe_pc=" + $("#tipe_pc").val(), function(data, status) {
			if (status == "success") {
				$("#inventaris-container").insertFusionCharts(data);
			}
		});
	}
</script>
@endsection