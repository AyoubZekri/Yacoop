<?php
include "allcase.php";
include "layout/header.php";

// Calculate stats
$total_debts_count = count($debts);
$total_amount = 0;
$paid_amount = 0;
$unpaid_amount = 0;
$recent_debts = array_slice($debts, 0, 5);

foreach($debts as $d) {
    $total_amount += $d['amount'];
    if($d['payment_status'] == 'paid') {
        $paid_amount += $d['amount'];
    } else {
        $unpaid_amount += $d['amount'];
    }
}
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">لوحة التحكم</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400">نظرة عامة على الحالة المالية والديون المسجلة.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <p class="text-sm font-medium text-slate-500">إجمالي المبالغ</p>
            <h3 class="text-2xl font-bold mt-1"><?= number_format($total_amount, 2) ?> د.ج</h3>
            <p class="text-xs text-slate-400 mt-2">من أصل <?= $total_debts_count ?> عملية</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <p class="text-sm font-medium text-slate-500">تم تحصيلها</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1"><?= number_format($paid_amount, 2) ?> د.ج</h3>
            <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-500 h-full" style="width: <?= $total_amount > 0 ? ($paid_amount/$total_amount)*100 : 0 ?>%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">pending_actions</span>
            </div>
            <p class="text-sm font-medium text-slate-500">ديون متبقية</p>
            <h3 class="text-2xl font-bold text-rose-600 mt-1"><?= number_format($unpaid_amount, 2) ?> د.ج</h3>
            <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-rose-500 h-full" style="width: <?= $total_amount > 0 ? ($unpaid_amount/$total_amount)*100 : 0 ?>%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-center items-center text-center">
            <a href="add_debt.php" class="group flex flex-col items-center">
                <div class="p-4 bg-primary text-white rounded-full mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined">add</span>
                </div>
                <span class="font-bold text-primary">إضافة عملية جديدة</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
        <!-- Recent Debts -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="text-xl font-bold">آخر العمليات</h3>
                <a href="list_debts.php" class="text-sm text-primary font-bold hover:underline">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الزبون</th>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">المبلغ</th>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الحالة</th>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php foreach($recent_debts as $debt): ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-bold"><?= htmlspecialchars($debt['customer_name']) ?></span>
                            </td>
                            <td class="px-8 py-5 font-bold"><?= number_format($debt['amount'], 2) ?> د.ج</td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center gap-1 <?= $debt['payment_status'] == 'paid' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' ?> px-3 py-1 rounded-full text-xs font-bold">
                                    <?= $debt['payment_status'] == 'paid' ? 'مدفوع' : 'غير مدفوع' ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-400"><?= $debt['debt_date'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($recent_debts)): ?>
                            <tr><td colspan="4" class="px-8 py-10 text-center text-slate-400">لا توجد عمليات مؤخراً</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>