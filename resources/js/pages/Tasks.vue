<template>
  <div>
    <div class="page-container">
      <div class="flex flex-row justify-between">
        <div class="flex flex-row content-center">
          <p class="title">
            <font-awesome-icon icon="tasks" />
            <span class="pl-2">Tasks</span>
          </p>
          <div class="form-control ml-3">
            <input
              type="text"
              name="search"
              class="mt-0 border-gray-400 w-60 h-7"
              placeholder="Search.."
            />
            <button
              class="bg-white ml-2 h-8 text-gray-500 px-2 border-gray-400 border rounded text-sm hover:bg-primary hover:text-white"
            >
              <font-awesome-icon icon="search" size="sm" class="mr-2" />Search
            </button>
          </div>
        </div>
        <router-link to="add" append>
          <div class="bg-primary h-8 text-white px-2 rounded text-sm flex flex-row items-center">
            <font-awesome-icon icon="plus" size="sm" />
            <span class="ml-1">Add Task</span>
          </div>
        </router-link>
      </div>
      <Alert
        type="success"
        message="Task Deleted Successfully"
        :onClose="onClose"
        v-if="deleteTaskStatus == 'success'"
      />
      <Alert
        type="failure"
        message="Failed Deleting Task"
        v-else-if="deleteTaskStatus == 'failure'"
        :onClose="onClose"
      />
      <div class="mt-2 bg-white" v-if="tasks.status == 200">
        <table class="w-full">
          <thead>
            <tr class="text-black">
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
              <th class="w-20"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="tasks.data.data.data.length == 0">
              <td colspan="13" class="text-gray-500 text-lg">No tasks</td>
            </tr>
            <tr v-for="task in tasks.data.data.data" :key="task.id">
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
              <td class="w-20">{{parseDate(task.print_date)}}</td>
              <td class="text-gray-300">
                <router-link :to="`edit?id=${task.id}`" append>
                  <font-awesome-icon
                    icon="pencil-alt"
                    class="mr-2 hover:text-blue-400 cursor-pointer"
                  />
                </router-link>
                <font-awesome-icon
                  icon="trash"
                  v-on:click="deleteTask(task.id)"
                  class="hover:text-red-400 cursor-pointer"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center text-primary">
        <font-awesome-icon icon="spinner" spin size="2x" />
      </div>
    </div>
  </div>
</template>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}

.form-control {
  @apply mt-0;
}

.input{
    @apply w-60;
}
table,
th,
td {
  @apply text-xs;
}
</style>
<script>
import Alert from "../components/Alert";

export default {
  computed: {
    tasks: function () {
      return this.$store.getters.tasks;
    },
    deleteTaskStatus: function () {
      return this.$store.getters.deleteTaskStatus;
    },
  },
  created: function () {
    this.$store.dispatch("getTasks");
  },
  components: {
    Alert,
  },
  methods: {
    parseDate: function (rawdate) {
      console.log(rawdate);
      var date = new Date(rawdate);
      console.log();
      return date.toLocaleString();
    },
    deleteTask: function (taskId) {
      var resp = confirm("Do you want to delete this task?");
      if (resp) {
        this.$store.dispatch("deleteTask", taskId);
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetDeleteTaskStatus");
    },
  },
};
</script>
