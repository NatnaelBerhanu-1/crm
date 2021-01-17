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
    <form v-on:submit="addTask" method="post" v-if="users.status == 200">
      <div class="pt-2 w-full">
        <div class="grid w-full grid-cols-2 gap-4">
          <div class="w-full">
            <div class="form-control">
              <label>Full Name</label>
              <br />
              <input type="text" v-model="task.name" id="full-name" placeholder="Name" required />
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
              <label >Service <span class="text-red-500" v-if="task.services==null">this field is required</span></label>
              <br />
              <multiselect
                v-model="task.services"
                :options="services"
                :multiple="true"
                placeholder="Select Service"
                :closeOnSelect="false"
              ></multiselect>
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
              <label>Description</label>
              <br />
              <input
                type="text"
                v-model="task.description"
                id="description"
                placeholder="Description"
                required
              />
            </div>
            <div class="form-control">
              <label>Data Location</label>
              <br />
              <input
                type="text"
                v-model="task.data_location"
                id="data_location"
                placeholder="Data Location"
              />
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
            <div class="form-control">
              <label for>Assign Staff <span class="text-red-500" v-if="staffValues==null">this field is required</span></label>
              <br />
              <multiselect
                v-model="staffValues"
                :options="users.data.data"
                class="h-9 mt-1"
                :multiple="true"
                placeholder="Assign Staffs"
                :closeOnSelect="false"
                track-by="id"
                label="name"
              ></multiselect>
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
            <div class="form-control">
              <label>Selection Date</label>
              <br />
              <input type="date" v-model="task.selection_date" id="selection_date" required />
            </div>
            <div class="grid grid-cols-2 gap-4 py-2">
              <div>
                <label>Shot Date</label>
                <input
                  type="datetime-local"
                  v-model="task.shot_date"
                  id="shot-date"
                  placeholder="Shot Date"
                  required
                />
              </div>
              <div>
                <label for>Delivery Date</label>
                <input
                  type="datetime-local"
                  v-model="task.delivery_date"
                  id="delivery-date"
                  placeholder="Delivery Date"
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
              <textarea
                v-model="task.remark"
                id="remark"
                class="w-full h-28"
                rows="4"
                placeholder="remark"
              ></textarea>
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
    <div class="text-center text-primary" v-else>
      <font-awesome-icon icon="spinner" spin size="lg" />
    </div>
  </div>
</template>
<script>
import Alert from "../components/Alert";
import Multiselect from "vue-multiselect";

export default {
  components: {
    Alert,
    Multiselect,
  },
  data: function () {
    return {
      today: new Date().toISOString(),
      phoneNumberError: false,
      staffValues: null
    };
  },
  computed: {
    addTaskStatus: function () {
      console.log(this.$store.getters.addTaskStatus);
      return this.$store.getters.addTaskStatus;
    },
    users: function () {
      return this.$store.getters.users;
    },
    task: function () {
      return this.$store.getters.addTask;
    },
    services: function() {
        return this.$store.getters.services;
    }
  },
  methods: {
    addTask: function (e) {
      console.log(this.value);
      e.preventDefault();
      var phoneno = /^\d{10}$/;
      if (this.staffValues==null || this.task.services == null){
          alert("fill all the required fields");
          return;
      }
      if (this.task.phone_number.match(phoneno)) {
        this.phoneNumberError = false;
        this.staffValues.forEach(staff => {
            this.task.staffs.push(staff.id);
        });
        console.log(this.task);
        this.$store.dispatch("addTask", this.task).then(()=>{
            this.staffValues = null;
        });
      } else {
        this.phoneNumberError = true;
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddTaskStatus");
    },
  },
  created: function () {
    this.$store.dispatch("resetAddTaskStatus");
    this.$store.dispatch("getUsers", {only: "staff"});
  },
  destroyed: function () {
    this.$store.dispatch("resetAddTask");
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.form-control {
  @apply w-full h-20;
}
.form-control input,
.form-control select {
  @apply w-full;
}
</style>
