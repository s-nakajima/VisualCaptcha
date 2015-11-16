<article>
	<?php echo $this->NetCommonsForm->create(false); ?>

		<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
		<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>

		<?php echo $this->element(
			'VisualCaptcha.visual_captcha', array(
					'identifyKey' => 'VisualCaptcha',
		)); ?>

	<div class="text-center">
		<?php echo $this->BackTo->pageLinkButton(__d('net_commons', 'Cancel'), array('icon' => 'remove')); ?>
		<?php echo $this->NetCommonsForm->button(
		__d('net_commons', 'NEXT') . ' <span class="glyphicon glyphicon-chevron-right"></span>',
		array(
		'class' => 'btn btn-primary',
		'name' => 'next_' . '',
		)) ?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</article>