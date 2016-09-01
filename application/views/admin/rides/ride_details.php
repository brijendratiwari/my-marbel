<?php 
      # echo "<pre>"; print_r($rides['ride_ID']);    die; 
    //echo '<pre>';print_r($rides_points['graph_data']);die;
     #die; 
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12" style="border:solid 1px #ddd;margin-top:25px;">
            <div class="row">
                <div class="col-md-8" style="border-right:1px solid #ddd">
                    <div class="row" >
                        <div class="col-md-12 user-details" style="margin-top: 2%;">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <?php if (!empty($rides['user_profile_pic'])) { ?>
                                    <img data-holder-rendered="true" src="<?php echo base_url('assets/profile-imgs/' . $rides['user_profile_pic']) ?>" style="width: 140px; float: left;" data-src="holder.js/140x140" class="img-circle img-responsive" alt="140x140">
                                <?php } else { ?>
                                    <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" style="width: 140px; float: left;" data-src="holder.js/140x140" class="img-circle img-responsive" alt="140x140">
                                <?php } ?>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-12 full-width768-980">
                                <h1><?php echo!empty($rides['est_start_st']) ? $rides['est_start_st'] : ""; ?> To <?php echo!empty($rides['est_finish_st']) ? $rides['est_finish_st'] : ""; ?></h1>
                                <p>Ridden By <a href="<?php echo base_url('get_customer_info/' . $rides['userID']); ?>" class="blue"><?php echo!empty($rides['first_name']) ? $rides['first_name'] . ' ' . $rides['last_name'] : ""; ?></a> at <?php echo date('h:i A', strtotime($rides['start_time'])); ?> on <?php echo date('D', strtotime($rides['start_time'])) . ' day'; ?>, <?php echo date('m/d/Y', strtotime($rides['start_time'])); ?></p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 full-width768-980">
                                <div class="round-box rb2 pull-right">
                                    <?php echo !empty($rides['efficiency']) ? round($rides['efficiency'],2) : "0"; ?>%
                                    <small>e-score</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" style="padding:20px 2px; text-align: center; ">
                        <?php if (is_array($rides_points['polyline'])) {
                            ?>
                            <div id="map_data" style="height: 500px;"></div>
                        <?php } else { ?>
                            <div id="map_data" style="height: 225px; color:#00aeef; ">Details not available for create map.</div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4 summery">
                    <div class="row">
                        <div class="panel with-nav-tabs panel-default">
                            <div class="panel-heading" style="padding:0">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1default" data-toggle="tab">Summery</a></li>
<!--                                    <li><a href="#tab2default" data-toggle="tab"></a></li>
                                    <li><a href="#tab3default" data-toggle="tab"></a></li>
                                    <li><a href="#tab4default" data-toggle="tab"></a></li>-->
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1default">

                                        <table width="100%">
                                            <!--<tr>
                                                <td>Time</td>
                                                <td>05:00:13</td>
                                                </tr>-->
                                            <tr>
                                                <td>Elapsed</td>
                                                <td><?php echo !empty($rides['trip_duration'])? (round($rides['trip_duration']/60,2)):"0";?> Minutes</td>
                                            </tr>
                                            <tr>
                                                <td>Max Speed</td>
                                                <td><?php echo !empty($rides_points['maxspeed']) ? $rides_points['maxspeed'] : "00.0"; ?>MPH</td>
                                            </tr>
                                            <tr>
                                                <td>Avg Speed</td>
                                                <td><?php echo !empty($rides_points['avgspeed']) ? $rides_points['avgspeed'] : "00.0"; ?>MPH</td>
                                            </tr>
                                            <tr>
                                                <td>Device</td>
                                                <td>Marbel one pro</td>
                                            </tr>
                                            <tr>
                                                <td>Max Incline</td>
                                                <td><?php echo (!empty($rides_points['maxincline'])) ? $rides_points['maxincline'] : "00.0"; ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>Max Power</td>
                                                <td><?php echo !empty($rides_points['maxpowes']) ? $rides_points['maxpowes'] : "00.0"; ?> Watts</td>
                                            </tr>
                                            <tr>
                                                <td>Avg Power</td>
                                                <td><?php echo !empty($rides_points['avgpower']) ? $rides_points['avgpower'] : "00.0"; ?> Watts</td>
                                            </tr>
                                            <tr>
                                                <td>Max Current</td>
                                                <td><?php echo !empty($rides_points_calculation['maxcurrent']) ? $rides_points_calculation['maxcurrent'] : "00.0"; ?> Amps</td>
                                            </tr>
                                            <tr>
                                                <td>Avg Current</td>
                                                <td><?php echo !empty($rides_points_calculation['avgcurrent']) ? $rides_points_calculation['avgcurrent'] : "00.0"; ?> Amps</td>
                                            </tr>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="tab2default">Default 2</div>
                                    <div class="tab-pane fade" id="tab3default">Default 3</div>
                                    <div class="tab-pane fade" id="tab4default">Default 4</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12" style="margin-top:50px">
             <?php if($rides_points['graph_data']) {?>
            <h2>Details</h2>
            <div class="row" id="default_graph">    
              <div id="chartdiv" style="height: 659px; width: 100%;"></div>
            </div>
            
<!--             <div class="row" id="load_graph" style="display:none;">-->
               
             
            
<!--              <button type="button" id="load_more" class="btn btn-success" name="load_more">Load More</button>     -->
<!--            </div>-->
<!--            <div class="col-md-3">
                                        <ul class="radio-ul-li">
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio1" checked="checked" id="radio1" value="option1"> 
                                        <label for="radio1">Speed</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio2" checked="checked" id="radio2" value="option2"> 
                                        <label for="radio2">Power</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio3" checked="checked" id="radio3" value="option1"> 
                                        <label for="radio3">Elevation</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio4" checked="checked" id="radio4" value="option1"> 
                                        <label for="radio4">Hill Incline</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio5" id="radio5" value="option1"> 
                                        <label for="radio5">Battery %</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio6" id="radio6" value="option1"> 
                                        <label for="radio6">Trip Distance</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio7" id="radio7" value="option1"> 
                                        <label for="radio7">E-Score</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio8" id="radio8" value="option1"> 
                                        <label for="radio8">Energy(Wh)</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio7" id="radio9" value="option1"> 
                                        <label for="radio9">Pack voltage</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio8" id="radio10" value="option2"> 
                                        <label for="radio10">Pack Current</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
            
                        <div class="col-md-3">
                            <ul class="radio-ul-li">
            
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio11" id="radio11" value="option11"> 
                                        <label for="radio11">Cell 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio12" id="radio12" value="option12"> 
                                        <label for="radio12">Cell 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio13" id="radio13" value="option13"> 
                                        <label for="radio13">Cell 3</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio14" id="radio14" value="option14"> 
                                        <label for="radio14">Cell 4</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio15" id="radio15" value="option15"> 
                                        <label for="radio15">Cell 5</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio16" id="radio16" value="option16"> 
                                        <label for="radio16">Cell 6</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio17" id="radio17" value="option17"> 
                                        <label for="radio17">Cell 7</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio18" id="radio18" value="option18"> 
                                        <label for="radio18">Cell 8</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio19" id="radio19" value="option19"> 
                                        <label for="radio19">Cell 9</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio20" id="radio20" value="option20"> 
                                        <label for="radio20">Cell 10</label>
                                    </div>
                                </li>
            
                            </ul>
                        </div>
            
                        <div class="col-md-3">
                            <ul class="radio-ul-li">
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio21" id="radio21" value="option21"> 
                                        <label for="radio21">rmp 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio22" id="radio22" value="option22"> 
                                        <label for="radio22">motor direction 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio23" id="radio23" value="option23"> 
                                        <label for="radio23">motor amps 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio24" id="radio24" value="option24"> 
                                        <label for="radio24">motor volts 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio25" id="radio25" value="option25"> 
                                        <label for="radio25">esc 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio26" id="radio26" value="option26"> 
                                        <label for="radio26">rmp 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio27" id="radio27" value="option27"> 
                                        <label for="radio27">motor direction 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio28" id="radio28" value="option28"> 
                                        <label for="radio28">motor amps 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio29" id="radio29" value="option29"> 
                                        <label for="radio29">motor volts 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio30" id="radio30" value="option30"> 
                                        <label for="radio30">esc 2</label>
                                    </div>
                                </li>
                            </ul>
                        </div> 
                        <div class="col-md-3">
                            <ul class="radio-ul-li">
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio31" id="radio31" value="option31"> 
                                        <label for="radio31">Wh reading</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio32" id="radio32" value="option32"> 
                                        <label for="radio32">Board Odometer Reading</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio33" id="radio33" value="option33"> 
                                        <label for="radio33">remoteBLEConnection</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio34" id="radio34" value="option34"> 
                                        <label for="radio34">internalTamp</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio35" id="radio35" value="option35"> 
                                        <label for="radio35">Remote throttle value</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio36" id="radio36" value="option36"> 
                                        <label for="radio36">Remote battery</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio37" id="radio37" value="option37"> 
                                        <label for="radio37">Throttle from App send</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="radio radio-primary"> 
                                        <input type="checkbox" name="radio38" id="radio38" value="option38"> 
                                        <label for="radio38">ble Connection strength RSSI</label>
                                    </div>
                                </li>
                            </ul>
                        </div>-->
        </div>
             <?php } ?>
    </div>

</div>
<script src="<?php echo base_url(); ?>assets/js/amChart/amcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/amChart/serial.js"></script>
<script src="<?php echo base_url(); ?>assets/js/amChart/light.js"></script>
<script src="<?php echo base_url(); ?>assets/js/amChart/autoOffsetAxis.min.js"></script>
<script type="text/javascript">

    /**
     * Create a chart
     */
    $("#load_more").click(function(){
        $("#chartdiv").css("display","none");
         $("#chartdiv1").css("display","block");
         $("#load_more").css("display","none");
         $("#back").css("display","block");
        
    });
     $("#back").click(function(){
        $("#chartdiv").css("display","block");
         $("#chartdiv1").css("display","none"); 
         $("#back").css("display","none");
         $("#load_more").css("display","block");
        
    });
   


var chartData = generateChartData();
    var chart = AmCharts.makeChart("chartdiv", {
      
        "type": "serial",
        "theme": "light",
        
         "legend": {
    "useGraphSettings": true,
    "clickMarker": handleLegendClick,
    "clickLabel": handleLegendClick
  },
        "dataProvider": chartData,
        "valueAxes": [{
                "id": "v1",
                "axisColor": "#FF6600",
                "axisThickness": 2, 
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
                }, {
                "id": "v2",
                "axisColor": "#04D215",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v3",
                "axisColor": "#0D8ECF",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v4",
                "axisColor": "#ff00ff",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v5",
                "axisColor": "#374321",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v6",
                "axisColor": "#0f48a5",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v7",
                "axisColor": "#57a50f",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v8",
                "axisColor": "#ffbf00",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }, {
                "id": "v9",
                "axisColor": "#C390D4",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v10",
                "axisColor": "#5E1B36",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v11",
                "axisColor": "#5E3D1B",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v12",
                "axisColor": "#445E1B",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v13",
                "axisColor": "#2383A1",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v14",
                "axisColor": "#1C4BD9",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                
             "id": "v15",
                "axisColor": "#771CD9",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
           }
            ,
            {
                "id": "v16",
                "axisColor": "#D91CC9",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }
            ,{
                "id": "v17",
                "axisColor": "#D91C35",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }
            ,{
                "id": "v18",
                "axisColor": "#1CD9C0",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            }
            ,{
                "id": "v19",
                "axisColor": "#636E62",
                "axisThickness": 2, 
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }
            ,{
                "id": "v20",
                "axisColor": "#6FA9D1",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },
             {
                "id": "v21",
                "axisColor": "#17E324",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v22",
                "axisColor": "#0AB8F2",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v23",
                "axisColor": "#A01DAD",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v24",
                "axisColor": "#990890",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v25",
                "axisColor": "#E08E26",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v26",
                "axisColor": "#D11944",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v27",
                "axisColor": "#22F2C2",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v28",
                "axisColor": "#D1667F",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v29",
                "axisColor": "#5A22F2",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v30",
                "axisColor": "#B1E81E",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v31",
                "axisColor": "#7D88DB",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v32",
                "axisColor": "#F07AC3",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },
            {
                "id": "v33",
                "axisColor": "#58E88F",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v34",
                "axisColor": "#604575",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v35",
                "axisColor": "#FA760A",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "right",
                "tickLength": 0,
                "autoOffset": true
            },{
                "id": "v36",
                "axisColor": "#85ACCC",
                "axisThickness": 2,
                "gridAlpha": 0,
                "axisAlpha": 1,
                "position": "left",
                "tickLength": 0,
                "autoOffset": true
            }

        ],
        "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#FF6600",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Speed(MPH)",
                "valueField": "speed",
                "fillAlphas": 0
                
                
            }, {
                "valueAxis": "v2",
                "lineColor": "#04D215",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Elevation(feet)",
                "valueField": "elevation",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#0D8ECF",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Battery %",
                "valueField": "battery",
                "fillAlphas": 0
            }, {
                "valueAxis": "v4",
                "lineColor": "#ff00ff",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Remote Battery %",
                "valueField": "remote_batt",
                "fillAlphas": 0
                
            }, {
                "valueAxis": "v5",
                "lineColor": "#374321",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Hill Incline %",
                "valueField": "hill_incline",
                "fillAlphas": 0
            }, {
                "valueAxis": "v6",
                "lineColor": "#0f48a5",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Trip Distance(Mi)",
                "valueField": "trip_distance",
                "fillAlphas": 0
            }, {
                "valueAxis": "v7",
                "lineColor": "#57a50f",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Power(Watts)",
                "valueField": "power",
                "fillAlphas": 0
            }, {
                "valueAxis": "v8",
                "lineColor": "#ffbf00",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "E-scop %",
                "valueField": "efficiency_score",
                "fillAlphas": 0
            }, {
                "valueAxis": "v9",
                "lineColor": "#C390D4",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Energy(Wh)",
                "valueField": "energy",
                "fillAlphas": 0
            }, {
                "valueAxis": "v10",
                "lineColor": "#5E1B36",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage",
                "valueField": "voltage",
                "fillAlphas": 0
            }, {
                "valueAxis": "v11",
                "lineColor": "#5E3D1B",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage1",
                "valueField": "voltage1",
                "fillAlphas": 0
                //"hidden":true
            }, {
                "valueAxis": "v12",
                "lineColor": "#445E1B",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage2",
                "valueField": "voltage2",
                "fillAlphas": 0,
                "hidden":true
            }, {
                "valueAxis": "v13",
                "lineColor": "#2383A1",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage3",
                "valueField": "voltage3",
                "fillAlphas": 0,
                "hidden":true
            }, {
                "valueAxis": "v14",
                "lineColor": "#1C4BD9",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage4",
                "valueField": "voltage4",
                "fillAlphas": 0,
                "hidden":true
            },{
                "valueAxis": "v15",
                "lineColor": "#771CD9",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage5",
                "valueField": "voltage5",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v16",
                "lineColor": "#D91CC9",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage6",
                "valueField": "voltage6",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v17",
                "lineColor": "#D91C35",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage7",
                "valueField": "voltage7",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v18",
                "lineColor": "#1CD9C0",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage8",
                "valueField": "voltage8",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v19",
                "lineColor": "#636E62",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage9",
                "valueField": "voltage9",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v20",
                "lineColor": "#6FA9D1",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Voltage10",
                "valueField": "voltage10",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v21",
                "lineColor": "#A01DAD",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Rpm1",
                "valueField": "rpm1",
                "fillAlphas": 0,
                "hidden":true
            }
             , {
                "valueAxis": "v22",
                "lineColor": "#0AB8F2",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor direction1",
                "valueField": "motor_direction1",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v23",
                "lineColor": "#17E324",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor amps1",
                "valueField": "motor_amps1",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v24",
                "lineColor": "#990890",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor volts1",
                "valueField": "motor_volts1",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v25",
                "lineColor": "#E08E26",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Esc1",
                "valueField": "esc1",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v26",
                "lineColor": "#D11944",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Rpm2",
                "valueField": "rpm2",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v27",
                "lineColor": "#22F2C2",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor direction2",
                "valueField": "motor_direction2",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v28",
                "lineColor": "#D1667F",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor amps2",
                "valueField": "motor_amps2",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v29",
                "lineColor": "#5A22F2",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Motor volts2",
                "valueField": "motor_volts2",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v30",
                "lineColor": "#B1E81E",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Esc2",
                "valueField": "esc2",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v31",
                "lineColor": "#7D88DB",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Wh",
                "valueField": "wh",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v32",
                "lineColor": "#F07AC3",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Odometer",
                "valueField": "odometer",
                "fillAlphas": 0,
                "hidden":true
            }
            , {
                "valueAxis": "v33",
                "lineColor": "#58E88F",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Remote BLEConnection",
                "valueField": "remoteBLEConnection",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v34",
                "lineColor": "#604575",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Internal Temperature",
                "valueField": "internalTemperature",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v35",
                "lineColor": "#FA760A",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Throttle",
                "valueField": "throttle",
                "fillAlphas": 0,
                "hidden":true
            },
            {
                "valueAxis": "v36",
                "lineColor": "#85ACCC",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Ble conn strength",
                "valueField": "ble_conn_strength",
                "fillAlphas": 0,
                "hidden":true
            }
            
        ],
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse"
        },
        "categoryField": "date",
        "categoryAxis": {
            "minPeriod": "ss",
            "parseDates": true,
            "boldPeriodBeginning": true,
            "gridPosition": "start"
        },
        "export": {
            "enabled": true,
            "position": "bottom-right"
        }
    });
  
    
    chart.addListener("dataUpdated", zoomChart);
    zoomChart();
  

    function generateChartData() {
        var chartData = [];
        var graph_data = $.parseJSON('<?php echo json_encode($rides_points['graph_data']); ?>');
        if (graph_data !== null) {
            for (var i = 0; i < graph_data.length; i++) {
                var newDate = new Date(graph_data[i].time_stamp);
                newDate.setSeconds(newDate.getSeconds());

                chartData.push({
                    date: newDate,
                    speed: graph_data[i].speed,
                    elevation: graph_data[i].elevation,
                    battery: graph_data[i].battery,
                    remote_batt: graph_data[i].remote_batt,
                    hill_incline: graph_data[i].hill_incline,
                    trip_distance:graph_data[i].trip_distance,
                    power:graph_data[i].power,
                    efficiency_score:graph_data[i].efficiency_score,
                    energy:graph_data[i].energy,
                    voltage:graph_data[i].voltage,
                    voltage1:graph_data[i].voltage1,
                    voltage2:graph_data[i].voltage2,
                    voltage3:graph_data[i].voltage3,
                    voltage4:graph_data[i].voltage4,
                    voltage5:graph_data[i].voltage5,
                    voltage6:graph_data[i].voltage6,
                    voltage7:graph_data[i].voltage7,
                    voltage8:graph_data[i].voltage8,
                    voltage9:graph_data[i].voltage9, 
                    voltage10:graph_data[i].voltage10,
                    rpm1:graph_data[i].rpm1,
                    motor_direction1:graph_data[i].motor_direction1, 
                    motor_amps1:graph_data[i].motor_amps1,
                    motor_volts1:graph_data[i].motor_volts1,
                    esc1:graph_data[i].esc1,
                    rpm2:graph_data[i].rpm2,
                    motor_direction2:graph_data[i].motor_direction2,
                    motor_amps2:graph_data[i].motor_amps2,
                    motor_volts2:graph_data[i].motor_volts2,
                    esc2:graph_data[i].esc2,
                    wh:graph_data[i].wh,
                    odometer:graph_data[i].odometer,
                    remoteBLEConnection:graph_data[i].remoteBLEConnection,
                    internalTemperature:graph_data[i].internalTemperature,
                    throttle:graph_data[i].throttle,
                    ble_conn_strength:graph_data[i].ble_conn_strength
                });
             
            }
            return chartData;
        }
    }
    
    // check condition of how many data are show on graph
    function handleLegendClick(graph) {
         var chart = graph.chart;
         var count = 0;
         var ids = [];

         var selGraph = null;

         for( var i = 0; i < chart.graphs.length; i++ ) {
             if(chart.graphs[i].hidden == false) {
                 ids.push(chart.graphs[i].id);
                 count++;
             }
             if (graph.id === chart.graphs[i].id) {
                 selGraph = chart.graphs[i];
             }
         }
         if (selGraph != null) {
             if (ids.indexOf(graph.id) != -1) {
                 //alert(selGraph);
                 chart.hideGraph(selGraph);
                  //console.log(chart.graphs[i]);
             }
             else {
                 if (count < 11) {
                     chart.showGraph(selGraph);
                 }
             }
         }
         return false;
    }
    // check condition of how many data are show on graph


    function zoomChart() {
       
            chart.zoomToIndexes(chart.dataProvider.length - 1000, chart.dataProvider.length - 1);
        
    }
 
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzddLs98Y66TgM0dTVTbYHvdtD7NbkmW4&callback=initMap"></script>
<script>

    function initMap() {

        var flightPlanCoordinates =<?php echo preg_replace('/["]/', '', json_encode($rides_points['polyline'])); ?>

        var map = new google.maps.Map(document.getElementById('map_data'), {
            zoom: 14,
            center: flightPlanCoordinates[0],
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
                {
                    featureType: 'all',
                    stylers: [
                        {saturation: -80}
                    ]
                }, {
                    featureType: 'road.arterial',
                    elementType: 'geometry',
                    stylers: [
                        {hue: '#00ffee'},
                        {saturation: 50}
                    ]
                }, {
                    featureType: 'poi.business',
                    elementType: 'labels',
                    stylers: [
                        {visibility: 'off'}
                    ]
                }, {
                    featureType: 'poi.park',
                    elementType: 'labels',
                    stylers: [
                        {hue: '#990000'},
                        {saturation: 10}
                    ]
                }
            ]

        });

        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#00aeef',
            strokeOpacity: 1.0,
            strokeWeight: 8
        });


        var startMarker = new google.maps.Marker({
            position: flightPath.getPath().getAt(0),
            map: map,
            title: "Ride Start Here",
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
        });
        var endMarker = new google.maps.Marker({
            position: flightPath.getPath().getAt(flightPath.getPath().getLength() - 1),
            map: map,
            title: "Ride End Here",
            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
        });

        flightPath.setMap(map);

    }


</script>
<style>
    .amcharts-chart-div>a{

        display: none !important;
    }
</style>
