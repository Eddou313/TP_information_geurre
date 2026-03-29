<?php
// Sidebar include - requires $user and $currentPage variables
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h1>Back Office</h1>
        <span>Gestion de contenu</span>
    </div>

    <nav class="sidebar-nav">
        <a href="<?php echo $basePath ?? ''; ?>home.php" class="nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Tableau de bord
        </a>

        <div class="nav-item <?php echo in_array($currentPage ?? '', ['articles-list', 'articles-add', 'articles-edit', 'articles-view']) ? 'open' : ''; ?>">
            <a href="#" class="nav-link" onclick="toggleDropdown(this.parentElement); return false;">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Articles
                <span class="arrow">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </a>
            <div class="nav-dropdown">
                <a href="<?php echo $basePath ?? ''; ?>articles/list.php" class="nav-link <?php echo ($currentPage ?? '') === 'articles-list' ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Liste
                </a>
                <a href="<?php echo $basePath ?? ''; ?>articles/add.php" class="nav-link <?php echo ($currentPage ?? '') === 'articles-add' ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Creer
                </a>
            </div>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
            </div>
            <div class="user-details">
                <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                <span>Administrateur</span>
            </div>
        </div>
        <a href="<?php echo $basePath ?? ''; ?>logout.php" class="btn-logout-sidebar">
            <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Deconnexion
        </a>
    </div>
</aside>

<script>
    function toggleDropdown(element) {
        element.classList.toggle('open');
    }
</script>
