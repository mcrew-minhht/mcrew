@extends('master')

@section('css')
<style>
    .toggleE2 {
        display: none;
    }
    thead th span{
        cursor: pointer;
    }
    #status{
        display: none;
    }
</style>
@endsection

@section('content')
<?php
$role = Auth::user()->role;
$preventMember = $role == Constants::USER_ROLE_MEMBER
?>
<section class="content">
    <form action="work_time" method="get" id="resetForm">
    </form>
    <form action="{{asset('work_time/search')}}" method="POST" id="searchForm">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Search</strong>
            </div>
            <div class="card-body">
                @csrf
                @if(!$preventMember)
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Target</label>
                            <select name="target" class="form-control">
                                @foreach($targetSelectData as $k=>$i)

                                <option value="{{$k}}" {{ old('target', '') == $k ? 'selected' : ''}}>{{$i}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>Month</label>
                            <input type="month" class="form-control" name="month" value="{{old('month', '')}}" required>
                            @error('month')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4 nameInputCtn">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', '')}}">
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
                    <button class="btn btn-primary pull-right">
                        search
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if(isset($result) || isset($grandResult))
    <form action="{{asset('work_time/search')}}" method="POST" id="pdfDownloadForm">@csrf
        <input type="hidden" name="isDownloadPdf" value="true">
        <input type="hidden" name="month" value="{{ isset($month) ? $month : '' }}">
        <input type="hidden" name="userId" value="{{ isset($userId) ? $userId : '' }}">
        <input type="hidden" name="userName" value="{{ isset($userName) ? $userName : '' }}">
    </form>
    @endif

    @if(isset($result))
    <div class="card">
        <form action="{{asset('work_time/save')}}" method="POST" id="saveForm">@csrf
            <input name="monthYear" type="hidden" value='{{$month}}'>
            <input name="userId" type="hidden" value='{{$userId}}'>
            <input type="hidden" name="userName" value="{{ $userName }}">
            <input type="hidden" id="project" name="project" value="">
            <input type="hidden" id="id" name="id" value="">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong class="card-title m-0">{{ $month }}/{{ $userName }}</strong>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary mr-10 editModeBtn toggleE1">Edit Mode</button>
                    <button type="button" class="btn btn-primary toggleE1 pdfDBtn">Export PDF</button>
                    <button type="button" class="btn btn-danger mr-10 toggleE2 resetBtn">Reset</button>
                    <button type="submit" class="btn btn-success toggleE2">Save</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered w-m-700p">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Day Of Week</th>
                            <th>Time Of Work(h)</th>
                            <th>Project</th>
                            @if (Auth::user()->role == 1)
                            <th>Status
                                <span id="status">
                                    <span>(</span>
                                    <span id="hide-status-all">
                                        <span id="text-hide">Hide</span>
                                        <input type="checkbox" hidden id="hide-all">
                                    </span>/
                                    <span id="show-status-all">
                                        <span id="text-show">Show</span>
                                        <input type="checkbox" hidden id="show-all">
                                    </span
                                    <span>)</span>
                                </span>
                            </th>
                            @endif
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
                                <input name="time[]" @if ($i['status'] == 0) disabled @endif type="number" style="display:none" class="toggleE2" value="{{ $i['time'] }}">
                            </td>
                            <td>
                                @foreach (($i['projectName']) as $item)
                                    <span class="toggleE1">{{ $item->name }}</span><br>
                                @endforeach
                                <input type="hidden" class="id" value="{{ $i['id'] }}">
                                <select name="projects[]" multiple  class="toggleE2 multiple" style="display:none">
                                    @foreach( $projects as $p )
                                    <option @if ($i['status'] == 0) disabled @endif value="{{$p->id}}" {{ $i['projectID'] == $p->id ? 'selected' : '' }}>{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            @if (Auth::user()->role == 1)
                            <td>
                                @if ( $i['status'] == 0)
                                <span class="radio-status">
                                    <span class="statusWorkTime" status-id="1">Show</span>
                                    <input class="setStatus" type="text" hidden value="0" name="status[]" >
                                </span>
                                @else
                                <span class="radio-status">
                                    <span class="statusWorkTime" status-id="0">Hide</span>
                                    <input class="setStatus" type="text" hidden value="1" name="status[]" >
                                </span>
                                @endif
                            </td>
                            @endif
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

    @if(isset($grandResult))
    <form action="{{asset('work_time/search')}}" id="toODF" method="post">@csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="userId" value="">
        <input type="hidden" name="userName" value="">
    </form>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong class="card-title m-0">{{ $month }}/Search/{{ $searchName }}</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-primary toggleE1 pdfDBtn3 {{ count($grandResult) ? '' : 'd-n'}}" data-month="{{$month}}" data-userId="{{$listUID}}">Export PDF</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered w-m-700p">
                <thead>
                    <tr>
                        <th class="w-400p">Name</th>
                        <th class="w-300p">Total Time</th>
                        <th class="w-100p"></th>
                        <th class="w-100p"></th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($grandResult) )
                    @foreach( $grandResult as $i )
                    <tr>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->total_time }}</td>
                        <td class="t-center"><button class="btn btn-primary w-80p pdfDBtn2" data-month="{{$month}}" data-userId="{{$i->user_id}}" data-userName="{{$i->name}}">Pdf</button></td>
                        <td class="t-center"><button class="btn btn-default w-80p toODB" data-userId="{{$i->user_id}}" data-userName="{{$i->name}}">Detail</button></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="t-center">No Data</td>
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
    var totalGrandResult = <?php $a1 = isset($grandResult) ? count($grandResult) : 0; echo $a1; ?>;
    var WORK_TIME = {};
    var result = <?php
                    if (isset($result)) {
                        echo json_encode($result);
                    } else {
                        echo 'undefined';
                    }
                    ?>;
    var totalWorkTime = <?php
                        if (isset($totalWorkTime)) {
                            echo $totalWorkTime;
                        } else {
                            echo 'undefined';
                        }
                        ?>;
    var projects = <?php
                    if (isset($projects)) {
                        echo json_encode($projects);
                    } else {
                        echo 'undefined';
                    }
                    ?>;

    WORK_TIME.reset = function() {
        $('button.resetBtn').click(function() {
            $('thead tr th #status').css('display', 'none');
            $('tbody#dynamicBody1 tr').remove();

            result.forEach(function(item, index) {
                let projectName = item.projectName ? item.projectName : '';
                $('tbody#dynamicBody1').append(`
                    <tr>
                        <td>` + item.day + `</td>
                        <td>` + item.dayOfWeek + `</td>
                        <td>
                            <span class="toggleE1">` + item.time + `</span>
                            <input name="time[]" `+(item.status  == 0 ? 'disabled' : '')+` type="number" class="toggleE2" value="` + item.time + `">
                        </td>
                        <td>`+
                            console.log(projectName)

                            +`
                            <select name="projects[]" class="toggleE2" data-day="` + item.day + `" data-value="` + item.projectID + `">
                            </select>
                        </td>`+
                        (item.userId  == 1 ?
                        `<td>`+
                        (item.status == 0 ?
                        `<span class="radio-status">
                            <span class="statusWorkTime" status-id="1">Show</span>
                            <input class="setStatus" type="text" hidden value="0" name="status[]" >
                        </span>` :
                        `<span class="radio-status">
                            <span class="statusWorkTime" status-id="0">Hide</span>
                            <input class="setStatus" type="text" hidden value="1" name="status[]" >
                        </span>`)+`</td>` :'')+

                    `</tr>
                `);

                projects.forEach(function(item2, index2) {
                    let isSelected = item.projectID == item2.id ? 'selected' : '';
                    $('select[data-day="' + item.day + '"]').append(`
                        <option `+(item.status  == 0 ? 'disabled' : '')+` value="` + item2.id + `" ` + isSelected + `>` + item2.name + `</option>
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

    WORK_TIME.toggleInputNameCtn = function() {
        $('select[name="target"]').change(function() {
            if ($(this).val() == '1') {
                $('div.nameInputCtn').css('display', 'block');
            } else {
                $('div.nameInputCtn').css('display', 'none');
            }
        });
    };

    WORK_TIME.toOtherDetail = function() {
        $('button.toODB').click(function() {
            $userId = $(this).attr('data-userId');
            $userName = $(this).attr('data-userName');
            $('form#toODF input[name="userId"]').val($userId);
            $('form#toODF input[name="userName"]').val($userName);
            $('form#toODF').submit();
        });
    };
    $(document).ready(function() {
        WORK_TIME.reset();
        WORK_TIME.sum();
        WORK_TIME.toggleInputNameCtn();
        WORK_TIME.toOtherDetail();

        if ($('select[name="target"]').val() != 1) {
            $('.nameInputCtn').addClass('d-n');
        } else {
            $('.nameInputCtn').removeClass('d-n');
        };

        $('#clearBtn').click(function() {
            $('#resetForm').submit();
        });

        $('button.editModeBtn').click(function() {
            $('input.toggleE2, select.toggleE2, button.toggleE2').css('display', 'inline-block');
            $('span.toggleE1, button.toggleE1').css('display', 'none');
            $('thead tr th #status').css('display', 'inline-block');
           // $('#dynamicBody1 tr td .toggleE2').css('display', 'none');
        });

        $('button.pdfDBtn').click(function() {
            $('form#pdfDownloadForm').submit();
        });

        $('button.pdfDBtn2').click(function() {
            let month = $(this).attr('data-month');
            let userId = $(this).attr('data-userId');
            let userName = $(this).attr('data-userName');
            $('form#pdfDownloadForm input[name="month"]').val(month);
            $('form#pdfDownloadForm input[name="userId"]').val(userId);
            $('form#pdfDownloadForm input[name="userName"]').val(userName);
            $('form#pdfDownloadForm').submit();
        });

        $('button.pdfDBtn3').click(function() {
            if (totalGrandResult == 0) return;
            let month = $(this).attr('data-month');
            let userId = $(this).attr('data-userId');
            $('form#pdfDownloadForm input[name="month"]').val(month);
            $('form#pdfDownloadForm input[name="userId"]').val(userId);
            $('form#pdfDownloadForm').submit();
        });
        $('.statusWorkTime').click(function(){
            $(this).closest('.radio-status').find('input[type="text"]').val($(this).attr('status-id'));
            $(this).css('color','red');
        })
        $('#text-hide').click(function(){
            $(this).parents('#hide-status-all').find('input[type="checkbox"]').attr('checked','checked');
            $(this).css('color','red');
            if($('#hide-all').is(":checked"))
            {
                $('#text-show').css('color','');
                $("#show-all").removeAttr('checked');
                $('.radio-status').find('.setStatus').val(0);
            }
        })
        $('#text-show').click(function(){
            $(this).parents('#show-status-all').find('input[type="checkbox"]').attr('checked','checked');
            $(this).css('color','red');
            if($('#show-all').is(":checked"))
            {
                $('#text-hide').css('color','');
                $("#hide-all").removeAttr('checked');
                $('.radio-status').find('.setStatus').val(1);
            }
        })

        $('.multiple').on('click',function(){
            var id = $(this).closest('td').find('input.id').val()
            var arr = $(this).val();
            $('#saveForm').find('#project').val(arr);
            $('#saveForm').find('#id').val(id);
          })
    });
</script>
@endsection
