<header class="site-header">
    <div class="header-container">
        <a href="/TP_information_geurre/" class="logo">
            <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            <span class="logo-text">Information Guerre</span>
        </a>

        <form class="search-form" action="/TP_information_geurre/articles" method="GET">
            <input type="text" name="q" class="search-input" placeholder="Rechercher un article..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            <button type="submit" class="search-btn" aria-label="Rechercher">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </form>

        <nav class="header-nav">
            <a href="/TP_information_geurre/" class="nav-link">Accueil</a>
            <a href="/TP_information_geurre/articles" class="nav-link">Articles</a>
            <a href="/TP_information_geurre/admins" class="btn-admin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Connexion</span>
            </a>
        </nav>

        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <form class="mobile-search-form" action="/TP_information_geurre/articles" method="GET">
            <input type="text" name="q" class="search-input" placeholder="Rechercher..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            <button type="submit" class="search-btn" aria-label="Rechercher">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </form>
        <a href="/TP_information_geurre/" class="mobile-nav-link">Accueil</a>
        <a href="/TP_information_geurre/articles" class="mobile-nav-link">Articles</a>
        <a href="/TP_information_geurre/admins" class="mobile-nav-link btn-admin-mobile">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Connexion Admin
        </a>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var mobileBtn = document.getElementById('mobileMenuBtn');
    var mobileMenu = document.getElementById('mobileMenu');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
            mobileBtn.classList.toggle('open');
        });
    }
});
</script>
