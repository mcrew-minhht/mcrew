@extends('master')

@section('pageTitle', 'MCREW TECH')

@section('content')
<section class="content">
    <form action="{{asset('customers/search')}}" method="get" id="resetForm">
    </form>
    <form action="{{asset('customers/search/submit')}}" method="POST" id="submitForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search Customer</strong>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', '')}}" maxlength="100">
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
    @if(isset($list))
    <form action="{{asset('customers/detail')}}" method="post"  id="detailForm">
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
                        <th style="width: 10%; text-align: center"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($list))
                    @foreach($list as $i)
                    <tr>
                        <td>{{$i->name}}</td>
                        <td class="t-center">
                            <btn class="btn btn-info detailBtn" data-id="{{$i->id}}">Detail</btn>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="text-center">
                        <td colspan="2">No Data</td>
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
        $('#clearBtn').click(function(){
            $('#resetForm').submit();
        });
        $('.detailBtn').click(function(){
            $('#detailForm').find('input[name="id"]').val($(this).attr('data-id'));
            $('#detailForm').submit();
        });
    });
</script>
@endsection
