<?php
include "allcase.php";
include "layout/header.php";

// Stats for profile
$total_amount = 0;
foreach($debts as $d) { $total_amount += $d['amount']; }
?>

<main class="mx-auto w-full max-w-4xl flex-1 p-6 lg:p-10">
    <div class="mb-10 flex items-center gap-6">
        <div class="h-24 w-24 rounded-3xl bg-primary/10 flex items-center justify-center border-2 border-primary/20">
            <img alt="Profile" class="h-20 w-20 rounded-2xl object-cover" src="https://ui-avatars.com/api/?name=<?= $_SESSION['username'] ?>&background=0d9488&color=fff&size=128"/>
        </div>
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">حساب <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <p class="text-slate-500">مدير نظام إدارة الديون</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Account Info -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person_outline</span>
                    المعلومات الشخصية
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-slate-50 dark:border-slate-800">
                        <span class="text-slate-500">الاسم</span>
                        <span class="font-bold"><?= htmlspecialchars($_SESSION['username']) ?></span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-50 dark:border-slate-800">
                        <span class="text-slate-500">نوع الحساب</span>
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold">مستخدم نشط</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">settings</span>
                    إعدادات النظام
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-400">notifications</span>
                            <span class="font-medium">التنبيهات البريدية</span>
                        </div>
                        <div class="h-6 w-11 bg-primary rounded-full relative">
                            <div class="h-5 w-5 bg-white rounded-full absolute right-0.5 top-0.5 shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-primary to-teal-700 text-white p-8 rounded-3xl shadow-xl shadow-primary/20">
                <h4 class="text-lg font-bold opacity-90">ديونك الخاصة</h4>
                <div class="text-3xl font-black mt-2"><?= number_format($total_amount, 2) ?> د.ج</div>
                <p class="text-sm mt-4 opacity-80 italic">إجمالي المستحقات المسجلة باسمك</p>
            </div>
            
            <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm text-center">
                <div class="h-16 w-16 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl">logout</span>
                </div>
                <h4 class="font-bold">تسجيل الخروج</h4>
                <p class="text-sm text-slate-500 mt-1">إنهاء الجلسة الحالية</p>
                <a href="allcase.php?action=logout" class="block w-full mt-6 bg-slate-100 dark:bg-slate-800 hover:bg-rose-500 hover:text-white text-slate-600 dark:text-slate-300 font-bold py-3 rounded-xl transition-all text-center">
                    خروج آمن
                </a>
            </div>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>
