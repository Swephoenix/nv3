(function ($) {
	function textOrFallback(value, fallback) {
		return value && value.trim() ? value.trim() : fallback;
	}

	function htmlToPreviewText(value) {
		const html = value && value.trim() ? value : '';
		if (!html) return '<p>Artikeltexten visas här medan du skriver.</p>';
		return html;
	}

	function escapeHtml(value) {
		return String(value || '').replace(/[&<>"']/g, function (character) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			}[character];
		});
	}

	function escapeAttr(value) {
		return escapeHtml(value).replace(/`/g, '&#096;');
	}

	function renderSourcesPreview(value) {
		const lines = String(value || '').split(/\n+/).map(function (line) {
			return line.trim();
		}).filter(Boolean);

		if (!lines.length) return '';

		const items = lines.map(function (line) {
			const parts = line.split('|').map(function (part) {
				return part.trim();
			});
			const url = parts[0] || '';
			const label = parts[1] || url;
			const note = parts[2] || '';
			const source = url
				? '<a href="' + escapeAttr(url) + '" target="_blank" rel="noopener noreferrer">' + escapeHtml(label) + '</a>'
				: escapeHtml(label);
			return '<li>' + source + (note ? ' - ' + escapeHtml(note) : '') + '</li>';
		}).join('');

		return '<h2 class="article-end-title">Källor</h2><ul class="article-sources">' + items + '</ul>';
	}

	function imageUrlForControl(target) {
		const control = $('[data-image-control="' + target + '"]');
		const img = control.find('.nv-article-builder-image__preview img').attr('src');
		const fallback = control.find('input[name$="_url"]').val();
		return img || fallback || '';
	}

	function updateArticleHeroPreview() {
		const url = imageUrlForControl('_thumbnail_id');
		const target = $('.article-builder-preview__image');
		if (!target.length) return;
		if (url) {
			target.html('<img src="' + escapeAttr(url) + '" alt="">');
		} else {
			target.text('Utvald bild visas på artikelsidan');
		}
	}

	function updateArticleAssetPreview(outputName, controlName, label) {
		const url = imageUrlForControl(controlName);
		const target = $('[data-preview-output="' + outputName + '"]');
		if (!target.length) return;
		if (url) {
			target.html('<img src="' + escapeAttr(url) + '" alt="' + escapeAttr(label) + '">');
		} else {
			target.empty();
		}
	}

	function updatePreview() {
		const preview = $('.article-builder-preview');
		const title = $('#nv-article-title').val() || $('#title').val() || $('.editor-post-title__input').text();
		const kicker = $('[data-preview-field="kicker"]').val();
		const dek = $('[data-preview-field="dek"]').val();
		const articleIngress = $('[data-preview-field="article_ingress"]').val();
		const caption = $('[data-preview-field="hero_caption"]').val();
		const body = getArticleEditorContent();
		const sources = $('#nv-sources').val();
		const category = $('#nv-article-category option:selected').text() || $('#categorychecklist input:checked').first().closest('label').text().trim();

		if (!preview.length) return;

		$('[data-preview-output="title"]').text(textOrFallback(title, 'Artikelrubrik'));
		$('[data-preview-output="kicker"]').text(textOrFallback(kicker, 'Analys'));
		$('[data-preview-output="dek"]').text(textOrFallback(dek, 'Ingressen visas här medan du skriver.'));
		$('[data-preview-output="article_ingress"]').text(articleIngress || '');
		$('[data-preview-output="hero_caption"]').text(caption || '');
		$('[data-preview-output="category"], [data-preview-output="category_badge"]').text(textOrFallback(category, 'Kategori'));
		$('[data-preview-output="body"]').html(htmlToPreviewText(body));
		$('[data-preview-output="sources"]').html(renderSourcesPreview(sources));
		updateArticleHeroPreview();
		updateArticleAssetPreview('support_image', 'newsvoice_support_image_id', 'Stödannons');
		updateArticleAssetPreview('medialinq_image', 'newsvoice_medialinq_image_id', 'Medialinq');
		updateArticleAssetPreview('banner_image', 'newsvoice_banner_image_id', 'Banner');
	}

	function getArticleEditorContent() {
		const fallback = $('#nv_article_content');
		const editor = window.tinyMCE && window.tinyMCE.get('nv_article_content');

		if (editor && !editor.isHidden()) {
			return editor.getContent();
		}

		return fallback.length ? fallback.val() : $('[data-preview-output="body"]').html();
	}

	function setImagePreview(target, id, url) {
		const control = $('[data-image-control="' + target + '"]');
		control.find('input[name="' + target + '"]').val(id).trigger('change');
		const urlInput = control.find('input[name$="_url"]');
		if (urlInput.length) urlInput.val(url || '').trigger('change');

		const preview = control.find('.nv-article-builder-image__preview');
		if (url) {
			preview.html('<img src="' + escapeAttr(url) + '" alt="">');
		} else {
			preview.html('<span>Ingen bild vald</span>');
		}
		updatePreview();
	}

	function bindArticleEditorPreview() {
		const editor = window.tinyMCE && window.tinyMCE.get('nv_article_content');

		if (!editor) return false;

		editor.on('keyup change input undo redo SetContent', updatePreview);
		return true;
	}

	$(document).on('submit', '.nv-article-builder-page form', function () {
		const editor = window.tinyMCE && window.tinyMCE.get('nv_article_content');
		if (editor) editor.save();
	});

	$(document).on('input change', '[data-preview-field], #title, #categorychecklist input, #nv-article-category, #nv_article_content, #nv-sources', updatePreview);

	$(document).on('click', '.nv-article-builder-select-image', function () {
		const target = $(this).data('target');
		const frame = wp.media({
			title: 'Välj bild',
			button: { text: 'Använd bild' },
			multiple: false
		});

		frame.on('select', function () {
			const attachment = frame.state().get('selection').first().toJSON();
			const sizes = attachment.sizes || {};
			const image = sizes.medium || sizes.thumbnail || sizes.full || attachment;
			setImagePreview(target, attachment.id, image.url);
		});

		frame.open();
	});

	$(document).on('click', '.nv-article-builder-remove-image', function () {
		setImagePreview($(this).data('target'), '', '');
	});

	$(function () {
		updatePreview();
		if (!bindArticleEditorPreview()) {
			window.setTimeout(bindArticleEditorPreview, 500);
		}
	});
})(jQuery);
