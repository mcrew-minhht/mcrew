@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
    <section class="content">
        <form action="{{route('searchProject')}}" method="POST" id="searchForm">
            @csrf
            <div class="card">
                <div class="card-header">
                <strong class="card-title">Search project</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="nameSearch" >
                                @error('nameSearch')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if(isset($list))
        <form action="{{asset('projects/detail')}}" method="post"  id="detailForm">
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
                            <th>No.</th>
                            <th class="text-center">Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($list))
                            @foreach($list as $k=> $vProject)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td class="nameProject">{{$vProject->name}}</td>
                                    <td>
                                        <div class="perfect-center-ctn">
                                            <a href="{{route('detailProject',$vProject->id)}}" class="btn btn-info updateProject">Update</a>
                                        </div>
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
        $('.updateProject').click(function(){
            $('#detailForm').find('input[name="id"]').val($(this).attr('project-id'));
            $('#detailForm').submit();
        });
    });
</script>
@endsection
