import { createRouter, createWebHistory } from 'vue-router';

import Login from '../components/Login.vue';
import DashboardLanding from '../components/DashboardLanding.vue';
import Settings from '../components/Settings.vue';

const routes = [
    { path: '/', redirect: '/login' },
    { path: '/login', component: Login },
    { path: '/dashboard', component: DashboardLanding },
    { path: '/settings', component: Settings },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
