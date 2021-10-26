import AllEntries from './Pages/Favorites/AllEntries.vue';
import Search from './Pages/search.vue';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllEntries
    },
    {
        name: 'search',
        path: '/',
        component: Search
    },
];
