<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Web Portal</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">

        <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="css/dashboard_style.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
            function division_view() // class information
            {
                var division = document.getElementById("division").value;

                var xmlRequest = GetXmlHttpObject();
                if (xmlRequest == null)
                    return;

                var url = "ajaxDataDistrictDHIS2Dashboard.php?division_id=" + division;

                var browser = navigator.appName;
                if (browser == "Microsoft Internet Explorer")
                {
                    xmlRequest.open("POST", url, true);
                } else
                {
                    xmlRequest.open("GET", url, true);
                }
                xmlRequest.setRequestHeader("Content-Type", "application/x-www-formurlencoded");
                xmlRequest.onreadystatechange = function ()
                {
                    if (xmlRequest.readyState == 4)
                    {
                        HandleAjaxResponse_division_view(xmlRequest);
                    }
                };
                xmlRequest.send(null);
                return false;
            }

            function HandleAjaxResponse_division_view(xmlRequest)
            {
                var xmlT = xmlRequest.responseText;
                document.getElementById("district_view").innerHTML = xmlT;
                return false;
            }
            //OBJECT FUNCTION ////////////////////////
            function GetXmlHttpObject()
            {
                var xmlHttp = null;
                try
                {
                    xmlHttp = new XMLHttpRequest();
                } catch (e)
                {
                    // Internet Explorer
                    try
                    {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e)
                    {
                        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                    }
                }
                return xmlHttp;
            }
            //For upazila
            function district_view() // class information
            {
                var district = document.getElementById("district").value;
                var xmlRequest = GetXmlHttpObject();
                if (xmlRequest == null)
                    return;

                var url = "ajaxDataUpazillaDHIS2Dashboard.php?district_id=" + district;

                var browser = navigator.appName;
                if (browser == "Microsoft Internet Explorer")
                {
                    xmlRequest.open("POST", url, true);
                } else
                {
                    xmlRequest.open("GET", url, true);
                }
                xmlRequest.setRequestHeader("Content-Type", "application/x-www-formurlencoded");
                xmlRequest.onreadystatechange = function ()
                {
                    if (xmlRequest.readyState == 4)
                    {
                        HandleAjaxResponse_district_view(xmlRequest);
                    }
                };
                xmlRequest.send(null);
                return false;
            }

            function HandleAjaxResponse_district_view(xmlRequest)
            {
                var xmlT = xmlRequest.responseText;
                document.getElementById("upazilla_view").innerHTML = xmlT;

                return false;
            }
            //OBJECT FUNCTION ////////////////////////
            function GetXmlHttpObject()
            {
                var xmlHttp = null;
                try
                {
                    xmlHttp = new XMLHttpRequest();
                } catch (e)
                {
                    // Internet Explorer
                    try
                    {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e)
                    {
                        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                    }
                }
                return xmlHttp;
            }

        </script>
        <style>
            .buttontype{
                border:1px solid #3C8DBC;
                margin-top:15px;
            }
        </style>
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->

    <!--
    .bg-red, .bg-yellow, .bg-aqua, .bg-blue, .bg-light-blue, .bg-green, .bg-navy, .bg-teal, 
    .bg-olive, .bg-lime, .bg-orange, .bg-fuchsia, .bg-purple, .bg-maroon, .bg-black
    -->

    <?php $chart_height = "330px"; ?>

    <body class="hold-transition skin-blue sidebar-collapse">
        <div class="wrapper">


            <?php
            // Top Menu
            //include 'mainpage/header.php';
            include 'dli-config.php';
            //include_once("analyticstracking.php");
            ?>

            <?php
            $current_year = 2019;
            $division_id = '';
            $district_id = '';

            $search_where = "";

            if (isset($_POST['Submit'])) {
                $current_year = $_POST['year'];
                $district_id = $_POST['district'];
                $lastmonth = $_POST['month'];
            }

            if (isset($_POST['month'])) {

                $lastmonth = $_POST['month'];
                if ($lastmonth != '')
                    $search_where = $search_where . " AND  period_month <=$lastmonth";
            }


            if (isset($_POST['division'])) {

                $division_id = $_POST['division'];
                if ($division_id != '')
                    $search_where = $search_where . " AND  division_id IN ($division_id)";
            }

            if (isset($_POST['district'])) {

                $district_id = $_POST['district'];
                if ($district_id != '')
                    $search_where = $search_where . " AND  district_id=$district_id";
            }
            if (isset($_POST['upazila'])) {

                $upazila_id = $_POST['upazila'];
                if ($upazila_id != '')
                    $search_where = $search_where . " AND  upazila_id=$upazila_id";
            }
            ?>

            <?php
            $sql_chart = "select sum(registered_pregnant_women) as registered_pregnant_women,
            sum(nutrition_counselling_unique) as nutrition_counselling_unique,
            sum(weight_measured_unique) as weight_measured_unique,
            sum(ifa_distributed_unique) as ifa_distributed_unique,
            sum(received_counselling_weight_ifa_unique) as received_counselling_weight_ifa_unique,
            ROUND(
            (sum(received_counselling_weight_ifa_unique)*100)/sum(registered_pregnant_women)
            , 2)
            as result 
            from disbursement_link_indicator
            where period_year=$current_year " . $search_where;
            //echo $sql_chart;
            $result_chart = $GLOBALS['conn']->query($sql_chart);
            while ($row_chart = $result_chart->fetch_assoc()) {
                $registered_pregnant_women = $row_chart['registered_pregnant_women'];
                $nutrition_counselling_unique = $row_chart['nutrition_counselling_unique'];
                $weight_measured_unique = $row_chart['weight_measured_unique'];
                $ifa_distributed_unique = $row_chart['ifa_distributed_unique'];
                $received_counselling_weight_ifa_unique = $row_chart['received_counselling_weight_ifa_unique'];
                $result = $row_chart['result'];
            }
            ?>

            <?php
            // Top Menu
            //include 'mainpage/header.php'; 
            ?>

            <?php
            // Left Menu
            //include 'mainpage/leftmenu.php'; 
            ?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) --> 


                <!-- Main content -->
                <section class="content">



                    <div class="row">
                        <div class="col-md-12">
                            <!-- Maternal mortality -->
                            <div class="box box-primary">
                                <div class="box-header with-border">


                                    <div class="row">
                                        <!--
                                        <div class="col-md-12" align="center">
                                            <img src="../files/logo/GoB.png" width="45px"/>
                                        </div>
                                        <div class="col-md-12" align="center">
                                            <strong>Government of the People’s Republic of Bangladesh</strong>
                                        </div>
                                        <div class="col-md-12" align="center">
                                            <strong>Ministry of Health & Family Welfare</strong>
                                        </div>
                                        -->
                                        <div class="col-md-12" style="margin-bottom:-5px;padding:0px 28px 0px 25px;">
                                            <table class="tbl1">
                                                <tr>
                                                    <td class="fst_cell1" width="100%"  align="center">
                                                        <div class="main_foot">HSSP DLR 13.4: Percentage of Registered Pregnant Mothers Receiving Specified Maternal Nutrition Services</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fst_cell1" width="100%"  align="center">
                                                        <div class="main_head">PERFORMANCE SCORECARD</div>         
                                                    </td>
                                                </tr>
												        <tr>
                                                    <td class="fst_cell1" width="100%"  align="center">
                                                        <div class="main_head">
														<p style="color:red;font-size:20px">
														DRAFT (Under Development)
														</p>
 </div>         
                                                    </td>
                                                </tr>
                                        
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- DIRECT CHAT PRIMARY -->
                                            <div class="box">
                                                <!--
                                                <div class="box-header with-border">
                                                  
                                                    <div class="box-tools pull-right">
                                                        
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>
                                                        
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                -->
                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                    <form action="" method="post">
                                                        <span class="custom_label"><b>Period&nbsp; </b></span>


                                                        <?php
                                                        $sql = "
