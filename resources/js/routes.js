import Vue from "vue";
import VueRouter from "vue-router";
import Main from "./pages/Main.vue";
import Dashboard from "./pages/Dashboard.vue";
import Tasks from "./pages/Tasks.vue";
import Staff from "./pages/Staff.vue";
import Report from "./pages/Report.vue";
import Calendar from "./pages/Calendar.vue";
import Settings from "./pages/Settings.vue";
import Warehouse from "./pages/Warehouse.vue";
import AddStaff from "./pages/AddStaff.vue";
import AddTask from "./pages/AddTask.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: Main,
        children: [
            {
                path: "dashboard",
                component: Dashboard
            },
            {
                path: "tasks",
                component: Tasks
            },
            {
                path: "calendar",
                component: Calendar
            },
            {
                path: "settings",
                component: Settings
            },
            {
                path: 'warehouse',
                component: Warehouse
            },
            {
                path: 'staff',
                component: Staff,     
            },
            {
                path: 'report',
                component: Report
            },
            {
                path: 'staff/add',
                component: AddStaff
            },
            {
                path: 'tasks/add',
                component: AddTask
            }
        ]
    }
];

const router = new VueRouter({
    mode: "history",
    routes: routes
});

export default router;
