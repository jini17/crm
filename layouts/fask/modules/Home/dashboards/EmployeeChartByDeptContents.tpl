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
              <div class="" id="widgetChartContainer_{$WIDGET->get('id')}" style="height:250px; width:100%;"> 
               <div style="position: absolute;z-index: 99;display: none;color: #fff;background: rgba(0,0,0,.7);bottom: 12px;left: 136px;padding: 10px;border-radius: 6px;" class="tooltipgraph">popup</div>
           </div>
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
          
    var hreflinks = [];
          
      for(var i = 0; i < data.links.length ; i++){
         hreflinks.push(data.links[i]);
      }	

    var chartData = [];
    var labelarray = [];
    var labelobjarray = [];
    var valuearray = []; 
    var ledgend_color = []

    for(var i = 0; i < data.labels.length ; i++){
       var label = data.labels[i];
       var links = data.links[i];
       var value = parseInt(data.values[i]);
       var rowData = [label, value,links];
        var colors = data.colors[i]
        ledgend_color.push(colors);
       chartData.push(rowData);

    }	
  
    var plot1 = $.jqplot("widgetChartContainer_{$WIDGET->get('id')}", [chartData], {
        gridPadding: {
            top:0, 
            bottom:38,
            left:0, 
            right:0
        },
        grid: {
            borderColor: 'white', 
            shadow: false, 
            drawBorder: true
        },
           seriesColors:ledgend_color,
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
            }
        },
        highlighter: {
        tooltipContentEditor: function (str, seriesIndex, pointIndex) {
            return str + "<br/> additional data";
        },

        // other options just for completeness
        show: true,
        showTooltip: true,
        tooltipFade: true,
        sizeAdjust: 10,
        formatString: '%s',
        tooltipLocation: 'n',
        useAxesFormatters: false,
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
           link = data[data.length -1];
            window.open(link,"_blank");
    });
    previousPoint = null;
$('#widgetChartContainer_{$WIDGET->get('id')}').bind('jqplotMouseLeave', function (ev, seriesIndex, pointIndex, data) {
        $('#widgetChartContainer_{$WIDGET->get('id')} .tooltipgraph').text('').hide()
});
$('#widgetChartContainer_{$WIDGET->get('id')}').bind('jqplotDataMouseOver', function (ev, seriesIndex, pointIndex, data) { 
    var labels = $('#widgetChartContainer_{$WIDGET->get('id')} .jqplot-data-label');
    $('#widgetChartContainer_{$WIDGET->get('id')} .tooltipgraph').text('').show();
            if (previousPoint != null)
            {
               labels[previousPoint['idx']].innerHTML = previousPoint['data'][1]+'';               
            }

            $('#widgetChartContainer_{$WIDGET->get('id')} .tooltipgraph').text(data[0] + ": " + data[1]);      
            $( '#widgetChartContainer_{$WIDGET->get('id')} .jqplot-event-canvas').on('mouseout',function(){
             $('#widgetChartContainer_{$WIDGET->get('id')} .tooltipgraph').text('').hide()
            });
      });
});
</script>
