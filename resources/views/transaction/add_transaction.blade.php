<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="needle">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>E - NEEDLE</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->


    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">


    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/sweetalert2/sweetalert2.min.css') }}">


    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <!-- End layout styles -->

    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">


    {{-- <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" /> --}}




    <!-- javascript -->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>



    <style>
        /* style jam digital */
        .time-now {
            font-size: 160px;
            font-weight: bold;
            text-align: center;
            color: rgb(255, 230, 0);
            padding: 0px 0px 0px 0px;

        }

        .date-now {
            font-size: 50px;
            font-weight: 600;
            color: rgb(197, 197, 197);
            text-align: center;
            padding: 0px 0px 0px 0px;
        }

        .menu-now {
            font-size: 10px;
            font-weight: 600;
            color: rgb(197, 197, 197);
            text-align: center;
            padding: 0px 0px 0px 0px;
        }

        .area-datetime {
            margin-top: 0px;
            padding: 0px;
            width: 100%;
            height: 340px;
            background-color: black;
        }

        .card {
            background-color: black;

        }

        .card-title {
            text-align: center;
            font-weight: 600;
            color: rgb(197, 197, 197);
        }

        .txt-count {
            font-weight: bold;
            text-align: center;
            color: rgb(255, 230, 0);
        }

        .txt-counts {
            font-weight: bold;
            font-size: 50px;
            text-align: center;
            color: rgb(255, 17, 17);
        }

        .hidden-input {
            display: none;
        }
    </style>





</head>

<body class="bg-black" id="content-scan" onclick="openFullscreen();">

    <div class="p-1">

        <!-- partial -->
        <div class="page-wrapper">
            <div class="">
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="area-datetime  align-items-center">
                            <div class="time-now" id="timenow"></div>
                            <div class="date-now" id="datenow"></div>
                            <div class="menu-now">IN</div>


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
                                            <h6 class="card-title mb-0">STAY ON AREA</h6>

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

                <div class="row mt-0">
                    <form id="TransactionForm" name="TransactionForm">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p class="txt-counts" id="txt-name">-</p>

                                <input type="text" class="form-control" id="nik" name="nik"
                                    placeholder="NIK" autofocus required>

                                <input type="text" class="form-control hidden-input" id="employee_id"
                                    name="employee_id" required>

                            </div>

                        </div>


                    </form>


                </div>
            </div>
        </div>

    </div>







    <script type="text/javascript">
        $(document).ready(function() {



//             get_employee();
//             get_in();
//             get_out();
//             get_stay();

            clear_input();
    
    
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




            if ($("#txt-name").text() === '-') {
                $("#types").prop('disabled', true); // Nonaktifkan input types
            }



            $("#nik").on('keyup', function(e) {

                if (e.keyCode === 13) {

                    var nik = $(this).val();

                    $.ajax({
                        url: "{{ route('check.employee') }}",
                        method: "POST",
                        data: {
                            nik: nik,
                            _token: '{{ csrf_token() }}' // Sertakan token CSRF
                        },
                        success: function(response) {
                            if (response.id) {
                                $("#employee_id").val(response.id);
                                var truncatedName = response.name.substring(0, 15);
                                $("#txt-name").html(truncatedName);



                                // Simpan transaksi dengan tipe "IN"
                                saveTransaction(response.id, "IN");

                            } else {
                                const Toast = Swal.mixin({
                                 
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });

                                Toast.fire({
                                    icon: 'error',
                                    title: 'NIK tidak ditemukan!'
                                })

                                $('#nik').val('');
                            }
                        }

                    });
                }
            });

        });

        function clear_input() {
            $('#nik').val('');
            $('#employee_id').val('');
            $('#txt-name').text('-');
        }

        function clear_txt() {
            $('#txt-name').html('-');
        }


        function saveTransaction(employeeId, types) {
            $.ajax({
                url: "{{ route('store.transaction') }}",
                method: "POST",
                data: {
                    employee_id: employeeId,
                    types: types,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi berhasil disimpan!',
                           
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                        });

                        // Perbarui jumlah IN
                        get_in();
                        get_out()
                        get_stay();
                        get_employee();
                        clear_input();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Already IN!',
                          
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                        });

                        clear_input();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                    
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            });
        }





        function get_employee() {

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

        function openFullscreen() {
            var elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE11 */
                elem.msRequestFullscreen();
            }

            $("#nik").focus();
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




</body>




</html>

<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
