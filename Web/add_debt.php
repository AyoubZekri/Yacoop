<?php
include "allcase.php";
include "layout/header.php";
?>

<main class="mx-auto w-full max-w-3xl flex-1 p-6 lg:p-10">
    <nav class="flex mb-8 text-sm text-slate-500 gap-2 items-center">
        <a href="index.php" class="hover:text-primary">الرئيسية</a>
        <span class="material-symbols-outlined text-xs">chevron_left</span>
        <span class="text-slate-900 dark:text-white font-medium">إضافة دين جديد</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 shadow-xl">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">تسجيل عملية دين جديدة</h2>
            <p class="text-slate-500 mt-2">يرجى ملء البيانات التالية بدقة لضمان تتبع صحيح للمستحقات.</p>
        </div>

        <form action="allcase.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">اسم الزبون الكامل</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">person</span>
                        <input name="customer_name" required type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 pr-12 pl-4 focus:ring-2 focus:ring-primary transition-all" placeholder="مثال: أحمد محمد بن علي"/>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">المبلغ المستحق (د.ج)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">payments</span>
                        <input name="amount" required type="number" step="0.01" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 pr-12 pl-4 focus:ring-2 focus:ring-primary transition-all" placeholder="0.00"/>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">تاريخ العملية</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_today</span>
                        <input name="debt_date" required type="date" value="<?= date('Y-m-d') ?>" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 pr-12 pl-4 focus:ring-2 focus:ring-primary transition-all"/>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">حالة الدفع الأولية</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center p-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input type="radio" name="payment_status" value="unpaid" checked class="hidden"/>
                            <span class="font-bold text-slate-600 dark:text-slate-400 checked:text-primary">غير مدفوع</span>
                        </label>
                        <label class="relative flex items-center justify-center p-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input type="radio" name="payment_status" value="paid" class="hidden"/>
                            <span class="font-bold text-slate-600 dark:text-slate-400 checked:text-primary">مدفوع مسبقاً</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary/25 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    حفظ البيانات
                </button>
                <a href="index.php" class="px-8 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl hover:bg-slate-200 transition-all flex items-center justify-center">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</main>

<?php include "layout/footer.php"; ?>


<!-- sudo apt update
sudo apt install git docker.io -->

<!-- kubectl apply -f k8s-distributed.yaml -->
