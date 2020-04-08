@extends('master')

@section('pageTitle', 'MCREW TECH')
@section('css')
    <style>
        .b-grey{
            background: #B5B5B5 !important;
        }
    </style>
@endsection
@section('content')
<section class="content" id="test1">
    <form action="salary/calc" method="get" id="resetForm">
    </form>
    <form action="{{asset('salary/calc/search')}}" method="POST" id="submitForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Salary Calculation</strong>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    @if($adFeature)
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Member Type</label>
                            <select class="form-control" name="member_type">
                                <option value=""></option>
                                @foreach($member_types as $i)
                                    <option value="{{$i->id}}" {{ old('member_type', '') == $i->id ? 'selected' : '' }}>{{$i->name}}</option>
                                @endforeach
                            </select>
                            @error('member_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', '')}}" maxlength="100">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Month Of Year</label>
                            @if (isset($month))
                            <input type="month" class="form-control" name="monthYear" id="datePicker" value="{{ $month }}">
                            @else
                            <input type="month" class="form-control" name="monthYear" id="datePicker" value="{{old('monthYear','')}}">
                            @endif
                            @error('monthYear')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default" id="clearBtn">
                        Clear
                    </button>
                    <button class="btn btn-primary" id="searchCalc">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if(isset($workTime))
    <div class="card">
        <div class="card-header">
            <h4>Result</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="primaryWorking-tab" data-toggle="tab" href="#primaryWorking" role="tab" aria-controls="primaryWorking" aria-selected="true">Primary Working</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="otWorking-tab" data-toggle="tab" href="#otWorking" role="tab" aria-controls="otWorking" aria-selected="false">OT Working</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="total-tab" data-toggle="tab" href="#total" role="tab" aria-controls="total" aria-selected="false">Total</a>
                </li>
            </ul>
            <?php $dayGroupCount = count($dayGroup); ?>
            <div class="tab-content pt-10" id="myTabContent">
                <div class="tab-pane fade show active ctn-scroll-x-auto-900" id="primaryWorking" role="tabpanel" aria-labelledby="primaryWorking">
                    <!-- (^0_0^) -->
                    <script>
                        var myTabContentOriginWidth = document.getElementById('myTabContent').offsetWidth - 1;
                    </script>
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th class="w-200p" rowspan="2">Name</th>
                                <th class="t-center" colspan="{{$dayGroupCount}}" style="width: {{60 * $dayGroupCount}}px">{{$monthText}}</th>
                            </tr>
                            <tr>
                                @foreach($dayGroup as $dg)
                                    @if ($dg[1] == 6 || $dg[1] == 0)
                                        <th class="t-center bg-secondary">{{$dg[0]}}</th>
                                    @else
                                        <th class="t-center">{{$dg[0]}}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workTime as $wt)
                            <tr>
                                <td>{{$wt['userName']}}</td>
                                @foreach($wt['data'] as $wti)
                                <td class="t-center">{{ !$wti['isWeekend'] ? ($wti['time'] > 8 ? 8 : $wti['time']) : 0 }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            @if(empty($workTime))
                            <td class="t-center" colspan="{{count($dayGroup) + 1}}">No Data</td>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade ctn-scroll-x-auto-900" id="otWorking" role="tabpanel" aria-labelledby="otWorking">
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th class="w-200p" rowspan="2">Name</th>
                                <th class="t-center" colspan="{{$dayGroupCount}}" style="width: {{60 * $dayGroupCount}}px">{{$monthText}}</th>
                            </tr>
                            <tr>
                                @foreach($dayGroup as $dg)
                                    @if ($dg[1] == 6 || $dg[1] == 0)
                                        <th class="t-center bg-secondary">{{$dg[0]}}</th>
                                    @else
                                        <th class="t-center">{{$dg[0]}}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workTime as $wt)
                            <tr>
                                <td>{{$wt['userName']}}</td>
                                @foreach($wt['data'] as $wti)
                                <?php
                                $time = 0;
                                if ($wti['isWeekend']) {
                                    $time = $wti['time'];
                                } else if ($wti['time'] >= 8) {
                                    $time = $wti['time'] - 8;
                                }
                                ?>
                                <td class="t-center">{{$time}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            @if(empty($workTime))
                            <td class="t-center" colspan="{{count($dayGroup) + 1}}">No Data</td>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade ctn-scroll-x-auto-900" id="total" role="tabpanel" aria-labelledby="total">
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th class="t-x-y-center w-200p" rowspan="3">Name</th>
                                <th class="t-x-y-center w-150p" rowspan="3">Lương Cơ Bản</th>
                                <th class="t-x-y-center w-100p" rowspan="3">Ngày Công</th>
                                <th class="t-x-y-center w-400p" colspan="3">Phụ Cấp</th>
                                <th class="t-x-y-center w-150p" rowspan="3">Thu Nhập Theo Ngày Công Thực Tế</th>
                                <th class="t-x-y-center w-400p" colspan="3">Tăng Ca</th>
                                <th class="t-x-y-center w-150p" rowspan="3">Thưởng</th>
                                <th class="t-x-y-center w-150p" rowspan="3">Tổng Thu Nhập Tháng</th>
                                <th class="t-x-y-center w-400p" colspan="4">Các Khoản Khấu Trừ Vào Lương</th>
                                <th class="t-x-y-center w-500p" colspan="5">Thuế thu nhập cá nhân</th>
                            </tr>
                            <tr>
                                <th class="t-x-y-center" rowspan="2">Lương năng suất lao động</th>
                                <th class="t-x-y-center" rowspan="2">Tiền cơm</th>
                                <th class="t-x-y-center" rowspan="2">Tổng</th>
                                <th class="t-x-y-center" rowspan="2">Giờ công</th>
                                <th class="t-x-y-center" rowspan="2">Lương giờ</th>
                                <th class="t-x-y-center" rowspan="2">Thành tiền</th>
                                <th class="t-x-y-center">BHXH</th>
                                <th class="t-x-y-center">BHYT</th>
                                <th class="t-x-y-center">BHTN</th>
                                <th class="t-x-y-center">Số tiền</th>
                                <th class="t-x-y-center" colspan="2">Giảm trừ phụ thuộc</th>
                                <th class="t-x-y-center" rowspan="2">TN không chịu thuế</th>
                                <th class="t-x-y-center" colspan="2">Thuế TNCN</th>
                            </tr>
                            <tr>
                                <th class="t-x-y-center">8%</th>
                                <th class="t-x-y-center">1.5%</th>
                                <th class="t-x-y-center">1%</th>
                                <th class="t-x-y-center">10.5%</th>
                                <th class="t-x-y-center">Số người</th>
                                <th class="t-x-y-center">Số tiền</th>
                                <th class="t-x-y-center">TN chịu thuế</th>
                                <th class="t-x-y-center">Thuế TNCN tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workTime as $wt)
                            <tr>
                                <td>{{$wt['userName']}}</td><!-- 0 -->
                                <td>{{$wt['base_salary']}}</td><!-- 1 -->
                                <td>{{$wt['primaryWorkDay']}}</td><!-- 2 -->
                                <?php $laborProductivitySalary = $wt['salary'] - Constants::LUNCH_VALUE; ?>
                                <td>{{$laborProductivitySalary}}</td><!-- 3 -->
                                <td>{{Constants::LUNCH_VALUE}}</td><!-- 4 -->
                                <td>{{$wt['salary']}}</td><!-- 5 -->
                                <?php $primaryIncome = round($wt['salary'] * ($wt['primaryWorkDay'] / $totalDayNotWeekend)) ?>
                                <td>{{ $primaryIncome }}</td><!-- 6 -->
                                <td>{{$wt['otTime']}}</td><!-- 7 -->
                                <?php $otSalaryPerHour = round($laborProductivitySalary / ($totalDayNotWeekend * 8)) ?>
                                <td>{{ $otSalaryPerHour }}</td><!-- 8 -->
                                <?php $otIncome = $wt['otTime'] * $otSalaryPerHour ?>
                                <td>{{ $otIncome }}</td><!-- 9 -->
                                <?php $bonus = 0 ?>
                                <td>{{$bonus}}</td><!-- 10 -->
                                <?php $totalIncome = $primaryIncome + $otIncome + $bonus ?>
                                <td>{{ $totalIncome }}</td><!-- 11 -->
                                <td>{{ $wt['base_salary'] * Constants::BHXH }}</td><!-- 12 -->
                                <td>{{ $wt['base_salary'] * Constants::BHYT }}</td><!-- 13 -->
                                <td>{{ $wt['base_salary'] * Constants::BHTN }}</td><!-- 14 -->
                                <?php $totalInsurance = $wt['base_salary'] * Constants::BH_TOTAL ?>
                                <td>{{ $totalInsurance }}</td><!-- 15 -->
                                <td>{{ $wt['number_of_dependents'] }}</td><!-- 16 -->
                                <?php $totalDependentPeopleFee = $wt['number_of_dependents'] * Constants::DEPENDENT_PERSON ?>
                                <td>{{ $totalDependentPeopleFee }}</td><!-- 17 -->
                                <td>{{ $totalIncome - $totalInsurance -  $totalDependentPeopleFee }}</td><!-- 18 -->
                                <?php $taxInIncome = $totalInsurance + $totalDependentPeopleFee ?>
                                <td>{{ $taxInIncome }}</td><!-- 19 -->
                                <?php
                                $personalTax = $taxInIncome * 0.35 - 9850000;
                                if ($taxInIncome <= 5000000) {
                                    $personalTax = $taxInIncome * 0.05;
                                } else if ($taxInIncome <= 10000000) {
                                    $personalTax = $taxInIncome * 0.1 - 250000;
                                } else if ($taxInIncome <= 18000000) {
                                    $personalTax = $taxInIncome * 0.15 - 750000;
                                } else if ($taxInIncome <= 32000000) {
                                    $personalTax = $taxInIncome * 0.2 - 1650000;
                                } else if ($taxInIncome <= 52000000) {
                                    $personalTax = $taxInIncome * 0.25 - 3250000;
                                } else if ($taxInIncome <= 80000000) {
                                    $personalTax = $taxInIncome * 0.3 - 5850000;
                                }
                                ?>
                                <td>{{$personalTax}}</td>
                            </tr>
                            @endforeach
                            @if(empty($workTime))
                            <td class="t-center" colspan="21">No Data</td>
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
        if (typeof myTabContentOriginWidth != "undefined") {
            $('#primaryWorking, #otWorking, #total').css('width', myTabContentOriginWidth);
        }
        $('#clearBtn').click(function() {
            $('#resetForm').submit();
        });
    });
</script>
@endsection
