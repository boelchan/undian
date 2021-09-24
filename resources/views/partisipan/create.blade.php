@extends('layouts/contentLayoutMaster')

@section('title', 'Partisipan')

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('partisipan.index') }}" title="kembali"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;</a>
                        <h4 class="card-title">Tambah data</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'partisipan.store', 'class' => 'form_ajax']) !!}
                        
                        {!! Form::vText('nik') !!}
                        {!! Form::vText('nama') !!}
                        {!! Form::vTextarea('alamat') !!}
                        {!! Form::vText('hadiah') !!}

                        <div class="form-group">
                            {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection