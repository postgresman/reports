
import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '/resources/js/Partials/Login.vue'; // Your login component
import DashboardView from '/resources/js/Partials/Dashboard.vue'; // Your dashboard component

const routes = [
    { 
        name: 'Login', 
        component: LoginView 
    },{ 
        name: 'Dashboard', 
        component: DashboardView, 
        meta: { requiresAuth: true } 
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
