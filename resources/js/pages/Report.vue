<template>
  <div class="page-container">
    <div class="flex flex-row justify-between">
      <p class="title">
        <font-awesome-icon icon="chart-line" />
        <span class="pl-2">Report</span>
      </p>
      <div class="flex flex-row">
        <div v-on:click="showPrint = !showPrint"
          class="bg-white border border-gray-300 cursor-pointer hover:bg-gray-300 hover:text-black h-8 text-black px-2 mr-2 rounded text-sm flex flex-row items-center"
        >
          <font-awesome-icon icon="print" size="sm" />
          <span class="pl-2">Generate Report</span>
        </div>
        <router-link to="add" append>
          <div class="bg-primary h-8 text-white px-2 rounded text-sm flex flex-row items-center">
            <font-awesome-icon icon="plus" size="sm" />
            <span class="pl-2">Add daily report</span>
          </div>
        </router-link>
      </div>
    </div>
    <div v-on-clickaway="hidePrintModal" class="p-2 w-60 bg-white shadow-md border rounded-md radius-sm absolute right-52 top-32" v-if="showPrint">
      <div class="text-center text-primary" v-if="printReportStatus == 'busy'">
        <font-awesome-icon icon="spinner" spin />
      </div>
      <form v-on:submit="printReport" method="get">
        <div>
          <label for class="text-primary font-bold">from:</label>
          <br />
          <input type="date" class="w-48" v-model="from" id="from" required />
        </div>
        <div>
          <label for class="text-primary font-bold">to:</label>
          <br />
          <input class="w-48" type="date" v-model="to" id="to" required />
        </div>
        <button class="btn-primary" type="submit">Generate</button>
      </form>
    </div>

    <Alert
      type="success"
      message="Task Deleted Successfully"
      :onClose="onClose"
      v-if="deleteReportStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Deleting Task"
      v-else-if="deleteReportStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="mt-2 bg-white" v-if="reports.status == 200">
      <table class="w-full">
        <thead>
          <tr class="text-black">
            <th colspan="2">Income</th>
            <th colspan="2">Expense</th>
            <th rowspan="2">Date</th>
            <th rowspan="2" class="w-20"></th>
          </tr>
          <tr>
            <th>Amount</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="report in reports.data.data.data" :key="report.id">
            <td>{{report.income_amount}}</td>
            <td>{{report.income_description}}</td>
            <td>{{report.expense_amount}}</td>
            <td>{{report.expense_description}}</td>
            <td>{{report.date}}</td>
            <td class="text-gray-300">
              <router-link :to="`edit?id=${report.id}`" append>
                <font-awesome-icon
                  icon="pencil-alt"
                  class="mr-2 hover:text-blue-400 cursor-pointer"
                />
              </router-link>
              <font-awesome-icon
                icon="trash"
                v-on:click="deleteReport(report.id)"
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
</template>
<script>
import Alert from "../components/Alert";
import { mixin as clickaway } from 'vue-clickaway';

export default {
    mixins: [clickaway],
  data: function () {
    return {
      from: "",
      to: "",
      showPrint: false
    };
  },
  components: {
    Alert,
  },
  computed: {
    reports: function () {
      return this.$store.getters.reports;
    },
    deleteReportStatus: function () {
      return this.$store.getters.deleteReportStatus;
    },
    printReportStatus: function () {
      return this.$store.getters.printReportStatus;
    },
  },
  created: function () {
    this.$store.dispatch("getReports");
  },
  methods: {
    deleteReport: function (reportId) {
      var resp = confirm("Do you want to remove this report?");
      if (resp) this.$store.dispatch("deleteReport", reportId);
    },
    onClose: function () {
      this.$store.dispatch("resetDeleteReportStatus");
    },
    printReport: function(e) {
        e.preventDefault();
        console.log({from: this.from, to: this.to});
        this.$store.dispatch("getToPrint", {from: this.from, to: this.to});
    },
    hidePrintModal: function() {
        if(this.showPrint){
            this.showPrint = false;
        }
    }
  },
};
</script>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}
</style>
