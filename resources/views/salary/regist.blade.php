@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
              <strong class="card-title">Regist Salary</strong>
            </div>
            <div class="card-body">
                <form action="{{route('saveSalary')}}" id="registForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>User name</label>
                                <select class="form-control" name="nameSalary">
                                    @if (isset($users))
                                        <option selected disabled>Select user name</option>
                                        @foreach ($users as $vUser)
                                        <option value="{{ $vUser->id }}">{{ $vUser->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('nameSalary')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Base salary</label>
                                <input type="text" class="form-control" name="baseSalary" value="">
                                @error('baseSalary')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Salary</label>
                                <input type="text" class="form-control" name="salary" value="">
                                @error('salary')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" id="clearBtn">
                            Clear
                        </button>
                        <button class="btn btn-primary pull-right">
                        Regist
                        </button>
                    </div>
                  </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#clearBtn').click(function(){
            $('#registForm').trigger("reset");
            $('.alert').hide();
        });
    });
</script>
@endsection
