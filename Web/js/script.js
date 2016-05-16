var data = "rssi";
$(function (){
    function clear()
    {
        $('#button-rssi').removeClass('active');
        $('#button-user').removeClass('active');
        $('#button-data').removeClass('active');
        $('#button-spec').removeClass('active');
    }
    $('#button-rssi').click(function(event) {
        event.preventDefault();
      data = "rssi";
      clear();
      $(this).addClass('active');
      getData();
    });
    $('#button-user').click(function(event) {
        event.preventDefault();
      data = "user";
      clear();
      $(this).addClass('active');
      getData();
    });
    $('#button-data').click(function(event) {
        event.preventDefault();
      data = "data";
      clear();
      $(this).addClass('active');
      getData();
    });
    // $('#button-spec').click(function(event) {
    //     event.preventDefault();
    //   data = "spec";
    // clear();
    // $(this).addClass('active');
    //   getData();
    // });

    // var url = "data.php?n=10&data=";
    // url = url.concat(data);
    // console.log(url);
    // getData("data.php?n=10&data=user");
    getData();

    $( "#submitButton" ).click(function(event) {
        event.preventDefault();
       getData();
    });
    setInterval(function(){
        // getData("data.php?n=10&data=user");
        getData();
    }, 60*5*1000);


function getData() {
    var url = "data.php?n=10&data=";
    url = url.concat(data);
    var value1 = document.getElementById('time1').value;
    var value2 = document.getElementById('time2').value;
    console.log(value1);
    console.log(value2);
    if(value1.length > 0 && value2.length >0){
        url = "data.php?&data="+data+"&time1="+value1+"&time2="+value2;
    }
    console.log(url);
    $.getJSON(url,function(data){
        var chart = {
            height: 600,
            type: 'line'
        };
        var xAxis = {
            categories: data.categories,
            crosshair:true
        };
        var series = data.series;

        var title = {
            text: 'Average RSSI'
        };
        var subtitle = {
            text: 'Source: Raspberry Pi 2 Model B'
        };

        var xAxis = {
            categories: data.categories,
            crosshair:true
        };

        var yAxis = {
            // title: {
            //     // text: 'RSSI (dBm)'
            //     text: 'Unit'
            // }
        };
        var tooltip = {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                // '<td style="padding:0"><b>{point.y:.1f} dBm    </b></td></tr>',
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        };
        var plotOptions = {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        };
        var credits = {
            enabled: false
        };

        var json = {};
        json.title = title;
        json.subtitle = subtitle;
        json.chart = chart;
        json.xAxis = xAxis;
        json.yAxis = yAxis;
        json.tooltip = tooltip;
        json.plotOptions = plotOptions;
        json.credits = credits;
        json.series = series;

        $('#chart').highcharts(json);

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });


    });
}

});
