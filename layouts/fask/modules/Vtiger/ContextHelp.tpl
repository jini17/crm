<div class="modal-content helpbox" style="overflow:hidden;">
	<div class="modal-header">
	    <button title="Close" class="close" data-dismiss="modal">x</button>
	    <h4 class="modal-title" id="defaultModalLabel">{$DATA['question']}</h4>
	</div>
	<div class="modal-body" style="overflow:scroll;">
		<div class="top-btn pull-right">
			{*<button title="{vtranslate('Go to Support')}" class="help-btn" onclick="window.location.href='{$REF_URL}support'">{vtranslate('Go to Support')}</button>
			<button title="{vtranslate('Create Ticket')}" class="help-btn" onclick="window.location.href='{$REF_URL}support/index.php?module=HelpDesk&action=new'">{vtranslate('Create Ticket')}</button>
		*}
			{if $DATA['cf_1324'] neq ''}
			<a class="btn btn-lg btn-primary" href="#youtube" data-toggle="modal" data-height="360" data-width="720" href="https://www.youtube.com/watch?v=b16k1vJgLgk">
			<img alt="{$DATA['question']}" src="layouts/vlayout/skins/images/youtube.png" height="30" width="30" data-target="youtube">
			</a>
			<div id="youtube" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content1">
						<div class="modal-header1">
							<button type="button" class="close" id="youtubeclose" aria-hidden="true">&times;</button>
					 	</div>
						<div class="modal-body">
							<iframe id="cartoonVideo" width="460" height="340" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
			{/if}
		</div>
		<div class="clear"></div>
		<div class="help-ctn">
			<span>{$DATA['faq_answer']}</span>
		</div>
	</div>
</div>
