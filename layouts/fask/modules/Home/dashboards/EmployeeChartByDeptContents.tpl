{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}

{assign var=WIDGETDOMID value=$WIDGET->get('linkid')|cat:'-':$WIDGET->get('id')}

 {if count($DATA) gt 0 }
    <input id="widgetChart_{$WIDGET->get('id')}" type=hidden value='{$DATA}' />
    <input class="yAxisFieldType" type="hidden" value="{$YAXIS_FIELD_TYPE}" />
        <input type='hidden' name='widgetid' id="{$WIDGET->get('id')}" value="{$WIDGET->get('id')}" />
        <input type='hidden' name='data' value='{$DATA}' />
        <input type='hidden' name='clickthrough' value="{$CLICK_THROUGH}" />

   <div class="row" style="margin:0px 10px;height:250px;width:100%;">
        <div class="col-lg-11">


           <div class="" id="widgetChartContainer_{$WIDGET->get('id')}"></div>
            <br>
        </div>
                <div class="col-lg-1"></div>
    </div>
{else}
    <span class="noDataMsg">
        {vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
    </span>
{/if}

{if $CHART_TYPE eq 'pieChart' OR $CHART_TYPE eq ''  OR empty($CHART_TYPE)}
<script type="text/javascript">



          var jData = jQuery("#widgetChart_{$WIDGET->get('id')}").val();
          var data = JSON.parse(jData);


         {* var hreflinks = [];
      for(var i = 0; i < data.links.length ; i++){
         hreflinks.push(data.links[i]);
      }	*}
         var chartData = [];

         for(var i = 0; i < data.labels.length ; i++){
                var label = data.labels[i];
                var value = data.values[i];
                var rowData = [label, value];
                chartData.push(rowData);
        }	

             var chartOptions = {
                        seriesDefaults:{
                        renderer:$.jqplot.PieRenderer,
                                                     sliceMargin: 0,
                                                    lineWidth: 0,        
                                                     startAngle: 10,
                                                    showDataLabels: true,
                                                    shadowAlpha: 0,     
                                                    ringMargin:2,               
                                                     varyBarColor: true,             
                                                       thickness: 7 ,
                        rendererOptions: {
                            showDataLabels: true,
                        },
                       //links: hreflinks,
                },

                grid: {
                        drawBorder: false, 
                        drawGridlines: false,
                        background: '',
                        shadow:false
                    },
                    axesDefaults: {
                                yaxis:{
                                    min:-10,
                                    max:240
                                }
                    },
                    gridPadding: {
                        top:0,
                        bottom:0, 
                        left:0,
                        right:0
                    },
                legend:{ 
                                                show:true,
                                                fontSize:'11px', 
                                                placement: 'outside',

                                                rendererOptions:{ 
                                                numberRows:data.labels.length}, 
                                                location: 'e', 
                                                marginTop:'5px',
                                                 marginLeft:'100px;'
                                            },

        };




          var plot5 = $.jqplot("widgetChartContainer_{$WIDGET->get('id')}", [chartData], chartOptions);

</script>

{elseif $CHART_TYPE eq 'verticalbarChart'}

<script type="text/javascript">
    $(document).ready(function(){

          var jData = jQuery("#widgetChart_{$WIDGET->get('id')}").val();
          var data = JSON.parse(jData);
          console.log(data);
                 var chartData = [];
                      var labelarray = [];
                      var labelobjarray = [];
         var valuearray = []; 
         for(var i = 0; i < data.labels.length ; i++){
                var label = data.labels[i];
                var value = data.values[i];
                var rowData = [label, value];
                chartData.push(rowData);
                               labelarray.push(label);
                               
                               valuearray.push(value);
        }	
{*        alert(data.labels);
          var s1= [460, -210, 690, 820];
  var s2 = [460, -210, 690, 820];
    var s3 = [-260, -440, 320, 200];*}
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    var ticks =data.labels;


  var chartOptions =  {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {
                fillToZero: true
            }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[labelarray],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outsideGrid',
            localhost:'e'
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
           yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            {*yaxis: {
                pad: 1.05,

            }*}
        }
    };
        var plot6 = $.jqplot("widgetChartContainer_{$WIDGET->get('id')}",[valuearray], chartOptions);
      
});

</script>

{elseif $CHART_TYPE eq 'lineChart'}

