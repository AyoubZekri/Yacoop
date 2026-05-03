<?php
include "allcase.php";
include "layout/header.php";

// Calculate sales stats
$total_sales_count = count($sales);
$total_revenue = 0;
$today_sales = 0;
$total_products = count($products);
$recent_sales = array_slice($sales, 0, 5);
$today = date('Y-m-d');

foreach($sales as $s) {
    $total_revenue += $s['total_amount'];
    if($s['sale_date'] == $today) {
        $today_sales += $s['total_amount'];
    }
}
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">لوحة التحكم</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400">نظرة عامة على أداء المبيعات وحالة المخزون.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <p class="text-sm font-medium text-slate-500">إجمالي الإيرادات</p>
            <h3 class="text-2xl font-bold mt-1"><?= number_format($total_revenue, 2) ?> د.ج</h3>
            <p class="text-xs text-slate-400 mt-2">من أصل <?= $total_sales_count ?> عملية بيع</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">today</span>
            </div>
            <p class="text-sm font-medium text-slate-500">مبيعات اليوم</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1"><?= number_format($today_sales, 2) ?> د.ج</h3>
            <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-500 h-full" style="width: <?= $total_revenue > 0 ? ($today_sales/$total_revenue)*100 : 0 ?>%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl w-fit mb-4">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <p class="text-sm font-medium text-slate-500">إجمالي المنتجات</p>
            <h3 class="text-2xl font-bold text-amber-600 mt-1"><?= $total_products ?> منتج</h3>
            <p class="text-xs text-slate-400 mt-2">متوفرة في المخزون</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-center items-center text-center">
            <a href="add_sale.php" class="group flex flex-col items-center">
                <div class="p-4 bg-primary text-white rounded-full mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined">add_shopping_cart</span>
                </div>
                <span class="font-bold text-primary">عملية بيع جديدة</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
        <!-- Recent Sales -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="text-xl font-bold">آخر المبيعات</h3>
                <a href="list_sales.php" class="text-sm text-primary font-bold hover:underline">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">الزبون</th>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">المبلغ</th>
                            <th class="px-8 py-4 font-bold text-sm text-slate-500 uppercase">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php foreach($recent_sales as $sale): ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-bold"><?= htmlspecialchars($sale['customer_name'] ?: 'زبون عابر') ?></span>
                            </td>
                            <td class="px-8 py-5 font-bold"><?= number_format($sale['total_amount'], 2) ?> د.ج</td>
                            <td class="px-8 py-5 text-sm text-slate-400"><?= $sale['sale_date'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($recent_sales)): ?>
                            <tr><td colspan="3" class="px-8 py-10 text-center text-slate-400">لا توجد عمليات بيع مؤخراً</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>