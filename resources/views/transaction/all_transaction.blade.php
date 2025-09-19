@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">
                                <div class="col">
                                    <nav class="page-breadcrumb">
                                        <ol class="breadcrumb">
                                            <a href="{{ route('add.transaction') }}" class="btn btn-primary mx-1 btn-sm"><i
                                                    class="feather-16" data-feather="file-plus"></i> &nbsp;Add</a>
                                            <a href="{{ route('export.transaction') }}"
                                                class="btn btn-success mx-1 btn-sm"><i class="feather-16"
                                                    data-feather="file-minus"></i> &nbsp;Excel</a>

                                            <a href="{{ route('pdf.transaction') }}" class="btn btn-danger mx-1 btn-sm"><i
                                                    class="feather-16" data-feather="file-minus"></i> &nbsp;pdf</a>
                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">Transaction</h6>

                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button id="filter" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No TRX</th>
                                        <th>NIK</th>
                                        <th>NAME</th>
                                        <th>DEPT.</th>
                                        <th>TYPE 1</th>
                                        <th>DATE IN</th>
                                        <th>TYPE 2</th>
                                        <th>DATE OUT</th>
                                        <th>REMARK</th>

                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="transaction-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $('body').on('click', '#deletes', function() {



            var id_trans = $(this).data("id");

            console.log(id_trans);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        type: "GET",
                        url: "/delete/transaction/" + id_trans,
                        success: function(data) {
                            // table.ajax.reload(null, false);

                            swalWithBootstrapButtons.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success',
                            )
                            window.location.reload();
                        },
                        error: function(data) {
                            console.log('Error:', data);

                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                `'There is relation data'.${data.responseJSON.message}`,
                                'error'
                            )

                        }
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your file is safe :)',
                        'error'
                    )
                }
            })

        });

         $(document).ready(function() {
       
 $('#filter').on('click', function() {
var dataTable = $('#dataTableExample').DataTable({
            processing: true,
            serverSide: true,
   destroy: true,
      
            ajax: {
                url: "{{ route('get.transactionfilter') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                dataSrc: function (json) {
                    if(json.data.length === 0) {
                        return [];
                    }
                    return json.data;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'no_trx', name: 'no_trx' },
                { data: 'employee.nik', name: 'employee.nik' },
                { data: 'employee.name', name: 'employee.name' },
                { data: 'employee.department', name: 'employee.department' },
                { data: 'type1', name: 'type1' },
                 {
        data: 'created_at',
        name: 'created_at',
        render: function(data) {
            return new Date(data).toLocaleString('en-GB', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).replace(',', '');
        }
    },
                { data: 'type2', name: 'type2' },
                {
        data: 'updated_at',
        name: 'updated_at',
        render: function(data, type, row) {
            return data === row.created_at ? " " : new Date(data).toLocaleString('en-GB', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).replace(',', '');
        }
    },
                { data: 'remark', name: 'remark' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
        
         
            initComplete: function(settings, json) {
                dataTable.clear().draw();
            }
        });

  });
    });


function formatDate(dateString) {
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2);
        var day = ('0' + date.getDate()).slice(-2);
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        var seconds = ('0' + date.getSeconds()).slice(-2);
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }


    </script>
@endsection
