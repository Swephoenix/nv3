const NEWSVOICE_THEME = window.newsvoiceTheme || {};
const NEWSVOICE_ASSET_BASE = NEWSVOICE_THEME.assetBase || 'assets/';
const NEWSVOICE_ARTICLE_URL = NEWSVOICE_THEME.articleUrl || '#';

function newsvoiceAssetUrl(path) {
    if (!path || /^(https?:)?\/\//.test(path) || path.startsWith('/')) {
        return path;
    }

    return path.replace(/^assets\//, NEWSVOICE_ASSET_BASE);
}

// Mobilmeny funktion
    function toggleMenu() {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('menu-open');
    }

    function setupMobileSubmenus() {
        const nav = document.getElementById('mainNav');
        if (!nav) return;

        nav.querySelectorAll('.submenu-toggle').forEach((button) => button.remove());

        nav.querySelectorAll('.has-children').forEach((item) => {
            const link = item.querySelector(':scope > a');
            const submenu = item.querySelector(':scope > .sub-menu');
            if (!link || !submenu) return;

            item.classList.remove('is-open');

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'submenu-toggle';
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', `Visa undermeny för ${link.textContent.trim()}`);
            button.textContent = '+';

            button.addEventListener('click', () => {
                const isOpen = item.classList.toggle('is-open');
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                button.textContent = isOpen ? '−' : '+';
            });

            link.insertAdjacentElement('afterend', button);
        });
    }

    function updateCurrentDate() {
        const el = document.getElementById('current-date');
        if (!el) return;
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        el.textContent = now.toLocaleDateString('sv-SE', options);
    }

    function setupSplashScreen() {
        const splash = document.getElementById('splash-screen');
        const views = Array.from(document.querySelectorAll('[data-splash-mode]'));
        const choices = Array.from(document.querySelectorAll('[data-splash-choice]'));
        const skipButton = document.getElementById('splash-skip-button');
        const startButton = document.getElementById('splash-start-button');
        const video = document.getElementById('entry-splash-video');

        if (!splash || views.length === 0) {
            document.body.classList.remove('splash-active');
            return;
        }

        let isClosed = false;
        let activeMode = splash.dataset.activeMode || views[0].dataset.splashMode;
        if (video) {
            video.muted = false;
            video.volume = 1;
        }

        function closeSplash() {
            if (isClosed) return;
            isClosed = true;
            if (video) video.pause();
            splash.classList.add('is-hidden');
            document.body.classList.remove('splash-active');
            splash.setAttribute('aria-hidden', 'true');
            window.setTimeout(() => splash.remove(), 360);
        }

        function playWithSound() {
            if (!video) return;
            splash.classList.remove('needs-user-start');
            video.muted = false;
            const playAttempt = video.play();
            if (playAttempt && typeof playAttempt.catch === 'function') {
                playAttempt.catch(() => {
                    splash.classList.add('needs-user-start');
                });
            }
        }

        function setSplashMode(mode) {
            const matchingView = views.find((view) => view.dataset.splashMode === mode);
            activeMode = matchingView ? mode : views[0].dataset.splashMode;
            const showVideo = activeMode === 'video' && video;

            views.forEach((view) => {
                view.hidden = view.dataset.splashMode !== activeMode;
            });
            choices.forEach((button) => {
                button.classList.toggle('is-active', button.dataset.splashChoice === activeMode);
            });

            if (startButton) startButton.hidden = !showVideo;

            if (showVideo) {
                playWithSound();
                return;
            }

            splash.classList.remove('needs-user-start');
            if (video) video.pause();
        }

        skipButton?.addEventListener('click', closeSplash);
        startButton?.addEventListener('click', playWithSound);
        choices.forEach((button) => {
            button.addEventListener('click', () => setSplashMode(button.dataset.splashChoice));
        });
        splash.addEventListener('click', (event) => {
            if (event.target === splash) closeSplash();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeSplash();
        }, { once: true });

        video?.addEventListener('ended', closeSplash, { once: true });
        video?.addEventListener('error', closeSplash, { once: true });

        setSplashMode(activeMode);
    }

    // Static data (no backend needed)
    const STATIC_ARTICLES = [
        {
            id: 1,
            title: "Israels och USA:s upptrappning mot Iran förändrar maktbalansen i Mellanöstern",
            summary: "En sammanfattande genomgång av hur angrepp, motangrepp, regional press och stormaktspolitik har fört konflikten mellan Israel, USA och Iran in i en farligare fas.",
            category: "Krig och Fred",
            imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Iran-armada-1170x600.jpg",
            featured: true
        },
        { id: 101, title: "Kommuner pressas av växande kostnader för äldreomsorg och skola", summary: "Flera svenska kommuner flaggar för hårdare prioriteringar i årets budgetarbete.", category: "Sverige", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Carl-Bildt_Mark-Carney-900x491.jpg", featured: false },
        { id: 102, title: "Ny svensk beredskapsplan ska stärka livsmedelsförsörjningen", summary: "Myndigheter och producenter tar fram åtgärder för ökad nationell motståndskraft.", category: "Sverige", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Depositphotos_construction-worker-960x492.jpg", featured: false },
        { id: 103, title: "Regioner varnar för längre vårdköer efter ny sparrunda", summary: "Trycket ökar på akutsjukhus och primärvård när kostnaderna stiger.", category: "Sverige", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/intravenost-e1769588724538-960x492.jpg", featured: false },
        { id: 104, title: "Nordiskt säkerhetssamarbete fördjupas i Arktis", summary: "Svenska och nordiska företrädare lyfter logistik, energi och försvar i norr.", category: "Sverige", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Military-Arctic-Foto-Arktisoutdoor.co_.uk_-900x506.jpg", featured: false },
        { id: 105, title: "Biståndsmyndighet i USA pressas efter växande intern kritik", summary: "Ledningen pressas när biståndsprogram granskas hårdare.", category: "USA", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Maduro-Trump-960x492.jpg", featured: false },
        { id: 106, title: "Nytt federalt direktiv skakar amerikansk universitetsidrott", summary: "Idrottsorganisationen kommenterar det nya federala direktivet.", category: "USA", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Hegseth-Rubio-Trump-Vance-960x492.jpg", featured: false },
        { id: 107, title: "Ny kurs i Gaza sätter press på USA:s diplomati i regionen", summary: "Företrädare beskriver en reviderad diplomatisk linje för regionen.", category: "Mellanöstern", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Jared-Kushner-New-Gaza-960x492.jpg", featured: false },
        { id: 108, title: "Syrien signalerar hårdare säkerhetslinje efter nya angrepp", summary: "Syriens ledare bekräftar fortsatt fokus på en militär lösning.", category: "Världen", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Iran-revolution-2025-960x492.jpg", featured: false },
        { id: 109, title: "Malaysia trappar upp BRICS-handeln med ny flerårsplan för export och investeringar", summary: "Kuala Lumpur presenterar en flerårig satsning för att öka exporten och fördjupa investeringarna med BRICS-partner.", category: "Världen", imageUrl: "assets/Malaysia.jpg", featured: false },
        { id: 110, title: "Rysk diplomat varnar för ny farlig fas i stormaktskonflikten", summary: "Uttalandet kommer samtidigt som militära markeringar ökar i flera regioner.", category: "Världen", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Maria-Zakharova-Moscow-960x492.jpg", featured: false },
        { id: 111, title: "Opinion: Europas ledare underskattar följderna av det nya säkerhetsläget", summary: "Ett växande antal bedömare menar att besluten tas utan tydlig långsiktig strategi.", category: "Opinion", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Caitlin-Johnstone-AI-edited-960x492.jpg", featured: false },
        { id: 112, title: "Debatt: När geopolitik blir inrikespolitik förändras hela medielandskapet", summary: "En analys av hur konflikter och informationskrig spiller över i svensk offentlighet.", category: "Opinion", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/George-Galloway-5mars-2024-960x492.jpg", featured: false },
        { id: 113, title: "Analys: regionala konflikter kan snabbt slå mot energi, handel och valutor", summary: "Ekonomisk analys modellerar effekterna av större konflikter.", category: "Opinion", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Jack-F-Matlock-Jr-960x492.jpg", featured: false },
        { id: 114, title: "Krönika: teknokratisk styrning växer i skuggan av kriserna", summary: "Allt fler beslut flyttas från väljare och parlament till permanenta expertstrukturer.", category: "Opinion", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Mark-Bullen-depixled-960x492.jpg", featured: false },
        { id: 115, title: "Ny nordisk handelskorridor ska korta ledtider för mindre exportföretag", summary: "Initiativet ska ge snabbare transporter för mindre tillverkare.", category: "Ekonomi", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Canada-China-900x491.jpg", featured: false },
        { id: 116, title: "Industriföretag flyttar investeringar när energipriserna fortsätter svänga", summary: "Nya kalkyler visar att osäkerheten påverkar långsiktiga etableringsbeslut.", category: "Ekonomi", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/4Air-960x492.jpg", featured: false },
        { id: 117, title: "Exportbolag varnar för dyrare försäkringar i oroliga handelsleder", summary: "Ökade riskpremier pressar redan små marginaler inom sjöfart och logistik.", category: "Ekonomi", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Depositphotos_solarstorm-900x515.jpg", featured: false },
        { id: 118, title: "Ny kapitalflykt från tillväxtmarknader väcker oro på valutamarknaden", summary: "Investerare söker sig till säkrare tillgångar när den geopolitiska osäkerheten ökar.", category: "Ekonomi", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/secret-room-telephone-crestock-862x600.jpg", featured: false },
        { id: 119, title: "Läkare efterlyser bredare debatt om övermedicinering i primärvården", summary: "Flera vårdprofessioner vill se mer fokus på orsaker, livsstil och förebyggande insatser.", category: "Hälsa & Vård", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/vaccination-historia-960x492.jpg", featured: false },
        { id: 120, title: "Ny studie granskar effekterna av rödljusbehandling vid långvarig smärta", summary: "Forskare och terapeuter pekar på ett växande intresse för komplementära metoder.", category: "Hälsa & Vård", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/rodljusterapi-1-960x492.jpg", featured: false },
        { id: 121, title: "Sjukvården pressas när fler patienter söker intravenös näringsterapi", summary: "Efterfrågan ökar samtidigt som debatten om evidens och regelverk hårdnar.", category: "Hälsa & Vård", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/intravenost-e1769588724538-768x453.jpg", featured: false },
        { id: 122, title: "Kostdebatten fortsätter efter ny rapport om ultraprocessade livsmedel", summary: "Experter vill se tydligare märkning och mer oberoende forskning om effekterna.", category: "Hälsa & Vård", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/havremjolk-900x507.jpg", featured: false },
        { id: 123, title: "Mediehus skär ned samtidigt som alternativa plattformar växer", summary: "Nya vanor och minskade annonsintäkter förändrar villkoren för journalistiken.", category: "Media", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/internetfrihet-csno-960x492.jpg", featured: false },
        { id: 124, title: "Yttrandefriheten på nätet prövas när nya regler införs i flera länder", summary: "Teknikbolag och redaktioner förbereder sig för hårdare tillsyn och större ansvar.", category: "Media", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/google-assistant-960x492.jpg", featured: false },
        { id: 125, title: "Analys: oberoende publicister vinner mark i takt med publikens misstro", summary: "Fler läsare söker fördjupning och tydliga perspektiv utanför de stora redaktionerna.", category: "Media", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/David-Pyne-Rattansi-960x492.jpg", featured: false },
        { id: 126, title: "Ny tv-satsning vill samla reportage, intervjuer och geopolitisk analys", summary: "Producenter ser ökat intresse för längre format med eget redaktionellt uttryck.", category: "Media", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/tridactyl-Paloma-960x492.jpg", featured: false },
        { id: 127, title: "Dokumentärvågen fortsätter när publiken söker längre berättelser om samtiden", summary: "Flera producenter vittnar om ett ökat intresse för fördjupande format.", category: "Kultur", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Agnes-aged-to-2026.jpg", featured: false },
        { id: 128, title: "Kulturdebatt om AI-bearbetade porträtt delar konstvärlden", summary: "Frågor om autenticitet, upphovsrätt och uttryck står i centrum för diskussionen.", category: "Kultur", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Caitlin-Johnstone-AI-edited-1170x600.jpg", featured: false },
        { id: 129, title: "Nya musik- och scenprojekt växer fram utanför storstädernas institutioner", summary: "Fristående kulturaktörer hittar egna publiker genom digitala plattformar och turnéer.", category: "Kultur", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/George-Galloway-5mars-2024-1170x600.jpg", featured: false },
        { id: 130, title: "Filmfestivaler lyfter berättelser om övervakning, makt och identitet", summary: "Teman om kontroll och frihet sätter tonen för årets internationella urval.", category: "Kultur", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Mark-Bullen-depixled-1170x600.jpg", featured: false },
        { id: 131, title: "Kinesisk chiputvecklare visar upp genombrott inom kvantnära beräkningar", summary: "En ny processor väntas ge kraftigt högre beräkningshastighet.", category: "Teknik", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/JUNI-cas.cn_-960x492.jpg", featured: false },
        { id: 132, title: "Ny debatt om AI-assistenter och integritet tar fart i Europa", summary: "Utvecklingen går snabbare än lagstiftningen och väcker frågor om dataskydd.", category: "Teknik", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/google-assistant-960x492.jpg", featured: false },
        { id: 133, title: "Experter varnar för rymdskrot när kommersiella uppskjutningar ökar", summary: "Fler satelliter i omloppsbana höjer risken för störningar och kedjekollisioner.", category: "Teknik", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/space-debris-900x475.jpg", featured: false },
        { id: 134, title: "Ny cybersäkerhetsplattform riktar in sig på självständiga journalister", summary: "Verktyg för skyddad kommunikation och anonym research blir allt viktigare.", category: "Teknik", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/laptopman-SAROS-960x492.jpg", featured: false },
        { id: 135, title: "Prepping i vardagen: så bygger du ett robust hemmalager utan överköp", summary: "Små, praktiska steg kan göra hushållet mer motståndskraftigt vid störningar.", category: "Vardagstips", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Depositphotos_construction-worker-1170x600.jpg", featured: false },
        { id: 136, title: "DIY-guide: enklare energisnåla förbättringar som sänker kostnaderna hemma", summary: "Från tätning till smart belysning - flera åtgärder går att göra utan stora investeringar.", category: "Vardagstips", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/4Air-1170x600.jpg", featured: false },
        { id: 137, title: "Fem saker att ordna innan nästa avbrott i el eller internet", summary: "Beredskap i hemmet handlar ofta mer om rutiner än om dyr utrustning.", category: "Vardagstips", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/internetfrihet-csno-900x462.jpg", featured: false },
        { id: 138, title: "Så planerar du ett enklare förråd för vatten, värme och kommunikation", summary: "Med rätt prioritering kan ett litet lager göra stor skillnad i vardagen.", category: "Vardagstips", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Depositphotos_solarstorm-1170x669.jpg", featured: false },
        { id: 139, title: "English Edition: Nordic logistics shift as new regional trade routes emerge", summary: "Analysts say smaller exporters may benefit first from the proposed transport corridor.", category: "Engelska", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Canada-China-1170x638.jpg", featured: false },
        { id: 140, title: "English Edition: Pressure grows on US foreign policy after latest regional escalation", summary: "Observers point to a widening gap between official rhetoric and strategic outcomes.", category: "Engelska", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/Jack-F-Matlock-Jr-1170x600.jpg", featured: false },
        { id: 141, title: "English Edition: Independent media gains ground as trust in legacy outlets erodes", summary: "Audience behavior is shifting toward long-form analysis, interviews and alternative reporting.", category: "Engelska", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/newsvoice-logo-retina-544px.png", featured: false },
        { id: 142, title: "English Edition: New health debate questions the long-term effects of processed diets", summary: "Researchers call for more independent studies and better public information.", category: "Engelska", imageUrl: "assets/NewsVoice - Public Service på riktigt_files/havremjolk-1170x659.jpg", featured: false }
    ];

    const STATIC_ADS = [
        {
            id: 2, title: "Premium VPN-tjänst", description: "Sakra din anslutning",
            imageUrl: "assets/PremiumVpn.png", adType: "banner", targetUrl: "#", sponsor: "SecureNet"
        },
        {
            id: 4, title: "Annonspaket i NewsVoice", description: "Na nya kunder och ditt foretag stodjer samtidigt NewsVoice",
            imageUrl: "assets/NVannons.png", adType: "rectangle", targetUrl: "#", sponsor: "NewsVoice", fit: "contain"
        }
    ];

    function fetchArticles() { return [...STATIC_ARTICLES]; }
    function fetchFeaturedArticles() { return STATIC_ARTICLES.filter(article => article.featured); }
    function fetchRandomAdByType(type) {
        const adsOfType = STATIC_ADS.filter(ad => ad.adType === type);
        return adsOfType.length > 0 ? adsOfType[Math.floor(Math.random() * adsOfType.length)] : null;
    }
    function fetchAdsByType(type) { return STATIC_ADS.filter(ad => ad.adType === type); }
    function getAnyAd() { return STATIC_ADS.length > 0 ? STATIC_ADS[Math.floor(Math.random() * STATIC_ADS.length)] : null; }

    function getMenuCategory(category) {
        return category ? category.split(' ')[0] : "Nyheter";
    }

    const SECTION_CONFIG = {
        sverige: { categories: ['Sverige'] },
        varlden: { categories: ['USA', 'Mellanöstern', 'Världen'] },
        opinion: { categories: ['Opinion'] },
        ekonomi: { categories: ['Ekonomi'] },
        halsa: { categories: ['Hälsa & Vård'] },
        media: { categories: ['Media'] },
        kultur: { categories: ['Kultur'] },
        teknik: { categories: ['Teknik'] },
        vardagstips: { categories: ['Vardagstips'] },
        engelska: { categories: ['Engelska'] }
    };

    function shuffleArticles(articles) {
        return [...articles].sort(() => 0.5 - Math.random());
    }

    function getSectionArticles(sectionKey) {
        const config = SECTION_CONFIG[sectionKey];
        const allArticles = fetchArticles().filter(article => !article.featured);
        if (!config) {
            return shuffleArticles(allArticles).slice(0, 4);
        }

        const matched = allArticles.filter(article => config.categories.includes(article.category));
        const fallback = allArticles.filter(article => !matched.includes(article));
        return [...shuffleArticles(matched), ...shuffleArticles(fallback)].slice(0, 4);
    }

    function buildNewsGridHtml(articles) {
        let html = '';
        articles.forEach(article => {
            html += `
                <div class="article-link" data-article-id="${article.id}">
                    <div class="news-item-4">
                        <div class="news-thumb">
                            <img src="${newsvoiceAssetUrl(article.imageUrl)}" alt="${article.title}">
                            <span class="category-label">${getMenuCategory(article.category)}</span>
                        </div>
                        <h3>${article.title}</h3>
                    </div>
                </div>
            `;
        });
        return html;
    }

    async function renderSectionGrid(containerId, sectionKey) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const articles = getSectionArticles(sectionKey);
        if (articles.length > 0) {
            container.innerHTML = buildNewsGridHtml(articles);
        }
    }

    // Render featured article
    async function renderFeaturedArticle() {
        const container = document.getElementById('featured-article-container');
        const featuredArticles = fetchFeaturedArticles();
        const article = (featuredArticles.length > 0) ? featuredArticles[Math.floor(Math.random() * featuredArticles.length)] : fetchArticles()[0];
        
        if(article) {
            container.innerHTML = `
                <a href="${NEWSVOICE_ARTICLE_URL}" class="article-link" data-article-id="${article.id}">
                    <div class="featured-article">
                        <div class="featured-img-container">
                            <div class="featured-img-placeholder" style="width: 60%; background: #555; color:white;">
                                <img src="${newsvoiceAssetUrl(article.imageUrl)}" style="width:100%; height:100%; object-fit:cover;" alt="${article.title}">
                            </div>
                            <div class="featured-img-placeholder" style="width: 40%; background: #888; color:white;">
                                <img src="${newsvoiceAssetUrl('assets/journalist.png')}" style="width:100%; height:100%; object-fit:cover;" alt="Ebba Larsson">
                            </div>
                        </div>
                        <div class="featured-text">
                            <div class="label-red">${getMenuCategory(article.category)}</div>
                            <h1>${article.title}</h1>
                            <p style="margin-top: 15px; font-size: 14px; line-height: 1.4;">${article.summary}</p>
                        </div>
                    </div>
                </a>
            `;
        }
    }

    // Render news grid 3
    async function renderNewsGrid3() {
        const container = document.getElementById('news-grid-3-container');
        const articles = fetchArticles().filter(a => !a.featured).slice(0, 3);
        
        if (articles.length > 0) {
            let html = '';
            articles.forEach(article => {
                html += `
                    <div class="article-link" data-article-id="${article.id}">
                        <div class="grid-item-3">
                            <div class="grid-item-3-thumb">
                                <img src="${newsvoiceAssetUrl(article.imageUrl)}" alt="${article.title}">
                                <span class="category-label">${getMenuCategory(article.category)}</span>
                            </div>
                            <h3>${article.title}</h3>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }
    }

    // Render latest news grid
    async function renderEconomyBusinessGrid() {
        const container = document.getElementById('economy-business-grid');
        const articles = fetchArticles().filter(a => !a.featured).sort(() => 0.5 - Math.random()).slice(0, 4);
        
        if (articles.length > 0) {
            container.innerHTML = buildNewsGridHtml(articles);
        }
    }

    // ADS
    async function renderTopBannerSlot() {
        const container = document.getElementById('top-banner-slot');
        const ad = fetchRandomAdByType('banner') || getAnyAd();
        if (ad) container.innerHTML = `<a href="${ad.targetUrl}"><img src="${newsvoiceAssetUrl(ad.imageUrl)}" alt="${ad.title}" style="width:100%; height:90px; object-fit:contain;" onerror="this.src='https://via.placeholder.com/728x90?text=ANNONS';"></a>`;
    }

    async function renderMiddleAd() {
        const container = document.getElementById('middle-ads-placeholder');
        const ad = fetchRandomAdByType('rectangle') || getAnyAd();
        if (ad) {
            const imageFit = ad.fit === 'cover' ? 'cover' : 'contain';
            container.innerHTML = `<a href="${ad.targetUrl}"><img src="${newsvoiceAssetUrl(ad.imageUrl)}" alt="${ad.title}" style="width:100%; height:250px; object-fit:${imageFit}; display:block;" onerror="this.src='https://via.placeholder.com/970x250?text=Bred+annons';"></a>`;
        }
    }

    // Init
    async function initPage() {
        setupSplashScreen();
        updateCurrentDate();
        setupMobileSubmenus();
        if (NEWSVOICE_THEME.homeBuilderEnabled) return;
        await renderFeaturedArticle();
        await renderNewsGrid3();
        await renderEconomyBusinessGrid();
        await renderSectionGrid('sverige-grid', 'sverige');
        await renderSectionGrid('varlden-grid', 'varlden');
        await renderSectionGrid('opinion-grid', 'opinion');
        await renderSectionGrid('ekonomi-grid', 'ekonomi');
        await renderSectionGrid('halsa-grid', 'halsa');
        await renderSectionGrid('media-grid', 'media');
        await renderSectionGrid('kultur-grid', 'kultur');
        await renderSectionGrid('teknik-grid', 'teknik');
        await renderSectionGrid('vardagstips-grid', 'vardagstips');
        await renderSectionGrid('engelska-grid', 'engelska');
        await renderTopBannerSlot();
        await renderMiddleAd();
    }

    document.addEventListener('DOMContentLoaded', initPage);
