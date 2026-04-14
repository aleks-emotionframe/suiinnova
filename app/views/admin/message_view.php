<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Nachricht</h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/messages" class="btn btn-sm btn-outline">&larr; Zurück</a>
</div>

<div class="form-card">
    <div class="message-detail">
        <div class="message-meta-grid">
            <div class="message-meta-item">
                <span class="message-meta-label">Name</span>
                <span class="message-meta-value"><?= e($msg['name']) ?></span>
            </div>
            <div class="message-meta-item">
                <span class="message-meta-label">E-Mail</span>
                <span class="message-meta-value"><a href="mailto:<?= e($msg['email']) ?>"><?= e($msg['email']) ?></a></span>
            </div>
            <?php if (!empty($msg['phone'])): ?>
            <div class="message-meta-item">
                <span class="message-meta-label">Telefon</span>
                <span class="message-meta-value"><a href="tel:<?= e($msg['phone']) ?>"><?= e($msg['phone']) ?></a></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($msg['company'])): ?>
            <div class="message-meta-item">
                <span class="message-meta-label">Firma</span>
                <span class="message-meta-value"><?= e($msg['company']) ?></span>
            </div>
            <?php endif; ?>
            <div class="message-meta-item">
                <span class="message-meta-label">Datum</span>
                <span class="message-meta-value"><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></span>
            </div>
        </div>

        <?php if (!empty($msg['subject'])): ?>
        <h2 class="message-subject"><?= e($msg['subject']) ?></h2>
        <?php endif; ?>

        <div class="message-body">
            <?= nl2br(e($msg['message'])) ?>
        </div>
    </div>
</div>

<div class="form-actions" style="margin-top: 1.5rem;">
    <a href="mailto:<?= e($msg['email']) ?>?subject=Re: <?= e($msg['subject'] ?? 'Ihre Anfrage') ?>" class="btn btn-primary">Antworten per E-Mail</a>
    <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/messages/<?= $msg['id'] ?>/delete" class="inline-form" onsubmit="return confirm('Nachricht wirklich löschen?')">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
        <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
    </form>
</div>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
