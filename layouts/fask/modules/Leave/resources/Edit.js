Vtiger_Edit_Js("Leave_Edit_Js",{
        file : false
},{

        registerChangeRadionButton:function(container) {
                var thisInstance = this;

                container.on('change', 'input[name="type"]', function(e){

                        var typeElement = container.find('input[name="type"]');
                        var typeValue = typeElement.val();

                        if(typeElement.val() == 'LeaveType'){

                                $("div.row").removeAttr("hidden");
                        }else if(typeElement.val() == 'lastleaves'){
                                $("div.row").attr("hidden");
                        }
                }

        },

        registerEvents : function(container) {
        this._super(container);
                this.registerChangeRadionButton(container);
        }
        
});