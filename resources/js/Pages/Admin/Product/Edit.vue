<template>
    <div>
        <h1 class="p-2">Creating product</h1>
        <form @submit.prevent="updateProduct()">
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    v-model="product.name"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Description</label>
                <textarea
                    type="text"
                    v-model="product.description"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Price</label>
                <input
                    type="number"
                    v-model="product.price"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Discount price</label>
                <input
                    type="number"
                    v-model="product.discount_price"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Quantity</label>
                <input
                    type="number"
                    v-model="product.quantity"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="1" required
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Weight</label>
                <input
                    type="number"
                    v-model="product.weight"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-700">Material</label>
                <input
                    type="text"
                    v-model="product.material"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="mb-4 text-sm font-medium text-gray-700">Is active</label>
                <input
                    type="checkbox"
                    v-model="product.is_active"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="p-2 flex flex-col space-y-2">
                <label class="mb-4 text-sm font-medium text-gray-700">Category</label>
                <select v-model="product.category_id"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option disabled selected>Select a category</option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
            </div>
            <h2 class="p-2">Params</h2>
            <div style="margin: 0.5rem !important;"
                 class="p-2  border rounded-md border-gray-400" id="param-block">
                <div v-for="(param,index) in product.parameters">
                <div class="flex flex-col space-y-2">
                    <label class="mb-2 mt-2 text-sm font-medium text-gray-700">Color</label>
                    <select v-model="param.color_id"
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" disabled selected>Select a color</option>
                        <option v-for="color in colors" :value="color.id">{{ color.name }}</option>
                    </select>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="mb-2 mt-2 text-sm font-medium text-gray-700">Width</label>
                    <input
                        type="number"
                        v-model="param.width"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"

                    >
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="mb-2 mt-2 text-sm font-medium text-gray-700">Height</label>
                    <input
                        type="number"
                        v-model="param.height"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"

                    >
                </div>
                <div class="flex flex-col space-y-2 h-auto">
                    <label class="mb-2 mt-2 text-sm font-medium text-gray-700">Images</label>
                    <input
                        type="file"
                        multiple
                        @change="handleFileUpload($event,index)"
                        accept="image/*"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                    <div v-if="param.images && param.images.length > 0"
                         class="grid grid-cols-3 gap-4 mt-4">
                        <div
                            v-for="(image, imgIndex) in param.images"
                            :key="image.id || imgIndex"
                            class="relative group"
                        >
                            <img
                                :src="image.path"
                                :alt="image.name"
                                class="w-full h-24 object-cover rounded-lg border"
                            >
                            <button
                                @click="removeImage(index, imgIndex)"
                                type="button"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                &times;
                            </button>
                            <p class="text-xs text-gray-600 truncate mt-1">{{ image.name }}</p>
                        </div>
                    </div>
                </div>
                </div>
                <div class="flex gap-4">
                <div class="mt-4 mb-4">
                    <a @click="addParam()"
                       class=" px-4 py-2 text-sm font-medium text-white bg-green-400 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Add new param
                    </a>
                </div>
                <div class="mt-4 mb-4" v-if="product.parameters.length > 1">
                    <a @click="product.parameters.pop()"
                       class=" px-4 py-2 text-sm font-medium text-white bg-red-400 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete last param
                    </a>
                </div>
                </div>
            </div>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update
            </button>
        </form>
    </div>
</template>

<script>
import AuthenticatedAdminLayout from '@/Layouts/AuthenticatedAdminLayout.vue';

export default {
    layout: AuthenticatedAdminLayout,
    name: 'Index',
    props: {
        categories: Array,
        colors: Array,
        product: Object
    },
    data() {
        return {
            // product: {
            //     name: '',
            //     description: '',
            //     short_description: '',
            //     price: '',
            //     discount_price: '',
            //     quantity: '',
            //     weight: '',
            //     material: '',
            //     is_active: false,
            //     is_featured: '',
            //     category_id: '',
            //     brand_id: '',
            //     parameters: [
            //         {
            //             color_id: '',
            //             width: '',
            //             height: '',
            //             images: [],
            //         }
            //     ],
            // },

            categoriesMap: {}
        }
    },
    mounted() {
        this.categories.forEach(category => {
            this.categoriesMap[category.id] = category.title;
        });
    },
    methods: {
        addParam() {
            this.product.parameters.push({
                color_id: '',
                width: '',
                height: '',
                size: '',
                images: []
            });
        },
        handleFileUpload(event,index) {
            this.createImages(event.target.files || e.dataTransfer.files,index)
        },
        createImages(files, index) {
            [...files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    this.product.parameters[index].images.push({
                        file,
                        dataUrl: e.target.result, // для превью
                        name: file.name,
                        size: file.size,
                        type: file.type,
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        removeImage(index,indexImg) {
            if (this.product.parameters[index].images[indexImg].url) {
                URL.revokeObjectURL(this.product.parameters.images[indexImg].url);
            }

            this.product.parameters[index].images.splice(indexImg, 1);
        },

        readFileAsDataURL(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        },
        updateProduct() {
            axios.patch(route('admin.products.update',this.product.id), {product: this.product}, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                alert('Product updated successfully');
            }).catch(error => {
                alert(error.message);
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
