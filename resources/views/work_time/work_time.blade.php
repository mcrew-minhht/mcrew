@extends('master')

@section('css')
<style>
    .toggleE2 {
        display: none;
    }
</style>
@endsection

@section('content')
<section class="content">
    <form action="{{asset('work_time/search')}}" method="POST" id="searchForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search</strong>
            </div>
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Month</label>
                            <input type="month" class="form-control" name="month" value="" required>
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
    @if(isset($result))
    <div class="card">
        <form action="{{asset('work_time/search')}}" method="POST" id="pdfDownloadForm">@csrf
            <input type="hidden" name="isDownloadPdf" value="true">
            <input type="hidden" name="month" value="{{ $month }}">
        </form>
        <form action="{{asset('work_time/save')}}" method="POST" id="saveForm">@csrf
            <input name="monthYear" type="hidden" value='{{$month}}'>
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong class="card-title m-0">{{ $month }}</strong>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary mr-10 editModeBtn toggleE1">Edit Mode</button>
                    <button type="button" class="btn btn-primary toggleE1 pdfDBtn">Export PDF</button>
                    <button type="button" class="btn btn-danger mr-10 toggleE2 resetBtn">Reset</button>
                    <button type="submit" class="btn btn-success toggleE2">Save</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Day Of Week</th>
                            <th>Time Of Work(h)</th>
                            <th>Project</th>
                        </tr>
                    </thead>
                    <tbody id="dynamicBody1">
                        @if( count($result) )
                        @foreach( $result as $i )
                        <tr>
                            <td>{{ $i['day'] }}</td>
                            <td>{{ $i['dayOfWeek'] }}</td>
                            <td>
                                <span class="toggleE1">{{ $i['time'] }}</span>
                                <input name="time[]" type="number" class="toggleE2" value="{{ $i['time'] }}">
                            </td>
                            <td>
                                <span class="toggleE1">{{ $i['projectName'] }}</span>
                                <select name="projects[]" class="toggleE2">
                                    @foreach( $projects as $p )
                                    <option value="{{$p->id}}" {{ $i['projectID'] == $p->id ? 'selected' : '' }}>{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Total: </td>
                            <td id="timeSum">{{$totalWorkTime}}</td>
                            <td></td>
                        </tr>
                        @else
                        <tr>
                            <td>No Data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    @endif
</section>
@endsection

@section('js')
<script>
    var WORK_TIME = {};
    var result = <?php
                    if (isset($result)) {
                        echo json_encode($result);
                    } else {
                        echo '';
                    }
                    ?>;
    var totalWorkTime = <?php
                        if (isset($totalWorkTime)) {
                            echo $totalWorkTime;
                        } else {
                            echo '';
                        }
                        ?>;
    var projects = <?php
                    if (isset($projects)) {
                        echo json_encode($projects);
                    } else {
                        echo '';
                    }
                    ?>;
                    
    WORK_TIME.reset = function() {
        $('button.resetBtn').click(function() {
            $('tbody#dynamicBody1 tr').remove();

            result.forEach(function(item, index) {
                let projectName = item.projectName ? item.projectName : '';
                $('tbody#dynamicBody1').append(`
                    <tr>
                        <td>` + item.day + `</td>
                        <td>` + item.dayOfWeek + `</td>
                        <td>
                            <span class="toggleE1">` + item.time + `</span>
                            <input name="time[]" type="number" class="toggleE2" value="` + item.time + `">
                        </td>
                        <td>
                            <span class="toggleE1">` + projectName + `</span>
                            <select name="projects[]" class="toggleE2" data-day="` + item.day + `" data-value="` + item.projectID + `">
                            </select>
                        </td>
                    </tr>
                `);

                projects.forEach(function(item2, index2) {
                    let isSelected = item.projectID == item2.id ? 'selected' : '';
                    $('select[data-day="' + item.day + '"]').append(`
                        <option value="` + item2.id + `" ` + isSelected + `>` + item2.name + `</option>
                    `);
                });
            });

            $('tbody#dynamicBody1').append(`
                <tr>
                    <td colspan="2">Total: </td>
                    <td>` + totalWorkTime + `</td>
                    <td></td>
                </tr>
            `);

            $('span.toggleE1').css('display', 'inline');
            $('button.toggleE1').css('display', 'inline-block');
            $('button.toggleE2, input.toggleE2, select.toggleE2').css('display', 'none');

            WORK_TIME.sum();
        });
    };

    WORK_TIME.sum = function() {
        $('input[name="time[]"]').change(function() {
            let sum = 0;
            $('input[name="time[]"]').each(function(index) {
                sum += parseFloat($(this).val());
            });
            $('td#timeSum').html(sum);
        });
    };
    $(document).ready(function() {
        WORK_TIME.reset();
        WORK_TIME.sum();
        
        $('button.editModeBtn').click(function() {
            $('input.toggleE2, select.toggleE2, button.toggleE2').css('display', 'inline-block');
            $('span.toggleE1, button.toggleE1').css('display', 'none');
        });
        
        $('button.pdfDBtn').click(function() {
            $('form#pdfDownloadForm').submit();
        });

    });
</script>
@endsection