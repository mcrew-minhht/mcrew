@extends('master')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">REGISTER COMPANY</h3>
            </div>
            <form action="{{asset('companies/regist/save')}}" method="POST" class="form-horizontal">@csrf
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
                        <label>Password</label>
                        <input type="text" class="form-control" name="password" value="{{old('password', '')}}">
                        @error('password')
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
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label>Birthday</label>
                        <input type="date" class="form-control" name="birthday" value="{{old('birthday', '')}}">
                        @error('birthday')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Join Company Date</label>
                        <input type="date" class="form-control" name="join_company_date" value="{{old('join_company_date', '')}}">
                        @error('join_company_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col col-md-4">
                        <label>Company Staff Date</label>
                        <input type="date" class="form-control" name="company_staff_date" value="{{old('company_staff_date', '')}}">
                        @error('company_staff_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label>Role</label>
                        <select  class="form-control" name="role">
                            <option value="0" {{old('role', '') == '0' ? 'selected' : ''}}>Admin</option>
                            <option value="1" {{old('role', '') == '1' ? 'selected' : ''}}>Staff</option>
                        </select>
                        @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary float-right">Register</button>
                </div>
            </form>
        </div>
    </section>
@endsection
