import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Register from './Pages/Register.vue';
import Login from './Pages/Login.vue';
import Products from './pages/Products.vue';
import ImportProduct from './pages/ImportProduct.vue';
import ImportStock from './pages/ImportStock.vue';

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [

        {
            name: 'register',
            path: '/register',
            component: Register
        },
        {
            name: 'login',
            path: '/',
            component: Login
        },
        {
            name: 'products',
            path: '/products',
            component: Products
        },
        {
            name: 'import_product',
            path: '/import_product',
            component: ImportProduct
        },
        {
            name: 'import_stock',
            path: '/import_stock',
            component: ImportStock
        },
    ]
});

export default router;