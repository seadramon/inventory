@extends('layout.main')

@section('extra-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<div class="row">
		<div class="col-12">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-header">
					<h3 class="card-title">Akses Menu</h3>
				</div>
				<div class="card-body col-md-6">
                    <form class="form" method="post">
                        <input type="text" name="_token" hidden="" value="{{csrf_token()}}">
                        <input type="text" name="id" hidden="" value="{{ $id }}" id="role_id">
                        <div id="kt_docs_jstree_basic"></div>
                </div>
                <div class="card-footer" >
                    <a href="javascript:void(0)" class="btn btn-primary mr-2" id="updateBtn">Update</a>
                    <a href="{{ URL::previous() }}" class="btn btn-secondary">Cancel</a>
                    <a href="{{ route('setting.akses.menu.delete.setting', ['id' =>  $id]) }}" 
                        onClick="return confirm('Are you sure ?')"  class="btn btn-secondary">Remove All Menus</a>
                </div>
            </form>
			</div>
		</div>
	</div>
@endsection

@section('extra-js')
	<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
        // $('#kt_docs_jstree_basic').jstree({
        //     "core" : {
        //         "themes" : {
        //             "responsive": false
        //         }
        //     },
        //     "types" : {
        //         "default" : {
        //             "icon" : "fa fa-folder"
        //         },
        //         "file" : {
        //             "icon" : "fa fa-file"
        //         }
        //     },
        //     "plugins": ["types","checkbox"]
        // });

         $.ajax({
            type: "POST",
            url: "{{ route('setting.akses.menu.tree.data') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                    id : $('#role_id').val(),
                },
            success: function(result) {
                $('#kt_docs_jstree_basic').jstree({ 
                    'core' : result, 
                    "plugins": ["types","checkbox"]
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        $('#updateBtn').on("click", function(e) { 

            var selectedElmsIds = $('#kt_docs_jstree_basic').jstree("get_selected");
            var selectedElmsIds = [];
            var selectedElms = $('#kt_docs_jstree_basic').jstree("get_selected", true);
            $.each(selectedElms, function() {
                selectedElmsIds.push(this.li_attr.val_id);
            });

            swal({
                title: "Apakah anda yakin ?",
                text: "Semua menu terpilih akan diperbarui/ditambahkan",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.akses.menu.update.setting') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                                data: selectedElmsIds,
                                role_id : $('#role_id').val(),
                            },
                        success: function(result) {
                            // swal("Menu Successfully Update");
                            flasher.success("Data telah berhasil ditambahkan!");
                            setTimeout(function() { 
                                window.location=window.location;
                            },1000);
                            console.log(result);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                } else {
                    swal("Update Canceled", {
                        icon: "success",
                    }); 
                }
            });
        });

		
	</script>
@endsection