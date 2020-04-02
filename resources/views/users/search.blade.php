@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
<section class="content">
    <form action="users/search" method="get" id="resetForm">
    </form>
    <form action="{{asset('users/search/submit')}}" method="POST" id="searchForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search User</strong>
            </div>
            <div class="card-body">
                @csrf
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
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" value="{{old('phone_number', '')}}">
                            @error('phone_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default" id="clearBtn">
                        Clear
                    </button>
                    <button class="btn btn-primary">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if(isset($list))
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
                        <th style="width: 50px"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($list))
                    @foreach($list as $i)
                    <tr>
                        <td>{{$i->name}}</td>
                        <td>{{$i->email}}</td>
                        <td>{{$i->identity}}</td>
                        <td>{{$i->phone_number}}</td>
                        <td>{{$i->current_address}}</td>
                        <td>{{explode(' ', $i->birthday)[0]}}</td>
                        <td class="text-center">
                            <btn class="btn-sm btn-info detailBtn" user-id="{{$i->id}}">Detail</btn>
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
            $('.detailBtn').click(function(){
                $('#detailForm').find('input[name="id"]').val($(this).attr('user-id'));
                $('#detailForm').submit();
            });
            $('#clearBtn').click(function() {
                $('#resetForm').submit();
            });
        });
    </script>
@endsection
