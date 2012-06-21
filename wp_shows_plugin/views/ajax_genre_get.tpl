<div class="genre_ajax_form">
	<div class="form_line">
		<label for="genre_title">{$data.labels.title}</label>
		<input type="text" name="genre_title" id="genre_title">
	</div>
	<div class="form_line">
		<label for="genre_description">{$data.labels.description}</label>
		<textarea rows="2" cols="20" name="genre_description" id="genre_description">
	</div>
	<div class="form_line">
		<label for="genre_color">{$data.labels.color} #</label>
		<input type="text" name="genre_color" id="genre_color">
	</div>
	<div calls="form_line">
		<input type="hidden" name="genre_id" value="{$data.genre_id}" />
		<input type="hidden" name="genre_nonce" value="{$data.nonce}" />
		<button class="ajax_click" rel="genre_ajax_form, genre_save">{$data.labels.save}</button>
	</div>
</div>
