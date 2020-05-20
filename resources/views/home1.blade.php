<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>League Ranking</title>

    <style>
        td.td-team-name {
            padding-left: 5px;
            padding-right: 0px;
        }
        th.th-width-120 {
            width: 120px;
        }
        .container {
            font-size: 13px !important;
        }
    </style>
</head>
<body>
<input type="hidden" id="js-league-token" value="{{ $league_token }}"/>
<input type="hidden" id="js-week-no" value="1"/>

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4">
            <table class="table table-bordered table-league-ranking">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center">League Table</th>
                    </tr>
                    <tr>
                        <th class="th-width-120">Teams</th>
                        <th>PTS</th>
                        <th>P</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                    <tr>
                        <td class="td-team-name">{{ $team }}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Match Results</th>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="3">4th Week Match Result</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 40%;" class="text-right">Chelsea</td>
                        <td class="text-center">3 - 3</td>
                        <td style="width: 40%;">Liverpool</td>
                    </tr>
                    <tr>
                        <td style="width: 40%;" class="text-right">Arsenal</td>
                        <td class="text-center">3 - 3</td>
                        <td style="width: 40%;">Manchester City</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th colspan="3" class="text-center">Prediction</th>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">4th Week Prediction</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 40%;" class="text-right">Chelsea</td>
                    <td class="text-center">3 - 3</td>
                    <td style="width: 40%;">Liverpool</td>
                </tr>
                <tr>
                    <td style="width: 40%;" class="text-right">Arsenal</td>
                    <td class="text-center">3 - 3</td>
                    <td style="width: 40%;">Manchester City</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-sm-12 text-center">
            <button class="btn btn-outline-primary">
                Play All
            </button>
            <button class="btn btn-outline-primary ml-5" id="js-btn-next-week">
                Next Week
            </button>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<!-- script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("button#js-btn-next-week").click(function() {
            $.ajax({
                url: "/doNextMatch",
                type: "POST",
                data: {
                    _token: '{!! csrf_token() !!}',
                    week_no: $('#js-week-no').val(),
                    league_token: $('#js-league-token').val(),
                },
                success: function(data) {
                    $('input#js-week-no').val($('input#js-week-no').val() * 1 + 1);
                    console.log(data);
                }
            });
        });
    });
</script>
</body>
</html>