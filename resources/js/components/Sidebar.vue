<template>
    <div class="text-white py-4">
        <h1 class="font-bold text-3xl px-6">CRM</h1>
        <ul class="p-0 mt-6">
            <li v-if="isAdmin">
                <router-link to="/dashboard">
                    <SideBarItem v-bind:icon="['fas', 'tachometer-alt']" title="Dashboard" :active="currentRoute.indexOf('dashboard')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li v-if="isAdmin">
                <router-link to="/staff">
                    <SideBarItem v-bind:icon="['fas', 'id-card']" title="Staff" :active="currentRoute.indexOf('staff')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li v-if="isAdmin">
                <router-link to="/tasks">
                    <SideBarItem v-bind:icon="['fas', 'tasks']" title="Tasks" :active="currentRoute.indexOf('tasks')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li v-if="isAdmin">
                <router-link to="/inventory">
                    <SideBarItem v-bind:icon="['fas', 'camera']" title="Inventory" :active="currentRoute.indexOf('inventory')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li>
                <router-link to="/calendar">
                    <SideBarItem v-bind:icon="['fas', 'calendar-alt']" title="Calendar" :active="currentRoute.indexOf('calendar')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li v-if="isAdmin">
                <router-link to="/report">
                    <SideBarItem v-bind:icon="['fas', 'chart-line']" title="Report" :active="currentRoute.indexOf('report')!=-1"></SideBarItem>
                </router-link>
            </li>
            <li>
                 <router-link to="/settings">
                    <SideBarItem v-bind:icon="['fas', 'cog']" title="Settings" :active="currentRoute.indexOf('settings')!=-1"></SideBarItem>
                </router-link>
            </li>
        </ul>
    </div>
</template>
<script>
import SideBarItem from './SidebarItem.vue';
import localService from '../localservice';

export default {
    data: function() {
        return {
            currentRoute: this.$router.currentRoute.path,
            isAdmin: localService.isAdmin(),
        }
    },
    components: {
        SideBarItem
    },
    watch: {
        '$route' (to, from){
            console.log(to);
            this.currentRoute = to.path
        }
    },
    created: function() {
        console.log(this.$router.currentRoute.path);
    }
}

</script>
