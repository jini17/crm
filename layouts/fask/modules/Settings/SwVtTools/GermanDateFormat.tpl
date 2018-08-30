<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div id="pageOverlay" onclick="closePageOverlay();" style='cursor:url("modules/SwVtTools/icons/cross-button.png"), auto;position:fixed;z-index:20000;top:0;left:0;display:none;height:100%;width:100%;background-image:url("modules/Workflow2/icons/modal.png");'><div id='pageOverlayContent' style='position:fixed;cursor:default;top:100px;margin:auto;left:50%;padding:10px;background-color:#ffffff;'>&nbsp;</div></div>
<div class="container-fluid" id="moduleManagerContents">

    <div class="widget_header row">
        <div class="col-lg-12">
            <h3>
                <b>
                    <a href="index.php?module=SwVtTools&view=Index&parent=Settings" target="_blank">
                        <img src="https://redoo.click/img/redoo-80.png" class="pull-right" /> Redoo Networks VtigerCRM Tools
                    </a>
                </b>
            </h3>
        </div>
    </div>
    <hr>

    <ol>
        <li>Apply Database changes: <button class="btn btn-default" type="button" onclick="return SwVtTools.GeneralOptions('germanDateFormatStep1', true, true);">Run Step 1</button></li>
        <li>Apply Filemodifications: <a class="btn btn-default" target="_blank" href="index.php?module=SwVtTools&parent=Settings&&view=Patcher&hash=germandateformat">Start Step 2</a></li>
    </ol>
</div>