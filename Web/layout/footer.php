<?php
// layout/footer.php
?>
        <footer class="mt-auto border-t border-slate-200 dark:border-slate-800 py-8 px-6 lg:px-20 bg-white dark:bg-slate-900/50">
            <div class="mx-auto max-w-7xl flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm">verified</span>
                    </div>
                    <p class="text-sm text-slate-500">© <?= date('Y') ?> نظام إدارة الديون الذكي. جميع الحقوق محفوظة.</p>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-slate-400 hover:text-primary transition-colors">عن النظام</a>
                    <a href="#" class="text-sm text-slate-400 hover:text-primary transition-colors">الدعم الفني</a>
                    <a href="#" class="text-sm text-slate-400 hover:text-primary transition-colors">سياسة الخصوصية</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
