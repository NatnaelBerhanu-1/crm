<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Edit Report</span>
    </p>
    <Alert
      type="success"
      message="Report Added Successfully"
      :onClose="onClose"
      v-if="editReportStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed editing report"
      v-else-if="editReportStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="pt-2 w-96">
      <form action v-on:submit="editReport" method="post" v-if="report.status == 200">
        <div class="form-control">
          <label>Income amount</label>
          <br />
          <input
            type="number"
            min="0"
            v-model="report.data.data.income_amount"
            id="income-amount"
            placeholder="Income amount"
          />
        </div>
        <div class="form-control">
          <label>Income description</label>
          <br />
          <input
            type="text"
            v-model="report.data.data.income_description"
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
            v-model="report.data.data.expense_amount"
            id="expense_amount"
            placeholder="Expense amount"
          />
        </div>
        <div class="form-control">
          <label>Expense description</label>
          <br />
          <input
            type="text"
            v-model="report.data.data.expense_description"
            id="expense-description"
            placeholder="Expense description"
          />
        </div>
        <div class="form-control">
          <label>Date</label>
          <br />
          <input type="date" v-model="report.data.data.date" id="location" placeholder="Location" required />
        </div>
        <div class="form-control" v-if="editReportStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Edit Report</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Edit Report</span>
          </button>
        </div>
      </form>
      <div v-else class="text-center text-primary">
        <font-awesome-icon icon="spinner" spin size="2x" />
      </div>
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
    editReportStatus: function () {
      return this.$store.getters.editReportStatus;
    },
    report: function () {
      return this.$store.getters.editReport;
    },
  },
  created: function () {
    this.$store.dispatch("resetEditReportStatus");
    this.$store.dispatch("getSingleReport", this.$route.query.id);
  },
  methods: {
    editReport: function (e) {
      e.preventDefault();
      console.log(this.report);
      this.$store.dispatch("updateReport", this.report.data.data);
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddReportStatus");
    },
  },
};
</script>
