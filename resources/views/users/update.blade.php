@extends('master')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Update User</strong>
        </div>
        <div class="card-body">
            <form action="{{asset('users/detail')}}" method="post" id="resetForm">
                @csrf
                <input type="hidden" name="id" value="{{old('id', '')}}">
            </form>
            <form action="{{asset('users/update')}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{old('id', '')}}">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', '')}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{old('email', '')}}">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Email Verified At</label>
                            <input type="text" class="form-control" name="email_verified_at" value="{{old('email_verified_at', '')}}">
                            @error('email_verified_at')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="date" class="form-control" name="birthday" value="{{old('birthday', '')}}">
                            @error('birthday')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Identity</label>
                            <input type="text" class="form-control" name="identity" value="{{old('identity', '')}}">
                            @error('identity')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Identity Date</label>
                            <input type="date" class="form-control" name="identity_date" value="{{old('identity_date', '')}}">
                            @error('identity_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Identity Place</label>
                            <input type="text" class="form-control" name="identity_place" value="{{old('identity_place', '')}}">
                            @error('identity_place')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" value="{{old('phone_number', '')}}">
                            @error('phone_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Current Address</label>
                            <input type="text" class="form-control" name="current_address" value="{{old('current_address', '')}}">
                            @error('current_address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Regularly Address</label>
                            <input type="text" class="form-control" name="regularly_address" value="{{old('regularly_address', '')}}">
                            @error('regularly_address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-right">
                <button type="button" class="btn btn-default" id="clearBtn">
                    Clear
                </button>
                <button class="btn btn-primary pull-right" id="submitBtn">
                    Update
                </button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var isOrigin = '<?php echo isset($userInfo) ?>';
        var userInfo = null;
        if (isOrigin) {
            userInfo = <?php if (isset($userInfo)) echo json_encode($userInfo);
                        else echo json_encode((object) []); ?>;
            let submitForm = $('#submitForm');
            let resetForm = $('#resetForm');
            for (const key in userInfo) {
                if (key == 'role' || key == 'member_type') {
                    $('select[name="'+key+'"]').find('option[value="' + userInfo[key] + '"]').attr('selected', true);
                } else {
                    submitForm.find('input[name="' + key + '"]').val(userInfo[key]);
                    resetForm.find('input[name="' + key + '"]').val(userInfo[key]);
                }
            }
        }

        $('#submitBtn').click(function() {
            $('#submitForm').submit();
        });
        $('#clearBtn').click(function(){
            $('#resetForm').submit();
        });
    });
</script>
@endsection
