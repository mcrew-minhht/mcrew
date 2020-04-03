@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
              <strong class="card-title">Regist Project</strong>
            </div>
            <div class="card-body">
                <form action="{{route('saveProject')}}" id="registForm" method="POST">
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
                    <div class="text-right">
                        <button type="button" class="btn btn-default" id="clearBtn">
                            Clear
                        </button>
                        <button class="btn btn-primary pull-right">
                            Register
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
