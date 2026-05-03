<?php
include "allcase.php";
include "layout/header.php";

$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    foreach ($products as $p) {
        if ($p['id'] == $edit_id) {
            $edit_product = $p;
            break;
        }
    }
}
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">إدارة المنتجات</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">إضافة، تعديل، وحذف المنتجات في المخزون.</p>
        </div>
        <button onclick="document.getElementById('product-form').scrollIntoView({behavior: 'smooth'})" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/25 hover:scale-105 transition-all flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined">add</span>
            منتج جديد
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Products List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-4 font-bold text-sm text-slate-500 uppercase">المنتج</th>
                                <th class="px-6 py-4 font-bold text-sm text-slate-500 uppercase">السعر</th>
                                <th class="px-6 py-4 font-bold text-sm text-slate-500 uppercase">المخزون</th>
                                <th class="px-6 py-4 font-bold text-sm text-slate-500 uppercase text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php foreach($products as $product): ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold"><?= htmlspecialchars($product['name']) ?></span>
                                        <span class="text-xs text-slate-400"><?= htmlspecialchars($product['description']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-bold text-primary"><?= number_format($product['price'], 2) ?> د.ج</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1 <?= $product['stock'] > 10 ? 'bg-emerald-100 text-emerald-600' : ($product['stock'] > 0 ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600') ?> px-3 py-1 rounded-full text-xs font-bold">
                                        <?= $product['stock'] ?> قطعة
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="?edit=<?= $product['id'] ?>" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <a href="allcase.php?delete_product=<?= $product['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">
                                            <span class="material-symbols-outlined">delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($products)): ?>
                                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">لا توجد منتجات مسجلة</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add/Edit Form -->
        <div id="product-form" class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm sticky top-24">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary"><?= $edit_product ? 'edit_square' : 'add_circle' ?></span>
                    <?= $edit_product ? 'تعديل منتج' : 'إضافة منتج جديد' ?>
                </h3>
                <form action="allcase.php" method="POST" class="space-y-5">
                    <input type="hidden" name="action" value="add_product">
                    <?php if($edit_product): ?>
                        <input type="hidden" name="product_id" value="<?= $edit_product['id'] ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">اسم المنتج</label>
                        <input type="text" name="name" required value="<?= $edit_product ? htmlspecialchars($edit_product['name']) : '' ?>" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all" placeholder="مثال: آيفون 15">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">الوصف</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all" placeholder="وصف مختصر للمنتج..."><?= $edit_product ? htmlspecialchars($edit_product['description']) : '' ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">السعر</label>
                            <input type="number" step="0.01" name="price" required value="<?= $edit_product ? $edit_product['price'] : '' ?>" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">الكمية</label>
                            <input type="number" name="stock" required value="<?= $edit_product ? $edit_product['stock'] : '' ?>" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all" placeholder="0">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-primary/25 hover:opacity-90 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined"><?= $edit_product ? 'save' : 'add_circle' ?></span>
                        <?= $edit_product ? 'حفظ التعديلات' : 'إضافة المنتج' ?>
                    </button>
                    
                    <?php if($edit_product): ?>
                        <a href="products.php" class="block text-center text-sm text-slate-500 hover:underline">إلغاء التعديل</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "layout/footer.php"; ?>
