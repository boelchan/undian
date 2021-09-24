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
                            <li> <a data-toggle="collapse" data-target="#collapseFilter"><i class="fas fa-search fa-lg"></i></a> </li>
                            <li> <a class="btn-link" data-route="{{ route('hadiah.create') }}"><i class="fas fa-plus fa-lg"></i></a> </li>
                        </ul>
                    </div>
                </div>
                <!--Search Form -->
                <div class="collapse-margin ml-2 mr-2" id="accordionExample">
                    <div class="card">
                        <div id="collapseFilter" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                            <div class="card-body">
                                <h5>Filter</h5>
                                <div class="form-row mb-1">
                                    <div class="col-lg-4 filter-table">
                        {!! Form::vText('hadiah') !!}
                        {!! Form::vText('status') !!}

                                    </div>
                                </div>
                                <div>
                                    {!! Form::button('<i class="fas fa-search"></i> Cari', ['class' => 'submit-filter btn btn-success btn-sm', 'data-target' => 'hadiah-table', 'value'=> 'submit']) !!}
                                    {!! Form::button('<i class="fas fa-redo"></i> Reset', ['class' => 'submit-filter btn btn-outline-danger btn-sm', 'data-target' => 'hadiah-table', 'value'=> 'reset']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-datatable">
                    <table class="dt-advanced-search table" id="hadiah-table">
                        <thead>
                            <tr>
                                <th width="3%"></th>
                                <th>Hadiah</th>
                                <th>icon</th>
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
            { data: 'icon', name: 'icon'},
            { data: 'status', name: 'status'},
            
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order:[[1,'asc']],
        drawCallback: function( settings ) { feather.replace() },
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: { paginate: { previous: '&nbsp;', next: '&nbsp;' } }
    });
</script>
  
@endsection