<script type="text/javascript">
$(document).ready(function(){
    
    


          var jData = jQuery("#widgetChart_{$WIDGET->get('id')}").val();
          var data = JSON.parse(jData);
          console.log(data);

         {* var hreflinks = [];
      for(var i = 0; i < data.links.length ; i++){
         hreflinks.push(data.links[i]);
      }	*}
         var chartData = [];
         var labelarray = [];
         var valuearray = []

         for(var i = 0; i < data.labels.length ; i++){
             var value ='';
             var label = '';
                 label= data.labels[i];
                 value = data.values[i];
                var rowData = [label, value];
                chartData.push(rowData);
              labelarray.push(label);
              valuearray.push([i,value]);
        }	
    var cosPoints = [];
  for (var i=0; i<2*Math.PI; i+=1){ 
    cosPoints.push([i, Math.cos(i)]); 
  }
console.log(cosPoints);
console.log(valuearray);
{*  var sinPoints = []; 
  for (var i=0; i<2*Math.PI; i+=0.4){ 
     sinPoints.push([i, 2*Math.sin(i-.8)]); 
  }
    
  var powPoints1 = []; 
  for (var i=0; i<2*Math.PI; i+=1) { 
      powPoints1.push([i, 2.5 + Math.pow(i/4, 2)]); 
  }
    
  var powPoints2 = []; 
  for (var i=0; i<2*Math.PI; i+=1) { 
      powPoints2.push([i, -2.5 - Math.pow(i/4, 2)]); 
  } *}
 
  var plot3 = $.jqplot("widgetChartContainer_{$WIDGET->get('id')}", [valuearray], 
    { 
      title:'', 
      // Set default options on all series, turn on smoothing.
      seriesDefaults: {
          rendererOptions: {
              smooth: true
          }
      },
      // Series options are specified as an array of objects, one object
      // for each series.
      series:[ 
          {
            // Change our line width and use a diamond shaped marker.
            lineWidth:2, 
            markerOptions: { style:'diamond' }
          }, 
          {
            // Don't show a line, just show markers.
            // Make the markers 7 pixels with an 'x' style
            showLine:true, 
            markerOptions: { size: 7, style:"x" }
          },
          { 
            // Use (open) circlular markers.
            markerOptions: { style:"circle" }
          }, 
          {
            // Use a thicker, 5 pixel line and 10 pixel
            // filled square markers.
            lineWidth:6, 
            markerOptions: { style:"filledSquare", size:10 }
          }
      ]
    }
  );
    
});
      {*  Vtiger_Barchat_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

                getPlotContainer : function(useCache) {
                        if(typeof useCache == 'undefined'){
                                useCache = false;
                        }
                        if(this.plotContainer == false || !useCache) {
                                var container = this.getContainer();
                                this.plotContainer = jQuery('.widgetChartContainer');
                        }
                        return this.plotContainer;
                },

                generateData : function() {


                        //var jsonData = jQuery('input[name=data]').val();
                        var thisInstance  = this;
                        var parent = thisInstance.getContainer();
                        var jsonData = parent.find("input[name=data]").val();

                        var data = this.data = JSON.parse(jsonData);
                        var values = data['values'];

                        var chartData = [];
                        var yMaxValue = 0;

                        chartData[1] = []
                        chartData[2] = []
                        chartData[0] = []
                        for(var i in values) {
                                var value =  values[i];
                                for(var j in value) {
                                        chartData[j].push(value[j]);
                                }
                        }
                        yMaxValue = yMaxValue + yMaxValue*0.15;

                        return {literal}{'chartData':chartData,
                                        'yMaxValue':yMaxValue,
                                        'labels':data['labels'],
                                        'data_labels':data['data_labels']

                                }{/literal};
                },

                loadChart : function() {
                        var data = this.generateData();
                        var thisInstance  = this;
                        var parent = thisInstance.getContainer();
                        var widgetid = parent.find("input[name=widgetid]").val();
                        var plot2 = $.jqplot('widgetChartContainer_'+widgetid, data['chartData'], {

                                legend:{
                                        show:true,
                                        labels:data['data_labels'],
                                        location:'ne',
                                        showSwatch : true,
                                        showLabels : true,
                                        placement: 'outside'
                        },
                                seriesDefaults: {
                                        pointLabels: {
                                                show: true
                                        }
                                },
                                axes: {
                                        xaxis: {
                                                min:0,
                                                pad: 1,
                                                renderer: $.jqplot.CategoryAxisRenderer,
                                                ticks:data['labels'],
                                                tickOptions: {
                                                        formatString: '%b %#d'
                                                }
                                        }
                                },
                                cursor: {
                                        show: true
                                }
                        });
                        jQuery('table.jqplot-table-legend').css('width','95px');
                }

        });*}
</script>

{elseif $CHART_TYPE eq 'horizontalbarChart'}

