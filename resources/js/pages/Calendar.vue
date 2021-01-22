<template>
  <div class="relative">
    <div class="page-container h-full flex flex-row">
      <FullCalendar :options="calendarOptions" class="w-full" v-if="showCalendar" />
      <div v-else class="text-center text-primary w-full">
        <font-awesome-icon icon="spinner" spin size="2x" />
      </div>
    </div>
    <div class="absolute w-full h-full top-0 z-20 bg-black bg-opacity-60 p-8" v-if="showSelectedModal">
    <div class="w-full mt-8 p-8 shadow-md border rounded-md bg-white">

        <p class="title flex flex-row items-center justify-between">
            <span class="pl-2">Tasks</span>
            <font-awesome-icon icon="times" class="cursor-pointer" @click="showSelectedModal=false"/>
        </p>
        <div v-if="gettingSelectedTasksStatus=='busy'" class="text-center text-primary w-full">
            <font-awesome-icon icon="spinner" spin size="2x" />
        </div>
        <div v-else>
            <table class="w-full mt-2">
            <thead>
                <tr class="text-black text-xs">
                <th>Date</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Type</th>
                <th>Location</th>
                <th>Package</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Paid Amount</th>
                <th>Unpaid</th>
                <th>Shot Date</th>
                <th>Print Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="selectedTasks.length == 0">
                <td colspan="13" class="text-gray-500 text-lg">No tasks</td>
                </tr>
                <tr v-for="task in selectedTasks" :key="task.id">
                <td class="w-20">{{parseDate(task.created_at)}}</td>
                <td>{{task.name}}</td>
                <td>{{task.phone_number}}</td>
                <td>{{task.type}}</td>
                <td>{{task.location}}</td>
                <td>{{task.package}}</td>
                <td>{{task.size}}</td>
                <td>{{task.quantity}}</td>
                <td>{{task.total_price}}</td>
                <td>{{task.paid_amount}}</td>
                <td>{{task.total_price - task.paid_amount}}</td>
                <td class="w-20">{{parseDate(task.shot_date)}}</td>
                <td class="w-20">{{parseDate(task.delivery_date)}}</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>

  </div>
</template>
<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import Axios from "axios";

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
  },
  data: function () {
    return {
      showCalendar: false,
      calendarOptions: {
        eventClick: this.handleEventClick,
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
      },
      showSelectedModal: false,
      gettingSelectedTasksStatus: '',
      selectedTasks: []
    };
  },
  created: function () {
    this.$store.dispatch("getCalendarTasks").then(() => {
      this.showCalendar = true;
      console.log(this.$store.getters.calendarTasks);
      this.calendarOptions.events = this.$store.getters.calendarTasks;
    });
  },
  methods: {
    handleEventClick: function (info) {
        this.showSelectedModal = true;
        this.gettingSelectedTasksStatus = 'busy';
        var type = info.event.extendedProps.type;
        var date = `${info.event.start.getFullYear()}-${Number(info.event.start.getMonth())+1}-${info.event.start.getDate()}`;
        console.log(info.event.start.toUTCString());
        console.log(info.event.start.toISOString());
        Axios.get(`/api/tasks?filterBy=date&type=${info.event.extendedProps.type}&date=${date}`).then(
            response => {
                console.log(response);
                this.gettingSelectedTasksStatus = 'success';
                this.selectedTasks = response.data.data;
            }
        )
    },
    parseDate: function (rawdate) {
      console.log(rawdate);
      var date = new Date(rawdate);
      console.log();
      return date.toLocaleString();
    },
  },
  destroyed: function() {
      this.showSelectedModal = false;
  }
};
</script>
<style>
.fc-view tr {
  background-color: white !important;
}
.fc-event {
  cursor: default;
}
th{
    @apply text-xs ;
}
</style>
