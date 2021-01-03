<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Task</span>
    </p>
    <Alert
      type="success"
      message="Task Added Successfully"
      :onClose="onClose"
      v-if="addTaskStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed adding task"
      v-else-if="addTaskStatus == 'failure'"
      :onClose="onClose"
    />
    <form v-on:submit="addTask" method="post">
      <div class="pt-2 w-full">
        <div class="grid w-full grid-cols-2 gap-4">
          <div class="w-full">
            <div class="form-control">
              <label>Full Name</label>
              <br />
              <input type="text" v-model="task.name" id="full-name" placeholder="Name" required />
            </div>
            <div class="form-control">
              <label>Phone Number<span class="text-red-500 text-sm ml-2 font-normal" v-if="phoneNumberError">phone number invalid</span></label>
              <br />
              <input
                type="phone"
                v-model="task.phone_number"
                id="phone-number"
                placeholder="Phone Number"
                required
              />
            </div>
            <div class="form-control">
              <label>Location</label>
              <br />
              <select v-model="task.location" id="role" required>
                <option selected value>Select Location</option>
                <option value="Field">Field</option>
                <option value="Studio">Studio</option>
              </select>
            </div>
            <div class="form-control">
              <label>Type</label>
              <br />
              <select v-model="task.type" id="type" required>
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
              <select v-model="task.package" id="package" required>
                <option selected value>Select Package</option>
                <option value="Package 1">Package 1</option>
                <option value="Package 2">Package 2</option>
                <option value="Package 3">Package 3</option>
              </select>
            </div>
            <div class="form-control">
              <label>Size</label>
              <br />
              <input type="text" v-model="task.size" id="size" placeholder="Size" required />
            </div>
          </div>
          <div class="w-full">
            <div class="form-control">
              <label>Quantity</label>
              <br />
              <input
                type="number"
                min="1"
                v-model="task.quantity"
                id="quantity"
                placeholder="Quantity"
                required
              />
            </div>
            <div class="form-control flex flex-row justify-between content-between w-full gap-4">
              <div class="w-full">
                <label for="total-price">Total price</label>
                <input
                  type="number"
                  min="1"
                  v-model="task.total_price"
                  id="total-price"
                  placeholder="Price"
                  required
                />
              </div>
              <div class="w-full">
                <label for="paid-amount">Paid amount</label>
                <input
                  type="number"
                  min="0"
                  v-model="task.paid_amount"
                  id="paid-amount"
                  placeholder="Paid amount"
                  required
                />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label >Shot Date</label>
                <input
                  type="datetime-local"
                  v-model="task.shot_date"
                  id="shot-date"
                  placeholder="Shot Date"
                  required
                />
              </div>
              <div>
                <label for>Print Date</label>
                <input
                  type="datetime-local"
                  v-model="task.print_date"
                  id="print-date"
                  placeholder="Print Date"
                  required
                />
              </div>
            </div>
            <div class="form-control">
              <label>Status</label>
              <br />
              <select v-model="task.status" id="status" required>
                <option selected value>Select Status</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Delayed">Delayed</option>
                <option value="Complete">Complete</option>
              </select>
            </div>
            <div class="form-control">
              <label for>Remark</label>
              <textarea v-model="task.remark" id="remark" class="w-full h-28" rows="4" placeholder="remark"></textarea>
            </div>
          </div>
        </div>
        <div class="form-control" v-if="addTaskStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Add Task</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button type="submit" class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Add Task</span>
          </button>
        </div>
      </div>
    </form>
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
      today: new Date().toISOString(),
      phoneNumberError: false
    };

  },
  computed: {
    addTaskStatus: function () {
      console.log(this.$store.getters.addTaskStatus);
      return this.$store.getters.addTaskStatus;
    },
    task: function() {
        return this.$store.getters.addTask;
    }
  },
  methods: {
    addTask: function (e) {
      e.preventDefault();
      console.log(this.task);
      var phoneno = /^\d{10}$/;
      if((this.task.phone_number.match(phoneno))){
        this.phoneNumberError = false;
        this.$store.dispatch("addTask", this.task);
      }else{
          this.phoneNumberError = true;
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddTaskStatus");
    },
  },
  created: function () {
    this.$store.dispatch("resetAddTaskStatus");
  },
  destroyed: function() {
      this.$store.dispatch("resetAddTask");
  }
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

</style>
