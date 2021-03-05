<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Report</span>
    </p>
    <Alert
      type="success"
      message="Report Added Successfully"
      :onClose="onClose"
      v-if="addReportStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed adding report"
      v-else-if="addReportStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="pt-2 w-96">
      <form action v-on:submit="addReport" method="post">
        <div class="form-control">
          <label>Income amount</label>
          <br/>
          <input
            type="number"
            min="0"
            v-model="report.income_amount"
            id="income-amount"
            placeholder="Income amount"
          />
        </div>
        <div class="form-control">
          <label>Income description</label>
          <br />
          <input
            type="text"
            v-model="report.income_description"
            id="income-description"
            placeholder="Income description"
          />
        </div>
        <div class="form-control">
          <label>Expense amount</label>
          <br />
          <input
            type="number"
            min="0"
            v-model="report.expense_amount"
            id="expense_amount"
            placeholder="Expense amount"
          />
        </div>
        <div class="form-control">
          <label>Expense description</label>
          <br />
          <input
            type="text"
            v-model="report.expense_description"
            id="expense-description"
            placeholder="Expense description"
          />
        </div>
        <div class="form-control">
          <label>Date</label>
          <br />
          <input
            type="date"
            v-model="report.date"
            id="location"
            placeholder="Location"
            required
          />
        </div>
        <div class="form-control" v-if="addReportStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Add Report</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Add Report</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped>
.form-control input,
.form-control textarea {
  @apply w-full;
}

</style>
<script>
import Alert from "../components/Alert";

export default {
  components: {
    Alert,
  },
  computed: {
    addReportStatus: function () {
      return this.$store.getters.addReportStatus;
    },
    report: function () {
      return this.$store.getters.addReport;
    },
  },
  methods: {
    addReport: function (e) {
      e.preventDefault();
      console.log(this.report);
      this.$store.dispatch("addReport", this.report);
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddReportStatus");
    },
  },
  created: function(){
      this.$store.dispatch("resetAddReportStatus");
  }
};
</script>
