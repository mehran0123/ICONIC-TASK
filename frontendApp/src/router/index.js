import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import Comments from '../views/Comments.vue';
import AddFeedback from '../views/AddFeedback.vue';

const isAuthenticated = () => {
    // Check if the token exists in localStorage to determine if the user is authenticated
    return !!localStorage.getItem('token');
};

const routes = [{
        path: '/',
        name: 'login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true } // Add requiresAuth meta field
    },
    {
        path: '/add-feedback',
        name: 'add-feedback',
        component: AddFeedback,
        meta: { requiresAuth: true } // Add requiresAuth meta field
    },
    {
        path: '/comment/:id/add',
        name: 'add-comment',
        component: Comments,
        meta: { requiresAuth: true } // Add requiresAuth meta field
    }
];

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes
});

// Add a global beforeEach guard
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // Check if the route requires authentication
        if (!isAuthenticated()) {
            // If not authenticated, redirect to login page
            next({ name: 'login' });
        } else {
            // If authenticated, proceed to the route
            next();
        }
    } else {
        // If the route does not require authentication, proceed to the route
        next();
    }
});

export default router;