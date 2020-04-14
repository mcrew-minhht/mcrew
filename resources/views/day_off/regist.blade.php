@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
              <strong class="card-title">Regist Day Off</strong>
            </div>
            <div class="card-body">
                <form action="{{route('storeDayOff')}}" id="registForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" name="date">
                                @error('date')
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
