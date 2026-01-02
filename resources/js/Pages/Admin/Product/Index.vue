<template>

                    <!-- Заголовок с кнопкой добавления -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Products</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Total: {{ productsData.length }} products
                            </p>
                        </div>
                        <a
                            :href="route('admin.products.create')"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Add New Product
                        </a>
                    </div>

                    <!-- Таблица -->
                    <div class="overflow-hidden border border-gray-200 rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="(product, index) in productsData"
                                :key="product.id"
                                :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                                class="hover:bg-gray-100 transition-colors duration-150"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ product.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">
                                            ${{ formatPrice(product.price) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="[
                                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                                product.quantity > 10 ? 'bg-green-100 text-green-800' :
                                                product.quantity > 0 ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-red-100 text-red-800'
                                            ]"
                                        >
                                            {{ product.quantity }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="[
                                                'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                                product.is_active
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            ]"
                                        >
                                            <span
                                                :class="[
                                                    'w-2 h-2 mr-2 rounded-full',
                                                    product.is_active ? 'bg-green-500' : 'bg-red-500'
                                                ]"
                                            ></span>
                                            {{ product.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                                            {{ getCategoryName(product.category_id) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a
                                            :href="route('admin.products.edit', product.id)"
                                            class="px-3 py-1 text-blue-600 transition-colors duration-150 bg-transparent border border-blue-600 rounded hover:bg-blue-600 hover:text-white"
                                        >
                                            Edit
                                        </a>
                                        <button
                                            @click.prevent="confirmDelete(product)"
                                            class="px-3 py-1 text-red-600 transition-colors duration-150 bg-transparent border border-red-600 rounded hover:bg-red-600 hover:text-white"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- ПАГИНАЦИЯ - исправленная версия -->
                        <div v-if="pagination && pagination.links && pagination.last_page > 1"
                             class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button
                                    @click="goToPage(pagination.current_page - 1)"
                                    :disabled="pagination.current_page === 1"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                                >
                                    Previous
                                </button>
                                <button
                                    @click="goToPage(pagination.current_page + 1)"
                                    :disabled="pagination.current_page === pagination.last_page"
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                                >
                                    Next
                                </button>
                            </div>

                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ pagination.from || 1 }}</span>
                                        to
                                        <span class="font-medium">{{ pagination.to || productsData.length }}</span>
                                        of
                                        <span class="font-medium">{{ pagination.total || productsData.length }}</span>
                                        results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                        <!-- Номера страниц - с проверкой на существование link -->
                                        <template v-for="(link, index) in pagination.links" :key="index">
                                            <button
                                                v-if="link && link.label && !['&laquo; Previous', 'Next &raquo;', '...'].includes(link.label)"
                                                @click="goToLink(link)"
                                                :class="[
                            'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                            link.active
                                ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                        ]"
                                                :disabled="!link.url || link.active"
                                                v-html="link.label"
                                            ></button>
                                            <span
                                                v-else-if="link && link.label === '...'"
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                                            >
                        ...
                    </span>
                                        </template>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- Empty state -->
                        <div
                            v-if="productsData.length === 0"
                            class="px-6 py-12 text-center"
                        >
                            <div class="mx-auto w-16 h-16 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Get started by creating a new product.
                            </p>
                        </div>
                    </div>

                    <!-- Пагинация (если нужно) -->
                    <!-- <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                        Пагинация здесь
                    </div> -->

    <!-- Модальное окно подтверждения удаления -->
    <div
        v-if="deleteModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    Confirm Deletion
                </h3>
                <button
                    @click="deleteModalOpen = false"
                    class="text-gray-400 hover:text-gray-500"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="mb-6 text-gray-600">
                Are you sure you want to delete "<strong>{{ productToDelete?.name }}</strong>"? This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-3">
                <button
                    @click="deleteModalOpen = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Cancel
                </button>
                <button
                    @click="deleteProductConfirmed"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import AuthenticatedAdminLayout from '@/Layouts/AuthenticatedAdminLayout.vue';

export default {
    layout: AuthenticatedAdminLayout,
    name: 'Index',
    props: {
        products: Array, // Оставляем как Array - это будет products.data
        categories: Array,
        pagination: Object, // Добавляем новый prop для пагинации
    },
    data() {
        return {
            productsData: this.products, // Массив товаров как и раньше
            categoriesMap: {},
            deleteModalOpen: false,
            productToDelete: null
        }
    },
    mounted() {
        console.log('Products data:', this.productsData);
        console.log('Pagination data:', this.pagination);

        // Создаем карту категорий для быстрого поиска
        this.categories.forEach(category => {
            this.categoriesMap[category.id] = category.title;
        });
    },
    methods: {
        // Метод для перехода по ссылке пагинации
        goToLink(link) {
            if (!link.url || link.active) return;

            const urlObj = new URL(link.url);
            const page = urlObj.searchParams.get('page');

            if (page) {
                this.goToPage(parseInt(page));
            }
        },

        // Метод для перехода на конкретную страницу
        goToPage(page) {
            if (page < 1 || page > this.pagination.last_page) return;

            // Используем Inertia для навигации
            this.$inertia.get(route('admin.products.index', {
                page: page,
                per_page: this.pagination.per_page
            }), {
                preserveScroll: true,
                preserveState: true
            });
        },

        confirmDelete(product) {
            this.productToDelete = product;
            this.deleteModalOpen = true;
        },

        deleteProductConfirmed() {
            if (!this.productToDelete) return;

            axios.delete(route('admin.products.destroy', this.productToDelete.id))
                .then(res => {
                    // Удаляем товар из списка
                    this.productsData = this.productsData.filter(p => p.id !== this.productToDelete.id);

                    // Обновляем счетчики пагинации
                    if (this.pagination) {
                        this.pagination.total -= 1;
                        this.pagination.to -= 1;
                    }

                    this.deleteModalOpen = false;
                    this.productToDelete = null;

                    this.$toast.success('Product deleted successfully!');
                })
                .catch(error => {
                    console.error('Error deleting product:', error);
                    this.$toast.error('Failed to delete product');
                });
        },

        formatPrice(price) {
            return parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        },

        getCategoryName(categoryId) {
            return this.categoriesMap[categoryId] || 'Uncategorized';
        }
    }
}
</script>
<style scoped>
/* Дополнительные стили если нужно */
table {
    border-collapse: collapse;
}

/* Стили для скролла на мобильных */
@media (max-width: 768px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
    }
}

/* Плавные анимации */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