SELECT period_year,MAX(period_month) AS period_month
FROM disbursement_link_indicator
WHERE period_year=
(
SELECT MAX(period_year) AS period_year
FROM disbursement_link_indicator
)

";

                                                        $result1 = $GLOBALS['conn']->query($sql);

                                                        $row = $result1->fetch_assoc();

                                                        $current_year = $row["period_year"];
                                                        $lastmonth = $row["period_month"];


                                                        $date = new DateTime();
                                                        $months = array(0 => '-- Select --', 1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
                                                        ?>

                                                        <select name="month" id="month">

                                                            <?php foreach ($months as $key => $month) { ?>

                                                                <?php
                                                                $default_month = "";

                                                                if (isset($_POST['month']))
                                                                    $default_month = ($key == $_POST['month']) ? 'selected' : '';
                                                                else
                                                                    $default_month = ($key == $lastmonth) ? 'selected' : '';
                                                                //$default_month = ($key == $date->format('m')-1)?'selected':'';
                                                                ?>
                                                                <option <?php echo $default_month; ?> value="<?php echo $key; ?>">
                                                                    <?php echo $month; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>




                                                        <?php
                                                        $yearArray = range(2018,2019);

                                                        echo "<select name = 'year' id='year' class='custom_input'>";

                                                        echo "<option value=''>Select Year</option>";
                                                        foreach ($yearArray as $year) {
                                                            // if you want to select a particular year
                                                            //$selected = ($year == $current_year) ? 'selected' : '';

                                                            if (isset($_POST['year']))
                                                                $selected = ($year == $_POST['year']) ? 'selected' : '';
                                                            else {
                                                                $current_year = date('Y', strtotime((string) date('Ym')));
                                                                $selected = ($year == $current_year) ? 'selected' : '';
                                                            }
                                                            // if you want to select a particular year
                                                            //$selected = ($top == 5) ? 'selected' : '';
                                                            //echo '<option ' . $selected . ' value="' . $top . '">' . $top . '</option>';




                                                            echo '<option ' . $selected . ' value="' . $year . '">' . $year . '</option>';
                                                        }

                                                        echo "</select>";
                                                        ?>

                                                        <span class="custom_label"><b>Division&nbsp;</b></span>
                                                        <select name="division" id="division" class='custom_input' onchange="division_view()">
                                                            <option value="">Select</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT(division_id),division_name FROM `dhis2_national_dashboard` ORDER BY  division_name";

                                                            $result_division = $GLOBALS['conn']->query($sql);

                                                            while ($row = $result_division->fetch_assoc()) {
                                                                ?>
                                                                <option value="<?php echo $row['division_id']; ?>"<?php
                                                                if (!empty($_POST['division'])) {
                                                                    if ($_POST['division'] == $row['division_id']) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>><?php echo $row['division_name']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        <span class="custom_label"><b>District&nbsp;</b></span>
                                                        <span id="district_view">
                                                            <select name="district" id="district" class='custom_input' onchange="district_view()">
                                                                <option value="">Select</option>
                                                                <?php
                                                                $condition = "";
                                                                if (!empty($_POST['division'])) {
                                                                    $condition.=" and division_id='$_POST[division]'";
                                                                }
                                                                $sql = "SELECT DISTINCT(district_name),district_id FROM `dhis2_national_dashboard` where 1=1 $condition ORDER BY  district_name";

                                                                $result_district = $GLOBALS['conn']->query($sql);

                                                                while ($row = $result_district->fetch_assoc()) {
                                                                    ?>
                                                                    <option value="<?php echo $row['district_id']; ?>"<?php
                                                                    if (!empty($_POST['district'])) {
                                                                        if ($_POST['district'] == $row['district_id']) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?php echo $row['district_name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </span>
                                                        <span class="custom_label"><b>Upazila&nbsp;</b></span>
                                                        <span id="upazilla_view">
                                                            <select name="upazila" id="upazila" class='custom_input'>
                                                                <option value="">Select Upazila</option>
                                                                <?php
                                                                if (!empty($_POST['district'])) {
                                                                    $condition.=" and district_id='$_POST[district]'";
                                                                }
                                                                $sql = "SELECT DISTINCT(upazila_name),upazila_id FROM `dhis2_national_dashboard` WHERE 1=1 $condition and LENGTH(upazila_name)>1 ORDER BY  upazila_name";
                                                                $result_upazila = $GLOBALS['conn']->query($sql);

                                                                while ($row = $result_upazila->fetch_assoc()) {
                                                                    ?>
                                                                    <option value="<?php echo $row['upazila_id']; ?>"<?php
                                                                    if (!empty($_POST['upazila'])) {
                                                                        if ($_POST['upazila'] == $row['upazila_id']) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?php echo $row['upazila_name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </span>


                                                        <input type="submit" name="Submit" value="Search" class="btn btn-success"/>
                                                    </form>


                                                    <b>last updated at:  </b>

                                                    <?php 
                                                      $sql = "SELECT
                                                      SUBSTR(TIMESTAMP, 1, 10) AS task_end_date,
                                                      SUBSTR(TIMESTAMP, 12, 8) AS task_end_time
                                                      FROM
                                                      log
                                                      WHERE timestamp =
                                                      (SELECT
                                                      MAX(timestamp)
                                                      FROM
                                                      log
                                                      WHERE logger = 'Nutrition-DLI'
                                                      )
                                                      ORDER BY task_end_time DESC
                                                      LIMIT 0, 1 ";
                                                      $result1 = $GLOBALS['conn_log']->query($sql);
                                                      $row1 = $result1->fetch_assoc();
                                                      $conv_date = strtotime($row1['task_end_date']);
                                                      $conv_date = date('F j, Y', $conv_date);
                                                      $conv_time = strtotime($row1['task_end_time']);
                                                      $conv_time = date('h:m:i a', $conv_time);

                                                      echo $conv_date;
                                                      echo "  ";
                                                      echo $conv_time; 
                                                    ?>


                                                    <!-- /.direct-chat-pane -->
                                                </div>

                                            </div>
                                            <!--/.direct-chat -->
                                        </div>
                                        <!-- /.col -->
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- DIRECT CHAT PRIMARY -->
                                            <div class="box box-primary direct-chat direct-chat-primary">

                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Cumulative result</h3>

                                                    <div class="box-tools pull-right">

                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>

                                                <!-- /.box-header -->
                                                <div class="box-body">


                                                    <div class="box_body_without_border">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype">
                                                                    <span class="info-box-icon lg-icon"><img src="../files/icons/reg_no.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo number_format($registered_pregnant_women); ?>
                                                                        </span>
                                                                        <p>Pregnant women in Community Clinic</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype">
                                                                    <span class="info-box-icon lg-icon"><img src="../files/icons/ifa.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo number_format($ifa_distributed_unique); ?>
                                                                        </span>
                                                                        <p>Received Iron Folate</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype">
                                                                    <span class="info-box-icon lg-icon"><img src="../files/icons/weight_measured.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo number_format($weight_measured_unique); ?>
                                                                        </span>
                                                                        <p>Weight measured</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype">
                                                                    <span class="info-box-icon lg-icon"><img src="../files/icons/nutrition_counselling.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo number_format($nutrition_counselling_unique); ?>
                                                                        </span>
                                                                        <p>Received Nutrition Couselling</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype">
                                                                    <span class="info-box-icon lg-icon"><img src="../files/icons/three_service.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo number_format($received_counselling_weight_ifa_unique); ?>
                                                                        </span>
                                                                        <p>Received all 3 intervention</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $style = "";
                                                            if ($result <= 5) {
                                                                $style = "style='background-color:red;color:white !important;'";
                                                            } elseif ($result >= 6 & $result <= 10) {
                                                                $style = "style='background-color:yellow;color:black !important;'";
                                                            } elseif ($result >= 11 & $result <= 20) {
                                                                $style = "style='background-color:Aqua;color:black !important;'";
                                                            }
                                                            elseif ($result >= 21 & $result < 50) {
                                                                $style = "style='background-color:green;color:white !important;'";
                                                            } elseif ($result >= 51) {
                                                                $style = "style='background-color:blue;color:white !important;'";
                                                            }
                                                            ?>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="info-box buttontype" <?php echo $style; ?>>
                                                                    <span class="info-box-icon lg-icon" <?php echo $style; ?>><img src="../files/icons/result.png"/></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-number"><?php echo $result; ?>
                                                                        </span>
                                                                        <p>Result (%)</p>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                    
                                                        <div class="col-md-12">
															<div align="right">
																<table style="table">
																	<tr>
																		<td style="background-color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																		<td>&nbsp;&nbsp;Very low (&lt;5&percnt;)&nbsp;&nbsp;</td>
																		<td style="background-color:yellow;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																		<td>&nbsp;&nbsp;Low (5-10&percnt;) &nbsp;&nbsp;</td>
																		<td style="background-color:Aqua;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																		<td>&nbsp;&nbsp;Good (11-20&percnt;)&nbsp;&nbsp;</td>
																		<td style="background-color:green;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																		<td>&nbsp;&nbsp;Very Good (21-50&percnt;)&nbsp;&nbsp;</td>
																		<td style="background-color:blue;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																		<td>&nbsp;&nbsp;Excellent (51-100&percnt;)&nbsp;&nbsp;</td>
																	</tr>
																</table>
															</div>
                                                        </div>
                                                    </div>



                                                    <!-- /.direct-chat-pane -->
                                                </div>

                                            </div>
                                            <!--/.direct-chat -->
                                        </div>
                                        <!-- /.col -->
                                    </div>



                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- DIRECT CHAT PRIMARY -->
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    <h3 class="box-title">Monthly progress tracker, <?php echo $current_year ?> </h3>

                                                    <div class="box-tools pull-right">

                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">

                                                    <div >
                                                        <center><div id="disease" style="height: <?php echo $chart_height; ?>; position: relative;" ></div></center>
                                                    </div>
                                                    <!-- /.direct-chat-pane -->
                                                </div>

                                            </div>
                                            <!--/.direct-chat -->
                                        </div>


                                        <div class="col-md-6">
                                            <!-- DIRECT CHAT PRIMARY -->
                                            <div class="box box-success">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    <h3 class="box-title">DLI </h3>

                                                    <div class="box-tools pull-right">

                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">

                                                    <div >
                                                        <center><div id="dli_administrative" style="height: <?php echo $chart_height; ?>; position: relative;" ></div></center>
                                                    </div>
                                                    <!-- /.direct-chat-pane -->
                                                </div>

                                            </div>
                                        </div>

                                        <!-- /.col -->
                                    </div>

<!--
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="box box-primary">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    <h3 class="box-title">GIS, <?php  /* echo $current_year */ ?> </h3>

                                                    <div class="box-tools pull-right">

                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">

                                                    <div >
                                                        <center><div id="gis" style=" position: relative;" >

                                                                <div class='tableauPlaceholder' id='viz1538535340361' style='position: relative'><noscript><a href='#'><img alt='DLI ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Up&#47;Upazilawisephysicianpostsummary&#47;DLI&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='Upazilawisephysicianpostsummary&#47;DLI' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Up&#47;Upazilawisephysicianpostsummary&#47;DLI&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='filter' value='publish=yes' /></object></div>                <script type='text/javascript'>

																var divElement = document.getElementById('viz1538535340361');
                                                                    var vizElement = divElement.getElementsByTagName('object')[0];
                                                                    if (divElement.offsetWidth > 800) {
                                                                        vizElement.style.width = '1000px';
                                                                        vizElement.style.height = '827px';
                                                                    } else if (divElement.offsetWidth > 500) {
                                                                        vizElement.style.width = '1000px';
                                                                        vizElement.style.height = '827px';
                                                                    } else {
                                                                        vizElement.style.width = '100%';
                                                                        vizElement.style.height = '927px';
                                                                    }
                                                                    var scriptElement = document.createElement('script');
                                                                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                                    vizElement.parentNode.insertBefore(scriptElement, vizElement);

																	</script>

                                                            </div></center>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                        </div>
                                    </div>
-->


                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>            



                    <!-- Your Page Content Here -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php
// Footer
            include 'mainpage/footer.php';
            ?>



        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.2.3 -->
        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>


        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!--Code for Pyramid Chart-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>



        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMVW6SZ1NFcxnEs1l5NdtIhLWo-2i7_L4&callback=initMap">
        </script>


        <!--Code for line graph-->
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawDisease);

            function drawDisease() {

                /* var data = google.visualization.arrayToDataTable([
                 ['Name', 'Diarrhea Case', {role: 'annotation'}, 'Injury Case', {role: 'annotation'}, 'RTI Case', {role: 'annotation'}, 'Skin Disease Case', {role: 'annotation'}],
                 */

                var data = google.visualization.arrayToDataTable([
                    ['Name', 'No. of Registered Pregnant women (RPW)', {role: 'annotation'}, '(%) of RPW Received all 3 services'],
<?php
$search_where = '';

if (isset($_POST['Submit']))
    $current_year = $_POST['year'];

if (isset($_POST['division'])) {
    $division_id = $_POST['division'];
    if ($division_id != '')
        $search_where = $search_where . " AND  division_id IN ($division_id)";
}
if (isset($_POST['district'])) {

    $district_id = $_POST['district'];
    if ($district_id != '')
        $search_where = $search_where . " AND  district_id=$district_id";
}
if (isset($_POST['upazila'])) {

    $upazila_id = $_POST['upazila'];
    if ($upazila_id != '')
        $search_where = $search_where . " AND  upazila_id=$upazila_id";
}
$sql_chart = "
        select MONTHNAME(STR_TO_DATE(period_month, '%m')) as period_month,
        IFNULL(sum(registered_pregnant_women),0) as registered_pregnant_women,
        IFNULL(sum(nutrition_counselling_unique),0) as nutrition_counselling_unique,
        IFNULL(sum(weight_measured_unique),0) as weight_measured_unique,
        IFNULL(sum(ifa_distributed_unique),0) as ifa_distributed_unique,
        IFNULL(sum(received_counselling_weight_ifa_unique),0) as received_counselling_weight_ifa_unique,
        IFNULL((sum(received_counselling_weight_ifa_unique)*100)/sum(registered_pregnant_women),0) as result 
        from disbursement_link_indicator
        where period_year=$current_year " . $search_where . " 
        GROUP BY period_month";

$result_chart = $GLOBALS['conn']->query($sql_chart);


while ($row_chart = $result_chart->fetch_assoc()) {
    $period_date = $row_chart['period_month'];
    $registered_pregnant_women = $row_chart['registered_pregnant_women'];
//    $received_counselling_weight_ifa_unique = $row_chart['received_counselling_weight_ifa_unique'];
    $received_counselling_weight_ifa_unique = $row_chart['result'];

    /*    echo "['{$period_date}', {$diarrhea_case},{$diarrhea_case},{$injury_case},{$injury_case},
      {$resp_tract_infection_case},{$resp_tract_infection_case},
      {$skin_disease_case},{$skin_disease_case}],"; */

    echo "['{$period_date}',
                    {$registered_pregnant_women},
                    {$registered_pregnant_women},
                    {$received_counselling_weight_ifa_unique}
                ],";
}
?>

                ]);

                var options = {
                    //title: 'Monthly progress tracker',
                    hAxis: {title: 'Diameter'},
                    vAxes: {0: {viewWindowMode: 'explicit',
                            gridlines: {color: 'transparent'},
                        },
                        1: {
                            minValue: 0,
                            maxValue: 20,
                            format: '#\'%\''
                        },
                    },
                    //hAxis: {title: 'Person'},
                    seriesType: 'bars',
                    //colors: ['#2E8A8A'],
                    legend: {position: 'bottom'},
                    hAxis: {
                        direction: 1,
                        slantedText: true,
                        textStyle: {
                            fontSize: 16, // or the number you want
                            bold: false
                        }
                    },
                    titleTextStyle: {
                        fontSize: 16, // 12, 18 whatever you want (don't specify px)
                        bold: true, // true or false
                    },
                    chartArea: {
                        top: 20, left: 60, height: '60%', width: '85%'},
                    series: {
                        0: {targetAxisIndex: 0},
                        1: {targetAxisIndex: 1, type: 'line', pointsVisible: true},
                    },
                    seriesType: 'bars',
                };

                // Instantiate and draw the chart.
                var chart1 = new google.visualization.ComboChart(document.getElementById('disease'));
                chart1.draw(data, options);

            }
        </script>



        <!--Code for line graph-->
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(diarrhoea_administrative);

            function diarrhoea_administrative() {

                /* var data = google.visualization.arrayToDataTable([
                 ['Name', 'Diarrhea Case', {role: 'annotation'}, 'Injury Case', {role: 'annotation'}, 'RTI Case', {role: 'annotation'}, 'Skin Disease Case', {role: 'annotation'}],
                 */

                var data = google.visualization.arrayToDataTable([
                    ['Name', 'diarrhoea', {role: 'annotation'}],
<?php
$select_string = " division_name";
$group_string = " division_name";

if (isset($_POST['Submit']))
    $where_string = $_POST['year'];

if (isset($_POST['division'])) {
    $division_id = $_POST['division'];
    if ($division_id != '') {
        $select_string = " district_name";
        $where_string = $where_string . " AND  division_id IN ($division_id)";
        $group_string = " district_name";
    }
}

if (isset($_POST['upazila'])) {
    $district_id = $_POST['district'];
    if ($district_id != '') {
        $select_string = " upazila_name";
        $where_string = $where_string . " AND  district_id=$district_id";
        $group_string = " upazila_name";
    }
}

$sql_chart = "
                    select $select_string as orgunit,
                    IFNULL((sum(received_counselling_weight_ifa_unique)*100)/sum(registered_pregnant_women),0) as result 
                    from disbursement_link_indicator 
                    where period_year=$current_year " . $search_where . " 
                    GROUP BY $group_string 
                    ";




$result_chart = $GLOBALS['conn']->query($sql_chart);


while ($row_chart = $result_chart->fetch_assoc()) {
    $period_date = $row_chart['orgunit'];
    $result = round($row_chart['result'], 1);


    /*    echo "['{$period_date}', {$diarrhea_case},{$diarrhea_case},{$injury_case},{$injury_case},
      {$resp_tract_infection_case},{$resp_tract_infection_case},
      {$skin_disease_case},{$skin_disease_case}],"; */

    echo "['{$period_date}',
                                {$result},'{$result}'
                            ],";
}
?>

                ]);

                var options = {
                    //title: 'Monthly progress tracker',
                    //hAxis: {title: 'Diarrhoea'},

                    //hAxis: {title: 'Person'},
                    //seriesType: 'columns',
                    //colors: ['#7FD607'],
                    is3D: true,
                    colors: ["#109618", "#699A36", "#000000"],
                    legend: {position: 'none'},
                    chartArea: {top: 10, left: 80, height: '80%', width: '87%'},
                };

                // Instantiate and draw the chart.
                var chart1 = new google.visualization.BarChart(document.getElementById('dli_administrative'));
                chart1.draw(data, options);

            }
        </script>



    </body>
</html>
 //hAxis: {title: 'Person'},
                    //seriesType: 'columns',
                    //colors: ['#7FD607'],
                    is3D: true,
                    colors: ["#109618", "#699A36", "#000000"],
                    legend: {position: 'none'},
                    chartArea: {top: 10, left: 80, height: '80%', width: '87%'},
                };

                // Instantiate and draw the chart.
                var chart1 = new google.visualization.BarChart(document.getElementById('dli_administrative'));
                chart1.draw(data, options);

            }
        </script>



    </body>
</html>
