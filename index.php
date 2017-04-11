<?php include "function.php";?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Timezone Conversion | Differences</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <!-- App css style -->
    <link rel="stylesheet" href="css/style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="container">
    <h1 class="text-center"><span class="label label-success">Carbon DateTime</span> | <span class="label label-warning">Timezone Conversion</span> | <span class="label label-primary">Date Differences</span></h1>
    <div>&nbsp;</div>

    <div class="row">
        <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th colspan="2" style="" class="success">Server Info</th>
                </tr>
                <tr>
                    <th>Timezone</th> <td><?php echo $server_tz;?></td>
                </tr>
                <tr>
                    <th>Timezone Offset</th> <td><?php echo $server_offset;?></td>
                </tr>
                <tr>
                    <th>Current Date and Time</th><td><?php echo $server_current_dt;?></td>
                </tr>
                <tr>
                    <th colspan="2" style="" class="success">Event Info</th>
                </tr>
                <tr>
                    <th>Timezone</th> <td><?php echo $event_tz;?></td>
                </tr>
                <tr>
                    <th>Timezone Offset</th> <td><?php echo $event_offset;?></td>
                </tr>
                <tr>
                    <th>Current Date and Time</th><td><?php echo $event_current_dt;?></td>
                </tr>
                <tr>
                    <th>Event Close Date</th><td><?php echo $event_close_date;?></td>
                </tr>
                <tr>
                    <th colspan="2" class="success">Conversion</th>
                </tr>
                <tr>
                    <th>Event Close Date (Server)</th><td><?php echo $event_close_date_server;?></td>
                </tr>
                <tr>
                    <th colspan="2" style="" class="success">Differences</th>
                </tr>
                <tr>
                    <th>Time left (As per Event TZ)</th>
                    <td><?php echo $human_readable_diff_server;?></td>
                </tr>
                <tr>
                    <th>Countdown</th>
                    <td>
                        <ul id="jqtimer" class="jquerytimer">
                            <li><span class="days">00</span><p class="days_text">Days</p></li>
                            <li class="seperator">:</li>
                            <li><span class="hours">00</span><p class="hours_text">Hours</p></li>
                            <li class="seperator">:</li>
                            <li><span class="minutes">00</span><p class="minutes_text">Minutes</p></li>
                            <li class="seperator">:</li>
                            <li><span class="seconds">00</span><p class="seconds_text">Seconds</p></li>
                        </ul>
                        <div class="close_now" id="jqtimer_finished"></div>
                    </td>
                </tr>

            </table>
            <span>*TZ = Timezone</span><br />
            <span>*Please install require dependency (nesbot/carbon) via Packagist.</span> <br />
            <span class="small">Feel free to change event(local)/server timezone or datetime to explore how timezone conversion works!</span>

        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/countdown.min.js"></script>
    <script type="text/javascript">
        $("#jqtimer").countdown({
                date: "<?php echo $event_close_date_server;?>",
                offset: 10,
                day: 'Day',
                days: 'Days'
        }, function () {
                $("#jqtimer").css('display','none');
                $("#jqtimer_finished").css('display','block');
                $("#jqtimer_finished").html("<span>CLOSED</span>");
        });
    </script>

  </body>
</html>
