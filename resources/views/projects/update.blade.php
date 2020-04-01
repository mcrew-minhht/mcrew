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
            <form action="{{route('updateProject')}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{$projectInfo->id}}">
                <input type="hidden" name="userId" id="userId" >
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$projectInfo->name}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select multiple class="form-control" name="user[]" required=""  id="multiselect" >
                                @if(isset($users))
                                @foreach ($users as $k=>$item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                @endif

                            </select>
                            @error('role')
                            <div class="alert alert-danger"></div>
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
        </div>
    </div>
    @if(isset($userProject))
        <form action="{{asset('projects/remove/user')}}" method="post"  id="removeForm">
            <input type="hidden" name="idProject" value="{{$projectInfo->id}}">
            <input type="hidden" name="id">
            @csrf
        </form>
        <div class="card">
            <div class="card-header">
                <strong class="card-title">List User Project</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="listUser">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Identity</th>
                            <th class="text-center">Phone Number</th>
                            <th class="text-center">Current Address</th>
                            <th class="text-center">Birthday</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($userProject))
                        @foreach($userProject as $i)
                        <tr data-id="{{$i->id}}">
                            <td >{{$i->name}}</td>
                            <td>{{$i->email}}</td>
                            <td>{{$i->identity}}</td>
                            <td>{{$i->phone_number}}</td>
                            <td>{{$i->current_address}}</td>
                            <td>{{explode(' ', $i->birthday)[0]}}</td>
                            <td class="t-center">
                                <btn class="btn btn-danger removeBtn" user-id="{{$i->id}}">Delete</btn>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center">
                            <td colspan="7">No Data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
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
