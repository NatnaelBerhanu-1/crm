<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Edit Task</span>
    </p>
    <Alert
      type="success"
      message="Task Updated Successfully"
      :onClose="onClose"
      v-if="editTaskStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Updating task"
      v-else-if="editTaskStatus == 'failure'"
      :onClose="onClose"
    />

    <form v-on:submit="editTask" method="post" v-if="task.status == 200">
      <div class="pt-2 w-full">
        <div class="flex w-full flex-row gap-4">
          <div class="w-full">
            <div class="form-control">
              <label>Full Name</label>
              <br />
              <input
                type="text"
                v-model="task.data.data.name"
                id="full-name"
                placeholder="Name"
                required
              />
            </div>
            <div class="form-control">
              <label>
                Phone Number
                <span
                  class="text-red-500 text-sm ml-2 font-normal"
                  v-if="phoneNumberError"
                >phone number invalid</span>
              </label>
              <br />
              <input
                type="phone"
                v-model="task.data.data.phone_number"
                id="phone-number"
                placeholder="Phone Number"
                required
              />
            </div>
            <div class="form-control">
              <label>Location</label>
              <br />
              <select v-model="task.data.data.location" id="role" required>
                <option selected value>Select Location</option>
                <option value="Field">Field</option>
                <option value="Studio">Studio</option>
              </select>
            </div>
            <div class="form-control">
              <label>Type</label>
              <br />
              <select v-model="task.data.data.type" id="type" required>
                <option selected value>Select Type</option>
                <option value="Normal">Normal</option>
                <option value="Birthday">Birthday</option>
                <option value="Wedding">Wedding</option>
                <option value="Baby Shower">Baby Shower</option>
                <option value="Graduation">Graduation</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-control">
              <label>Package</label>
              <br />
              <select v-model="task.data.data.package" id="role" required>
                <option selected value>Select Package</option>
                <option value="Package 1">Package 1</option>
                <option value="Package 2">Package 2</option>
                <option value="Package 3">Package 3</option>
              </select>
            </div>
            <div class="form-control">
              <label>Size</label>
              <br />
              <input
                type="text"
                v-model="task.data.data.size"
                id="full-name"
                placeholder="Size"
                required
              />
            </div>
          </div>
          <div class="w-full">
            <div class="form-control">
              <label>Quantity</label>
              <br />
              <input
                type="number"
                v-model="task.data.data.quantity"
                id="full-name"
                placeholder="Quantity"
                required
              />
            </div>
            <div class="form-control flex flex-row justify-between content-between w-full gap-4">
              <div class="w-full">
                <label for="total-price">Total price</label>
                <input
                  type="number"
                  v-model="task.data.data.total_price"
                  id="total-price"
                  placeholder="Price"
                  required
                />
              </div>
              <div class="w-full">
                <label for="paid-amount">Paid amount</label>
                <input
                  type="number"
                  v-model="task.data.data.paid_amount"
                  id="paid-amount"
                  placeholder="Paid amount"
                  required
                />
              </div>
            </div>
            <div class="form-control flex flex-row justify-between content-between w-full gap-4">
              <div>
                <label for>Shot Date</label>
                <input
                  type="datetime-local"
                  v-model="shot_date"
                  id="shot-date"
                  placeholder="Shot Date"
                  required
                />
              </div>
              <div>
                <label for>Print Date</label>
                <input
                  type="datetime-local"
                  v-model="print_date"
                  id="print-date"
                  placeholder="Print Date"
                  required
                />
              </div>
            </div>
            <div class="form-control">
              <label>Status</label>
              <br />
              <select v-model="task.data.data.status" id="role" required>
                <option selected value>Select Status</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Delayed">Delayed</option>
                <option value="Complete">Complete</option>
              </select>
            </div>
            <div class="form-control">
              <label for>Remark</label>
              <textarea
                v-model="task.data.data.remark"
                class="w-full h-28"
                rows="4"
                placeholder="remark"
              ></textarea>
            </div>
          </div>
        </div>
        <div class="form-control" v-if="editTaskStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Save</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button type="submit" class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Save</span>
          </button>
        </div>
      </div>
    </form>
    <div v-else class="text-center text-primary">
      <font-awesome-icon icon="spinner" spin size="2x" />
    </div>
  </div>
</template>
<script>
import Alert from "../components/Alert";

export default {
  components: {
    Alert,
  },
  data: function () {
    return {
        phoneNumberError: false
    };
  },
  computed: {
    editTaskStatus: function () {
      console.log(this.$store.getters.addTaskStatus);
      return this.$store.getters.editTaskStatus;
    },
    task: function () {
      return this.$store.getters.editTask;
    },
    shot_date: {
      get() {
        return this.parseDateTime(this.task.data.data.shot_date);
      },
      set(newDate) {
        this.task.data.data.shot_date = newDate;
      },
    },
    print_date: {
      get() {
        return this.parseDateTime(this.task.data.data.print_date);
      },
      set(newDate) {
        this.task.data.data.print_date = newDate;
      },
    },
  },
  methods: {
    editTask: function (e) {
      e.preventDefault();
      console.log(this.task);
      var phoneno = /^\d{10}$/;
      if (this.task.data.data.phone_number.match(phoneno)) {
        this.phoneNumberError = false;
        this.$store.dispatch("updateTask", this.task.data.data);
      } else {
        this.phoneNumberError = true;
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetEditTaskStatus");
    },
    parseDateTime: function (date) {
      console.log(`${date.slice(0, 10)}T${date.slice(11)}`);
      return `${date.slice(0, 10)}T${date.slice(11)}`.toString();
    },
  },
  created: function () {
    this.$store.dispatch("resetEditTaskStatus");
    this.$store.dispatch("getSingleTask", this.$route.query.id);
  },
};
</script>
<style scoped>
.form-control {
  @apply w-full;
}
.form-control input,
.form-control select {
  @apply w-full;
}

.form-control input[type="date"],
.form-control input[type="datetime-local"] {
  @apply w-full;
}
</style>
