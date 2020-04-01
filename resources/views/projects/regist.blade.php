@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
              <strong class="card-title">Regist Project</strong>
            </div>
            <div class="card-body">
                <form action="{{route('saveProject')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-6 col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                      <button class="btn btn-lg btn-info btn-block">
                        Submit
                      </button>
                    </div>
                  </form>
            </div>
        </div>
    </section>
@endsection
