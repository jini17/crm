/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Vtiger_DashBoard_Js", {

    gridster: false,

//static property which will store the instance of dashboard
    currentInstance: false,
    dashboardTabsLimit: 1000,

    ViewMessage: function (userId) {
        var popupInstance = Vtiger_Popup_Js.getInstance();
        var searchparam = {};
        searchparam['employee_id'] = userId;
        var params = {};
        params['module'] = "MessageBoard";
        params['view'] = "MessagePopup";
        params['search_param'] = searchparam;
        params['record'] = userId;
        params['relatedLoad'] = true;

        var callback = function (data) {
            emailPreviewClass = app.getModuleSpecificViewClass('EmailPreview', 'Vtiger');
            _controller = new window[emailPreviewClass]();
            _controller.registerEventsForActionButtons();
            var descriptionContent = data.find('#iframeDescription').val();
            var frameElement = jQuery("#emailPreviewIframe")[0].contentWindow.document;
            frameElement.open();
            frameElement.close();
            jQuery('#emailPreviewIframe').contents().find('html').html(descriptionContent);
            jQuery("#emailPreviewIframe").height(jQuery('#emailPreviewIframe').contents().find('html').height());
            jQuery('#emailPreviewIframe').contents().find('html').find('a').on('click', function (e) {
                e.preventDefault();
                var url = jQuery(e.currentTarget).attr('href');
                window.open(url, '_blank');
            });
        }
        popupInstance.showPopup(params, null, callback);
    },
    addWidget: function (element, url) {
        var element = jQuery(element);
        var linkId = element.data('linkid');
        var name = element.data('name');
        var group = element.data('group');
  
  if(typeof element.attr("disabled") !== typeof undefined ){
   
        app.helper.showErrorNotification({"message": 'Widget already in use'});
      return false;
  }
  element.attr("disabled","disabled")
  element.attr("title","This widget is already active")   // Mabruk
// After adding widget, we should remove that widget from Add Widget drop down menu from active tab
        var activeTabId = Vtiger_DashBoard_Js.currentInstance.getActiveTabId();
      //  jQuery('a[data-name="' + name + '"]', "#tab_" + activeTabId).parent().hide();

        var widgetContainer = jQuery('<li class="new dashboardWidget loadcompleted" data-group="'+group+'" id="' + linkId + '" data-name="' + name + '" data-mode="open"></li>');
        widgetContainer.data('url', url);
        var width = element.data('width');
        var height = element.data('height');
        Vtiger_DashBoard_Js.gridster.add_widget(widgetContainer, width, height);
        Vtiger_DashBoard_Js.currentInstance.loadWidget(widgetContainer);
    },

    addMiniListWidget: function (element, url) {
// 1. Show popup window for selection (module, filter, fields)
// 2. Compute the dynamic mini-list widget url
// 3. Add widget with URL to the page.

        element = jQuery(element);

        app.request.post({"url": "index.php?module=Home&view=MiniListWizard&step=step1"}).then(function (err, res) {
            var callback = function (data) {
                var wizardContainer = jQuery(data);
                var form = jQuery('form', wizardContainer);

                var moduleNameSelectDOM = jQuery('select[name="module"]', wizardContainer);
                var filteridSelectDOM = jQuery('select[name="filterid"]', wizardContainer);
                var fieldsSelectDOM = jQuery('select[name="fields"]', wizardContainer);

                var moduleNameSelect2 = vtUtils.showSelect2ElementView(moduleNameSelectDOM, {
                    placeholder: app.vtranslate('JS_SELECT_MODULE')
                });
                var filteridSelect2 = vtUtils.showSelect2ElementView(filteridSelectDOM, {
                    placeholder: app.vtranslate('JS_PLEASE_SELECT_ATLEAST_ONE_OPTION')
                });
                var fieldsSelect2 = vtUtils.showSelect2ElementView(fieldsSelectDOM, {
                    placeholder: app.vtranslate('JS_PLEASE_SELECT_ATLEAST_ONE_OPTION'),
                    closeOnSelect: true,
                    maximumSelectionSize: 2
                });
                var footer = jQuery('.modal-footer', wizardContainer);

                filteridSelectDOM.closest('tr').hide();
                fieldsSelectDOM.closest('tr').hide();
                footer.hide();

                moduleNameSelect2.change(function () {
                    if (!moduleNameSelect2.val()) return;

                    var moduleNameSelect2Params = {
                        module: 'Home',
                        view: 'MiniListWizard',
                        step: 'step2',
                        selectedModule: moduleNameSelect2.val()
                    };

                    app.request.post({"data": moduleNameSelect2Params}).then(function (err, res) {
                        filteridSelectDOM.empty().html(res).trigger('change');
                        filteridSelect2.closest('tr').show();
                        fieldsSelect2.closest('tr').hide();
                        footer.hide();
                    })
                });
                filteridSelect2.change(function () {
                    if (!filteridSelect2.val()) return;

                    var selectedModule = moduleNameSelect2.val();
                    var filteridSelect2Params = {
                        module: 'Home',
                        view: 'MiniListWizard',
                        step: 'step3',
                        selectedModule: selectedModule,
                        filterid: filteridSelect2.val()
                    };

                    app.request.post({"data": filteridSelect2Params}).then(function (err, res) {
                        fieldsSelectDOM.empty().html(res).trigger('change');
                        var translatedModuleNames = JSON.parse(jQuery("#minilistWizardContainer").find("#translatedModuleNames").val());
                        var fieldsLabelText = app.vtranslate('JS_EDIT_FIELDS', translatedModuleNames[selectedModule], translatedModuleNames[selectedModule]);
                        fieldsSelect2.closest('tr').find('.fieldLabel label').text(fieldsLabelText);
                        fieldsSelect2.closest('tr').show();
                    });
                });
                fieldsSelect2.change(function () {
                    if (!fieldsSelect2.val()) {
                        footer.hide();
                    } else {
                        footer.show();
                    }
                });

                form.submit(function (e) {
                    e.preventDefault();
//To disable savebutton after one submit to prevent multiple submits
                    jQuery("[name='saveButton']").attr('disabled', 'disabled');
                    var selectedModule = moduleNameSelect2.val();
                    var selectedFilterId = filteridSelect2.val();
                    var selectedFields = fieldsSelect2.val();
                    if (typeof selectedFields != 'object') selectedFields = [selectedFields];

// TODO mandatory field validation

                    finializeAdd(selectedModule, selectedFilterId, selectedFields);
                });
            }
            app.helper.showModal(res, {"cb": callback});
        });

        function finializeAdd(moduleName, filterid, fields) {
            var data = {
                module: moduleName
            }
            if (typeof fields != 'object') fields = [fields];
            data['fields'] = fields;
            url += '&filterid=' + filterid + '&data=' + JSON.stringify(data);
            var linkId = element.data('linkid');
            var name = element.data('name');
            var widgetContainer = jQuery('<li class="new dashboardWidget loadcompleted" id="' + linkId + "-" + filterid + '" data-name="' + name + '" data-mode="open"></li>');
            widgetContainer.data('url', url);
            var width = element.data('width');
            var height = element.data('height');
            Vtiger_DashBoard_Js.gridster.add_widget(widgetContainer, width, height);
            Vtiger_DashBoard_Js.currentInstance.loadWidget(widgetContainer);
            app.helper.hideModal();
        }
    },

    addNoteBookWidget: function (element, url) {
// 1. Show popup window for selection (module, filter, fields)
// 2. Compute the dynamic mini-list widget url
// 3. Add widget with URL to the page.

        element = jQuery(element);


        app.request.get({"url": "index.php?module=Home&view=AddNotePad"}).then(function (err, res) {
            var callback = function (data) {
                var wizardContainer = jQuery(data);
                var form = jQuery('form', wizardContainer);
                var params = {
                    submitHandler: function (form) {
//To prevent multiple click on save
                        var form = jQuery(form);
                        jQuery("[name='saveButton']").attr('disabled', 'disabled');
                        var notePadName = form.find('[name="notePadName"]').val();
                        var notePadContent = form.find('[name="notePadContent"]').val();
                        var linkId = element.data('linkid');
                        var noteBookParams = {
                            'module': app.getModuleName(),
                            'action': 'NoteBook',
                            'mode': 'NoteBookCreate',
                            'notePadName': notePadName,
                            'notePadContent': notePadContent,
                            'linkId': linkId,
                            'tab': jQuery(".tab-pane.active").data("tabid")
                        }
                        app.request.post({"data": noteBookParams}).then(function (err, data) {
                            if (data) {
                                var widgetId = data.widgetId;
                                app.helper.hideModal();

                                url += '&widgetid=' + widgetId;

                                var name = element.data('name');
                                var widgetContainer = jQuery('<li class="new dashboardWidget loadcompleted" id="' + linkId + "-" + widgetId + '" data-name="' + name + '" data-mode="open"></li>');
                                widgetContainer.data('url', url);
                                var width = element.data('width');
                                var height = element.data('height');
                                Vtiger_DashBoard_Js.gridster.add_widget(widgetContainer, width, height);
                                Vtiger_DashBoard_Js.currentInstance.loadWidget(widgetContainer);
                            }
                        });
                        return false;
                    }
                }
                form.vtValidate(params);
            }
            app.helper.showModal(res, {"cb": callback});
        });

    }

}, {


    container: false,
    instancesCache: {},

    init: function () {
        Vtiger_DashBoard_Js.currentInstance = this;
        this.addComponents();
    },

    addComponents: function () {
        this.addComponent('Vtiger_Index_Js');
    },

    getDashboardContainer: function () {
        return jQuery(".dashBoardContainer");
    },

    getContainer: function (tabid) {
        if (typeof tabid == 'undefined') {
            tabid = this.getActiveTabId();
        }
        return jQuery(".gridster_" + tabid).find('ul');
    },

    getWidgetInstance: function (widgetContainer) {
        var id = widgetContainer.attr('id');
        if (!(id in this.instancesCache)) {
            var widgetName = widgetContainer.data('name');
            if (widgetName === "ChartReportWidget") {
                widgetName += "_" + id;
            }
            this.instancesCache[id] = Vtiger_Widget_Js.getInstance(widgetContainer, widgetName);
        }
        else {
            this.instancesCache[id].init(widgetContainer);
        }
        return this.instancesCache[id];
    },
/**
 * Get Active Tab ID
 * Commented By Khaled
 * @returns {Object}
 */
    getActiveTabId: function () {
        return jQuery(".tab-pane.active").data("tabid");
    },

    getActiveTabName: function () {
        return jQuery(".tab-pane.active").data("tabname");
    },

    getgridColumns: function () {
        var _device_width = $(window).innerWidth();
        var gridWidth = _device_width;

        if (_device_width < 480) {
            gridWidth = 1;
        } else if (_device_width >= 480 && _device_width < 768) {
            gridWidth = 1;
        } else if (_device_width >= 768 && _device_width < 992) {
            gridWidth = 2;
        } else if (_device_width >= 992 && _device_width < 1800) {
            gridWidth = 3;
        } else {
            gridWidth = 4;
        }
        return gridWidth;
    },

/**
 * Initialize Gridster
 * Commented By Khaled
 * @returns {undefined}
 */
    registerGridster: function () {
        var thisInstance = this;
        var widgetMargin = 5;
        var activeTabId = this.getActiveTabId();
        var activeGridster = jQuery(".gridster_" + activeTabId);
        var items = activeGridster.find('ul li');
        items.detach();

// Constructing the grid based on window width
        var cols = this.getgridColumns();
        $(".mainContainer").css('min-width', "800px");
        var col_width = (cols === 1) ? (Math.floor(($(".mainContainer").width() - 20) / cols) - (2 * widgetMargin)) : (Math.floor(($(window).width() - 20) / cols) - (2 * widgetMargin));


        Vtiger_DashBoard_Js.gridster = this.getContainer().gridster({
            widget_margins: [widgetMargin, widgetMargin],
            widget_base_dimensions: [col_width, 350],
            min_cols: 1,
            max_cols: 4,
            min_rows: 20,
            resize: {
                enabled: true,
                stop: function (e, ui, widget) {
                    var widgetName = widget.data('name');
                    /**
                     * we are setting default height in DashBoardWidgetContents.tpl
                     * need to overwrite based on resized widget height
                     */
                    var widgetChartContainer = widget.find(".widgetChartContainer");
                    if (widgetChartContainer.length > 0) {
                        widgetChartContainer.css("height", widget.height() - 60);
                    }
                    Vtiger_Widget_Js.getInstance(widget, widgetName);
                    widget.trigger(Vtiger_Widget_Js.widgetPostResizeEvent);
                }
            },
            /**
             * Drag Widget 
             * Commented By Khaled
             */
            draggable: {
                'stop': function (event, ui) {
                    thisInstance.savePositions(activeGridster.find('.dashboardWidget'));
                }
            }
        }).data('gridster');


        items.sort(function (a, b) {
            var widgetA = jQuery(a);
            var widgetB = jQuery(b);
            var rowA = parseInt(widgetA.attr('data-row'));
            var rowB = parseInt(widgetB.attr('data-row'));
            var colA = parseInt(widgetA.attr('data-col'));
            var colB = parseInt(widgetB.attr('data-col'));

            if (rowA === rowB && colA === colB) {
                return 0;
            }

            if (rowA > rowB || (rowA === rowB && colA > colB)) {
                return 1;
            }
            return -1;
        });
        jQuery.each(items, function (i, e) {
            var item = $(this);
            var columns = parseInt(item.attr("data-sizex")) > cols ? cols : parseInt(item.attr("data-sizex"));
            var id = item.attr("id");
            var rows = parseInt(item.attr("data-sizey"));
            if(id == 'widget_id_152'){
                rows = 2;
            }          
       
            if (item.attr("data-position") == "false") {
                Vtiger_DashBoard_Js.gridster.add_widget(item, columns, rows);
            } else {
                Vtiger_DashBoard_Js.gridster.add_widget(item, columns, rows);
            }
        });
//used when after gridster is loaded
        thisInstance.savePositions(activeGridster.find('.dashboardWidget'));
    },
/**
 * Save Widget Position Commented by Khlaed
 * @param {type} widgets
 * @returns {undefined}
 */
    savePositions: function (widgets) {
        var widgetRowColPositions = {}
        for (var index = 0, len = widgets.length; index < len; ++index) {
            var widget = jQuery(widgets[index]);
            widgetRowColPositions[widget.attr('id')] = JSON.stringify({
                row: widget.attr('data-row'), col: widget.attr('data-col')
            });
        }
        var params = {
            module: 'Vtiger',
            action: 'SaveWidgetPositions',
            positionsmap: widgetRowColPositions
        };
        app.request.post({"data": params}).then(function (err, data) {
        });
    },
    /**
     * Get Dashboard Widget Commented by Khaled
     * @returns {jQuery}
     */
    getDashboardWidgets: function () {
        return jQuery('.dashboardWidget', jQuery('.tab-pane.active'));
    },
    /**
     * Load Widget Commented by Khaled
     * @returns {undefined}
     */
    loadWidgets: function () {
        var thisInstance = this;
        var widgetList = thisInstance.getDashboardWidgets();
        widgetList.each(function (index, widgetContainerELement) {
            thisInstance.loadWidget(jQuery(widgetContainerELement));
            jQuery(widgetContainerELement).addClass('loadcompleted');
        });
    },
    /**
     * Widget Scoll 
     * Commented By Khaled
     * @param {type} elem
     * @returns {Boolean}
     */
    isScrolledIntoView: function (elem) {
        var viewportWidth = jQuery(window).width(),
            viewportHeight = jQuery(window).height(),

            documentScrollTop = jQuery(document).scrollTop(),
            documentScrollLeft = jQuery(document).scrollLeft(),

            minTop = documentScrollTop,
            maxTop = documentScrollTop + viewportHeight,
            minLeft = documentScrollLeft,
            maxLeft = documentScrollLeft + viewportWidth,

            $targetElement = jQuery(elem),
            elementOffset = $targetElement.offset();
        if (
            (elementOffset.top > minTop && elementOffset.top < maxTop) &&
            (elementOffset.left > minLeft && elementOffset.left < maxLeft)
        ) {
            return true;
        }
        else {
            return false;
        }
    },
    /**
     * Load Widget 
     * Commented by Khaled
     * @param {type} widgetContainer
     * @returns {undefined}
     */
    loadWidget: function (widgetContainer) {
        var thisInstance = this;
        var urlParams = widgetContainer.data('url');
        var mode = widgetContainer.data('mode');

        var activeTabId = this.getActiveTabId();
        urlParams += "&tab=" + activeTabId;
        app.helper.showProgress();
        if (mode == 'open') {
            app.request.post({"url": urlParams}).then(function (err, data) {
                widgetContainer.prepend(data);
                vtUtils.applyFieldElementsView(widgetContainer);
                thisInstance.getWidgetInstance(widgetContainer);
                widgetContainer.trigger(Vtiger_Widget_Js.widgetPostLoadEvent);
                app.helper.hideProgress();
            });
        } else {
        }
    },
    /**
     * Refresh Widget Commented by Khaled
     * @returns {undefined}
     */
    registerRefreshWidget: function () {
        var thisInstance = this;
        this.getContainer().on('click', 'a[name="drefresh"]', function (e) {
            var element = $(e.currentTarget);
            var parent = element.closest('li');
            var widgetInstnace = thisInstance.getWidgetInstance(parent);
            widgetInstnace.refreshWidget();
            return;
        });
    },
    /**
     * Remove Widget
     * Commented by Khaled
     * @returns {undefined}
     */
    removeWidget: function () {
        this.getContainer().on('click', 'li a[name="dclose"]', function (e) {
            var container = this.closest("ul");
            var element = $(e.currentTarget);
            var listItem = jQuery(element).parents('li');
            var width = listItem.attr('data-sizex');
            var height = listItem.attr('data-sizey');
            var url = element.data('url');
//            var group = element.closest("li").data('group');
            var parent = element.closest('.dashBoardWidgetFooter').parent();
            var widgetName = parent.data('name');
            var widgetTitle = parent.find('.dashboardTitle').attr('title');
            var activeTabId = element.closest(".tab-pane").data("tabid");

            var message = app.vtranslate('JS_ARE_YOU_SURE_TO_DELETE_WIDGET', widgetTitle);
            app.helper.showConfirmationBox({'message': message, 'htmlSupportEnable': false}).then(function (e) {
                app.helper.showProgress();
                app.request.post({"url": url}).then(
                    function (err, response) {
                       // console.log(response)
                       app.helper.hideProgress();
                        if (err == null) {
                            var nonReversableWidgets = ['MiniList', 'Notebook', 'ChartReportWidget']
                            parent.fadeOut('slow', function () {
                                Vtiger_DashBoard_Js.gridster.remove_widget(parent);
                                parent.remove();
                            });
                            if(jQuery.inArray(widgetName, nonReversableWidgets) == -1) {
                                var data = '<li><a style="padding-left:10px;" onclick="Vtiger_DashBoard_Js.addWidget(this, \'' + response.url + '\')" href="javascript:void(0);"';
                                data += 'data-width=' + width + ' data-height=' + height + ' data-linkid=' + response.linkid + ' data-name=' + response.name + '>' + response.title + '</a></li>';
                                var divider = jQuery('.widgetsList .divider', '#tab_' + activeTabId);
                               
                                if (divider.length) {                                                                     
                                    jQuery(data).insertBefore(divider);
                                        app.helper.hideProgress();
                                } else {
                                jQuery(".widget-item a[data-linkid='"+ response.linkid + "']").removeAttr("disabled")
                                jQuery(".widget-item a[data-linkid='"+ response.linkid + "']").removeAttr("title")  // Mabruk
                               
                               //   jQuery(".widgetsList ").find("."+group).find("ul").append(data)
                                   
                                  // jQuery(data).insertAfter(jQuery('.widgetsList li:last', '#tab_' + activeTabId));
                                }
                            }
                        }
                      

                    }
                );
            });
        });
    },
/**
 * Widget Lazy Loading
 * Commented by Khaled
 * @returns {undefined}
 */
    registerLazyLoadWidgets: function () {
        var thisInstance = this;
        jQuery(window).bind("scroll", function () {
            var widgetList = jQuery('.dashboardWidget').not('.loadcompleted');
            if (!widgetList[0]) {
// We shouldn't unbind as we might have widgets in another tab
//jQuery(window).unbind('scroll');
            }
            widgetList.each(function (index, widgetContainerELement) {
                if (thisInstance.isScrolledIntoView(widgetContainerELement)) {
                    thisInstance.loadWidget(jQuery(widgetContainerELement));
                    jQuery(widgetContainerELement).addClass('loadcompleted');
                }
            });
        });
    },
/**
 * Widget Full Screen View
 * Commented by Khaled
 * @returns {undefined}
 */
    registerWidgetFullScreenView: function () {
        var thisInstance = this;
        this.getContainer().on('click', 'a[name="widgetFullScreen"]', function (e) {
            var currentTarget = jQuery(e.currentTarget);
            var widgetContainer = currentTarget.closest('li');
            var widgetName = widgetContainer.data('name');
            var widgetTitle = widgetContainer.find('.dashboardTitle').text();
            var widgetId = widgetContainer.attr('id');
            var data = widgetContainer.find('input.widgetData').val();
            var chartType = '';
            if (widgetContainer.find('input[name="charttype"]').length) {
                chartType = widgetContainer.find('input[name="charttype"]').val();
            }
            var clickThrough = 0;
            if (widgetContainer.find('input[name="clickthrough"]').length) {
                clickThrough = widgetContainer.find('input[name="clickthrough"]').val();
            }
            var fullscreenview = '<div class="fullscreencontents modal-dialog modal-lg">\n\
                <div class="modal-content">\n\
                <div class="modal-header backgroundColor">\n\
                <div class="clearfix">\n\
                    <div class="pull-right">\n\
                            <button data-dismiss="modal" class="close" title="' + app.vtranslate('JS_CLOSE') + '"><span aria-hidden="true" class="fa fa-close"></span></button>\n\
                    </div>\n\
                    <h4 class="pull-left">' + widgetTitle + '</h4>\n\
                </div>\n\
                </div>\n\
                <div class="modal-body" style="overflow:auto;">\n\
                <ul style="list-style: none;"><li id="fullscreenpreview" class="dashboardWidget fullscreenview" data-name="' + widgetName + '">\n\
                    <div class="dashboardWidgetContent" style="min-height:500px;width:100%;min-width:600px; margin: 0 auto" data-displaymode="fullscreen">';
            if (chartType != '') {
                fullscreenview += ' <input type="hidden" value="' + chartType + '" name="charttype">\n\
            <input type="hidden" value="' + clickThrough + '" name="clickthrough">\n\
            <div id="chartDiv" name="chartcontent" style="width:100%;height:100%" data-mode="preview"></div> \n\
            <input class="widgetData" type="hidden" value="" name="data">';
            } else {
                fullscreenview += ' <div class="dashboardWidgetContent" style="width:100%;height:100%" data-displaymode="fullscreen">\n\
                    <div id="chartDiv" class="widgetChartContainer" style="width:100%;height:100%"></div>\n\
                            <input class="widgetData" type="hidden" value="" name="data">';
            }
            fullscreenview += '</div></ul></li></div></div></div>';

            var callback = function (modalData) {
                var element = jQuery(modalData);
                var modal = jQuery(".myModal", element);
                modal.parent().css({'top': '30px', 'left': '30px', 'right': '30px', 'bottom': '30px'});
                modal.css('height', '100%');
                var modalWidgetContainer = jQuery('.fullscreenview');
                modalWidgetContainer.find('.widgetData').val(data);
                if (chartType != '') {
//Chart report widget
                    var chartClassName = chartType.toCamelCase();
                    var chartClass = window["Report_" + chartClassName + "_Js"];
                    chartClass('Vtiger_ChartReportWidget_Widget_Js', {}, {
                        init: function () {
                            this._super(modalWidgetContainer);
                        }
                    });
                }
                var widgetInstance = Vtiger_Widget_Js.getInstance(modalWidgetContainer, widgetName);
                modalWidgetContainer.trigger(Vtiger_Widget_Js.widgetPostLoadEvent);
            }
            app.helper.showModal(fullscreenview, {"cb": callback});
        });
    },
/**
 * Widget Filter 
 * Commented by Khaled
 * @returns {undefined}
 */
    registerFilterInitiater: function () {
        var container = this.getContainer();
        container.on('click', 'a[name="dfilter"]', function (e) {
            var widgetContainer = jQuery(e.currentTarget).closest('.dashboardWidget');
            var filterContainer = widgetContainer.find('.filterContainer');
            var dashboardWidgetFooter = jQuery('.dashBoardWidgetFooter', widgetContainer);

            filterContainer.slideToggle(500);

            var callbackFunction = function () {
                filterContainer.slideToggle(500);
            }
//adding clickoutside event on the dashboardWidgetHeader
            var helper = new Vtiger_Helper_Js();
            helper.addClickOutSideEvent(dashboardWidgetFooter, callbackFunction);

            return false;
        })
    },
/**
 * Delete Dashboard Tab
 * Commented by Khaled
 * @returns {undefined}
 */
    registerDeleteDashboardTab: function () {
        var self = this;
        var dashBoardContainer = this.getDashboardContainer();
        dashBoardContainer.off("click", '.deleteTab');
        dashBoardContainer.on("click", '.deleteTab', function (e) {
// To prevent tab click event
            e.preventDefault();
            e.stopPropagation();

            var currentTarget = jQuery(e.currentTarget);
            var tab = currentTarget.closest(".dashboardTab");

            var tabId = tab.data("tabid");
            var tabName = tab.data("tabname");
            var message = app.vtranslate('JS_ARE_YOU_SURE_TO_DELETE_DASHBOARDTAB', tabName);
            app.helper.showConfirmationBox({'message': message, 'htmlSupportEnable': false}).then(function (e) {
                app.helper.showProgress();
                var data = {
                    'module': 'Vtiger',
                    'action': 'DashBoardTab',
                    'mode': 'deleteTab',
                    'tabid': tabId
                }
                app.request.post({"data": data}).then(function (err, data) {
                    app.helper.hideProgress();
                    if (err == null) {
//                        jQuery('li[data-tabid="' + tabId + '"]').remove();
//                        jQuery('.tab-content #tab_' + tabId).remove();

                        if (jQuery('.dashboardTab.active').length <= 0) {
// click the first tab if none of the tabs are active
                            var firstTab = jQuery('.dashboardTab').get(0);
                            jQuery(firstTab).find('a').click();
                        }
                        app.helper.showSuccessNotification({"message": ''});
                        if (jQuery('.dashboardTab').length < Vtiger_DashBoard_Js.dashboardTabsLimit) {
                            var element = dashBoardContainer.find('li.disabled');
                            self.removeQtip(element);
                        }

                    } else {
                        app.helper.showErrorNotification({"message": err});
                    }
                });
            });
        });
    },
    
    /**
     * Added By Khaled
     * Reset Data
     * @returns {undefined}
     */
    registerDataReset:function(){
        jQuery(".btn-reset").on("click",function(){
            var type = $(this).data("reset")
            var url =  "includes/Reset/"+type+".php";
          app.helper.showProgress();
               $.ajax({
                    type        : "POST",
                    url           : url,
                    data       : {
                        type:type
                    },                   
                    success : function( response ){
                        
                              
                        console.log( response );       
                     if(response.length > 0){
                         window.location.reload();
                     }
                    },
                    error: function(error){
                        console.log(error)
                    }
                });
             
        });
    },
    /**
     * Add Dashboard Tab
     * Commented by Khaled
     * @returns {undefined}
     */
    registerAddDashboardTab: function () {
        var self = this;
        var dashBoardContainer = this.getDashboardContainer();
        dashBoardContainer.off('click', '.addNewDashBoard');
        dashBoardContainer.on("click", ".addNewDashBoard", function (e) {
            if (jQuery('.dashboardTab').length >= Vtiger_DashBoard_Js.dashboardTabsLimit) {
                app.helper.showErrorNotification({"message": app.vtranslate("JS_TABS_LIMIT_EXCEEDED")});
                return;
            }
            var currentElement = jQuery(e.currentTarget);
            var data = {
                'module': 'Home',
                'view': 'DashBoardTab',
                'mode': 'showDashBoardAddTabForm'
            };

            app.request.post({"data": data}).then(function (err, res) {
                if (err === null) {
                    var cb = function (data) {
                        var form = jQuery(data).find('#AddDashBoardTab');
                        var params = {
                            submitHandler: function (form) {
                                var labelEle = jQuery(form).find('[name="tabName"]');
                                var tabName = labelEle.val().trim();
                                if (tabName.length > 50) {
                                    vtUtils.showValidationMessage(labelEle, app.vtranslate('JS_TAB_LABEL_EXCEEDS_CHARS', 50), {
                                        position: {
                                            my: 'bottom left',
                                            at: 'top left',
                                            container: jQuery(form)
                                        }
                                    });
                                    return false;
                                } else {
                                    vtUtils.hideValidationMessage(labelEle);
                                }

                                var params = jQuery(form).serializeFormData();
                                params['tabName'] = params['tabName'].trim();
                                app.request.post({"data": params}).then(function (err, data) {
                                    app.helper.hideModal();
                                    if (err) {
                                        app.helper.showErrorNotification({"message": err});
                                    } else { 
                                        var tabid = data["tabid"];
                                        var tabname = data["tabname"];
                                        var tabEle = '<li class="dashboardTab" data-tabid="' + tabid + '" data-tabname="' + tabname + '">';
                                        tabEle += '<a data-toggle="tab" href="#tab_' + tabid + '">\n\
                            <div>\n\
                                    <span class="name textOverflowEllipsis" value="' + tabname + '" style="width:10%">\n\
                                    <strong>' + tabname + '</strong>\n\
                                    </span>\n\
                                    <span class="editTabName hide"><input type="text" name="tabName"></span>\n\
                                    <i class="fa fa-close deleteTab"></i>\n\
                                    <i class="fa fa-bars moveTab hide"></i>\n\
                            </div>\n\
                            </a>';
                                        tabEle += '</li>';

                                        var tabContentEle = '<div id="tab_' + tabid + '" class="tab-pane fade" data-tabid="' + tabid + '"></div>';

                                        jQuery('.moreSettings').before(tabEle);
                                        jQuery('.moreSettings').prev().find('.name > strong').text(tabname);
                                        dashBoardContainer.find('.tab-content').append(tabContentEle);

// selecting added tab
                                        var currentTab = jQuery('li[data-tabid="' + tabid + '"]');
                                        currentTab.find('a').click();
                                        if (jQuery('.dashboardTab').length >= Vtiger_DashBoard_Js.dashboardTabsLimit) {
                                            jQuery('#newDashBoardLi').addClass('disabled');
                                            self.registerQtipMessage();
                                        }


                                    }
                                });
                            }
                        }
                        form.vtValidate(params);
                    }
                    app.helper.showModal(res, {"cb": cb});
                }
            })

        })
    },
    removeQtip: function (element) {
        jQuery(element).qtip("destroy");
        element.removeClass('disabled');
    },
/**
 * Floating Message
 * Commented by Khaled
 * @returns {undefined}
 */
    registerQtipMessage: function () {
        var dashBoardContainer = this.getDashboardContainer();
        var element = dashBoardContainer.find('li.disabled');
        var title = app.vtranslate("JS_TABS_LIMIT_EXCEEDED")
        jQuery(element).qtip({
            content: title,
            hide: {
                event: 'click mouseleave',
            },
            position: {
                my: 'bottom center',
                at: 'top left',
                adjust: {
                    x: 30,
                    y: 10
                }
            },
            style: {
                classes: 'qtip-dark'
            }
        });
    },
    /**
     * Rename Dashboard Tab
     * Commented by Khaled
     * @returns {undefined}
     */
    registerDashBoardTabRename: function () {
        var container = this.getContainer();
        var dashBoardContainer = jQuery(container).closest(".dashBoardContainer");

        dashBoardContainer.on("dblclick", ".dashboardTab", function (e) {
            e.preventDefault();
            e.stopPropagation();

            var currentTarget = jQuery(e.currentTarget);
            if (jQuery(".editTabName:visible").length > 0) {
                return;
            }
            var nameEle = currentTarget.find(".name");
            var oldName = nameEle.attr("value");
            var editEle = currentTarget.find(".editTabName");

            nameEle.addClass("hide");
            editEle.removeClass("hide");
            editEle.find("input").val(oldName);

            currentTarget.on("clickoutside", function (e) {
                var newName = editEle.find("input").val();
                var tabId = currentTarget.data("tabid");

                if (newName.trim() == "") {
                    vtUtils.showValidationMessage(editEle, app.vtranslate('JS_TAB_NAME_SHOULD_NOT_BE_EMPTY'), {
                        position: {
                            my: 'top left',
                            at: 'bottom left',
                            container: editEle.closest('.dashboardTab')
                        }
                    });
                    return false;
                }
                vtUtils.hideValidationMessage(editEle);

                if (newName.length > 50) {
                    vtUtils.showValidationMessage(editEle, app.vtranslate('JS_TAB_LABEL_EXCEEDS_CHARS', 50), {
                        position: {
                            my: 'bottom left',
                            at: 'top left',
                            container: jQuery('.module-action-content')
                        }
                    });
                    return false;
                } else {
                    vtUtils.hideValidationMessage(editEle);
                }
                currentTarget.off("clickoutside");
                if (newName != oldName) {

                    var data = {
                        'module': 'Vtiger',
                        'action': 'DashBoardTab',
                        'mode': 'renameTab',
                        'tabid': tabId,
                        'tabname': newName
                    }
                    currentTarget.find('.name > strong').text(newName);
                    app.helper.showProgress();
                    app.request.post({data: data}).then(function (err, data) {
                        app.helper.hideProgress();
                        if (err == null) {
                            app.helper.showSuccessNotification({"message": ''});
                            currentTarget.data('tabname', newName);
                        } else {
                            app.helper.showErrorNotification({"message": err});
                            currentTarget.find('.name > strong').text(oldName);
                        }
                    })
                }
                nameEle.attr("value", newName);

                editEle.addClass("hide");
                nameEle.removeClass("hide");
            })
        });
    },
    /**
     * Dashboard Tab Click Event
     * Registered by Khaled
     * @returns {undefined}
     */
    registerDashBoardTabClick: function () {
        var thisInstance = this;
        var container = this.getContainer();
        var dashBoardContainer = jQuery(container).closest(".dashBoardContainer");

        dashBoardContainer.on("shown.bs.tab", ".dashboardTab", function (e) {
            var currentTarget = jQuery(e.currentTarget);
            var tabid = currentTarget.data('tabid');


            if (tabid == 1) {

                dashBoardContainer.find('.widget-btn').css('display', 'none')
            }
            else {
                dashBoardContainer.find('.widget-btn').css('display', 'block')
            }

            jQuery("#default_tab").val(tabid);

            app.changeURL("index.php?module=Home&view=DashBoard&tabid=" + tabid);
            if (tabid == 1) {
                var params = {
                    'module': 'Calendar',
                    'view': 'TaskManagement',
                    'mode': 'showManagementView',
                    'actmodulename': 'Home'
                }
                app.helper.showProgress();
                app.request.post({"data": params}).then(function (err, data) {
// console.log(data);
                    if (err === null) {
                        app.helper.hideProgress();
                        $('.tab-content').html(data);
                        vtUtils.showSelect2ElementView($('#overlayPage .data-header').find('select[name="assigned_user_id"]'), {placeholder: "User : All"});
                        vtUtils.showSelect2ElementView($('#overlayPage .data-header').find('select[name="taskstatus"]'), {placeholder: "Status : All"});
                        var js = new Vtiger_TaskManagement_Js();
                        js.registerEvents();
                    } else {
                        app.helper.showErrorNotification({"message": err});
                    }
                });
            } else {
//alert("Nirbhay");
                jQuery('.tab-content').html('');

// If tab is already loaded earlier then we shouldn't reload tab and register gridster
                if (typeof jQuery("#tab_" + tabid).find(".dashBoardTabContainer").val() !== 'undefined') {
// We should overwrite gridster with current tab which is clicked
                    var widgetMargin = 10;
                    var cols = thisInstance.getgridColumns();
                    $(".mainContainer").css('min-width', "500px");
                    var col_width = (cols === 1) ? (Math.floor(($(".mainContainer").width() - 41) / cols) - (2 * widgetMargin)) : (Math.floor(($(window).width() - 41) / cols) - (2 * widgetMargin));

                    Vtiger_DashBoard_Js.gridster = thisInstance.getContainer(tabid).gridster({
// Need to set the base dimensions to eliminate widgets overlapping
                        widget_base_dimensions: [col_width, 300]
                    }).data("gridster");

                    return;
                }
                var data = {
                    'module': 'Home',
                    'view': 'DashBoardTab',
                    'mode': 'getTabContents',
                    'tabid': tabid
                }

                app.request.post({"data": data}).then(function (err, data) {
                    if (err === null) {
                        var dashBoardModuleName = jQuery("#tab_" + tabid, ".tab-content").html(data).find('[name="dashBoardModuleName"]').val();
                        if (typeof dashBoardModuleName != 'undefined' && dashBoardModuleName.length > 0) {
                            var dashBoardInstanceClassName = app.getModuleSpecificViewClass(app.view(), dashBoardModuleName);
                            if (dashBoardInstanceClassName != null) {
                                var dashBoardInstance = new window[dashBoardInstanceClassName]();
                            }
                        }
                        app.event.trigger("post.DashBoardTab.load", dashBoardInstance);
                        window.location = 'index.php?module=Home&view=DashBoard&tabid=' + tabid;
                    }
                });
            }
        });
    },
/**
 * Rearrange Dashboard Tab
 * Commented by Khaled
 * @returns {undefined}
 */
    registerRearrangeTabsEvent: function () {
        var dashBoardContainer = this.getDashboardContainer();

// on click of Rearrange button
        dashBoardContainer.on("click", 'button.reArrangeTabs', function (e) {
            var currentEle = jQuery(e.currentTarget);
            dashBoardContainer.find(".dashBoardDropDown").addClass('hide');

            var sortableContainer = dashBoardContainer.find(".tabContainer");
            var sortableEle = sortableContainer.find(".sortable");

            currentEle.addClass("hide");
            dashBoardContainer.find(".deleteTab").addClass("hide");
            dashBoardContainer.find(".moveTab").removeClass("hide");
            dashBoardContainer.find(".updateSequence").removeClass("hide");

            sortableEle.sortable({
                'containment': sortableContainer,
                stop: function () {
                }
            });
        });

// On click of save sequence
        dashBoardContainer.find(".updateSequence").on("click", function (e) {
            var reArrangedList = {};
            var currEle = jQuery(e.currentTarget);
            jQuery("ul.sortable li").each(function (i, el) {
                var el = jQuery(el);
                var tabid = el.data("tabid");
                if (tabid != 'undefined')
                    reArrangedList[tabid] = ++i;

            });

            var data = {
                "module": "Vtiger",
                "action": "DashBoardTab",
                "mode": "updateTabSequence",
                "sequence": JSON.stringify(reArrangedList)
            }

            app.request.post({"data": data}).then(function (err, data) {
                if (err == null) {
                    currEle.addClass("hide");
                    dashBoardContainer.find(".moveTab").addClass("hide");
                    dashBoardContainer.find(".reArrangeTabs").removeClass("hide");
                    dashBoardContainer.find(".deleteTab").removeClass("hide");
                    dashBoardContainer.find(".dashBoardDropDown").removeClass('hide');

                    var sortableEle = dashBoardContainer.find(".tabContainer").find(".sortable");
                    sortableEle.sortable('destroy');

                    app.helper.showSuccessNotification({"message": ''});
                } else {
                    app.helper.showErrorNotification({"message": err});
                }
            });
        });

    },
    /**
     * Email Button click Event
     * Commented by Khaled
     * @returns {undefined}
     */
    buttonemail: function () {
        var thisInstance = this;

        this.getContainer().on('click', 'button[id="emailbutton"]', function (e) {
            var userid = jQuery("input#recordId").val();//safuan
            Vtiger_Helper_Js.getInternalMailer(userid, 'email1', 'Users');

        });
    },
/**
 * Birthday Email
 * Commented by Khaled
 * @returns {undefined}
 */
    birthdayEmail: function () {
        var thisInstance = this;
        this.getContainer().on('click', 'div.birthdaywish', function (e) {
            var userid = jQuery("input#birthdayid").val();//jitu
            var module = jQuery("input#modulename").val();//jitu
            var fieldname = jQuery("input#fieldname").val();//jitu

            Vtiger_Helper_Js.getInternalMailer(userid, fieldname, module);

        });
    },
    /**
     * Detail Tab View
     * Commented by Khaled
     * @param {type} form
     * @returns {undefined}
     */
    registerDisplayDetailTabClickEvent: function (form) {
        var userid = jQuery('#selectUserfilter').val();
        var module = app.getModuleName();
        var aDeferred = jQuery.Deferred();
        var params = {
            'module': 'Users',
            'view': 'DashboardListViewAjax',
            'record': userid,
            'mode': 'getUserEducation',
        }
        AppConnector.request(params).then(
            function (data) {
                $('#education').html(data);
            },

            function (error, err) {
                aDeferred.reject();
            }
        );
        jQuery('div#tab ul li').on('click', function (e) {
            var tabIndx = $(this).index();
            var container = $('a', this).attr('href');
            container = container.replace('#', '');
            if (tabIndx >= 0) {
                var params = {
                    'module': 'Users',
                    'view': 'DashboardListViewAjax',
                    'record': userid,
                    'mode': 'getUser' + container.substr(0, 1).toUpperCase() + container.substr(1),
                }

                AppConnector.request(params).then(
                    function (data) {
                        $('#' + container).html(data);
                    },

                    function (error, err) {
                        aDeferred.reject();
                    }
                );
            }
        });
    },
    /**
     * Search Keyboard Button Press Filter
     * Commented by Khaled
     * @returns {undefined}
     */
    searchWidgetPressEnter: function () {
        var thisInstance = this;

        this.getContainer().on('keypress', 'input[id="searchvalue"]', function (e) {
            if (e.which == 13) {

//alert('You pressed enter!XDXDXD');
                var sevalue = jQuery("input#searchvalue").val();

                var url = "index.php?module=Users&view=SearchResult&mode=searchResult&key=" + sevalue;
                AppConnector.request(url).then(
                    function (data) {
//alert(data);
//var panel = $("#panel");
                        var dataContainer = $("#searchresult");
//panel.toggleClass('hide');
                        dataContainer.html(data);
//thisInstance.registerDisplayDetailTabClickEvent();
                    });
            }
        });
    },
    /**
     * Widget Search 
     * @returns {undefined}
     */
    searchWidgets: function () {
        var thisInstance = this;

        this.getContainer().on('click', 'a[class="widgetFilter"]', function (e) {
            var element = $(e.currentTarget);
            var url = element.data('url');
            AppConnector.request(url).then(
                function (data) {
                    var panel = $("#panel");
                    var dataContainer = $("#content");
                    panel.toggleClass('hide');
                    dataContainer.html(data);
                    thisInstance.registerDisplayDetailTabClickEvent();
                });
        });
    },
    /**
     * Widget Search button Event
     * Commented by Khaled
     * @returns {undefined}
     */
    searchWidgetButton: function () {
        var thisInstance = this;

        this.getContainer().on('click', 'button[id="keysearch"]', function (e) {
            var sevalue = jQuery("input#searchvalue").val();
            var url = "index.php?module=Users&view=SearchResult&mode=searchResult&key=" + sevalue;
            AppConnector.request(url).then(
                function (data) {
//alert(data);
//var panel = $("#panel");
                    var dataContainer = $("#searchresult");
//panel.toggleClass('hide');
                    dataContainer.html(data);
//thisInstance.registerDisplayDetailTabClickEvent();
                });
        });
    },

/**
 * register all methods
 * Commented by Khaled
 * @returns {undefined}
 */
    registerEvents: function () {
        var thisInstance = this;
        this.registerLazyLoadWidgets();
        this.registerAddDashboardTab();
        this.registerDashBoardTabClick();
        this.registerDashBoardTabRename();
        this.registerDeleteDashboardTab();
        this.registerRearrangeTabsEvent();
        this.registerDataReset();
        this.searchWidgetButton();
        /***************ADDED@05122014***************/
        this.searchWidgets();
        /**************ADDED@05122014***************/
        this.searchWidgetPressEnter();
        this.buttonemail();
        this.birthdayEmail();

        this.registerQtipMessage();
        app.event.off("post.DashBoardTab.load");
        app.event.on("post.DashBoardTab.load", function (event, dashBoardInstance) {
            var instance = thisInstance;
            if (typeof dashBoardInstance != 'undefined') {
                instance = dashBoardInstance;
                instance.registerEvents();
                return;
            }

            var tabid = jQuery("#default_tab").val();  // instance.loadTrello();

            if (tabid == 1) {
                var params = {
                    'module': 'Calendar',
                    'view': 'TaskManagement',
                    'mode': 'showManagementView',
                    'actmodulename': 'Home'
                }
                app.helper.showProgress();
                app.request.post({"data": params}).then(function (err, data) {
// console.log(data);
                    if (err === null) {
                        app.helper.hideProgress();
                        $('.tab-content').html(data);
                        vtUtils.showSelect2ElementView($('#overlayPage .data-header').find('select[name="assigned_user_id"]'), {placeholder: "User : All"});
                        vtUtils.showSelect2ElementView($('#overlayPage .data-header').find('select[name="taskstatus"]'), {placeholder: "Status : All"});
                        var js = new Vtiger_TaskManagement_Js();
                        js.registerEvents();
                    } else {
                        app.helper.showErrorNotification({"message": err});
                    }
                });
            } else {
                instance.registerGridster();
                instance.loadWidgets();
                instance.registerRefreshWidget();
                instance.removeWidget();
                instance.registerWidgetFullScreenView();
                instance.registerFilterInitiater();


            }
        });
        app.event.trigger("post.DashBoardTab.load");


    }
});
