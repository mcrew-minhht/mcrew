@extends('master')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Change Password</strong>
        </div>
        <div class="card-body">
            <form action="{{asset('users/password')}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{old('id', '')}}">
                <div class="row">
                    <div class="col-xs-6 offset-md-4 col-md-4">
                        <div class="form-group">
                            <label>Current password</label>
                            <input type="password" class="form-control" name="oldPassword">
                            @error('oldPassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 offset-md-4 col-md-4">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 offset-md-4 col-md-4">
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" class="form-control" name="confirmPassword">
                            @error('confirmPassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-right">
                <button  class="btn btn-default" id="clearBtn">
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
            $('#submitForm').trigger("reset");
            $('.alert').hide();
        });
    });
</script>
@endsection
