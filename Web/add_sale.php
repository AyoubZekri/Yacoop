<?php
include "allcase.php";
include "layout/header.php";
?>

<main class="mx-auto w-full max-w-7xl flex-1 p-6 lg:p-10 lg:px-20">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">عملية بيع جديدة</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400">سجل عملية بيع جديدة وخصم الكميات من المخزون.</p>
    </div>

    <form action="allcase.php" method="POST" id="sale-form">
        <input type="hidden" name="action" value="add_sale">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Side: Product Selection -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">shopping_basket</span>
                        اختيار المنتجات
                    </h3>
                    
                    <div class="space-y-4" id="selected-products">
                        <!-- Dynamic items will be added here -->
                        <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 justify-center text-slate-400" id="empty-msg">
                            لم يتم اختيار أي منتج بعد
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-4">أضف منتجاً</label>
                        <select id="product-selector" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all">
                            <option value="">اختر من القائمة...</option>
                            <?php foreach($products as $p): ?>
                                <option value="<?= $p['id'] ?>" data-name="<?= htmlspecialchars($p['name']) ?>" data-price="<?= $p['price'] ?>" data-stock="<?= $p['stock'] ?>">
                                    <?= htmlspecialchars($p['name']) ?> (<?= $p['price'] ?> د.ج) - المتاح: <?= $p['stock'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Right Side: Summary & Customer Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm sticky top-24">
                    <h3 class="text-xl font-bold mb-6">تفاصيل العملية</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">اسم الزبون</label>
                            <input type="text" name="customer_name" class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all" placeholder="اختياري">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تاريخ البيع</label>
                            <input type="date" name="sale_date" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-3 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:ring-primary focus:border-primary transition-all">
                        </div>

                        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex justify-between items-center mb-4">
                                <span class="font-bold text-slate-500">الإجمالي:</span>
                                <span class="text-2xl font-black text-primary" id="total-display">0.00 د.ج</span>
                                <input type="hidden" name="total_amount" id="total-input" value="0">
                            </div>
                            
                            <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-primary/25 hover:opacity-90 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">point_of_sale</span>
                                إتمام البيع
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<script>
const selector = document.getElementById('product-selector');
const container = document.getElementById('selected-products');
const emptyMsg = document.getElementById('empty-msg');
const totalDisplay = document.getElementById('total-display');
const totalInput = document.getElementById('total-input');

let cart = [];

selector.addEventListener('change', (e) => {
    const id = e.target.value;
    if(!id) return;
    
    const option = e.target.options[e.target.selectedIndex];
    const name = option.dataset.name;
    const price = parseFloat(option.dataset.price);
    const stock = parseInt(option.dataset.stock);

    if(cart.find(item => item.id == id)) {
        alert('المنتج موجود بالفعل في القائمة');
        selector.value = '';
        return;
    }

    cart.push({id, name, price, stock, qty: 1});
    renderCart();
    selector.value = '';
});

function updateQty(id, delta) {
    const item = cart.find(i => i.id == id);
    if(item) {
        const newQty = item.qty + delta;
        if(newQty > 0 && newQty <= item.stock) {
            item.qty = newQty;
            renderCart();
        } else if (newQty > item.stock) {
            alert('الكمية المطلوبة تتجاوز المتاح في المخزون');
        }
    }
}

function removeItem(id) {
    cart = cart.filter(i => i.id != id);
    renderCart();
}

function renderCart() {
    if(cart.length === 0) {
        container.innerHTML = `<div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 justify-center text-slate-400" id="empty-msg">لم يتم اختيار أي منتج بعد</div>`;
        totalDisplay.textContent = '0.00 د.ج';
        totalInput.value = 0;
        return;
    }

    let total = 0;
    container.innerHTML = cart.map((item, index) => {
        total += item.price * item.qty;
        return `
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm animate-in fade-in slide-in-from-bottom-2">
                <div class="flex flex-col">
                    <span class="font-bold text-lg">${item.name}</span>
                    <span class="text-sm text-slate-400">${item.price.toFixed(2)} د.ج للقطعة</span>
                    <input type="hidden" name="products[${index}][id]" value="${item.id}">
                    <input type="hidden" name="products[${index}][qty]" value="${item.qty}">
                    <input type="hidden" name="products[${index}][price]" value="${item.price}">
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center bg-slate-100 dark:bg-slate-900 rounded-xl p-1">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-8 h-8 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all">-</button>
                        <span class="w-12 text-center font-bold">${item.qty}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-8 h-8 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all">+</button>
                    </div>
                    <span class="font-bold text-primary min-w-[80px] text-left">${(item.price * item.qty).toFixed(2)} د.ج</span>
                    <button type="button" onclick="removeItem(${item.id})" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
        `;
    }).join('');

    totalDisplay.textContent = total.toFixed(2) + ' د.ج';
    totalInput.value = total.toFixed(2);
}
</script>

<?php include "layout/footer.php"; ?>
