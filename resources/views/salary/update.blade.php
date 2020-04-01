@extends('master')

@section('content')
@section('css')
<style>
    .selected{
        background:blue
    }
</style>
@endsection
<section class="content">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Update User</strong>
        </div>
        <div class="card-body">
            <form action="{{route('updateSalary')}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{$detailSalary->id}}">
                <input type="hidden" name="userId" value="{{$detailSalary->user_id}}">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>User name</label>
                            <input type="text" class="form-control" disabled value="{{$detailSalary->name}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Base salary</label>
                            <input type="text" class="form-control" name="baseSalary" value="{{$detailSalary->base_salary}}">
                            @error('baseSalary')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" class="form-control" name="salary" value="{{$detailSalary->salary}}">
                            @error('salary')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer-o1">
            <button class="btn btn-primary pull-right" id="submitBtn">
                Submit
            </button>
            <a href="javscript:void(0)" class="btn btn-default pull-right mr-2 reset">Cancel</a>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#submitBtn').click(function(){
            arrayUsername = [];
            $('#listUser').find('tr.selected').each(function() {
                arrayUsername.push($(this).data('id'))
            });
            $('#userId').val(arrayUsername);
            $('#submitForm').submit();
        });
        $('.removeBtn').click(function(){
            $('#removeForm').find('input[name="id"]').val($(this).attr('user-id'));
            $('#removeForm').submit();
        });
    });

    $('#listUser tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });

</script>
@endsection
