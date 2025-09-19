@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome </h4>
            </div>
            {{-- <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary"
                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary"
                    placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Download Report
            </button>
        </div> --}}
        </div>

        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="area-datetime  align-items-center">
                    <div class="time-now" id="timenow"></div>
                    <div class="date-now" id="datenow"></div>
                </div>

            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Employee Registred</h6>

                                </div>
                                <div class="row">
                                    <h1 class="txt-count mb-2" id="txt-count-emp">0</h1>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">IN </h6>

                                </div>
                                <div class="row">
                                    <h1 class="txt-count mb-2" id="txt-count-in">0</h1>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">OUT</h6>

                                </div>
                                <div class="row">
                                    <h1 class="txt-count mb-2" id="txt-count-out">0</h1>

                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">STAY</h6>

                                </div>
                                <div class="row">
                                    <h1 class="txt-count mb-2" id="txt-count-stay">0</h1>

                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->





    </div>


    <script>
        // A $( document ).ready() block.
        $(document).ready(function() {

              // Inisialisasi variabel untuk menyimpan data terakhir yang diterima
              var lastEmployeeCount = null;
            var lastInCount = null;
            var lastOutCount = null;
            var lastStayCount = null;

            // Fungsi untuk memeriksa dan memperbarui data jika ada perubahan
            function updateDataIfChanged() {
                get_employee(function(employeeCount) {
                    if (employeeCount !== lastEmployeeCount) {
                        $('#txt-count-emp').text(employeeCount);
                        lastEmployeeCount = employeeCount;
                    }
                });
                get_in(function(inCount) {
                    if (inCount !== lastInCount) {
                        $('#txt-count-in').text(inCount);
                        lastInCount = inCount;
                    }
                });
                get_out(function(outCount) {
                    if (outCount !== lastOutCount) {
                        $('#txt-count-out').text(outCount);
                        lastOutCount = outCount;
                    }
                });
                get_stay(function(stayCount) {
                    if (stayCount !== lastStayCount) {
                        $('#txt-count-stay').text(stayCount);
                        lastStayCount = stayCount;
                    }
                });
            }	

            // Set interval untuk memeriksa pembaruan data setiap 10 detik
            setInterval(updateDataIfChanged, 10000);

            // Inisialisasi pertama kali
            updateDataIfChanged();

        });



        function get_employee(callback) {

            $.ajax({
                url: "{{ route('get.employeecount') }}", // Ganti dengan URL yang sesuai untuk mengambil jumlah total karyawan
                method: 'GET',
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                //         'content') // Menggunakan token CSRF dari meta tag
                // },
                success: function(response) {
                    // Update teks pada elemen h1 dengan id "employeeCount" dengan jumlah total karyawan
                    $('#txt-count-emp').text(response.data.employee_count);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#txt-count-emp').html('Error fetching employee count');
                }
            });
        }

        function get_in(callback) {
            $.ajax({
                url: "{{ route('get.transactionin') }}", // Ganti dengan URL yang sesuai untuk mengambil jumlah total karyawan
                method: 'GET',

                success: function(response) {
                    // 
                    console.log(response.data.in);
                    $('#txt-count-in').text(response.data.in);
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                    console.log('eror');
                    $('#txt-count-in').html('Error fetching employee count');
                }
            });
        }


        function get_out(callback) {

            $.ajax({
                url: "{{ route('get.transactionout') }}", // Ganti dengan URL yang sesuai untuk mengambil jumlah total karyawan
                method: 'GET',

                success: function(response) {
                    // Update teks pada elemen h1 dengan id "employeeCount" dengan jumlah total karyawan
                    $('#txt-count-out').text(response.data.out);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#txt-count-out').html('Error fetching data');
                }
            });
        }

        function get_stay(callback) {

            $.ajax({
                url: "{{ route('get.transactionstay') }}", // Ganti dengan URL yang sesuai untuk mengambil jumlah total karyawan
                method: 'GET',

                success: function(response) {
                    // Update teks pada elemen h1 dengan id "employeeCount" dengan jumlah total karyawan
                    $('#txt-count-stay').text(response.data.stay);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#txt-count-stay').html('Error fetching data');
                }
            });
        }


          //intital tanggal dan waktu dari id
          var dateDisplay = document.getElementById("datenow");
        var timeDisplay = document.getElementById("timenow");
        //fungsi
        function refreshTime() {
            var dateString = new Date().toLocaleString("id-ID", {
                imeZone: "Asia/Jakarta"
            }); //gettime
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var todayy = dd + '/' + mm + '/' + yyyy;
            var formattedString = dateString.replace(",", "-");
            dateDisplay.innerHTML = todayy; // date 

            var splitarray = new Array();
            splitarray = formattedString.split(" ");
            var splitarraytime = new Array();
            splitarraytime = splitarray[1].split(".");
            timeDisplay.innerHTML = splitarraytime[0] + ':' + splitarraytime[1] + ':' +
                splitarraytime[2]; // time 
        }
        //panggil ulang otomatis fungsi 
        setInterval(refreshTime, 1000);
    </script>
@endsection
