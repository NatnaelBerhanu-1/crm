<template>
    <div v-if="initData.status == 200">
        <div class="grid grid-cols-8 grid-rows-2 h-60 gap-2">
            <div class="col-span-3 row-span-2">
                <p class="text-lg">Monthly Earning</p>
                <div class="mt-2 bg-white h-52 shadow-sm">
                    <line-chart :labels="monthlyLabel" class="w-full h-full" color="#FFE0E6" :data="formatForGraph(initData.data.data.monthlyEarning)" label="Monthly earning"></line-chart>
                </div>
            </div>
            <div class="col-span-3 row-span-2">
                <p class="text-lg">Monthly Tasks</p>
                <div class="mt-2 bg-white h-52 shadow-sm">
                    <line-chart class="w-full h-full" :labels="monthlyLabel" color="#CDEBFF" :data="formatForGraph(initData.data.data.monthlyTasks)" label="Monthly tasks"></line-chart>
                </div>
            </div>
            <div class="col-span-2 row-span-2">
                <p class="text-lg">Tasks</p>
                <div class="grid mt-2 grid-rows-2 grid-cols-1 h-52 gap-2">
                    <div class="w-full bg-white col-span-1 row-span-1 h-full flex flex-row shadow-sm">
                        <div class="bg-red-500 w-20 flex flex-row justify-center items-center">
                            <font-awesome-icon icon="list" size="2x" color="white" />
                        </div>
                        <div class="bg-white w-auto pt-2 pl-2 shadow-sm">
                            <p class="text-lg ">In progress</p>
                            <p class="text-xl font-bold ">{{initData.data.data.ongoingTasks}}</p>
                        </div>
                    </div>
                    <div class="w-full bg-white col-span-1 row-span-1 h-full flex flex-row">
                        <div class="bg-green-500 w-20 flex flex-row justify-center items-center">
                            <font-awesome-icon icon="tasks" size="2x" color="white" />
                        </div>
                        <div class="bg-white w-auto pt-2 pl-2 shadow-sm">
                            <p class="text-lg ">Completed</p>
                            <p class="text-xl font-bold ">{{initData.data.data.completedTasks}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-white p-4  mt-8 shadow-sm">
            <div class="flex flex-row items-baseline">
                <p class="text-lg">Upcomming tasks</p>
                <router-link to="tasks"><span class="text-primary font-semibold pl-2 text-sm">All tasks</span></router-link>
            </div>
            <div class="mt-2  bg-white">
                <table class="w-full">
                    <thead>
                        <tr class="bg-white text-black-54">
                            <th>Name</th>
                            <th>Phone number</th>
                            <th>Event type</th>
                            <th>Place</th>
                            <th>Shot Date</th>
                            <th>Print Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in initData.data.data.upcomingTasks" :key="task.id">
                            <td>{{task.name}}</td>
                            <td>{{task.phone_number}}</td>
                            <td>{{task.type}}</td>
                            <td>{{task.location}}</td>
                            <td>{{task.shot_date}}</td>
                            <td>{{task.print_date}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import LineChart from '../components/LineChart.vue';
export default {
    components: {LineChart},
    data: function() {
        return {
            monthlyLabel: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
        }
    },
    computed: {
        initData: function() {
            return this.$store.getters.initData;
        }
    },
    created: function(){
        this.$store.dispatch('getInitData');
    },
    methods: {
        formatForGraph(data){
            var randomArr = Array(12).fill(0);
            data.forEach(element => {
                randomArr[data.indexOf(element)] = element.data;
            });
            console.log(randomArr);
            return randomArr;
        }
    }

}
</script>
<style lang="css">
    td, th {
        @apply text-center;
    }

    table, th, td{
        @apply text-sm;
    }

    table {
        @apply border;
    }

    tbody tr:nth-child(odd){
        @apply bg-gray-100
    }
    tr:first-child {
        @apply border-b-2;
    }

    .title {
        @apply text-lg text-primary;
    }

    tr{
        @apply h-12;
    }

    .btn-primary{
        @apply text-sm bg-primary text-white px-3 py-2 mt-2 rounded;
    }

    input, select, textarea {
        @apply border border-gray-300 rounded-sm p-1 my-1 px-3 font-normal text-sm h-9;
    }

    input[type='datetime-local']{
        @apply w-full;
    }

    .form-control {
        @apply mt-2;
    }
    input:focus, select:focus, textarea:focus {
        outline: none;
        @apply border-primary;
    }

    label {
        @apply text-sm font-medium;
    }

    .page-container{
        @apply bg-white w-full p-4 shadow-sm;
    }

    button:disabled {
        opacity: .6;
        cursor: progress;
    }

</style>
