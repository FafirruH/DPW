<footer class="text-center py-3 border-top bg-white mt-auto">
        <div class="container">
            <p class="mb-0 text-secondary">&copy; 2026 SIMPUS &mdash; Jobsheet 8</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/DPW/assets/js/app.js"></script>
    <?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
    <script src="<?php echo $src; ?>"></script>
    <?php endforeach;
    endif; ?>
</body>
</html>