{************************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************}
<!--//ADDED BY JITU@SECONDCRM.COM- #dashreportchart-->
{assign var=WIDGETDOMID value=$WIDGET->get('linkid')|cat:'-':$WIDGET->get('id')}

 {if count($DATA) gt 0 }
    <input class="widgetData" type=hidden value='{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($DATA))}' />
    <input class="yAxisFieldType" type="hidden" value="{$YAXIS_FIELD_TYPE}" />

    <input type='hidden' name='charttype' value="{$CHART_TYPE}" />
	<input type='hidden' name='widgetid' id="{$WIDGET->get('id')}" value="{$WIDGET->get('id')}" />
	<input type='hidden' name='data' value='{$DATA}' />
	<input type='hidden' name='clickthrough' value="{$CLICK_THROUGH}" />

   <div class="row" style="margin:0px 10px;">
        <div class="col-lg-11">
           <div class="" id="widgetChartContainer_{$WIDGET->get('id')}" style="height:250px;width:85%;margin: 0 auto;">sdsdsdjksdhsdkjhsjsh</div>
            <br>
        </div>
		<div class="col-lg-1"></div>
    </div>
{else}
    <span class="noDataMsg">
        {vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
    </span>
{/if}

{if $CHART_TYPE eq 'pieChart'}
<script type="text/javascript">
	Vtiger_Pie_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

		getPlotContainer : function(useCache) {

			if(typeof useCache == 'undefined'){
				useCache = false;
			}
			if(this.plotContainer == false || !useCache) {
				var container = this.getContainer();

				var widgetid = container.find("input[name=widgetid]").val();
				this.plotContainer = jQuery('#widgetChartContainer_'+widgetid);
			}
			return this.plotContainer;
		},

		/**
		 * Function which will give chart related Data
		 */
		generateData : function() {
			//var jsonData = jQuery('input[name=data]').val();

			var thisInstance  = this;
			var parent = thisInstance.getContainer();
			var jsonData = parent.find("input[name=data]").val();


			var data = this.data = JSON.parse(jsonData);
			var values = data['values'];

			var chartData = [];
			for(var i in values) {
				chartData[i] = [];
				chartData[i].push(data['labels'][i]);
				chartData[i].push(values[i]);
			}
			return  {literal}{'chartData':chartData, 'labels':data['labels'], 'data_labels':data['data_labels']}{/literal};
		}
	});
</script>

{elseif $CHART_TYPE eq 'verticalbarChart'}

<script type="text/javascript">
	Vtiger_Barchat_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

		getPlotContainer : function(useCache) {

			if(typeof useCache == 'undefined'){
				useCache = false;
			}
			if(this.plotContainer == false || !useCache) {
				var container = this.getContainer();
				var widgetid = container.find("input[name=widgetid]").val();
				this.plotContainer = jQuery('#widgetChartContainer_'+widgetid);
			}
			return this.plotContainer;
		},

		/**
		 * Function which will give chart related Data
		 */
		generateChartData : function() {

			//var jsonData = jQuery('input[name=data]').val();

			var thisInstance  = this;
			var parent = thisInstance.getContainer();
			var jsonData = parent.find("input[name=data]").val();

			var data = this.data = JSON.parse(jsonData);

			var values = data['values'];

			var chartData = [];
			var yMaxValue = 0;

			if(data['type'] == 'singleBar') {
				chartData[0] = [];
				for(var i in values) {
					var multiValue = values[i];
					for(var j in multiValue) {
						chartData[0].push(multiValue[j]);
						if(multiValue[j] > yMaxValue) yMaxValue = multiValue[j];
					}
				}
			} else {
				chartData[0] = [];
				chartData[1] = [];
				chartData[2] = [];
				for(var i in values) {
					var multiValue = values[i];
					var info = [];
					for(var j in multiValue) {
						chartData[j].push(multiValue[j]);
						if(multiValue[j] > yMaxValue) yMaxValue = multiValue[j]+3;//Modified +3 by HARIZ@10052016 for increasing number length for bar chart
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

	});
</script>

{elseif $CHART_TYPE eq 'lineChart'}

<script type="text/javascript">

	Vtiger_Barchat_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

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

	});
</script>

{elseif $CHART_TYPE eq 'horizontalbarChart'}

<script type="text/javascript">

	Vtiger_Barchat_Widget_Js('Vtiger_Reportchart_Widget_Js',{},{

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

	});
</script>

{/if}

