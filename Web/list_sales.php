<?php
include "allcase.php";
include "layout/header.php";

// Fetch items for each sale if needed, but for the list we just show the summary
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">سجل المبيعات</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">تتبع جميع العمليات التي تمت عبر النظام.</p>
        </div>
        <a href="add_sale.php" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/25 hover:scale-105 transition-all flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined">add_shopping_cart</span>
            بيع جديد
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">رقم العملية</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الزبون</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">المبلغ الإجمالي</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">التاريخ</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php foreach($sales as $sale): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="px-8 py-5">
                            <span class="font-mono text-slate-400">#<?= str_pad($sale['id'], 5, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="font-bold"><?= htmlspecialchars($sale['customer_name'] ?: 'زبون عابر') ?></span>
                        </td>
                        <td class="px-8 py-5 font-bold text-primary"><?= number_format($sale['total_amount'], 2) ?> د.ج</td>
                        <td class="px-8 py-5 text-sm text-slate-500"><?= $sale['sale_date'] ?></td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="alert('ميزة عرض التفاصيل ستتوفر قريباً')" class="p-2 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <a href="#" class="p-2 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                                    <span class="material-symbols-outlined">print</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($sales)): ?>
                        <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400">لا توجد مبيعات مسجلة بعد</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>
