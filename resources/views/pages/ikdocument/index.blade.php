@extends('layout.main')
@section('pagetitle', 'IK Documents')

@section('extra-css')
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<!--begin::Container-->
			<div id="kt_content_container" class="container-xxl">
				
				<!--begin::Tables Widget 12-->
				<div class="card mb-5 mb-xl-8">
					<!--begin::Header-->
					<div class="card-header border-0 pt-5">
						<h3 class="card-title align-items-start flex-column">
							<span class="card-label fw-bolder fs-3 mb-1">List Data</span>
							<!-- <span class="text-muted mt-1 fw-bold fs-7">Over 500 new members</span> -->
						</h3>
						<div>
							
						<a href="{{ route('ikdocument.create') }}" class="btn btn-primary"><i class="bi bi-plus-square-dotted fs-4 me-2"></i>Add New</a>
						</div>
					</div>
					<!--end::Header-->
					<!--begin::Body-->
					<div class="card-body py-3">
						<!--begin::Table container-->
						<div class="table-responsive">


							<!--begin::Table-->
							<table class="table table-striped gy-7 gs-7" id="kt_advance_table_widget_1">
								<!--begin::Table head-->
								<thead>
									<tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
										<th class="min-w-200px">Nama File</th>
										<th class="min-w-125px">Action</th>
									</tr>
								</thead>
								<!--end::Table head-->
								<!--begin::Table body-->
								<tbody>
									
								</tbody>
								<!--end::Table body-->
							</table>
							<!--end::Table-->
						</div>
						<!--end::Table container-->
					</div>
					<!--begin::Body-->
				</div>
				<!--end::Tables Widget 12-->

			</div>
			<!--end::Container-->
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->
@endsection

@section('extra-js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>
    $(document).ready(function () {


        $('#kt_advance_table_widget_1').DataTable({
        	"scrollX": true,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ikdocument.data') }}",
            "columns": [          
                {data: 'file_url', name: 'file_url', defaultContent: '-', orderable: false, searchable: false},
                {data: 'menu', orderable: false, searchable: false}
            ],
            "order": [[0, 'asc']]
        });

        $('body').on('click', '.delete', function () {

        	if (confirm("Delete Record?") == true) {
        		var id = $(this).data('id');

        		// ajax
        		$.ajax({
        			type:"post",
        			url: "{{ url('ikdocument/destroy') }}",
        			data: {id : id, _token: "{{ csrf_token() }}"},
        			success: function(res){
        				if (res.result == 'success') {
        					flasher.success("Data has been deleted successfully!");

        					$('#kt_advance_table_widget_1').DataTable().ajax.url("{{ route('ikdocument.data') }}").load();
        				}
        			}
        		});
        	}
        });
    });
    </script>
@endsection