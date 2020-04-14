@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
    <section class="content">
        <form action="dayoff/search" method="get" id="resetForm">
        </form>
        <form action="{{route('searchDayOff')}}" method="POST" id="searchForm">
            @csrf
            <div class="card">
                <div class="card-header">
                <strong class="card-title">Search User Name</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="form-group">
                                <label>User Name</label>
                                @if (Auth::user()->role == 1)
                                    <input type="text" class="form-control" name="name" value="{{old('name', '')}}">
                                @else
                                    <input type="text" class="form-control" readonly name="name" value="{{ Auth::user()->name }}">
                                @endif
                                @error('name')
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

    @if(isset($lists) || isset($listUsers))
    <div class="card">
        <div class="card-header">
            <h4>Lists</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="primaryWorking-tab" data-toggle="tab" href="#primaryWorking" role="tab" aria-controls="primaryWorking" aria-selected="true">List User Regist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="total-tab" data-toggle="tab" href="#total" role="tab" aria-controls="total" aria-selected="false">Total</a>
                </li>
            </ul>
            <div class="tab-content pt-10" id="myTabContent">
                <div class="tab-pane fade show active ctn-scroll-x-auto-900" id="primaryWorking" role="tabpanel" aria-labelledby="primaryWorking">
                    <!-- (^0_0^) -->
                    <script>
                        var myTabContentOriginWidth = document.getElementById('myTabContent').offsetWidth - 1;
                    </script>
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center">No.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                @if(Auth::user()->role == 1)
                                <th style="width: 10%; text-align: center"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($lists))
                            @foreach($lists as $k=> $v)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td class="nameProject">{{$v->name}}</td>
                                    <td class="nameProject">{{$v->date}}</td>
                                    <td class="nameProject">{{$v->status}}</td>
                                    @if(Auth::user()->role == 1)
                                    <td>
                                        <div class="perfect-center-ctn">
                                            <a href="{{ route('detailDayOff',$v->id) }}" class="btn-sm btn-info updateProject">Detail</a>
                                        </div>
                                    </td>
                                    @endif
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
                <div class="tab-pane fade ctn-scroll-x-auto-900" id="total" role="tabpanel" aria-labelledby="total">
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Name</th>
                                <th class="text-center" colspan="2">Holiday</th>
                            </tr>
                            <tr>
                                <th>Total number of holidays</th>
                                <th>Holiday balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($listUsers))
                                <tr>
                                    <td class="nameProject">{{$listUsers->name}}</td>
                                    <td class="nameProject">{{ $totalRegistYear }}</td>
                                    <td>{{ $totalDay }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="nameProject">{{$user->name}}</td>
                                    <td class="nameProject">0</td>
                                    <td>12</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
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
        $('#clearBtn').click(function(){
            $('#resetForm').submit();
        });
    });
</script>
@endsection
