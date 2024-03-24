@extends('layout.main')

@section('extra-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">Item PC</h3>
				<div class="card-toolbar">
					<a href="{{route('master.item-pc.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
				</div>
			</div>
			<div class="card-body">
				<table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="tabel_item_pc">
					<thead>
						<tr class="text-start text-gray-800 fw-bolder fs-7 text-uppercase">
							<th>Kode</th>
							<th>Nama</th>
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
	        dt = $("#tabel_item_pc").DataTable({
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
	            ajax: "{{ route('master.item-pc.data') }}",
	            columns: [
	                {data: 'kd_item', name: 'kd_item', defaultContent: '-'},
	                {data: 'ket', name: 'ket', defaultContent: '-'},
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

	$('body').on('click', '.delete', function () {
		if (confirm("Delete Record?") == true) {
			var kd_item = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('master/item-pc/destroy') }}",
				data: {kd_item : kd_item, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_item_pc').DataTable().ajax.url("{{ route('master.item-pc.data') }}").load();
					}
				}
			});
		}
	});
</script>
@endsection