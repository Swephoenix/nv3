(function ($) {
	const articleData = (window.newsvoiceHomepageBuilder && window.newsvoiceHomepageBuilder.articles) || [];
	const articleMap = articleData.reduce(function (map, article) {
		map[String(article.id)] = article;
		return map;
	}, {});
	let activeChoiceField = null;
	let activeChoiceLimit = 1;
	let stagedChoiceIds = [];

	function idsFromValue(value) {
		return (value || '').split(/[\s,]+/).filter(Boolean);
	}

	function setImagePreview(wrapper, id, url) {
		wrapper.find('[data-homepage-image-id]').val(id).trigger('change');
		const preview = wrapper.find('[data-homepage-image-preview]');
		if (url) {
			preview.html('<img src="' + url + '" alt="">');
		} else {
			preview.html('<span>Ingen bild vald</span>');
		}
	}

	function articleForId(id) {
		return articleMap[String(id)] || { id: id, title: 'Artikel #' + id, category: 'Nyheter', image: '' };
	}

	function articleCardHtml(id) {
		const article = articleForId(id);
		const image = article.image ? '<img src="' + article.image + '" alt="">' : '<div class="nv-home-builder-choice__thumb-empty">#' + article.id + '</div>';
		return '<div class="nv-home-builder-choice-card">' + image + '<strong>' + article.title + '</strong><span>' + article.category + '</span></div>';
	}

	function updateChoicePreview(field) {
		const wrapper = $('[data-homepage-choice-field="' + field.attr('id') + '"]');
		const ids = idsFromValue(field.val());
		const status = ids.length === 1 ? 'Manuellt val: 1 artikel vald' : 'Manuellt val: ' + ids.length + ' artiklar valda';
		wrapper.find('[data-choice-status]').text(status);
		wrapper.find('[data-choice-preview]').html(ids.length ? ids.map(articleCardHtml).join('') : '<p>Inga artiklar valda.</p>');
	}

	function renderAllChoicePreviews() {
		$('[data-homepage-choice-field] input[data-preview-field]').each(function () {
			updateChoicePreview($(this));
		});
	}

	function adKeyFromName(name) {
		if (!name) return '';
		if (name.indexOf('[top_ad]') !== -1) return 'top_ad';
		if (name.indexOf('[middle_ad]') !== -1) return 'middle_ad';
		const sidebar = name.match(/\[sidebar_ads]\[(\d+)]/);
		return sidebar ? 'sidebar_' + sidebar[1] : '';
	}

	function collectAd(wrapper) {
		const type = wrapper.find('select[name$="[type]"]').val() || 'image';
		const iframe = wrapper.find('textarea[name$="[iframe]"]').val() || '';
		const imageIdUrl = wrapper.find('[data-homepage-image-preview] img').attr('src') || '';
		const imageUrl = wrapper.find('[data-homepage-image-url]').val() || imageIdUrl;
		const link = wrapper.find('input[name$="[url]"]').val() || '';
		return { type: type, iframe: iframe, imageUrl: imageUrl, link: link };
	}

	function renderPreviewAd(target, ad, fallback) {
		if (!target.length) return;
		if (ad.type === 'iframe' && ad.iframe.trim()) {
			target.html('<div class="homepage-builder-preview__ad-code">Iframe-annons</div>');
			return;
		}
		if (ad.imageUrl) {
			target.html('<img src="' + ad.imageUrl + '" alt="">');
			return;
		}
		target.text(fallback);
	}

	function renderArticleCard(id, variant) {
		const article = articleForId(id);
		const image = article.image ? '<img src="' + article.image + '" alt="">' : '<div class="homepage-preview-card__empty">#' + article.id + '</div>';
		return '<article class="homepage-preview-card homepage-preview-card--' + variant + '">' +
			'<div class="homepage-preview-card__image">' + image + '<span>' + article.category + '</span></div>' +
			'<h4>' + article.title + '</h4>' +
			'</article>';
	}

	function renderIdCards(target, ids, emptyText) {
		if (!target.length) return;
		if (!ids.length) {
			target.html('<div class="homepage-builder-preview__empty">' + emptyText + '</div>');
			return;
		}
		target.html(ids.map(function (id) {
			return renderArticleCard(id, 'small');
		}).join(''));
	}

	function renderSectionCards(target) {
		const sectionCards = [];
		$('.nv-home-builder-panel input[name*="[sections]"]').each(function () {
			if (this.id === 'nv-section-engelska-grid') return;
			const wrapper = $('[data-homepage-choice-field="' + this.id + '"]');
			const label = wrapper.find('h3').first().text();
			const ids = idsFromValue($(this).val());
			if (!ids.length) return;
			const first = articleForId(ids[0]);
			const image = first.image ? '<img src="' + first.image + '" alt="">' : '<div class="homepage-preview-card__empty">#' + first.id + '</div>';
			sectionCards.push('<article class="homepage-preview-section-card">' +
				'<div class="homepage-preview-section-card__image">' + image + '</div>' +
				'<div><strong>' + label + '</strong><span>' + ids.length + ' artiklar valda</span></div>' +
				'</article>');
		});
		target.html(sectionCards.length ? sectionCards.join('') : '<div class="homepage-builder-preview__empty">Sektioner med valda artiklar</div>');
	}

	function renderHomepagePreview() {
		const preview = $('.homepage-builder-preview');
		if (!preview.length) return;

		const featuredId = $('#nv-featured-post').val();
		const featuredArticle = articleForId(featuredId);
		const featuredImage = $('#nv-featured-image-url').val() || featuredArticle.image;
		const topIds = idsFromValue($('#nv-top-grid-posts').val());

		const featuredTarget = $('[data-homepage-preview-output="featured"]');
		if (featuredImage) {
			featuredTarget.html('<div class="homepage-builder-preview__hero-image"><img src="' + featuredImage + '" alt=""><span>' + featuredArticle.category + '</span></div><h3>' + featuredArticle.title + '</h3>');
		} else {
			featuredTarget.html('<h3>' + featuredArticle.title + '</h3>');
		}

		renderIdCards($('[data-homepage-preview-output="top_grid"]'), topIds, 'Tre toppartiklar');
		renderSectionCards($('[data-homepage-preview-output="sections"]'));
		renderIdCards($('[data-homepage-preview-output="english_section"]'), idsFromValue($('#nv-section-engelska-grid').val()), 'Engelska');

		const sidebarAds = [];
		$('[data-homepage-ad]').each(function () {
			const key = adKeyFromName($(this).find('[name]').first().attr('name'));
			const ad = collectAd($(this));
			if (key === 'top_ad') renderPreviewAd($('[data-homepage-preview-ad="top_ad"]'), ad, 'Annons uppe till höger');
			if (key === 'middle_ad') renderPreviewAd($('[data-homepage-preview-ad="middle_ad"]'), ad, 'Bred annons');
			if (key.indexOf('sidebar_') === 0) sidebarAds.push(ad);
		});

		const sidebarTarget = $('[data-homepage-preview-output="sidebar_ads"]');
		sidebarTarget.empty();
		sidebarAds.slice(0, 3).forEach(function (ad) {
			const slot = $('<div class="homepage-builder-preview__sidebar-ad"></div>');
			renderPreviewAd(slot, ad, 'Annons');
			sidebarTarget.append(slot);
		});

		renderAllChoicePreviews();
		preview.addClass('is-updating');
		window.setTimeout(function () {
			preview.removeClass('is-updating');
		}, 180);
	}

	function openChoiceModal(wrapper) {
		activeChoiceField = wrapper.find('input[data-preview-field]');
		activeChoiceLimit = parseInt(wrapper.data('choice-limit'), 10) || 1;
		stagedChoiceIds = idsFromValue(activeChoiceField.val()).slice(0, activeChoiceLimit);
		$('[data-choice-search]').val('');
		renderChoiceGallery('');
		$('#newsvoice-homepage-choice-modal').addClass('is-active').attr('aria-hidden', 'false');
	}

	function openAlgoModal(wrapper) {
		activeChoiceField = wrapper.find('input[data-preview-field]');
		activeChoiceLimit = parseInt(wrapper.data('choice-limit'), 10) || 1;
		$('#newsvoice-homepage-algo-modal').addClass('is-active').attr('aria-hidden', 'false');
	}

	function closeChoiceModal() {
		$('#newsvoice-homepage-choice-modal').removeClass('is-active').attr('aria-hidden', 'true');
		activeChoiceField = null;
		stagedChoiceIds = [];
	}

	function closeAlgoModal() {
		$('#newsvoice-homepage-algo-modal').removeClass('is-active').attr('aria-hidden', 'true');
		activeChoiceField = null;
	}

	function renderChoiceGallery(query) {
		const normalized = (query || '').toLowerCase();
		const gallery = $('[data-choice-gallery]');
		const filtered = articleData.filter(function (article) {
			return !normalized || article.title.toLowerCase().indexOf(normalized) !== -1 || article.category.toLowerCase().indexOf(normalized) !== -1 || String(article.id).indexOf(normalized) !== -1;
		});

		gallery.html(filtered.map(function (article) {
			const selected = stagedChoiceIds.indexOf(String(article.id)) !== -1;
			const image = article.image ? '<img src="' + article.image + '" alt="">' : '<div class="newsvoice-homepage-choice-card__empty">#' + article.id + '</div>';
			return '<button type="button" class="newsvoice-homepage-choice-card' + (selected ? ' is-selected' : '') + '" data-choice-id="' + article.id + '">' + image + '<strong>' + article.title + '</strong><span>' + article.category + '</span></button>';
		}).join('') || '<p>Inga artiklar matchar sökningen.</p>');

		$('[data-choice-count]').text(stagedChoiceIds.length);
	}

	function toggleChoice(id) {
		const stringId = String(id);
		const existing = stagedChoiceIds.indexOf(stringId);
		if (existing !== -1) {
			stagedChoiceIds.splice(existing, 1);
		} else {
			if (activeChoiceLimit === 1) stagedChoiceIds = [];
			if (stagedChoiceIds.length < activeChoiceLimit) stagedChoiceIds.push(stringId);
		}
		renderChoiceGallery($('[data-choice-search]').val());
	}

	function saveManualChoice() {
		if (!activeChoiceField) return;
		activeChoiceField.val(stagedChoiceIds.join(',')).trigger('change');
		updateChoicePreview(activeChoiceField);
		renderHomepagePreview();
		closeChoiceModal();
	}

	function saveAlgoChoice() {
		if (!activeChoiceField) return;
		const algorithm = $('input[name="newsvoice_homepage_algo_choice"]:checked').val();
		let articles = articleData.slice();
		if (algorithm === 'random') {
			articles = articles.sort(function () { return Math.random() - 0.5; });
		}
		const ids = articles.slice(0, activeChoiceLimit).map(function (article) {
			return String(article.id);
		});
		activeChoiceField.val(ids.join(',')).trigger('change');
		const wrapper = $('[data-homepage-choice-field="' + activeChoiceField.attr('id') + '"]');
		updateChoicePreview(activeChoiceField);
		wrapper.find('[data-choice-status]').text('Algoritm: ' + (algorithm === 'random' ? 'slumpmässiga artiklar' : algorithm === 'category' ? 'samma kategori' : 'senaste artiklar'));
		renderHomepagePreview();
		closeAlgoModal();
	}

	$(document).on('click', '.nv-home-builder-open-choice', function () {
		openChoiceModal($(this).closest('[data-homepage-choice-field]'));
	});

	$(document).on('click', '.nv-home-builder-open-algo', function () {
		openAlgoModal($(this).closest('[data-homepage-choice-field]'));
	});

	$(document).on('click', '.nv-home-builder-close-choice', closeChoiceModal);
	$(document).on('click', '.nv-home-builder-close-algo', closeAlgoModal);
	$(document).on('click', '.nv-home-builder-save-choice', saveManualChoice);
	$(document).on('click', '.nv-home-builder-save-algo', saveAlgoChoice);
	$(document).on('click', '.newsvoice-homepage-choice-modal', function (event) {
		if (event.target === this) closeChoiceModal();
	});
	$(document).on('click', '.newsvoice-homepage-algo-modal', function (event) {
		if (event.target === this) closeAlgoModal();
	});
	$(document).on('input', '[data-choice-search]', function () {
		renderChoiceGallery($(this).val());
	});
	$(document).on('click', '.newsvoice-homepage-choice-card', function () {
		toggleChoice($(this).data('choice-id'));
	});

	$(document).on('click', '.nv-home-builder-select-image', function () {
		const wrapper = $(this).closest('[data-homepage-ad]');
		const frame = wp.media({
			title: 'Välj bild',
			button: { text: 'Använd bild' },
			multiple: false
		});

		frame.on('select', function () {
			const attachment = frame.state().get('selection').first().toJSON();
			const sizes = attachment.sizes || {};
			const image = sizes.medium || sizes.thumbnail || sizes.full || attachment;
			setImagePreview(wrapper, attachment.id, image.url);
			renderHomepagePreview();
		});

		frame.open();
	});

	$(document).on('click', '.nv-home-builder-remove-image', function () {
		setImagePreview($(this).closest('[data-homepage-ad]'), '', '');
		renderHomepagePreview();
	});

	$(document).on('input change', '[data-homepage-image-url]', function () {
		const wrapper = $(this).closest('[data-homepage-ad]');
		if (wrapper.find('[data-homepage-image-id]').val()) return;
		setImagePreview(wrapper, '', $(this).val());
		renderHomepagePreview();
	});

	$(document).on('input change', '[data-preview-field], [data-homepage-image-id]', renderHomepagePreview);
	$(renderHomepagePreview);
})(jQuery);
