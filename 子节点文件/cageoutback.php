<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>售后配件库管理系统</title>
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
    <!-- bootstrap -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" type="text/css" href="css/elements.css" />
    <link rel="stylesheet" type="text/css" href="css/icons.css" />

    <!-- libraries -->
    <link href="css/lib/font-awesome.css" type="text/css" rel="stylesheet" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="css/compiled/user-list.css" type="text/css" media="screen" />


    <!--[if lt IE 9]>

    <![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

<!-- navbar -->
<?php require_once "navbar.html";?>
<!-- end navbar -->

<!-- sidebar -->
<?php require_once "sidebar.html";?>
<script type="text/javascript">
    document.getElementById('forsell').className = "active";

</script>


<!-- main container -->
    <div class="content">
        
        <!-- settings changer -->
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


        $sql = "SELECT cliname FROM client";

        $result = $conn->query($sql);
        //$row = $result->fetch_assoc();
        $conn->close();
        ?>
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div style="margin-bottom: 30px;" class="row-fluid header">
                    <h3 style="margin-bottom: 20px;">客户退货</h3>
                    <div class="span10 pull-right">
                        <div class="ui-dropdown">
                            <select style="min-height: 30px;margin-top: 40px; width: 150px;" id="client" onchange="getInfo(this)" >
                                <option disabled="disabled" selected/>选择客户
                                <?php
                                if ($result->num_rows > 0) {
                                    // 输出每行数据
                                    while($row = $result->fetch_assoc())  {
                                 ?>
                                        <option /> <?php echo $row["cliname"];?>
                                    <?php     }
                                }
                                ?>


                            </select>

                        </div>
                        <span style="margin-top: 40px;margin-left: 20px;" id="sum" class="label label-info pull-right"><i class="icon-money" ></i>总计金额：￥0</span>
                        <span style="margin-top: 40px;" id="operator" class="label label-info pull-right"><i class="icon-user" ></i>经办人：<?php echo $_SESSION['user'];?></span>

                    </div>

                </div>


                 <h4 style="margin-left: 0;margin-bottom: 10px;">可退配件</h4>

                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover" id="info">
                        <thead>
                            <tr>
                                <th class="span2 sortable">
                                    编号
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>名称
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>单价
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>可退量
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>退货量
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>总计
                                </th>

                                <th class="span3 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="pagination pull-right">
                    <a style="margin-bottom: 20px;" onclick="subcheck()" class="btn-flat success ">
                        确认退货

                    </a>
                </div>
                <!-- end users table -->
            </div>
        </div>
    </div>
    <!-- end main container -->


	<!-- scripts -->
    <script src="js/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/theme.js"></script>
    <script type="text/javascript">
        function value(id) {
            return document.getElementById(id).value;
        }

        var accname = new Array();
        var accprice = new Array();

        $.ajax({
            type: 'POST',
            url: 'http://111.230.12.120/Controller/Controller.php?controller=Set&method=showAccInfo',

            success: function (data) {
                var str = data;
                infoobj = JSON.parse(str);
                for(var i=0;i<infoobj.length;i++){
                    accname[infoobj[i].id] = infoobj[i].accname;
                    accprice[infoobj[i].id] = infoobj[i].priceout;
                }
            }
        });

        var tbody = document.createElement('tbody');

        document.getElementById('info').appendChild(tbody);



        function addRow(tbody,obj)
        {

            //添加一行
            var newTr = document.createElement('tr');
            //添加两列
            var newTd0 = newTr.insertCell();
            var newTd1 = newTr.insertCell();
            var newTd2 = newTr.insertCell();
            var newTd3 = newTr.insertCell();
            var newTd4 = newTr.insertCell();
            var newTd5 = newTr.insertCell();
            var newTd8 = newTr.insertCell();

            //设置列内容和属性
            newTd0.innerText= obj.id;
            newTd1.innerText= accname[obj.id];
            newTd2.innerText= accprice[obj.id];
            newTd3.innerText= obj.cnt;
            newTd4.innerHTML= "<td><input type=\"text\" onchange='recalc(this)' style=\"width: 20px;margin:0;height: 10px;\"></td>\n";

         //   newTd5.innerText= (parseInt(cnt)*parseInt(obj.pricein)).toString();

            newTd8.innerHTML =
                '<input type="checkbox" onchange="selcheck(this)" name="test" style="margin:0;" >选择退货';

            tbody.appendChild(newTr);
        }
        function checkhave(id,cnt) {
            var list = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].rows;
            var size = list.length;
            var tr;
            var flag = 1;
            for(var i = 0; i < size; i++) {
                tr = list[i];
                if(tr.cells[0].innerText == id) {
                    //console.log(tr.cells[3].getElementsByTagName("input")[0].value);
                    var temp =  tr.cells[3].getElementsByTagName("input")[0].value;
                    var newcnt = tr.cells[3].getElementsByTagName("input")[0].value = (parseInt(temp) + parseInt(cnt)).toString();
                    tr.cells[4].innerText = (parseInt(newcnt) * parseInt(tr.cells[2].innerText)).toString();

                   flag = 0;
                }
            }
            if(flag == 1)
            for(var i=0;i<obj.length;i++){
                if(obj[i].id == id) addRow(tbody,obj[i],cnt);
            }




        }
        var sum = 0;
        function resum() {
            var list = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].rows;
            var size = list.length;
            var tr;
            sum = 0;
            for(var i = 0; i < size; i++) {
                tr = list[i];
                if(tr.cells[6].getElementsByTagName('input')[0].checked == true)
                sum += parseInt(tr.cells[5].innerText);

            }
            document.getElementById('sum').innerText = "总计金额：￥" + sum.toString();
        }
        function recalc(tem) {
            var pri = $(tem).parents("tr").children("td").eq(2)[0].innerText;
            var cnt = tem.value;
            var upper = $(tem).parents("tr").children("td").eq(3)[0].innerText;

            if(parseInt(upper)<parseInt(cnt)) {
                alert("超过可退货上限");
                tem.value = 0;
                return;
            }

            $(tem).parents("tr").children("td").eq(5)[0].innerText = (parseInt(cnt)*parseInt(pri)).toString();
            resum();
        }
        function oopen() {
            window.open('chooseacc.html','title','height=500,width=370,top=0,left=0,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
        }

        function show(str) {
            var arr = str.split(',');

            for(var i=0;i<arr.length;i++){
                checkhave(arr[i],arr[++i]);
            }
           // alert(str);
            resum();
            console.log(obj[0].id);
        }
        function selcheck(tem) {
            if($(tem).parents("tr").children("td").eq(4)[0].getElementsByTagName('input')[0].value == "") alert("请输入数量");
            else resum();
        }
        function subcheck() {
            var cli = document.getElementById('client').value;
            var ope = document.getElementById('operator').innerText.substr(4);
            if(cli == "选择客户") {alert("请选择客户"); return; }
            var list = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].rows;
            var size = list.length;
            if(size == 0) {alert("请选择配件"); return; }

            var tr;
            var id_array=new Array();
            var cnt_array=new Array();
            var flag = 0;
            for(var i = 0; i < size; i++) {
                tr = list[i];
                if(tr.cells[6].getElementsByTagName('input')[0].checked == true){
                    flag = 1;
                    id_array.push(tr.cells[0].innerText);//向数组中添加元素
                    cnt_array.push(tr.cells[4].getElementsByTagName("input")[0].value);//向数组中添加元素

                }

            }
            if (flag==0) {
                alert("请选择需要退货的配件！");
                return;
            }
            var idstr=id_array.join(',');//将数组元素连接起来以构建一个字符串
            var cntstr=cnt_array.join(',');//将数组元素连接起来以构建一个字符串

            $.ajax({
                type: 'POST',
                url: 'Controller/Controller.php?controller=Cage&method=outCageBack',
                data: "idstr="+idstr+"&cntstr="+cntstr+"&client="+cli+"&operator="+ope+"&cost="+sum,
                success: window.location.href='cageoutback.php'
            });

        }

        function getInfo(s) {
            var cli = s.value;

            $.ajax({
                type: 'POST',
                url: 'Controller/Controller.php?controller=Cage&method=showOutBack',
                data: "client="+cli,
                success: function (data) {
                    var str = data;
                    obj = JSON.parse(str);

                    for(var i=0;i<obj.length;i++){
                        addRow(tbody,obj[i]);
                    }
                }
            });







        }
    </script>

</body>
</html>