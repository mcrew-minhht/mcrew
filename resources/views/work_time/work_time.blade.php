@extends('master')

@section('content')
<section class="content">
    <form action="{{asset('work_time/search')}}" method="POST" id="searchForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search User</strong>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Month</label>
                            <input type="month" class="form-control" name="month" value="">
                            @error('month')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer-o1">
                <button class="btn btn-primary pull-right">
                    search
                </button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Work Time</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
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
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>
                            <div class="perfect-center-ctn">
                                <a href="" class="btn btn-sm btn-info">Detail</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection