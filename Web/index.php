<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>System for Wi-Fi Quality Analysis using Raspberry Pi</title>
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
        <link href="css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <header>
                    <nav>
                        <ul class="nav nav-pills pull-right">
                            <li id="button-rssi" role="presentation" class="active">
                                <a href="index.php">RSSI</a>
                            </li>
                            <li id="button-user" role="presentation">
                                <a href="index.php">USER</a>
                            </li>
                            <li id="button-data" role="presentation">
                                <a href="index.php">DATA</a>
                            </li>
                            <!-- <li id="button-spec" role="presentation">
                                <a href="spec.php">SPECTRUM</a>
                            </li> -->
                        </ul>
                    </nav>
                    <h2 class="title">System for Wi-Fi Quality Analysis using Raspberry Pi</h2>
                    <hr>
                </header>
                <div class="container">
                    <div id="chart" style="min-width: 310px; margin: 0 auto"></div>
                </div>

                <!-- <form action="data.php" id="form1" method="get" onsubmit=""> -->
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-3">
                            <div class='input-group date' id='datetimepicker1'>
                                <input id="time1" name="time1" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-1" style="text-align: center;">
                            <span class="glyphicon glyphicon-minus"></span>
                        </div>
                        <div class="col-sm-3">
                            <div class='input-group date' id='datetimepicker2'>
                                <input id='time2' name="time2" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button id="submitButton" type="submit" class="btn btn-default" style="background-color: #000;color: #fff;">Submit</button>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/moment-with-locales.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/highcharts.js"></script>
        <script type="text/javascript" src="js/exporting.js"></script>
    </body>
</html>
