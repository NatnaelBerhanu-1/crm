<template>
    <div class="flex flex-row bg-gray-200 h-full">
        <div class="bg-primary w-60 h-screen fixed">
            <Sidebar></Sidebar>
        </div>
        <div class="w-full min-h-screen h-full ml-60 main-screen">
            <header class="z-50 h-14 bg-white sticky-0 flex sticky top-0 shadow-sm border-b-1 border-gray-800 flex-row justify-end right-0">
                <button id="profile-icon" class="flex-none bg-primary h-10 w-10 rounded-full self-center text-white mr-4 border-grey-300 border-4" v-on:click="toggleLogoutModal">
                    N
                </button>
                <div v-show="logoutModalState" v-on-clickaway="hideLogoutModal" class="bg-white absolute flex right-4 top-16 w-32 p-2 shadow-md hover:bg-primary hover:text-white">
                    <button class="w-full text-left">Logout</button>
                </div>
            </header>
            <div class="p-8 overflow-y-auto ">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import Sidebar from '../components/Sidebar.vue';
import { mixin as clickaway } from 'vue-clickaway';

export default {
    mixins: [clickaway],
    data: function(){
        return {
            logoutModalState: false
        }
    },
    methods: {
        toggleLogoutModal: function() {
            this.logoutModalState = !this.logoutModalState
        },
        hideLogoutModal: function(event) {
            if(this.logoutModalState && event.target.id != 'profile-icon'){
                this.logoutModalState = false;
            }
            // console.log(this.logoutModalState);
        }
    },
    components: {Sidebar}
}
</script>
<style>
    .main-screen{
        background-color: #EDF1F5;
    }
</style>
