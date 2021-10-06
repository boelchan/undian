@extends('layouts/contentLayoutMaster')

@section('title', 'Hadiah')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Data</h4>
                    <div class="heading-elements mb-0">
                        <ul class="list-inline mb-0">
                            <li> <a class="btn-link" data-route="{{ route('hadiah.create') }}"><i class="fas fa-plus fa-lg"></i></a> </li>
                        </ul>
                    </div>
                </div>
         
                <div class="card-datatable">
                    <table class="dt-advanced-search table" id="hadiah-table">
                        <thead>
                            <tr>
                                <th width="3%"></th>
                                <th>Hadiah</th>
                                <th>Status</th>
                                
                                <th width="12%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')

<script>
    var table = $('#hadiah-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : '{!! route('hadiah.data.list') !!}',
            data: function (d) {
                d.hadiah = $('#hadiah').val();
				d.status = $('#status').val();
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            { data: 'hadiah', name: 'hadiah'},
            { data: 'status', name: 'status'},
            
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order:[[1,'asc']],
        drawCallback: function( settings ) { feather.replace() },
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: { paginate: { previous: '&nbsp;', next: '&nbsp;' } }
    });

    $('body').on('click', '.table-reload', function () {
    Swal.fire({
        title: 'Apa Anda sudah yakin?',
        text: "Anda akan mengulang undian pada hadiah ini",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: $(this).data("url"),
                data: { "_token": $(this).data('token') },
                success: function (data) {
                    table.draw();
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Data berhasil diubah',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                },
                error: function (e) {
                    if (e.responseJSON.message) {
                        var swal_message = e.responseJSON.message;
                    } else {
                        var swal_message = "Data gagal dihapus";
                    }
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: swal_message,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        }
    })
});
</script>
  
@endsection