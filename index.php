<?php session_start();?>
<?php
if(!isset($_SESSION['user']))  header( "location:signin.html");

?>
<!DOCTYPE html>

<html>
<head>
	<title>售后配件库管理系统</title>
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
    <!-- bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" type="text/css" href="css/elements.css" />
    <link rel="stylesheet" type="text/css" href="css/icons.css" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="css/compiled/index.css" type="text/css" media="screen" />    



    <![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
    <?php require_once "navbar.html";?>
    <?php require_once "sidebar.html";?>
    <script type="text/javascript">
       document.getElementById('index').className = "active";

    </script>

    <?php
    header("Content-Type: text/html;charset=utf-8");
    $servername = "localhost:3306";
    $username = "root";
    $password = "123";
    $dbname = "db";
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    mysqli_set_charset ($conn,'utf8');

    $sql = "SELECT * FROM cage WHERE status = '周转备用新件'";
    $result = $conn->query($sql);
    $count1 = $result->num_rows;
    $sql = "SELECT * FROM cage WHERE status = '周转备用旧件'";
    $result = $conn->query($sql);
    $count2 = $result->num_rows;
    $sql = "SELECT * FROM cage WHERE status = '返修配件'";
    $result = $conn->query($sql);
    $count3 = $result->num_rows;
    $sql = "SELECT * FROM cage WHERE status = '报损件'";
    $result = $conn->query($sql);
    $count4 = $result->num_rows;

    $sql = "select dateduan,count(*)
from 
(select  
        id,
        case    
            when   (opedate>='2018-12-01 00:00:00')              then   '12' 
            when   (opedate>='2018-11-01 00:00:00' and opedate<'2018-12-01 00:00:00')   then   '11'
            when   (opedate>='2018-10-01 00:00:00' and opedate<'2018-11-01 00:00:00')    then    '10' 
            when   (opedate>='2018-09-01 00:00:00' and opedate<'2018-10-01 00:00:00')    then    '09' 
            when   (opedate>='2018-08-01 00:00:00' and opedate<'2018-09-01 00:00:00')    then    '08' 
            when   (opedate>='2018-07-01 00:00:00' and opedate<'2018-08-01 00:00:00')    then    '7' 
            when   (opedate>='2018-06-01 00:00:00' and opedate<'2018-07-01 00:00:00')    then    '6' 
            when   (opedate>='2018-05-01 00:00:00' and opedate<'2018-06-01 00:00:00')    then    '5' 
            when   (opedate>='2018-04-01 00:00:00' and opedate<'2018-05-01 00:00:00')    then    '4' 
            when   (opedate>='2018-03-01 00:00:00' and opedate<'2018-04-01 00:00:00')     then    '3'  
            when   (opedate>='2018-02-01 00:00:00' and opedate<'2018-03-01 00:00:00')     then    '2'  
            when   (opedate>='2018-01-01 00:00:00' and opedate<'2018-02-01 00:00:00')     then    '1'  
            else     'opedate unknow'
        end     as dateduan from 

         incage
)  as t  group by dateduan";
    $result = $conn->query($sql);
    $incage = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
    while($row = $result->fetch_assoc()){
        $incage[$row['dateduan']] = $row['count(*)'];
    }
    //print_r($incage);

    $sql = "select dateduan,count(*)
from 
(select  
        id,
        case    
            when   (opedate>='2018-12-01 00:00:00')              then   '12' 
            when   (opedate>='2018-11-01 00:00:00' and opedate<'2018-12-01 00:00:00')   then   '11'
            when   (opedate>='2018-10-01 00:00:00' and opedate<'2018-11-01 00:00:00')    then    '10' 
            when   (opedate>='2018-09-01 00:00:00' and opedate<'2018-10-01 00:00:00')    then    '09' 
            when   (opedate>='2018-08-01 00:00:00' and opedate<'2018-09-01 00:00:00')    then    '08' 
            when   (opedate>='2018-07-01 00:00:00' and opedate<'2018-08-01 00:00:00')    then    '7' 
            when   (opedate>='2018-06-01 00:00:00' and opedate<'2018-07-01 00:00:00')    then    '6' 
            when   (opedate>='2018-05-01 00:00:00' and opedate<'2018-06-01 00:00:00')    then    '5' 
            when   (opedate>='2018-04-01 00:00:00' and opedate<'2018-05-01 00:00:00')    then    '4' 
            when   (opedate>='2018-03-01 00:00:00' and opedate<'2018-04-01 00:00:00')     then    '3'  
            when   (opedate>='2018-02-01 00:00:00' and opedate<'2018-03-01 00:00:00')     then    '2'  
            when   (opedate>='2018-01-01 00:00:00' and opedate<'2018-02-01 00:00:00')     then    '1'  
            else     'opedate unknow'
        end     as dateduan from 

         outcage
)  as t  group by dateduan";
    $result = $conn->query($sql);
    $outcage = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
    while($row = $result->fetch_assoc()){
        $outcage[$row['dateduan']] = $row['count(*)'];
    }



    $conn->close();
    ?>
	<!-- main container -->
    <div class="content">

        <!-- settings changer -->

        <div class="container-fluid">

            <!-- upper main stats -->
            <div id="main-stats">
                <div class="row-fluid stats-row">
                    <div class="span3 stat">
                        <div class="data">
                            <span class="number"><?php echo $count1?></span>
                            条记录
                        </div>
                        <span class="date">周转备用新件</span>
                    </div>
                    <div class="span3 stat">
                        <div class="data">
                            <span class="number"><?php echo $count2?></span>
                            条记录
                        </div>
                        <span class="date">周转备用旧件</span>
                    </div>
                    <div class="span3 stat">
                        <div class="data">
                            <span class="number"><?php echo $count3?></span>
                            条记录
                        </div>
                        <span class="date">返修配件</span>
                    </div>
                    <div class="span3 stat last">
                        <div class="data">
                            <span class="number"><?php echo $count4?></span>
                            条记录
                        </div>
                        <span class="date">报损件</span>
                    </div>
                </div>
            </div>
            <!-- end upper main stats -->

            <div id="pad-wrapper">

                <!-- statistics chart built with jQuery Flot -->
                <div class="row-fluid chart">
                    <h4>
                        成交量变化统计
                    </h4>
                    <div class="span12">
                        <div id="statsChart"></div>
                    </div>
                </div>
                <!-- end statistics chart -->

                <!-- UI Elements section -->
             <!-- end UI elements section -->

                <!-- table sample -->
                <!-- the script for the toggle all checkboxes from header is located in js/theme.js -->

                <!-- end table sample -->
            </div>
        </div>
    </div>


	<!-- scripts -->
    <script src="js/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
    <!-- knob -->
    <script src="js/jquery.knob.js"></script>
    <!-- flot charts -->
    <script src="js/jquery.flot.js"></script>
    <script src="js/jquery.flot.stack.js"></script>
    <script src="js/jquery.flot.resize.js"></script>
    <script src="js/theme.js"></script>

    <script type="text/javascript">
        $(function () {

            // jQuery Knobs
            $(".knob").knob();



            // jQuery UI Sliders
            $(".slider-sample1").slider({
                value: 100,
                min: 1,
                max: 500
            });
            $(".slider-sample2").slider({
                range: "min",
                value: 130,
                min: 1,
                max: 500
            });
            $(".slider-sample3").slider({
                range: true,
                min: 0,
                max: 500,
                values: [ 40, 170 ],
            });

            

            // jQuery Flot Chart
            var visits = [[1, <?php echo $outcage[1];?>],
                [2, <?php echo $outcage[2];?>],
                [3, <?php echo $outcage[3];?>],
                [4, <?php echo $outcage[4];?>],
                [5, <?php echo $outcage[5];?>],
                [6, <?php echo $outcage[6];?>],
                [7, <?php echo $outcage[7];?>],
                [8, <?php echo $outcage[8];?>],
                [9, <?php echo $outcage[9];?>],
                [10, <?php echo $outcage[10];?>],
                [11, <?php echo $outcage[11];?>],
                [12, <?php echo $outcage[12];?>]];


            var visitors = [[1, <?php echo $incage[1]-$outcage[1];?>],
                [2, <?php echo $incage[2]-$outcage[2];?>],
                [3, <?php echo $incage[3]-$outcage[3];?>],
                [4, <?php echo $incage[4]-$outcage[4];?>],
                [5, <?php echo $incage[5]-$outcage[5];?>],
                [6, <?php echo $incage[6]-$outcage[6];?>],
                [7, <?php echo $incage[7]-$outcage[7];?>],
                [8, <?php echo $incage[8]-$outcage[8];?>],
                [9, <?php echo $incage[9]-$outcage[9];?>],
                [10,<?php echo $incage[10]-$outcage[10];?>],
                [11,<?php echo $incage[11]-$outcage[11];?>],
                [12,<?php echo $incage[12]-$outcage[12];?>]];

            var plot = $.plot($("#statsChart"),
                [ { data: visits, label: "销售"},
                 { data: visitors, label: "采购" }], {
                    series: {
                        lines: { show: true,
                                lineWidth: 1,
                                fill: true, 
                                fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                             },
                        points: { show: true, 
                                 lineWidth: 2,
                                 radius: 3
                             },
                        shadowSize: 0,
                        stack: true
                    },
                    grid: { hoverable: true, 
                           clickable: true, 
                           tickColor: "#f9f9f9",
                           borderWidth: 0
                        },
                    legend: {
                            // show: false
                            labelBoxBorderColor: "#fff"
                        },  
                    colors: ["#a7b5c5", "#30a0eb"],
                    xaxis: {
                        ticks: [[1, "一月"], [2, "二月"], [3, "三月"], [4,"四月"], [5,"五月"], [6,"六月"],
                               [7,"七月"], [8,"八月"], [9,"九月"], [10,"十月"], [11,"十一月"], [12,"十二月"]],
                        font: {
                            size: 12,
                            family: "Open Sans, Arial",
                            variant: "small-caps",
                            color: "#697695"
                        }
                    },
                    yaxis: {
                        ticks:3, 
                        tickDecimals: 0,
                        font: {size:12, color: "#9da3a9"}
                    }
                 });

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css( {
                    position: 'absolute',
                    display: 'none',
                    top: y - 30,
                    left: x - 50,
                    color: "#fff",
                    padding: '2px 5px',
                    'border-radius': '6px',
                    'background-color': '#000',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }

            var previousPoint = null;
            $("#statsChart").bind("plothover", function (event, pos, item) {
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(0),
                            y = item.datapoint[1].toFixed(0);

                        var month = item.series.xaxis.ticks[item.dataIndex].label;

                        showTooltip(item.pageX, item.pageY,
                            month + item.series.label + "单据量: " + y);
                    }
                }
                else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        });


    </script>

</body>
</html>