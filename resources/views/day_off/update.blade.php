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
            <form action="{{route('updateDayOff',$dateOff->id)}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{$dateOff->id}}">
                <input type="hidden" name="userId" id="userId" >
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="date" class="form-control" name="date" value="{{$dateOff->date}}">
                            @error('date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer-o1 text-right">
            <button type="button" class="btn btn-default" id="clearBtn">
                Clear
            </button>
            <button class="btn btn-primary pull-right" id="submitBtn">
                Update
            </button>
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
        $('#clearBtn').click(function(){
            $('#submitForm').trigger("reset");
            $('.alert').hide();
        });
    });

    $('#listUser tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });

</script>
@endsection
