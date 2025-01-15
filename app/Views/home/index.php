<?php require_once VIEWS_PATH . '/layouts/header.php'; ?>

<?php if ($promotions['new_year']['active']): ?>
    <?php include VIEWS_PATH . '/partials/promotional-modal.php'; ?>
<?php endif; ?>

<div class="container-fluid py-5" style="margin-top: 2rem;">
    <div class="row g-0">
        <!-- Left Column - News & Notices -->
        <?php include VIEWS_PATH . '/partials/news-sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-lg-8">
            <?php include VIEWS_PATH . '/partials/pricing-sections.php'; ?>
            <?php include VIEWS_PATH . '/partials/products-section.php'; ?>
        </div>

        <!-- Right Column - Events -->
        <?php include VIEWS_PATH . '/partials/events-sidebar.php'; ?>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>
