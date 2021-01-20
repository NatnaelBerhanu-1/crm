<template>
  <div>
    <div
      class="absolute w-full h-screen flex justify-items-center justify-center left-0 top-0 z-50 bg-black bg-opacity-60 p-12"
      v-if="showModal"
    >
      <div class="p-8 bg-white rounded-md h-min w-max">
        <div class="h-8 flex h-min gap-4 w-full justify-between content-center">
          <p class="text-primary font-bold">Detail</p>
          <font-awesome-icon icon="times" class="cursor-pointer" @click="showModal = false" />
        </div>
        <div class="pt-6 text-black gap-16 flex justify-center">
          <div>
            <ModalData title="Full Name" :content="detailTask.name" />
            <ModalData title="Phone Number" :content="detailTask.phone_number" />
            <ModalData title="Type" :content="detailTask.type" />
            <ModalData title="Location" :content="detailTask.location" />
            <ModalData title="Package" :content="detailTask.package" />
          </div>
          <div>
            <ModalData title="Description" :content="detailTask.description" />
            <ModalData title="Quantity" :content="detailTask.quantity" />
            <ModalData title="Total Price" :content="detailTask.total_price" />
            <ModalData title="Paid Amount" :content="detailTask.paid_amount" />
            <ModalData title="Unpaid" :content="detailTask.total_price - detailTask.paid_amount" />
          </div>
          <div>
            <ModalData title="Selection Date" :content="detailTask.selection_date" />
            <ModalData title="Shot Date" :content="detailTask.shot_date" />
            <ModalData title="Delivery Date" :content="detailTask.delivery_date" />
          </div>
        </div>
      </div>
    </div>
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
              v-model="searchVal"
              class="mt-0 border-gray-400 w-60 h-7"
              placeholder="Search.."
            />
            <button
              @click="search"
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
              <th>Name</th>
              <th>Phone Number</th>
              <th>Type</th>
              <th>Location</th>
              <th>Package</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Total Price</th>
              <th class="w-20"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="tasks.data.data.data.length == 0">
              <td colspan="13" class="text-gray-500 text-lg">No tasks</td>
            </tr>
            <tr v-for="task in tasks.data.data.data" :key="task.id" @click="rowClicked(task)">
              <td>{{task.name}}</td>
              <td>{{task.phone_number}}</td>
              <td>{{task.type}}</td>
              <td>{{task.location}}</td>
              <td>{{task.package}}</td>
              <td>{{task.description}}</td>
              <td>{{task.quantity}}</td>
              <td>{{task.total_price}}</td>
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
        <Pagination
          :data="{prev_page_url:{page: tasks.data.data.prev_page_url, search: searchVal}, next_page_url:{page:tasks.data.data.next_page_url, search: searchVal}, cur_page:tasks.data.data.current_page, total_page:tasks.data.data.last_page, get: 'getTasks'}"
        ></Pagination>
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

.input {
  @apply w-60;
}
table,
th,
td {
  @apply text-sm;
}
</style>
<script>
import Alert from "../components/Alert";
import Pagination from "../components/Pagination";
import ModalData from "../components/ModalData";

export default {
  data: function () {
    return {
      searchVal: null,
      showModal: false,
      detailTask: {},
    };
  },
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
    Pagination,
    ModalData,
  },
  methods: {
    rowClicked: function (data) {
      this.detailTask = data;
      this.showModal = true;
    },
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
    search: function () {
      this.$store.dispatch("getTasks", { page: 1, search: this.searchVal });
    },
    onClose: function (e) {
      this.$store.dispatch("resetDeleteTaskStatus");
    },
  },
};
</script>
