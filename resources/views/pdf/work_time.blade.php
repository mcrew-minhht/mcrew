<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    @if(isset($result))
    <div class="card">
        <input name="monthYear" type="hidden" value='{{$month}}'>
        <div class="card-header">
            <strong class="card-title">{{ $month }}</strong>
        </div>
        <div class="card-body">
            <div class="pull-right mb-1d25e">
                <button type="button" class="btn btn-sm btn-primary mr-10 editModeBtn toggleE1">Edit Mode</button>
                <button type="button" class="btn btn-sm btn-primary toggleE1">Export PDF</button>
                <button type="button" class="btn btn-sm btn-danger mr-10 toggleE2 resetBtn">Reset</button>
                <button type="submit" class="btn btn-sm btn-success toggleE2">Save</button>
            </div>
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
    </div>
    @endif
    </section>
</body>

</html>