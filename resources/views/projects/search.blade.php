@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
    <section class="content">
        <form action="{{route('searchProject')}}" method="POST" id="searchForm">
            <div class="card">
                <div class="card-header">
                <strong class="card-title">Search User</strong>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-xs-6 col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name', '')}}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer-o1">
                    <button class="btn btn-primary pull-right">
                        Search
                    </button>
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
                                            <a href="javascript:void(0)"  data-id="{{$vProject->id}}" class="btn btn-info modelUpdateProject">Update</a>
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
            <div class="modal fade modal headerModal" id="sProjectModal" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center bold">Delete the resource confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center font-s12">
                            <form action="{{asset('projects/update')}}" method="post" id="uProjectForm">
                                @csrf
                                <p>
                                    <input type="text" class="form-control" name="project_name">
                                </p>
                                <div class="clearfix"></div>
                                <div class="d-flex-justify-center">
                                    <input type="hidden" name="project_id">
                                    <button type="button" class="btn btn-violet" data-dismiss="modal">Cancel</button>
                                    <button  class="btn btn-violet mr-5">Ok</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
