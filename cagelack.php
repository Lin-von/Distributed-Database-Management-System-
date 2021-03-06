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
    document.getElementById('forcage').className = "active";

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
                    <h3 style="margin-bottom: 20px;">配件报损</h3>
                    <div class="span10 pull-right">
                        <div class="ui-dropdown">
                            <select style="min-height: 30px;margin-top: 40px; width: 150px;" id="operation" >
                                <option disabled="disabled" selected/>选择操作
                                <option />配件报旧
                                <option />配件报修
                                <option />配件报损

                            </select>

                        </div>
                        <!-- custom popup filter -->
                        <!-- styles are located in css/elements.css -->
                        <!-- script that enables this dropdown is located in js/theme.js -->

                        <span style="margin-top: 40px;" id="operator" class="label label-info pull-right"><i class="icon-user" ></i>经办人：<?php echo $_SESSION['user'];?></span>

                    </div>

                </div>
                <a style="margin-bottom: 20px;" onclick="oopen()" class="btn-flat info ">
                    添加配件

                </a>
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
                                    <span class="line"></span>库存
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>数量
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
                        确认操作

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


        function deleteCurrentRow(obj){
            var tr=obj.parentNode.parentNode;
            var tbody=tr.parentNode;
            tbody.removeChild(tr);
            //只剩行首时删除表格
            if(tbody.rows.length==1) {
                tbody.parentNode.removeChild(tbody);
            }
        }
        function destroyCommit(obj) {
            if(confirm("确定要删除该配件吗？"))
                deleteCurrentRow(obj);
            else return false;
        }


        function value(id) {
            return document.getElementById(id).value;
        }


        $.ajax({
            type: 'POST',
            url: 'Controller/Controller.php?controller=Set&method=showAccInfo',

            success: function (data) {
                var str = data;
                obj = JSON.parse(str);
            }
        });

        var tbody = document.createElement('tbody');

        document.getElementById('info').appendChild(tbody);



        function addRow(tbody,obj,cnt,lef)
        {

            //添加一行
            var newTr = document.createElement('tr');
            //添加两列
            var newTd0 = newTr.insertCell();
            var newTd1 = newTr.insertCell();
            //var newTd2 = newTr.insertCell();
            var newTd3 = newTr.insertCell();
            var newTd4 = newTr.insertCell();
           // var newTd5 = newTr.insertCell();
            var newTd8 = newTr.insertCell();

            //设置列内容和属性
            newTd0.innerText= obj.id;
            newTd1.innerText= obj.accname;
           // newTd2.innerText= obj.priceout;
            newTd3.innerText= lef;
            newTd4.innerHTML= "<td><input type=\"text\" value=\""+cnt+"\" onchange='recalc(this)' style=\"width: 20px;margin:0;height: 10px;\"></td>\n";
           // newTd5.innerText= (parseInt(cnt)*parseInt(obj.priceout)).toString();
            newTd8.innerHTML =
                '<div class="btn-glow" onclick="destroyCommit(this)" style="margin-left: 20px;"><i class="icon-remove-sign" ></i> 删除</div>';

            tbody.appendChild(newTr);
        }
        function checkhave(id,lef,cnt) {
            var list = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].rows;
            var size = list.length;
            var tr;
            var flag = 1;
            for(var i = 0; i < size; i++) {
                tr = list[i];
                if(tr.cells[0].innerText == id) {
                    //console.log(tr.cells[3].getElementsByTagName("input")[0].value);
                    var temp =  tr.cells[4].getElementsByTagName("input")[0].value;
                     tr.cells[4].getElementsByTagName("input")[0].value = (parseInt(temp) + parseInt(cnt)).toString();


                   flag = 0;
                }
            }
            if(flag == 1)
            for(var i=0;i<obj.length;i++){
                if(obj[i].id == id) addRow(tbody,obj[i],cnt,lef);
            }




        }

        function recalc(tem) {
            var lef = $(tem).parents("tr").children("td").eq(2)[0].innerText;
            var cnt = tem.value;
            if(parseInt(lef)<parseInt(cnt)) {
                alert("超出库存上限，请重新添加配件!");
                deleteCurrentRow($(tem).parents("tr").children("td").eq(4)[0].getElementsByTagName('div')[0]);
            }
        }
        function oopen() {
            window.open('chooseacc.php','title','height=500,width=370,top=0,left=0,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
        }

        function show(str) {
            var arr = str.split(',');

            for(var i=0;i<arr.length;i++){
                checkhave(arr[i],arr[++i],arr[++i]);
            }

        }
        
        function subcheck() {
            var opt = document.getElementById('operation').value;
            var ope = document.getElementById('operator').innerText.substr(4);
            if(opt == "选择操作") {alert("请选择操作"); return; }
            var list = document.getElementsByTagName('table')[0].getElementsByTagName('tbody')[0].rows;
            var size = list.length;
            if(size == 0) {alert("请选择配件"); return; }

            var tr;
            var id_array=new Array();
            var cnt_array=new Array();

            for(var i = 0; i < size; i++) {
                tr = list[i];
                id_array.push(tr.cells[0].innerText);//向数组中添加元素
                cnt_array.push(tr.cells[3].getElementsByTagName("input")[0].value);//向数组中添加元素
            }
            var idstr=id_array.join(',');//将数组元素连接起来以构建一个字符串
            var cntstr=cnt_array.join(',');//将数组元素连接起来以构建一个字符串

            $.ajax({
                type: 'POST',
                url: 'Controller/Controller.php?controller=Cage&method=statusChange',
                data: "idstr="+idstr+"&cntstr="+cntstr+"&operation="+opt+"&operator="+ope,
                success: window.location.href='cagelack.php'
            });

        }

    </script>

</body>
</html>