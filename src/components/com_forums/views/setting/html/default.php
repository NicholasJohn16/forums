<script src="com_forums/js/jquery.sceditor.bbcode.min.js"/>
<script src="com_forums/js/editor.js" />

<link rel="stylesheet" href="media/com_forums/css/sceditor.bootstrap.css">

<?= @helper('ui.actorbar', ['actorbar' => $actorbar]) ?>

<h3>Forum Settings</h3>

<form action="<?= @route('option=com_forums&view=setting&oid='.$actor->uniqueAlias.'&id='.$item->id) ?>" method="post" autocomplete="off">

	<input type="hidden" name="person_id" value="<?= $actor->id ?>">

	<div class="control-group">
		<label for="signature" class="control-label">Signature</label>

		<div class="controls">
			<textarea rows="10" class="bbcode-editor input-block-level" name="signature" tabindex="2" required><?= $item->signature ?></textarea>
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>

</form>