@extends('pdfMaster')

@section('css')
<style>

</style>
@endsection

@section('content')
    <h2 class="d-ib w-20pc t-center m-0">{{$month}}</h2>
    <h2 class="d-ib w-60pc t-center m-0">Work Time</h2>

    <div class="mt-40">
        <div class="d-ib bb-o1  w-40pc">
            <p class="d-ib w-20pc m-0">Company:</p>
            <p class="d-ib w-70pc t-center m-0">MCREW-TECH</p>
        </div>
    </div>
    <div class="mt-20">
        <div class="d-ib bb-o1  w-40pc">
            <p class="d-ib w-20pc m-0">Name:</p>
            <p class="d-ib w-70pc t-center m-0">{{$name}}</p>
        </div>
    </div>
    <table class="table-o1 mt-20">
        <thead>
            <tr>
                <th class=" b-o1 w-20pc t-center">Day</th>
                <th class=" b-o1 w-20pc t-center">Day of the week</th>
                <th class=" b-o1 w-20pc t-center">Time of work(h)</th>
                <th class=" b-o1 w-40pc t-center">Memo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($result as $i)
                <tr>
                    <td class=" t-center b-o1">{{ $i['day'] }}</td>
                    <td class=" t-center b-o1">{{ $i['dayOfWeek'] }}</td>
                    <td class=" t-center b-o1">{{ $i['time'] }}</td>
                    <td class=" b-o1">&nbsp;{{ $i['projectName'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class=" t-center b-o1">Total:</td>
                <td class=" t-center b-o1">{{$totalWorkTime}}</td>
                <td class=" b-o1"></td>
            </tr>
        </tbody>
    </table>
@endsection