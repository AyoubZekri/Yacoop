<?php
include "allcase.php";
include "layout/header.php";

$debt_id = (int)$_GET['id'];
$debt_to_edit = null;
foreach($debts as $d) {
    if($d['id'] == $debt_id) {
        $debt_to_edit = $d;
        break;
    }
}

if(!$debt_to_edit) {
    header("Location: list_debts.php");
    exit();
}
?>

<main class="mx-auto w-full max-w-3xl flex-1 p-6 lg:p-10">
    <nav class="flex mb-8 text-sm text-slate-500 gap-2 items-center">
        <a href="index.php" class="hover:text-primary">الرئيسية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <a href="list_debts.php" class="hover:text-primary">قائمة الديون</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <span class="text-slate-900 dark:text-white font-medium">تعديل سجل</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 shadow-xl">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">تعديل بيانات الدين</h2>
            <p class="text-slate-500 mt-2">تعديل السجل الخاص بـ: <span class="text-primary font-bold"><?= htmlspecialchars($debt_to_edit['customer_name']) ?></span></p>
        </div>

        <form action="allcase.php" method="POST" class="space-y-6">
            <input type="hidden" name="debt_id" value="<?= $debt_to_edit['id'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">اسم الزبون الكامل</label>
                    <input name="customer_name" required type="text" value="<?= htmlspecialchars($debt_to_edit['customer_name']) ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary outline-none" />
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">المبلغ (د.ج)</label>
                    <input name="amount" required type="number" step="0.01" value="<?= $debt_to_edit['amount'] ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary outline-none" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">التاريخ</label>
                    <input name="debt_date" required type="date" value="<?= $debt_to_edit['debt_date'] ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary outline-none" />
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">حالة الدفع</label>
                    <select name="payment_status" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary outline-none">
                        <option value="unpaid" <?= $debt_to_edit['payment_status'] == 'unpaid' ? 'selected' : '' ?>>غير مدفوع</option>
                        <option value="paid" <?= $debt_to_edit['payment_status'] == 'paid' ? 'selected' : '' ?>>مدفوع</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-2">
                    تحديث البيانات
                </button>
                <a href="list_debts.php" class="px-8 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl hover:bg-slate-200 transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</main>

<?php include "layout/footer.php"; ?>
