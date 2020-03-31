@extends('master')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Update User</strong>
        </div>
        <div class="card-body">
            <form action="{{route('updateProject')}}" method="POST" id="submitForm">
                @csrf
                <input type="hidden" name="id" value="{{$projectInfo->id}}">
                <div class="row">
                    <div class="col-xs-6 col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$projectInfo->name}}">
                            @error('name')
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
        </div>
    </div>
    @if(isset($users))
    <form action="{{asset('users/detail')}}" method="post"  id="detailForm">
        <input type="hidden" name="id">
        @csrf
    </form>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Search list</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
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
                    @if(count($users))
                    @foreach($users as $i)
                    <tr>
                        <td>{{$i->name}}</td>
                        <td>{{$i->email}}</td>
                        <td>{{$i->identity}}</td>
                        <td>{{$i->phone_number}}</td>
                        <td>{{$i->current_address}}</td>
                        <td>{{explode(' ', $i->birthday)[0]}}</td>
                        <td class="t-center">
                            <btn class="btn btn-info detailBtn" user-id="{{$i->id}}">Detail</btn>
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
            $('#submitForm').submit();
        });
    });
</script>
@endsection
