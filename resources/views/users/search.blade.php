@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
    <section class="content">

        <div class="card">
            <div class="card-header">
              <strong class="card-title">Search User</strong>
            </div>
            <div class="card-body">
                <form action="{{asset('users/search/submit')}}" method="POST" id="searchForm">
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
                                <label>Email Verified At</label>
                                <input type="text" class="form-control" name="email_verified_at" value="{{old('email_verified_at', '')}}">
                                @error('email_verified_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Birthday</label>
                                <input type="date" class="form-control" name="birthday" value="{{old('birthday', '')}}">
                                @error('birthday')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Identity</label>
                                <input type="text" class="form-control" name="identity" value="{{old('identity', '')}}">
                                @error('identity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Identity Date</label>
                                <input type="date" class="form-control" name="identity_date" value="{{old('identity_date', '')}}">
                                @error('identity_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                         
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Identity Place</label>
                                <input type="text" class="form-control" name="identity_place" value="{{old('identity_place', '')}}">
                                @error('identity_place')
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
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Current Address</label>
                                <input type="text" class="form-control" name="current_address" value="{{old('current_address', '')}}">
                                @error('current_address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                         
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Regularly Address</label>
                                <input type="text" class="form-control" name="regularly_address" value="{{old('regularly_address', '')}}">
                                @error('regularly_address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                         
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Join Company Date</label>
                                <input type="date" class="form-control" name="join_company_date" value="{{old('join_company_date', '')}}">
                                @error('join_company_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                        
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>Company Staff Date</label>
                                <input type="date" class="form-control" name="company_staff_date" value="{{old('company_staff_date', '')}}">
                                @error('company_staff_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                                                   
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
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
                    </div>
                    <div>
                      <button class="btn btn-lg btn-info btn-block">
                        search
                      </button>
                    </div>
                  </form>
            </div>
        </div>

            @if(isset($list))
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Search list</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Email Verified At</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Identity</th>
                            <th scope="col">Identity Date</th>
                            <th scope="col">Identity Place</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Current Address</th>
                            <th scope="col">Regularly Address</th>
                            <th scope="col">Join Company Date</th>
                            <th scope="col">Company Staff Date</th>
                            <th scope="col">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($list))
                                @foreach($list as $i)
                                    <tr>
                                        <th>{{$i->name}}</th>
                                        <th>{{$i->email}}</th>
                                        <th>{{$i->email_verified_at}}</th>
                                        <th>{{$i->birthday}}</th>
                                        <th>{{$i->identity}}</th>
                                        <th>{{$i->identity_date}}</th>
                                        <th>{{$i->identity_place}}</th>
                                        <th>{{$i->phone_number}}</th>
                                        <th>{{$i->current_address}}</th>
                                        <th>{{$i->regularly_address}}</th>
                                        <th>{{$i->join_company_date}}</th>
                                        <th>{{$i->company_staff_date}}</th>
                                        <th>{{$i->role}}</th>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No Data</td>
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
        $(document).ready(function () {
            
            // $('button#searchBtn').click(function(){
            //     let data = $('form#searchForm').serialize();
            //     $.ajax({
            //         url: '{{asset('users/search/submit')}}',
            //         type: 'POST',
            //         data: data,
            //         success: function(result){
            //             lResult = JSON.parse(result);
            //             console.log(lResult);
                        
            //         },
            //     });
            // });
        });
    </script>
@endsection
