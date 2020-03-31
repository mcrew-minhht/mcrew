@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
<section class="content">
    <form action="{{asset('customers/regist')}}" method="get" id="resetForm">
    </form>
    <form action="{{asset('customers/regist/save')}}" method="POST" id="submitForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Regist Customer</strong>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', '')}}" maxlength="100">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer-o1">
                <div class=" pull-right">
                    <button type="button" class="btn btn-default" id="clearBtn">
                        Clear
                    </button>
                    <button class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#clearBtn').click(function(){
            $('#resetForm').submit();
        });
    });
</script>
@endsection