
jQuery.Class("Dashboard_ReportChart_Js", {

	/**
	 * Function used to display message when there is no data from the server
	 */
	displayNoDataMessage : function() {
		$('#chartcontent').html('<div>'+app.vtranslate('JS_NO_CHART_DATA_AVAILABLE')+'</div>').css(
								{'text-align':'center', 'position':'relative', 'top':'100px'});
	},

	/**
	 * Function returns if there is no data from the server
	 */
	isEmptyData : function() {
		var jsonData = jQuery('input[name=data]').val();
		var data = JSON.parse(jsonData);
		var values = data['values'];
		if(jsonData == '' || values == '') {
			return true;
		}
		return false;
	}
},{

	/**
	 * Function returns instance of the chart type
	 */
	getInstance : function() {

		var chartType = jQuery('input[name=charttype]').val();
		var chartClassName = chartType.toCamelCase();
		var chartClass = window["Dashboard_"+chartClassName + "_Js"];
		alert(chartClassName);
		var instance = false;
		if(typeof chartClass != 'undefined') {		alert("NOT");
			instance = new chartClass();
			instance.postInitializeCalls();
		}
		return instance;
	},

	registerSaveOrGenerateReportEvent : function(){
		var thisInstance = this;
		jQuery('.generateReport').on('click',function(e){
			if(!jQuery('#chartDetailForm').validationEngine('validate')) {
				e.preventDefault();
				return false;
			}

			var advFilterCondition = thisInstance.calculateValues();
			var recordId = thisInstance.getRecordId();
			var currentMode = jQuery(e.currentTarget).data('mode');
			var postData = {
				'advanced_filter': advFilterCondition,
				'record' : recordId,
				'view' : "ChartSaveAjax",
				'module' : app.getModuleName(),
				'mode' : currentMode,
				'charttype' : jQuery('input[name=charttype]').val(),
				'groupbyfield' : jQuery('#groupbyfield').val(),
				'datafields' : jQuery('#datafields').val()
			};

			var reportChartContents = thisInstance.getContentHolder().find('#reportContentsDiv');
			var element = jQuery('<div></div>');
			element.progressIndicator({
				'position':'html',
				'blockInfo': {
					'enabled' : true,
					'elementToBlock' : reportChartContents
				}
			});

			e.preventDefault();

			AppConnector.request(postData).then(
				function(data){
					element.progressIndicator({'mode' : 'hide'});
					reportChartContents.html(data);
					thisInstance.registerEventForChartGeneration();
				}
			);
		});


	},

	registerEventForChartGeneration : function() {
		var thisInstance = this;console.log(JSON.stringify(thisInstance));
		try {
			thisInstance.getInstance();	// instantiate the object and calls init function
			jQuery('#chartcontent').trigger(Vtiger_Widget_Js.widgetPostLoadEvent);
		} catch(error) {
			alert('ERROR');
			console.log("error");
			console.log(error);
			Dashboard_ReportChart_Js.displayNoDataMessage();
			return;
		}
	},

	registerEventForModifyCondition : function() {
		jQuery('button[name=modify_condition]').on('click', function() {
			var filter = jQuery('#filterContainer');
			var icon = jQuery(this).find('i');
			var classValue = icon.attr('class');
			if(classValue == 'icon-chevron-right') {
				icon.removeClass('icon-chevron-right').addClass('icon-chevron-down');
				filter.show('slow');
			} else {
				icon.removeClass('icon-chevron-down').addClass('icon-chevron-right');
				filter.hide('slow');
			}
			return false;
		});
	},

	registerEvents : function(){
		//this._super();
		//this.registerEventForModifyCondition();
		this.registerEventForChartGeneration();
		//Reports_ChartEdit3_Js.registerFieldForChosen();
		//Reports_ChartEdit3_Js.initSelectValues();
		//jQuery('#chartDetailForm').validationEngine(app.validationEngineOptions);
	}
});

Vtiger_Pie_Widget_Js('Dashboard_Piechart_Js',{},{

	postInitializeCalls : function() {

		var clickThrough = jQuery('input[name=clickthrough]').val();
		if(clickThrough != '') {

			var thisInstance = this;
			this.getContainer().on("jqplotDataClick", function(evt, seriesIndex, pointIndex, neighbor) {
				var linkUrl = thisInstance.data['links'][pointIndex];
				if(linkUrl) window.location.href = linkUrl;
			});
			this.getContainer().on("jqplotDataHighlight", function(evt, seriesIndex, pointIndex, neighbor) {
				$('.jqplot-event-canvas').css( 'cursor', 'pointer' );
			});
			this.getContainer().on("jqplotDataUnhighlight", function(evt, seriesIndex, pointIndex, neighbor) {
				$('.jqplot-event-canvas').css( 'cursor', 'auto' );
			});
		}
	},

	postLoadWidget : function() {
		alert('DASHPOSTLOD');
		if(!Dashboard_ReportChart_Js.isEmptyData()) {
			this.loadChart();
		}else{
			this.positionNoDataMsg();
		}
	},

	positionNoDataMsg : function() {
		Dashboard_ReportChart_Js.displayNoDataMessage();
	},

	getPlotContainer : function(useCache) {
		if(typeof useCache == 'undefined'){
			useCache = false;
		}
		if(this.plotContainer == false || !useCache) {
			var container = this.getContainer();
			this.plotContainer = jQuery('#chartcontent');
		}
		return this.plotContainer;
	},

	init : function() {
		this._super(jQuery('#reportContentsDiv'));
	},

	generateData : function() {
		if(Dashboard_ReportChart_Js.isEmptyData()) {
			Dashboard_ReportChart_Js.displayNoDataMessage();
			return false;
		}
		alert('IN>>>');		
		var jsonData = jQuery('input[name=data]').val();
		var data = this.data = JSON.parse(jsonData);
		var values = data['values'];

		var chartData = [];
		for(var i in values) {
			chartData[i] = [];
			chartData[i].push(data['labels'][i]);
			chartData[i].push(values[i]);
		}
		return {'chartData':chartData, 'labels':data['labels'], 'data_labels':data['data_labels'], 'title' : data['graph_label']};
	}

});

jQuery(document).ready(function(e){ alert('board');
	var rcinstance = new Dashboard_ReportChart_Js();
	rcinstance.registerEvents();
})