<script type="text/javascript">
$(document).ready(function(){
   
    // For horizontal bar charts, x an y values must will be "flipped"
    // from their vertical bar counterpart.
  var plot1 = $.jqplot ("widgetChart_{$WIDGET->get('id')}", [[3,7,9,1,5,3,8,2,5]]);      
});
$(document).ready(function(){
      var jData = jQuery("#widgetChart_{$WIDGET->get('id')}").val();
          var data = JSON.parse(jData);
           
        
   {*              var chartData = [];
                      var labelarray = [];
                      var labelobjarray = [];
         var valuearray = [];
         for(var i = 0; i < data.labels.length ; i++){
                var label = data.labels[i];
                var value = data.values[i];
                var rowData = [label, value];
                chartData.push(rowData);
                               labelarray.push(label);
                               
                               valuearray.push(value);
                               
        }	*}
                alert('horizontal');
              var plot2 = $.jqplot("widgetChart_{$WIDGET->get('id')}", [
        [[2,1], [4,2], [6,3], [3,4]], 
        [[5,1], [1,2], [3,3], [4,4]], 
        [[4,1], [7,2], [1,3], [2,4]]], {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
            // Rotate the bar shadow as if bar is lit from top right.
            shadowAngle: 135,
            // Here's where we tell the chart it is oriented horizontally.
            rendererOptions: {
                barDirection: 'horizontal'
            }
        },
        axes: {
            yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
    });
      {*  Vtiger_Barchat_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

                getPlotContainer : function(useCache) {
                        if(typeof useCache == 'undefined'){
                                useCache = false;
                        }
                        if(this.plotContainer == false || !useCache) {
                                var container = this.getContainer();
                                this.plotContainer = jQuery('.widgetChartContainer');
                        }
                        return this.plotContainer;
                },

                generateChartData : function() {

                        var thisInstance  = this;
                        var parent = thisInstance.getContainer();
                        var jsonData = parent.find("input[name=data]").val();

                        //var jsonData = jQuery('input[name=data]').val();
                        //var widgetid = jQuery('input[name=widgetid]').val();
                        //var jsonData = jQuery('#130-'+widgetid).find("input[name=data]").val();
                        var data = this.data = JSON.parse(jsonData);
                        var values = data['values'];

                        var chartData = [];
                        var yMaxValue = 0;

                        if(data['type'] == 'singleBar') {
                                for(var i in values) {
                                        var multiValue = values[i];
                                        chartData[i] = [];
                                        for(var j in multiValue) {
                                                chartData[i].push(multiValue[j]);
                                                chartData[i].push(parseInt(i)+1);
                                                if(multiValue[j] > yMaxValue){
                                                        yMaxValue = multiValue[j];
                                                }
                                        }
                                }
                                chartData = [chartData];
                        } else {
                                chartData = [];
                                chartData[0] = [];
                                chartData[1] = [];
                                chartData[2] = [];
                                for(var i in values) {
                                        var multiValue = values[i];
                                        for(var j in multiValue) {
                                                chartData[j][i] = [];
                                                chartData[j][i].push(multiValue[j]);
                                                chartData[j][i].push(parseInt(i)+1);
                                                if(multiValue[j] > yMaxValue){
                                                        yMaxValue = multiValue[j];
                                                }
                                        }
                                }
                        }
                        yMaxValue = yMaxValue + (yMaxValue*0.15);

                        return {literal}{'chartData':chartData,
                                        'yMaxValue':yMaxValue,
                                        'labels':data['labels'],
                                        'data_labels':data['data_labels']

                                }{/literal};

                },

                loadChart : function() {
                        var data = this.generateChartData();
                        var labels = data['labels'];
                        var thisInstance  = this;
                        var parent = thisInstance.getContainer();
                        var widgetid = parent.find("input[name=widgetid]").val();
                        //var widgetid = jQuery('input[name=widgetid]').val();

                        jQuery.jqplot('widgetChartContainer_'+widgetid, data['chartData'], {
                                title: data['title'],
                                animate: !$.jqplot.use_excanvas,
                    seriesDefaults: {
                        renderer:$.jqplot.BarRenderer,
                                        showDataLabels: true,
                        pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                        shadowAngle: 135,
                        rendererOptions: {
                            barDirection: 'horizontal'
                        }
                    },
                    axes: {
                        yaxis: {
                                                tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
                                                renderer: jQuery.jqplot.CategoryAxisRenderer,
                                                ticks: labels,
                                                tickOptions: {
                                                  angle: -45
                                                }
                        }
                    },
                                legend: {
                        show: true,
                        location: 'e',
                        placement: 'outside',
                                        showSwatch : true,
                                        showLabels : true,
                                        labels:data['data_labels']
                    }
                });
                        jQuery('table.jqplot-table-legend').css('width','95px');
                },

        });*}
</script>

{/if}

<style>
    [data-name="EmployeeChartByDept"]{
      width: 480px !important; 
    }
</style>    