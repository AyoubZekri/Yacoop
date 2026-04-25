<?php
include "allcase.php";
include "layout/header.php";

// Simple filter logic
$filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$filtered_debts = $debts;
if($filter !== 'all') {
    $filtered_debts = array_filter($debts, function($d) use ($filter) {
        return $d['payment_status'] === $filter;
    });
}
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">قائمة الديون الكاملة</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">إجمالي السجلات: <?= count($filtered_debts) ?></p>
        </div>
        <a href="add_debt.php" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            إضافة سجل جديد
        </a>
    </div>

    <!-- Filters -->
    <div class="flex gap-4 mb-8 overflow-x-auto pb-2">
        <a href="?status=all" class="px-6 py-2 rounded-xl font-bold transition-all whitespace-nowrap <?= $filter == 'all' ? 'bg-primary text-white' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800' ?>">الكل</a>
        <a href="?status=unpaid" class="px-6 py-2 rounded-xl font-bold transition-all whitespace-nowrap <?= $filter == 'unpaid' ? 'bg-white dark:bg-slate-900 border border-rose-500 text-rose-500' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800' ?>">غير مدفوعة</a>
        <a href="?status=paid" class="px-6 py-2 rounded-xl font-bold transition-all whitespace-nowrap <?= $filter == 'paid' ? 'bg-white dark:bg-slate-900 border border-emerald-500 text-emerald-500' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800' ?>">مدفوعة</a>
    </div>

    <!-- Full List Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">المعرف</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الزبون</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">المبلغ</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">التاريخ</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الحالة</th>
                        <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php foreach($filtered_debts as $debt): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="px-8 py-5 text-slate-400 font-mono text-xs">#<?= $debt['id'] ?></td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-primary text-xs">
                                    <?= mb_substr($debt['customer_name'], 0, 1) ?>
                                </div>
                                <span class="font-bold"><?= htmlspecialchars($debt['customer_name']) ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-5 font-bold text-lg"><?= number_format($debt['amount'], 2) ?> د.ج</td>
                        <td class="px-8 py-5 text-sm text-slate-500"><?= $debt['debt_date'] ?></td>
                        <td class="px-8 py-5">
                            <a href="allcase.php?toggle_status=<?= $debt['id'] ?>" class="inline-flex items-center gap-1 <?= $debt['payment_status'] == 'paid' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600' ?> px-3 py-1 rounded-full text-xs font-bold cursor-pointer hover:opacity-80">
                                <span class="w-1.5 h-1.5 rounded-full <?= $debt['payment_status'] == 'paid' ? 'bg-emerald-600' : 'bg-rose-600' ?>"></span>
                                <?= $debt['payment_status'] == 'paid' ? 'مدفوع' : 'غير مدفوع' ?>
                            </a>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex gap-2">
                                <a href="edit_debt.php?id=<?= $debt['id'] ?>" class="p-2 hover:bg-teal-50 dark:hover:bg-teal-900/30 text-teal-600 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <a href="allcase.php?delete_debt=<?= $debt['id'] ?>" onclick="return confirm('هل أنت متأكد من حذف هذا السجل؟')" class="p-2 hover:bg-rose-100 text-rose-500 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($filtered_debts)): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                                <span class="material-symbols-outlined text-5xl mb-2">search_off</span>
                                <p>لم يتم العثور على سجلات تطابق الفلتر المختار</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>
