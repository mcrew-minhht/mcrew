@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Update company</strong>
            </div>
            <div class="card-body">
                <form action="{{asset('companies/update')}}" id="registForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $company->id }}">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{$company->name}}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{$company->phone}}">
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{$company->address}}">
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{$company->email}}">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Bank name</label>
                                <input type="text" class="form-control" name="bank_name" value="{{$company->bank_name}}">
                                @error('bank_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Bank number</label>
                                <input type="text" class="form-control" name="bank_number" value="{{$company->bank_number}}">
                                @error('bank_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Bank account name</label>
                                <input type="text" class="form-control" name="bank_account_name" value="{{$company->bank_account_name}}">
                                @error('bank_account_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="javscript:void(0)" class="btn btn-default mr-2" id="clearBtn">Clear</a>
                        <button class="btn btn-primary pull-right">
                            Submit
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
