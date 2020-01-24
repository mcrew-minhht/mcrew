@extends('master')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search company</strong>
            </div>
            <div class="card-body">
                <form action="{{asset('companies/search')}}" method="POST">
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
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone', '')}}">
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{old('address', '')}}">
                                @error('address')
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
                    </div>
                    <div class="text-right">
                        <button class="btn btn-sm btn-info">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($lists))
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Search result</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 20%; text-align: center">Name</th>
                                <th style="width: 15%; text-align: center">Phone</th>
                                <th style="width: 40%; text-align: center">Address</th>
                                <th style="width: 15%; text-align: center">Email</th>
                                <th style="width: 10%; text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($lists))
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['phone']}}</td>
                                <td>{{$list['address']}}</td>
                                <td>{{$list['email']}}</td>
                                <td>
                                    <div class="perfect-center-ctn">
                                        <a href="" class="btn btn-sm btn-info">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center">No Data</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>
@endsection
