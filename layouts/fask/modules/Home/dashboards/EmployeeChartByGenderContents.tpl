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


           <div class="" id="widgetChartContainer_{$WIDGET->get('id')}" style="height:250px; width:100%;"></div>
            <br>
        </div>
                <div class="col-lg-1"></div>
    </div>
{else}
    <span class="noDataMsg">
        {vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
    </span>
{/if}

<script type="text/javascript">
    $(document).ready(function(){

           var jData = jQuery("#widgetChart_{$WIDGET->get('id')}").val();
          var data = JSON.parse(jData);
             var chartData = [];
                      var labelarray = [];
                      var labelobjarray = [];
         var valuearray = []; 
         for(var i = 0; i < data.labels.length ; i++){
                var label = data.labels[i];
                labelarray.push( data.labels[i]);
                var value = parseInt(data.values[i]);
                var rowData = [label, value];
                chartData.push(rowData);
                          
        }	
       
        console.log(chartData);
    var plot1 = $.jqplot("widgetChartContainer_{$WIDGET->get('id')}", [chartData], {
        gridPadding: {
            top:0, 
            bottom:38,
            left:0, 
            right:0
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            trendline:{ show:true }, 
            rendererOptions: { padding: 4, showDataLabels: true },
             
            trendline:{ show:true }, 
            rendererOptions: { padding: 4, showDataLabels: true },
            shadow: false, 
            rendererOptions:{
                sliceMargin: 4, 
                // rotate the starting position of the pie around to 12 o'clock.
                startAngle: -90,
                showDataLabels: true
            },
            highlighter: {
                show: true,
                useAxesFormatters: false,
                tooltipFormatString: '%d'
              }
        },
        
        legend:{
          show: true,
                location: 'e',
                renderer: $.jqplot.EnhancedPieLegendRenderer,
                rendererOptions: {
                    numberColumns: 1,
                    toolTips: labelarray
                }
        }       
    });
    
$("#widgetChartContainer_{$WIDGET->get('id')}").bind('jqplotDataHighlight', function () {

                                            $('html,body').css('cursor','pointer');	  											
    });

$("#widgetChartContainer_{$WIDGET->get('id')}").bind('jqplotDataUnhighlight', function () {

                                            $('html,body').css('cursor','default');	  											
    }); 	

$("#widgetChartContainer_{$WIDGET->get('id')}").bind('jqplotDataClick', function (ev, seriesIndex, pointIndex, data) {

                                            link = data.pop();
                                            window.open(link,"_blank");

    });
});

{* var urls = ["www.yahoo.com", "www.google.com", "www.java.com", "www.w3schools.com/js/js_obj_date.asp"];
  $('#widgetChartContainer_{$WIDGET->get('id')}').bind('jqplotDataClick', function (ev, seriesIndex, pointIndex, data) {
      if(seriesIndex === 0){
          var url = urls[pointIndex];
          window.open("http://"+url);
      }
  });*}
</script>
{*[
    [
        ['a',25],
        ['b',14],
        ['c',7]
    ]
]
 Array [ "", "4" ]​
 1:  Array [ "Gen X", "3" ]​
 2: Array [ "Gen Z", "2" ]​
 3: Array [ "Millennials", "9" ]​
 4: Array [ "Xennials", "4" ]​
*}
