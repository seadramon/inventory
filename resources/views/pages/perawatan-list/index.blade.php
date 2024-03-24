@extends('layout.main')

@section('extra-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Perawatan</h3>
				</div>
				<div class="card-body">
					<table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="table_group_menu">
						<thead>
							<tr class="text-start text-gray-800 fw-bolder fs-7 text-uppercase">
								<th>Perawatan ID</th>
								<th>Perawatan</th>
								<th>Created By</th>
								<th>Tgl Sumbit</th>
								<th>Menu</th>
							</tr>
						</thead>
						<tbody class="fw-bold text-gray-600">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('extra-js')
	<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		"use strict";

		// Class definition
		var KTDatatablesServerSide = function () {
			// Shared variables
			var table;
			var dt;
			var filterPayment;

			// Private functions
			var initDatatable = function () {
				dt = $("#table_group_menu").DataTable({
					language: {
						lengthMenu: "Show _MENU_",
					},
					dom:
						"<'row'" +
						"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
						"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
						">" +

						"<'table-responsive'tr>" +

						"<'row'" +
						"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
						"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
						">",
					searchDelay: 500,
					processing: true,
					serverSide: true,
					order: [[0, 'desc']],
					stateSave: true,
					ajax: "{{ route('perawatan.data') }}",
					columns: [
						{data: 'id', name: 'id', defaultContent: '-'},
						{data: 'assigns.form_perawatan.nama', name: 'assigns.form_perawatan.nama', defaultContent: '-'},
						{data: 'created_by', name: 'created_by', defaultContent: '-'},
                        {data: 'created_at', name: 'created_at',"searchable": false,"sortable": false,
							render: function(data){
								if (data == null){
									return '-';
								}
								else {
									var aa = data.split("T");
									var new_data = aa[0].split("-");
									var tanggal_ = new_data[2];
									var bulan_ = new_data[1];
									var tahun_ = new_data[0];
									return tanggal_ +'-'+   bulan_ + '-' + tahun_;
								}
							}
			 			},
						{data: 'menu', orderable: false, searchable: false}
					],
				});

				table = dt.$;
			}
			
			// Public methods
			return {
				init: function () {
					initDatatable();
				}
			}
		}();

		// On document ready
		KTUtil.onDOMContentLoaded(function () {
			KTDatatablesServerSide.init();
		});

	</script>
@endsection