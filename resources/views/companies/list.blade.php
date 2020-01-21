@extends('master')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">SEARCH USER</h3>
            </div>
            <form action="{{asset('users/regist/search')}}" method="POST" class="form-horizontal">@csrf
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name', '')}}">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email', '')}}">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Birthday</label>
                        <input type="date" class="form-control" name="birthday" value="{{old('birthday', '')}}">
                        @error('birthday')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label>Identity</label>
                        <input type="text" class="form-control" name="identity" value="{{old('identity', '')}}">
                        @error('identity')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Identity Date</label>
                        <input type="date" class="form-control" name="identity_date" value="{{old('identity_date', '')}}">
                        @error('identity_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Identity Place</label>
                        <input type="text" class="form-control" name="identity_place" value="{{old('identity_place', '')}}">
                        @error('identity_place')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" value="{{old('phone_number', '')}}">
                        @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Current Address</label>
                        <input type="text" class="form-control" name="current_address" value="{{old('current_address', '')}}">
                        @error('current_address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Regularly Address</label>
                        <input type="text" class="form-control" name="regularly_address" value="{{old('regularly_address', '')}}">
                        @error('regularly_address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary float-right">Search</button>
                </div>
            </form>
        </div>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">SEARCH RESULTS</h3>
            </div>
            <div style="overflow-x: scroll">
                <table id="bootstrap-data-table" class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Identity</th>
                        <th>Phone Number</th>
                        <th>Current Address</th>
                        <th>Birthday</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>$320,800</td>
                        <td>Tiger Nixon</td>
                        <td>Tiger Nixon</td>
                        <td class="text-center"><a href="" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>$320,800</td>
                        <td>Tiger Nixon</td>
                        <td>Tiger Nixon</td>
                        <td class="text-center"><a href="" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>$320,800</td>
                        <td>Tiger Nixon</td>
                        <td>Tiger Nixon</td>
                        <td class="text-center"><a href="" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
