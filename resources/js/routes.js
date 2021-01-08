import Vue from "vue";
import VueRouter from "vue-router";
import Main from "./pages/Main.vue";
import Dashboard from "./pages/Dashboard.vue";
import Tasks from "./pages/Tasks.vue";
import Staff from "./pages/Staff.vue";
import Report from "./pages/Report.vue";
import Calendar from "./pages/Calendar.vue";
import Settings from "./pages/Settings.vue";
import Inventory from "./pages/Inventory.vue";
import AddStaff from "./pages/AddStaff.vue";
import AddTask from "./pages/AddTask.vue";
import AddInventory from "./pages/AddInventory";
import AddReport from "./pages/AddReport";
import EditTask from "./pages/EditTask.vue";
import EditInventory from "./pages/EditInventory";
import Login from "./pages/Login";
import localService from "./localservice";
import EditStaff from "./pages/EditStaff";
import EditReport from "./pages/EditReport";

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
                path: "inventory",
                component: Inventory
            },
            {
                path: "staff",
                component: Staff
            },
            {
                path: "report",
                component: Report
            },
            {
                path: "staff/add",
                component: AddStaff
            },
            {
                path: "tasks/add",
                component: AddTask
            },
            {
                path: "tasks/edit",
                component: EditTask
            },
            {
                path: "inventory/add",
                component: AddInventory
            },
            {
                path: "inventory/edit",
                component: EditInventory
            },
            {
                path: "report/add",
                component: AddReport
            },
            {
                path: "staff/edit",
                component: EditStaff
            },
            {
                path: "report/edit",
                component: EditReport
            },
        ]
    },
    {
        path: "/login",
        component: Login
    }
];

const router = new VueRouter({
    mode: "history",
    routes: routes
});

router.beforeEach((to, from, next) => {
    //TODO: do authentication and authorization here
    var allPaths = [
        "login",
        "dashboard",
        "tasks",
        "calendar",
        "settings",
        "inventory",
        "staff",
        "report",
        "tasks/edit",
        "tasks/add",
        "inventory/edit",
        "inventory/add",
        "staff/add",
        "staff/edit",
        "report/add",
        "report/edit"
    ];
    var forStaff = ["calendar", "settings"];
    if (localService.isAuthenticated()) {
        console.log(`path: ${to.path.slice(1)}`);
        if (allPaths.indexOf(to.path.slice(1)) == -1) {
            next({ path: "/dashboard" });
        } else {
            if (localService.isAdmin()) {
                next();
            }else if(localService.isStaff()){
                if(forStaff.indexOf(to.path.slice(1)) != -1){
                    next();
                }else{
                    next('/calendar');
                }
            }
        }
    } else if (!localService.isAuthenticated() && to.path == "/login") {
        next();
    } else {
        console.log("here");
        next("/login");
    }
});

export default router;
