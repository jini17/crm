Vtiger_Edit_Js("Leave_Edit_Js",{
        file : false
},{

        registerChangeRadionButton:function() {
                var thisInstance = this;

                jQuery(".filterContainer").on('change', 'input[name="type"]', function(e){

                        var typeElement = container.find('input[name="type"]');
                        var typeValue = typeElement.val();

                        if(typeElement.val() == 'LeaveType'){
                            $("div.row").removeAttr("hidden");
                        }else if(typeElement.val() == 'lastleaves'){
                            $("div.row").attr("hidden");
                        }
                });

        },

        registerEvents : function() {
                this._super();
                this.registerChangeRadionButton();
        }
        
});

          jQuery("#Leave_editView_fieldName_reasonofleave,#Leave_editView_fieldName_reasonnotapprove").closest('.row').find('div').css("height","100px");
          
           jQuery("#Leave_editView_fieldName_reasonofleave,#Leave_editView_fieldName_reasonnotapprove").closest('.row').find('div').css("margin-bottom","10px");
           jQuery("#Leave_editView_fieldName_reasonofleave,#Leave_editView_fieldName_reasonnotapprove").closest('div').css("border","none");
           jQuery("#Leave_editView_fieldName_reasonofleave,#Leave_editView_fieldName_reasonnotapprove").closest('.table').find(".row").after("<div class='clearfix'></div>");
           jQuery("#Leave_editView_fieldName_reasonofleave,#Leave_editView_fieldName_reasonnotapprove").after("<div class='clearfix'></div>")
           