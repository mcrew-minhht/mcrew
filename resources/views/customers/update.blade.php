@extends('master')

@section('content')
<section class="content">
    <form action="{{asset('customers/detail')}}" method="post" id="resetForm">
        @csrf
        <input type="hidden" name="id" value="{{old('id', '')}}">
    </form>
    <form action="{{asset('customers/update')}}" method="POST" id="submitForm">
        <input type="hidden" name="id" value="{{old('id', '')}}">
        <div class="card">
            @csrf
            <div class="card-header">
                <strong class="card-title">Update Customer</strong>
            </div>
            <div class="card-body">
                <input type="hidden" name="id" value="{{old('id', '')}}">
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
        var isOrigin = '<?php echo isset($customerInfo) ?>';
        var customerInfo = null;
        if (isOrigin) {
            customerInfo = <?php if (isset($customerInfo)) echo json_encode($customerInfo);
                            else echo json_encode((object) []); ?>;
            let submitForm = $('#submitForm');
            let resetForm = $('#resetForm');
            for (const key in customerInfo) {
                submitForm.find('input[name="' + key + '"]').val(customerInfo[key]);
                resetForm.find('input[name="' + key + '"]').val(customerInfo[key]);
            }
        }
        $('#clearBtn').click(function(){
            $('#resetForm').submit();
        });
    });
</script>
@endsection