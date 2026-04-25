<?php
// layout/header.php
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>نظام إدارة الديون الذكي</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0d9488",
                        "secondary": "#f43f5e",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        "sans": ["Noto Sans Arabic", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Noto Sans Arabic', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .dark .glass { background: rgba(15, 23, 42, 0.7); }
        .nav-link { @apply flex items-center gap-2 px-4 py-2 rounded-xl transition-all; }
        .nav-link-active { @apply bg-primary text-white shadow-lg shadow-primary/25; }
        .nav-link-inactive { @apply text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Navigation -->
        <header class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 glass px-6 py-4 lg:px-20">
            <div class="mx-auto flex max-w-7xl items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="index.php" class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-indigo-600 text-white shadow-lg">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <h1 class="text-xl font-bold tracking-tight hidden sm:block">إدارة الديون</h1>
                    </a>
                    
                    <nav class="hidden md:flex items-center gap-2">
                        <a href="index.php" class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100' ?>">
                            <span class="material-symbols-outlined text-sm">dashboard</span>
                            الرئيسية
                        </a>
                        <a href="list_debts.php" class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) == 'list_debts.php' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100' ?>">
                            <span class="material-symbols-outlined text-sm">list_alt</span>
                            قائمة الديون
                        </a>
                        <a href="add_debt.php" class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) == 'add_debt.php' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100' ?>">
                            <span class="material-symbols-outlined text-sm">add_circle</span>
                            إضافة دين
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <button id="theme-toggle" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-slate-600 dark:text-slate-300" id="theme-toggle-icon">dark_mode</span>
                    </button>
                    <a href="profile.php" class="h-10 w-10 overflow-hidden rounded-full ring-2 ring-primary/20 hover:ring-primary transition-all">
                        <img alt="Profile" class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name=<?= $_SESSION['username'] ?>&background=0d9488&color=fff"/>
                    </a>
                </div>
            </div>
        </header>

        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                themeToggleIcon.textContent = 'light_mode';
            }
            themeToggleBtn.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    themeToggleIcon.textContent = 'dark_mode';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggleIcon.textContent = 'light_mode';
                }
            });
        </script>
