<template>
  <div class="page-container">
    <div class="flex flex-row justify-between">
      <p class="title">
        <font-awesome-icon icon="chart-line" />
        <span class="pl-2">Report</span>
      </p>
      <div class="flex flex-row">
        <div
          v-on-clickaway="hideFilterModal"
          @click="showFilter = !showFilter"
          class="bg-white border border-gray-300 cursor-pointer hover:bg-gray-300 hover:text-black h-8 text-black px-2 mr-2 rounded text-sm flex flex-row items-center relative"
        >
          <font-awesome-icon icon="filter" size="sm" />
          <span class="pl-2">Filter</span>
          <div v-if="showFilter" class="absolute top-8">
            <FilterDropDown :onFilterClicked="onFilterClicked" :filterList="[
              {name: 'Overall', onclick: 'overall'},
              {name: 'Last 6 Months', onclick: 'thisyear'},
              {name: 'This Year so far', onclick: 'last6months'},
              {name: 'Last Month', onclick: 'lastmonth'},
              {name: 'This Month', onclick: 'list'},]
              "
               />
          </div>
        </div>
        <div
          v-on:click="showPrint = !showPrint"
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
    <line-chart class="py-2 h-96 border w-full my-8" :chartData="data" v-if="dataloaded" />
    <div v-else class="h-96"></div>
    <div
      v-on-clickaway="hidePrintModal"
      class="p-2 w-60 bg-white shadow-md border rounded-md radius-sm absolute right-52 top-32"
      v-if="showPrint"
    >
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
      message="Report Deleted Successfully"
      :onClose="onClose"
      v-if="deleteReportStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Deleting Report"
      v-else-if="deleteReportStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="mt-2 bg-white" v-if="reports.status == 200">
      <div class="mt-2 mb-1">
        <label for class="font-bold text-sm">Select Date:</label>
        <input type="date" v-model="selected_date" @change="getDailyReport" />
      </div>
      <div class="mb-4 flex gap-4" v-if="dailyReports.status==200">
        <div class="bg-green-100 p-2 w-40">
          <p class="text-sm">Daily Earning</p>
          <p
            class="font-bold text-xl"
            v-if="dailyReports.data.data.daily_income.length > 0"
          >{{dailyReports.data.data.daily_income[0].data}}</p>
        </div>
        <div class="bg-red-100 p-2 w-40">
          <p class="text-sm">Daily Expense</p>
          <p
            class="font-bold text-xl"
            v-if="dailyReports.data.data.daily_expense.length > 0"
          >{{dailyReports.data.data.daily_expense[0].data}}</p>
        </div>
        <div class="bg-blue-100 p-2 w-40">
          <p class="text-sm">Total</p>
          <p
            class="font-bold text-xl"
            v-if="dailyReports.data.data.daily_income.length > 0"
          >{{dailyReports.data.data.daily_income[0].data - dailyReports.data.data.daily_expense[0].data}}</p>
        </div>
      </div>
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
      <Pagination
        :data="{prev_page_url:{page: reports.data.data.prev_page_url}, next_page_url:{page: reports.data.data.next_page_url}, cur_page:reports.data.data.current_page, total_page:reports.data.data.last_page, get: 'getReports'}"
      ></Pagination>
    </div>
    <div v-else class="text-center text-primary">
      <font-awesome-icon icon="spinner" spin size="2x" />
    </div>
  </div>
</template>
<script>
import Alert from "../components/Alert";
import Pagination from "../components/Pagination";
import { mixin as clickaway } from "vue-clickaway";
import LineChart from "../components/ReportGraph.vue";
import FilterDropDown from "../components/FilterDropdown";
import Axios from "axios";

export default {
  mixins: [clickaway],
  data: function () {
    return {
      from: "",
      to: "",
      showPrint: false,
      showFilter: false,
      data: null,
      dataloaded: false,
      selected_date: null,
    };
  },
  components: {
    Alert,
    Pagination,
    LineChart,
    FilterDropDown,
  },
  computed: {
    reports: function () {
      return this.$store.getters.reports;
    },
    dailyReports: function () {
      return this.$store.getters.dailyReports;
    },
    deleteReportStatus: function () {
      return this.$store.getters.deleteReportStatus;
    },
    printReportStatus: function () {
      return this.$store.getters.printReportStatus;
    },
  },
  created: function () {
    this.$store.dispatch("resetDeleteReportStatus");
    this.$store.dispatch("getReports");
    this.$store.dispatch("getDailyReports");
    this.getGraphData("overall");
  },
  methods: {
    getGraphData: function (filterBy) {
      Axios.get(
        `/api/reports?forGraph=true&filterBy=${filterBy.toLowerCase()}`
      ).then((response) => {
        // console.log(response);
        var label = [];
        var expense = [];
        var income = [];
        if (response.status == 200) {
          response.data.data.income.forEach((element) => {
            income.push(element.data);
            label.push(element.label);
          });
          response.data.data.expense.forEach((element) => {
            expense.push(element.data);
          });
          this.data = {
            //Data to be represented on x-axis
            labels: label,
            datasets: [
              {
                label: `${filterBy.toLowerCase()} income`,
                backgroundColor: "#00000000",
                pointRadius: 0,
                borderWidth: .5,
                borderColor: "#3D68FF",
                backgroundColor: "#3D68FF10",
                //Data to be represented on y-axis
                data: income,
              },
              {
                label: `${filterBy.toLowerCase()} expense`,
                backgroundColor: "#00000000",
                pointRadius: 0,
                borderWidth: .5,
                borderColor: "#d6182e",
                backgroundColor: "#d6182e10",
                //Data to be represented on y-axis
                data: expense,
              },
            ],
          };
          this.dataloaded = true;
        }
      });
    },
    deleteReport: function (reportId) {
      var resp = confirm("Do you want to remove this report?");
      if (resp) this.$store.dispatch("deleteReport", reportId);
    },
    onClose: function () {
      this.$store.dispatch("resetDeleteReportStatus");
    },
    printReport: function (e) {
      e.preventDefault();
      // console.log({ from: this.from, to: this.to });
      this.$store.dispatch("getToPrint", { from: this.from, to: this.to });
    },
    hidePrintModal: function () {
      if (this.showPrint) {
        this.showPrint = false;
      }
    },
    hideFilterModal: function () {
      if (this.showFilter) {
        this.showFilter = false;
      }
    },
    onFilterClicked: function (filterBy) {
      // console.log(filterBy);
      this.getGraphData(filterBy);
    },
    getDailyReport: function () {
      // console.log("selected date" + this.selected_date);
      this.$store.dispatch("getDailyReports", this.selected_date);
    },
  },
};
</script>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}
</style>
