@extends('layouts.master')

@section('title') Out - Material | Admin - Beko  @endsection

@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .select2-container {
        width: 100%;
        z-index: 100000;

    }
</style>
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('title') Out - Material @endslot
    @endcomponent

            <div class="wrapper wrapper-content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <button type="button" style="float: right; margin: 2px;" class="btn btn-success customer_btn btn" onclick="modalShow()"><i class="bx bx-plus"></i> เพิ่ม </button>
                 
                    <h4 class="card-title">Out - Material</h4>
                    <br>

                    <br>
                     <div style="overflow-x: auto;">
                    <table id="simple_table" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Job No</th>
                                <th>Model</th>
                                <th>Serial</th>
                                <th>Customer</th>
                                <th>Invoice No</th>
                                <th>Ref</th>
                                <th>Material No</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                     </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="modal fade import-file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Import File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('out-mat.upload') }}" method="POST" id="import-file" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file">Choose File</label>
                        <input id="file" type="file" class="form-control"  name="select_file"  required="true" >
                           
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection
@section('script')
    
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>

<script>
    
        $(document).ready(function () {
            var simple = '';

        });


        $('#simple_table').ready(function () {
            var i = 1;
            simple = $('#simple_table').DataTable({
                "processing": false,
                "serverSide": false,
                "info": false,
                "searching": true,
                "responsive": false,
                "bFilter": false,
                "destroy": true,
                "pageLength": 500,
                // "order": [
                //     [0, "desc"]
                // ],
                "dom": 'Bfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "ajax": {
                    "url": "{{ route('out-mat.show') }}",
                    "method": "GET",
                    "data": {
                        "_token": "{{ csrf_token()}}",
                    },
                },
                'columnDefs': [
                    {
                        "targets": [0,1,2,3,4,5,6,7,8,9],
                        "className": "text-center",
                    },
                ],
                "columns": [
                    {
                     "data": "id",
                         "render": function (data, type, full) {
                            return i++
                        }
                    },
              
                    {
                        "data": "job_no",
                    },
                    {
                        "data": "model",
                    },
                    {
                        "data": "serial_no",
                    },
                    {
                        "data": "customer_name",
                    },
                
                    {
                        "data": "invoice_no",
                    },
                    {
                        "data": "ref_no",
                    },
                        {
                        "data": "material_no",
                    },
                    {
                        "data": "qty",
                        "render" : function (data, type, full){
                            let text = `<span class="text-danger"> ${data} </span>`;
                            return text
                        }
                    },
                        {
                        "data": "price",
                    },
                        {
                        "data": "total",
                    },
                     {
                        "data": "id",
                        "render": function (data, type, full) {
                            return `<button class="btn btn-danger" onclick="desrtoy(${data})"> <i class="fa fa-trash"></i> </button>`
                        }
                    },
                    
                    
                ],
            });
        });

        function desrtoy(id) {
            swal.fire({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                    $.post("{{ route('out-mat.destroy') }}", data = {
                            _token: '{{ csrf_token() }}',
                            id: id,
                        },
                        function(res) {
                            if (res.status == 'success') {
                                Swal.fire(
                                    '',
                                    'Success!',
                                    'success'
                                )

                                simple.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '',
                                    text: 'Not Success!'
                                })
                                // location.reload();
                            }
                        },
                    );
                }
            })

        }


        function modalShow() {

            $('#addModal').modal('show')
        }

</script>
  
@endsection
