@extends('master')

@section('pageTitle', 'MCREW TECH')
@section('css')
<style>
    .btn-default{
        background-color: #E3E3E3;
        border-color: #E3E3E3;
    }
</style>
@endsection
@section('content')
    <section class="content">
        <form action="salary/search" method="get" id="resetForm">
        </form>
        <form action="{{route('searchSalary')}}" method="POST" id="searchForm">
            @csrf
            <div class="card">
                <div class="card-header">
                <strong class="card-title">Search Salary</strong>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label>User name</label>
                                <input type="text" class="form-control" name="nameSearch" value="{{old('nameSearch', '')}}">
                                @error('nameSearch')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label>Salary</label>
                                <input type="text" class="form-control" name="salarySearch" value="{{old('salarySearch', '')}}">
                                @error('salarySearch')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button"  class="btn btn-default pull-right mr-2 clear">Clear</button>
                        <button class="btn btn-primary">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if(isset($list))
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Search list</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center">No.</th>
                            <th class="text-center">User name</th>
                            <th class="text-center">Base salary</th>
                            <th class="text-center">Salary</th>
                            <th style="width: 10%; text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($list))
                            @foreach($list as $k=> $vList)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td class="nameProject">{{ $vList->name }}</td>
                                    <td class="nameProject">{{ number_format($vList->base_salary,0,',',',') }}</td>
                                    <td class="nameProject">{{ number_format($vList->salary,0,',',',') }}</td>
                                    <td>
                                        <div class="perfect-center-ctn">
                                            <a href="{{ route('detailSalary',$vList->id) }}" class="btn-sm btn-info detailSalary">Detail</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="5">No Data</td>
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
        $('.clear').click(function(){
             $('#resetForm').submit();
        });
    });
</script>
@endsection
