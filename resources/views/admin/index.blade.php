@extends('layouts.master')

@section('title')
    @lang('translation.Dashboards')
@endsection

@section('content')
    <h3>Welcome !</h3>
    <br>
    <div class="row">
        <br>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" style="float: right;" class="btn btn-primary create_btn"><i class="bx bx-plus"></i>
                        เพิ่มข้อมูล </button>
                    <h2 class="card-title">Driving License Test</h2>
                    <br>

                    <div style="overflow-x: auto;">
                        <table id="simple_table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>วันที่บันทึก</th>
                                    <th>สถานะ</th>
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



    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><span id="modal_title"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="simple_form">
                        @csrf
                        <input type="hidden" class="form-input" name="dt_id" id="dt_id">
                        <div class="col-12">
                            <h5 class="text-primary"> ข้อมูลทั่วไป</h5>

                            <div class="row">

                                <div class="col-6">
                                    <label for="firstname" class="form-label">ชื่อ</label>
                                    <input  type="text" class="form-input form-control" id="firstname" value=""
                                        name="firstname" placeholder="กรอกชื่อ" required>
                                </div>

                                <div class="col-6">
                                    <label for="lastname" class="form-label">นามสกุล</label>
                                    <input  type="text" class="form-input form-control" id="lastname" value=""
                                        name="lastname" placeholder="กรอกนามสกุล" required>
                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <hr>
                            <h5 class="text-primary"> ทดสอบร่างกาย </h5>
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="body0" class="form-label"> 1. ทดสอบตาบอดสี</label><br>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" id="body0_wait" name="body[0]" value="W" checked><span> รอทดสอบ</span>
                                            <input type="radio" id="body0_pass" name="body[0]" value="P" ><span> ผ่าน</span>
                                            <input type="radio" id="body0_fail" name="body[0]" value="F"><span> ไม่ผ่าน</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="body1" class="form-label"> 2. ทดสอบสายตายาว</label><br>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" id="body1_wait" name="body[1]" value="W" checked><span> รอทดสอบ</span>
                                            <input type="radio" id="body1_pass" name="body[1]" value="P"><span> ผ่าน</span>
                                            <input type="radio" id="body1_fail" name="body[1]" value="F"><span> ไม่ผ่าน</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="body2" class="form-label"> 3. ทดสอบสายตาเอียง</label><br>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" id="body2_wait" name="body[2]" value="W" checked><span> รอทดสอบ</span>
                                            <input type="radio" id="body2_pass" name="body[2]" value="P" ><span> ผ่าน</span>
                                            <input type="radio" id="body2_fail" name="body[2]" value="F"><span> ไม่ผ่าน</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="body3" class="form-label"> 4.
                                                ทดสอบการตอบสนองของร่างกาย</label><br>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" id="body3_wait" name="body[3]" value="W" checked><span> รอทดสอบ</span>
                                            <input type="radio" id="body3_pass" name="body[3]" value="P"><span> ผ่าน</span>
                                            <input type="radio" id="body3_fail" name="body[3]" value="F"><span> ไม่ผ่าน</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="col-12">
                            <hr>
                            <h5 class="text-primary"> ทดสอบทฤษฎี (เต็ม 50 คะแนน) </h5>
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="theory0" class="form-label"> 1. ป้ายจราจาร</label><br>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control form-control-sm" type="number" id="theory0" name="theory[0]" value="0" max="50" min="0" required>
                                        </div>
                                        <div class="col-3"> คะแนน </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="theory1" class="form-label"> 2. เส้นจราจร</label><br>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control form-control-sm" type="number" id="theory1" name="theory[1]" value="0" max="50"  min="0" required>
                                        </div>
                                        <div class="col-3"> คะแนน </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="theory2" class="form-label"> 3. การให้ทาง</label><br>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control form-control-sm" type="number" id="theory2" name="theory[2]" value="0" max="50"  min="0" required>
                                        </div>
                                        <div class="col-3"> คะแนน </div>
                                    </div>
                                </div>


                            </div>
                        </div>




                        <div class="col-12">
                            <hr>
                            <h5 class="text-primary"> ทดสอบปฎิบัติ </h5>
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="practice" class="form-label"> ผลการสอบภาคปฎิบัติ </label><br>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" id="practice0_wait" name="practice" value="W" checked><span> รอทดสอบ</span>
                                            <input type="radio" id="practice0_pass" name="practice" value="P"><span> ผ่าน</span>
                                            <input type="radio" id="practice0_fail" name="practice" value="F"><span> ไม่ผ่าน</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>




                        <div class="mt-3 d-grid">
                            <br>
                            <button class="btn btn-primary waves-effect waves-light" id="save_btn" type="submit">
                                บันทึก </button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>


    <script>

        $(document).ready(function () {
            var simple = '';
        });

        $('#simple_table').ready(function () {
            
            simple = $('#simple_table').DataTable({
                "processing": false,
                "serverSide": false,
                "info": false,
                "searching": true,
                "responsive": true,
                "bFilter": false,
                "destroy": true,
                // "order": [
                //     [0, "desc"]
                // ],
                "ajax": {
                    "url": "{{ route('show') }}",
                    "method": "GET",
                    "data": {
                        "_token": "{{ csrf_token()}}",
                    },
                },
                'columnDefs': [
                    {
                        "targets": [0,1,2,3,4,5],
                        "className": "text-center",
                    },
                ],
                  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                        $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
                    },
                "columns": [


                    {
                        "data": "id",
                       
                    },
                    {
                        "data": "firstname",
                    },
                    {
                        "data": "lastname",
                    },

                    {
                        "data": "created_at",
                        "render": function (data, type, full) {
                            return moment(data).format('DD-MM-YYYY HH:mm');
                        }
                    },

                    {
                        "data": "status",
                        "render": function (data, type, full) {
                            let txt = '';
                            switch (data) {
                                case 'P':
                                    txt = `<span class="text-success">ผ่านการทดสอบ</span>`;
                                    break;
                                case 'F':
                                    txt = `<span class="text-danger">ไม่ผ่านการทดสอบ</span>`;
                                    break;
                                default:
                                    txt = `<span class="text-warning">รอพิจารณา</span>`;
                                    break;
                            }
                            return txt;
                        }
                    },

                    {
                        "data": "id",
                        "render": function (data, type, full) {
                            var obj = JSON.stringify(full);
                            var button = `
                              <button type="button" class="btn btn-sm btn-info" onclick='show(${obj})'><i class="bx bx-search-alt-2"></i>  </button>
                             <button type="button" class="btn btn-sm btn-danger" onclick='destroy(${data})'><i class="bx bx-trash"></i>  </button>
                            `;
                  
                            return button;

                        }
                    },
                    
                ],
            });
        });


        $(".create_btn").click(function() {
            $('#modal_title').text('เพิ่มข้อมูลใหม่');
            $('.form-input').val('');

            $('#body0_wait').prop("checked", true);
            $('#body1_wait').prop("checked", true);
            $('#body2_wait').prop("checked", true);
            $('#body3_wait').prop("checked", true);

            $('#theory0').val(0);
            $('#theory1').val(0);
            $('#theory2').val(0);

            $('#practice0_wait').prop("checked", true);

            $('#createModal').modal("show");
           
        });


        $('#simple_form').submit(function(e) {

            openLoading();
            e.preventDefault();
            let formData = new FormData(this);
            console.log('OK');
            $.ajax({
                type: "method",
                method: "POST",
                url: "{{ route('store') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    console.log(res);
                    simple.ajax.reload();
                    Swal.fire(res.title, res.msg, res.status);
                    $('#createModal').modal("hide");
                    closeLoading();
                }
            });

        });


        function destroy(id) {
            Swal.fire({
                title: 'คุณมั่นใจหรือไม่ ?',
                text: 'ที่จะลบรายการนี้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#7A7978',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',

            }).then((result) => {
                if (result.isConfirmed) {
                    openLoading();
                    $.post("{{ route('destroy') }}", data = {
                            _token: '{{ csrf_token() }}',
                            id: id,
                        },
                        function(res) {
                            simple.ajax.reload();
                            closeLoading();
                            Swal.fire(res.title, res.msg, res.status);
                        },
                    );

                }
            });
        }

        function show(obj){
            console.log(obj)
            $('#modal_title').text('รายละเอียด');
            $('#createModal').modal("show");

            $("#firstname").val(obj.firstname)
            $("#lastname").val(obj.lastname)
            $("#dt_id").val(obj.id)

            let driving_license_body_tests = obj.driving_license_body_tests ? obj.driving_license_body_tests : null;
            let driving_license_theory_tests = obj.driving_license_theory_tests ? obj.driving_license_theory_tests : null;
            let driving_license_practice_tests = obj.driving_license_practice_tests ? obj.driving_license_practice_tests : null;

            if(driving_license_body_tests){
                driving_license_body_tests.forEach(element => {
                    if(element.name == 'ทดสอบตาบอดสี' ){
                        switch (element.status) {
                            case "P":
                                $('#body0_pass').prop("checked", true);
                                break;
                            case "F":
                                $('#body0_fail').prop("checked", true);
                                break;
                            case "W":
                                $('#body0_wait').prop("checked", true);
                                break;
                        
                            default:
                                break;
                        }
                    }

                    if(element.name == 'ทดสอบสายตายาว' ){
                          switch (element.status) {
                            case "P":
                                $('#body1_pass').prop("checked", true);
                                break;
                            case "F":
                                $('#body1_fail').prop("checked", true);
                                break;
                            case "W":
                                $('#body1_wait').prop("checked", true);
                                break;
                        
                            default:
                                break;
                        }
                        
                    }

                    if(element.name == 'ทดสอบสายตาเอียง' ){

                          switch (element.status) {
                            case "P":
                                $('#body2_pass').prop("checked", true);
                                break;
                            case "F":
                                $('#body2_fail').prop("checked", true);
                                break;
                            case "W":
                                $('#body2_wait').prop("checked", true);
                                break;
                        
                            default:
                                break;
                        }
                        
                    }

                    if(element.name == 'ทดสอบร่างกาย' ){
                          switch (element.status) {
                            case "P":
                                $('#body3_pass').prop("checked", true);
                                break;
                            case "F":
                                $('#body3_fail').prop("checked", true);
                                break;
                            case "W":
                                $('#body3_wait').prop("checked", true);
                                break;
                        
                            default:
                                break;
                        }
                        
                    }
                 
                });
            }

            if(driving_license_theory_tests){
                driving_license_theory_tests.forEach(element => {
                    if(element.name == 'ป้ายจราจร' ){
                        $('#theory0').val(element.score)
                    }

                    if(element.name == 'เส้นจราจร' ){
                        $('#theory1').val(element.score)
                    }

                    if(element.name == 'การให้ทาง' ){
                        $('#theory2').val(element.score)
                    }

                 
                });
            }

            if(driving_license_practice_tests){
                driving_license_practice_tests.forEach(element => {
                    if(element.name == 'การสอบปฏิบัติ' ){
                          switch (element.status) {
                            case "P":
                                $('#practice0_pass').prop("checked", true);
                                break;
                            case "F":
                                $('#practice0_fail').prop("checked", true);
                                break;
                            case "W":
                                $('#practice0_wait').prop("checked", true);
                                break;
                        
                            default:
                                break;
                        }
                        
                    }
                 
                });
            }


            
        }
    </script>
@endsection
