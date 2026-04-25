<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>إنشاء حساب - نظام الديون</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>body { font-family: 'Noto Sans Arabic', sans-serif; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-xl p-10 border border-slate-100 dark:border-slate-800">
        <div class="text-center mb-10">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-600 text-white mb-6">
                <span class="material-symbols-outlined text-3xl">person_add</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">إنشاء حساب جديد</h1>
            <p class="text-slate-500 mt-2">انضم إلينا لإدارة ديونك باحترافية</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm font-bold text-center">
                البريد الإلكتروني مستخدم بالفعل، حاول بآخر.
            </div>
        <?php endif; ?>

        <form action="allcase.php" method="POST" class="space-y-6">
            <input type="hidden" name="action" value="register">
            <div>
                <label class="block text-sm font-bold mb-2">اسم المستخدم</label>
                <input name="username" required type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-teal-600 outline-none" placeholder="مثال: أحمد">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">البريد الإلكتروني</label>
                <input name="email" required type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-teal-600 outline-none" placeholder="example@mail.com">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">كلمة المرور</label>
                <input name="password" required type="password" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-teal-600 outline-none" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-teal-600/20 transition-all active:scale-95">
                تأكيد التسجيل
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-slate-500 text-sm">لديك حساب بالفعل؟ <a href="login.php" class="text-teal-600 font-bold hover:underline">سجل دخولك هنا</a></p>
        </div>
    </div>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</body>
</html>
