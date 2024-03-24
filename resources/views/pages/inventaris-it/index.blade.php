@extends('layout.main')

@section('extra-css')
	<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-xl-stretch mb-5 mb-xl-8">
			<div class="card-header">
				<h3 class="card-title">List Inventaris IT</h3>
				<div class="card-toolbar">
					<a href="{{route('inventaris-it.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
				</div>
			</div>
			<div class="card-body">
				<table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="tabel_inventaris_it">
					<thead>
						<tr class="text-start text-gray-800 fw-bolder fs-7 text-uppercase">
							<th>No Inventaris</th>
							<th>Pengguna</th>
							<th>Unit Kerja</th>
							<th>Harga Perolehan</th>
							<th>Tgl Perolehan</th>
							<th>Tipe</th>
							<th>Nilai Buku</th>
							<th>Status</th>
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

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	"use strict";

	// Class definition
	var KTDatatablesServerSide = function () {
	    // Shared variables
	    var table;
	    var dt;
	    var filterPayment;

	    // Private functions
	    var initDatatable = function () {
	        dt = $("#tabel_inventaris_it").DataTable({
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
	            ajax: "{{ route('inventaris-it.data') }}",
	            columns: [
	                {data: 'no_inventaris', name: 'no_inventaris', defaultContent: '-'},
	                {data: 'pengguna', name: 'pengguna', defaultContent: '-'},
					{
						render: function ( data, type, row ) {
							return row.pat?.ket;
						},
						name: 'kd_pat'
					},
					{data: 'hrg_perolehan', name: 'hrg_perolehan', defaultContent: '-',
						render: function(data){
								if (data == null){
									return '-';
								}
								else {
									return format(data, '.');
								}
							}
					},
					{data: 'tgl_perolehan', name: 'tgl_perolehan', defaultContent: '-'},
					{data: 'tipe_pc.ket', name: 'kd_tipe_pc', defaultContent: '-'},
					{data: 'nilai_buku', name: 'nilai_buku', defaultContent: '-',
						render: function(data){
								if (data == null){
									return '-';
								}
								else {
									return format(data, '.');
								}
							}
					},
					{data: 'status', name: 'status', defaultContent: '-'},
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
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('inventaris-it/destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_inventaris_it').DataTable().ajax.url("{{ route('inventaris-it.data') }}").load();
					}
				}
			});
		}
	});
</script>
@endsection