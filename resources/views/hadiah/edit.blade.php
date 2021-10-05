@extends('layouts/contentLayoutMaster')

@section('title', 'Hadiah')

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('hadiah.index') }}" title="kembali"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;</a>
                        <h4 class="card-title">Edit data</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model($hadiah, ['method' => 'PUT', 'route' => ['hadiah.update', $hadiah->id], 'class' => 'form_ajax', 'files'=>true ]) !!}

                        {!! Form::vText('hadiah') !!}
                        <div class="form-group">
                            {{ Form::label('Icon', null, ['class' => 'control-label']) }}
                            <br>
                            @if($hadiah->icon)
                                <img src="{{ asset('storage/icon/'.$hadiah->icon) }}" alt="" width="200px">
                            @endif
                            {{ Form::file('icon', ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
