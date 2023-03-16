@extends('layouts.master')

@section('title')
    @lang('translation.Dashboards')
@endsection

@section('content')
    <br>
    <div class="row">
        <br>
        <div class="col-12">

            <div class="card">

                <div class="card-body">
                    <h3>Filter</h3>
                    <div class="row">

                        <div class="col-4">

                            <label for="date" class="form-label">วันที่</label>
                            <input type="date" class="form-input form-control" id="date" value=""
                                name="date">

                        </div>

                        <div class="col-4">

                            <label for="firstname" class="form-label">นามสกุล</label>
                            <input type="text" class="form-input form-control" id="firstname" value=""
                                name="firstname" placeholder="ชื่อ">

                        </div>

                        <div class="col-4">

                            <label for="lastname" class="form-label">นามสกุล</label>
                            <input type="text" class="form-input form-control" id="lastname" value=""
                                name="lastname" placeholder="นามสกุล">

                        </div>

                        <div class="col-12">
                            <br>
                            <button type="button" class="btn btn-primary form-control" id="btn_search">ค้นหา</button>

                        </div>

                    </div>
                </div>
            </div>

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col-xl-12">
                            <div class="row">

                                <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                    
                                                    </div>
                                                    <h4 class="font-size-14 mb-0">ผ่านการทดสอบ</h4>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4><span id="count_pass"></span>  คน<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                    
                                                    </div>
                                                    <h4 class="font-size-14 mb-0">ไม่ผ่านการทดสอบ</h4>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4><span id="count_fail"></span>  คน<i class="mdi mdi-chevron-up ms-1 text-danger"></i></h4>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-xs me-3">
                                    
                                                    </div>
                                                    <h4 class="font-size-14 mb-0">รอพิจารณา</h4>
                                                </div>
                                                <div class="text-muted mt-4">
                                                    <h4><span id="count_wait"></span>  คน<i class="mdi mdi-chevron-up ms-1 text-warning"></i></h4>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                 

                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div style="overflow-x: auto;">
                        <table id="simple_table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>วันที่บันทึก</th>
                                    <th>ทดสอบร่างกาย</th>
                                    <th>ทดสอบทฤษฎี</th>
                                    <th>ทดสอบปฎิบัติ</th>
                                    <th>สถานะ</th>

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
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            var simple = '';
             showTable()
        });

        // $('#simple_table').ready(function() {
        
        function showTable(){
            let firstname = $('#firstname').val()
            let lastname = $('#lastname').val()
            let date = $('#date').val()

            simple = $('#simple_table').DataTable({
                "processing": false,
                "serverSide": false,
                "info": false,
                "searching": true,
                // "responsive": true,
                "bFilter": false,
                "destroy": true,
                // "order": [
                //     [0, "desc"]
                // ],
                "ajax": {
                    "url": "{{ route('report.show') }}",
                    "method": "GET",
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        'firstname': firstname,
                        'lastname': lastname,
                        'date': date,
                    },
                },
                'columnDefs': [{
                    "targets": [0, 1, 2, 3, 4, 5],
                    "className": "text-center",
                }, ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                },
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
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
                        "render": function(data, type, full) {
                            return moment(data).format('DD-MM-YYYY HH:mm');
                        }
                    },

                    {
                        "data": "driving_license_body_tests",
                        "render": function(data, type, full) {
                            var text = '';
                            var countF = data.filter(function(element){
                                return element.status == 'F';
                            }).length

                            var countW = data.filter(function(element){
                                return element.status == 'W';
                            }).length

                            if(countF >= 2){
                                text = '<span class="text-danger">ไม่ผ่านการทดสอบ</span>'
                            }else if(countW >= 1){
                                text = '<span class="text-warning">รอการทดสอบ</span>'
                            }else{
                                text = '<span class="text-success">ผ่านการทดสอบ</span>'
                            }
                            return text;
                        }
                    },

                    {
                        "data": "driving_license_theory_tests",
                        "render": function(data, type, full) {
                            let sum = 0;
                            let check_zero = 0;
                            let text = '';
                            data.forEach(element => {
                                sum += element.score
                                if( element.score == 0){
                                    check_zero = 1
                                }
                            });

                            if(check_zero == 1){
                                text = '<span class="text-warning">รอการทดสอบ</span>'
                            }else{
                                if(sum >= 120){
                                    text = '<span class="text-success">ผ่านการทดสอบ</span>'
                                }else{
                                    text = '<span class="text-danger">ไม่ผ่านการทดสอบ</span>'
                                }
                            }
                          
                            return text;
                        }
                    },

                    {
                        "data": "driving_license_practice_tests",
                        "render": function(data, type, full) {
                            var text = '';
                           
                            if(data[0].status == "F"){
                                text = '<span class="text-danger">ไม่ผ่านการทดสอบ</span>'
                            }else if(data[0].status == "W"){
                                text = '<span class="text-warning">รอการทดสอบ</span>'
                            }else{
                                text = '<span class="text-success">ผ่านการทดสอบ</span>'
                            }
                            return text;

                        }
                    },

              


                    {
                        "data": "status",
                        "render": function(data, type, full) {
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


                ],
                "drawCallback": function (settings) { 
                        // Here the response
                        var response = settings.json;
                        console.log(response);
                        if(response)
                        {
                            let arr = response.data
                       
                            var countP = arr.filter(function(element){
                                return element.status == 'P';
                            }).length

                            var countF = arr.filter(function(element){
                                return element.status == 'F';
                            }).length

                            var countW = arr.filter(function(element){
                                return element.status == 'W';
                            }).length
                            // console.log(countfiltered)
                            $("#count_pass").text(countP)
                            $("#count_fail").text(countF)
                            $("#count_wait").text(countW)
                        }
                        // $("#count_pass").text(response.length)
                    },
                });

        }

        

        $('#btn_search').on('click', function(e) {
             showTable()
        });


          
    </script>
@endsection
