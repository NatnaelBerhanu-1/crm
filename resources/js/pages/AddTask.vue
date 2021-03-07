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
                <option value="field">Field</option>
                <option value="studio">Studio</option>
                <option value="event">Event</option>
                <option value="studio/landscape">Studio/Landscape</option>
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
              <label>
                Service
                <span class="text-red-500" v-if="task.service==null">this field is required</span>
              </label>
              <br />
              <multiselect
                v-model="task.service"
                :options="services"
                :multiple="true"
                placeholder="Select Service"
                :closeOnSelect="false"
              ></multiselect>
            </div>
            <div class="form-control">
              <label>Package</label>
              <br />
              <select v-model="task.package" id="package" v-on:change="packageChanged" required>
                <option selected value>Select Package</option>
                <option value="platinum">Platinum Package</option>
                <option value="gold">Gold package</option>
                <option value="silver">Silver package</option>
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
              />
            </div>
            <div class="form-control">
              <label for>
                Assign Staff
                <span
                  class="text-red-500"
                  v-if="staffValues==null"
                >this field is required</span>
              </label>
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
              <label for>Tax</label>
              <div class="flex gap-4">
                <div class="flex content-center items-center">
                  <input type="radio" v-model="task.tax" value="true" class="w-auto" id="tax-yes" />
                  <label for="tax-yes" class="pl-2">yes</label>
                </div>
                <div class="flex content-center items-center">
                  <input type="radio" v-model="task.tax" value="false" class="w-auto" id="tax-no" />
                  <label for="tax-no" class="pl-2">no</label>
                </div>
              </div>
            </div>
            <div class="form-control">
              <label for>Package Description</label>
              <textarea
                v-model="task.remark"
                id="remark"
                class="w-full"
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
      staffValues: null,
      packageDescriptions: [
        `
        • Studio: 45 x 60, 30-page laminated album
        • Landscape: 30 x 90, 30-page laminated album
        • Landscape video 10 – 12 minutes
        • Photo:
        o 1 - 60 x 120 with matte frame
        o 1 - 50 x 80 Photo + board frame
        o 2 – 30 x 45 Photo + board frame
        o 500 thank you card
        o 2 mini album (15 x 30) 20 page
        o 2 signboards + softcopy
        • Bridal Photo
        o 20 x 25, 22 pages laminated + video by 1 camera man
        • Wedding day
        o Photo - 40 x 60, 40 pages laminated album with leather cover (by 2 camera man)
        o Video – by 3 or 4 camera man + GoPro + Drone with full HD
        • Melse (መልስ)
        o Photo – 45 x 60, 30 pages laminated album
        o Video – by 2 camera man + drone with editing
        • Kelkel (ቅልቅል)
        o Photo – 30 x 60, 22 pages laminated album
        o Video – by 2 camera man with editing
        • Enshoshula (እንሾሽላ)
        o Photo – 40 x 60, 30 pages
        o Video – by 2 camera man with editing
        • Soft copy of all photos and videos will be provide with 2 hard disk copies
          `,
        `
        • Studio: 40 x 60, 22 pages laminated album
        • Landscape: 30 x 90, 22 pages laminated album
        • Landscape video: 8 – 12 minutes video
        • Photo:
        o 2 – 50 x 80 photo + board frame
        o 2 – 30 x 45 photo + board frame
        o 2 - 20 pages mini album (15 x 30)
        o 400 thank you card
        o 2 signboards + soft copy
        • Bridal Photo: 20 x 25, 22 pages
        • Wedding day
        o Photo – 45 x 60, 30 pages laminated album by 2 camera man
        o Video – by 3 camera man full HD with editing
        • Melse (መልስ)
        o Photo - 45 x 60, 30 pages laminated album
        o Video – by 2 camera man + drone
        • Kelkel (ቅልቅል)
        o Photo – 30 x 60, 22 pages laminated album
        o Video by 1 camera man
        `,
        `
        • Studio: 40 x 60, 22 pages laminated album
        • Landscape: 30 x 90, 22 pages laminated album
        • Photo:
        o 2 – 50 x 80 photo + frame board
        o 2 - 30 x 45 photo + frame board
        o 1 signboard
        o 1 mini album (15 x 30) 20 pages
        o 300 thank you card
        • Bridal photo (20 x 25)
        • Wedding day
        o Photo – 45 x 60, 30 pages laminated album
        o Video – by 3 camera man + drone full HD with editing
        • Melse (መልስ)
        o Photo – 45 x 60, 30 pages laminated album
        o Video – by 2 camera man full HD with editing
        `,
      ],
      packageDescriptionsForContract: [
        `
        • Studio: 45 x 60, 30-page laminated album<w:br/>
        • Landscape: 30 x 90, 30-page laminated album<w:br/>
        • Landscape video 10 – 12 minutes<w:br/>
        • Photo:<w:br/>
        o 1 - 60 x 120 with matte frame<w:br/>
        o 1 - 50 x 80 Photo + board frame<w:br/>
        o 2 – 30 x 45 Photo + board frame<w:br/>
        o 500 thank you card<w:br/>
        o 2 mini album (15 x 30) 20 page<w:br/>
        o 2 signboards + softcopy<w:br/>
        • Bridal Photo<w:br/>
        o 20 x 25, 22 pages laminated + video by 1 camera man<w:br/>
        • Wedding day<w:br/>
        o Photo - 40 x 60, 40 pages laminated album with leather cover (by 2 camera man)<w:br/>
        o Video – by 3 or 4 camera man + GoPro + Drone with full HD<w:br/>
        • Melse (መልስ)<w:br/>
        o Photo – 45 x 60, 30 pages laminated album<w:br/>
        o Video – by 2 camera man + drone with editing<w:br/>
        • Kelkel (ቅልቅል)<w:br/>
        o Photo – 30 x 60, 22 pages laminated album<w:br/>
        o Video – by 2 camera man with editing<w:br/>
        • Enshoshula (እንሾሽላ)<w:br/>
        o Photo – 40 x 60, 30 pages<w:br/>
        o Video – by 2 camera man with editing<w:br/>
        • Soft copy of all photos and videos will be provide with 2 hard disk copies
          `,
        `
        • Studio: 40 x 60, 22 pages laminated album<w:br/>
        • Landscape: 30 x 90, 22 pages laminated album<w:br/>
        • Landscape video: 8 – 12 minutes video<w:br/>
        • Photo:<w:br/>
        o 2 – 50 x 80 photo + board frame<w:br/>
        o 2 – 30 x 45 photo + board frame<w:br/>
        o 2 - 20 pages mini album (15 x 30)<w:br/>
        o 400 thank you card<w:br/>
        o 2 signboards + soft copy<w:br/>
        • Bridal Photo: 20 x 25, 22 pages<w:br/>
        • Wedding day<w:br/>
        o Photo – 45 x 60, 30 pages laminated album by 2 camera man<w:br/>
        o Video – by 3 camera man full HD with editing<w:br/>
        • Melse (መልስ)<w:br/>
        o Photo - 45 x 60, 30 pages laminated album<w:br/>
        o Video – by 2 camera man + drone<w:br/>
        • Kelkel (ቅልቅል)<w:br/>
        o Photo – 30 x 60, 22 pages laminated album<w:br/>
        o Video by 1 camera man
        `,
        `
        • Studio: 40 x 60, 22 pages laminated album<w:br/>
        • Landscape: 30 x 90, 22 pages laminated album<w:br/>
        • Photo:<w:br/>
        o 2 – 50 x 80 photo + frame board<w:br/>
        o 2 - 30 x 45 photo + frame board<w:br/>
        o 1 signboard<w:br/>
        o 1 mini album (15 x 30) 20 pages<w:br/>
        o 300 thank you card<w:br/>
        • Bridal photo (20 x 25)<w:br/>
        • Wedding day<w:br/>
        o Photo – 45 x 60, 30 pages laminated album<w:br/>
        o Video – by 3 camera man + drone full HD with editing<w:br/>
        • Melse (መልስ)<w:br/>
        o Photo – 45 x 60, 30 pages laminated album<w:br/>
        o Video – by 2 camera man full HD with editing<w:br/>
        `,
      ],
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
    services: function () {
      return this.$store.getters.services;
    },
  },
  methods: {
    addTask: function (e) {
      console.log(this.value);
      e.preventDefault();
      var phoneno = /^\d{10}$/;
      if (this.staffValues == null || this.task.service == null) {
        alert("fill all the required fields");
        return;
      }
      if (this.task.phone_number.match(phoneno)) {
        this.phoneNumberError = false;
        this.staffValues.forEach((staff) => {
          this.task.staffs.push(staff.id);
        });
        console.log(this.task);
        this.$store.dispatch("addTask", this.task).then(() => {
          this.staffValues = null;
        });
      } else {
        this.phoneNumberError = true;
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddTaskStatus");
    },
    packageChanged: function (e) {
      console.log(this.task.package);
      var index;
      switch (this.task.package) {
        case "platinum":
          index = 0;
          break;
        case "gold":
          index = 1;
          break;
        case "silver":
          index = 2;
          break;
        default:
          break;
      }
      this.task.remark = this.packageDescriptions[index];
      this.task.desc_for_contract = this.packageDescriptionsForContract[index];
    },
  },
  created: function () {
    this.$store.dispatch("resetAddTaskStatus");
    this.$store.dispatch("getUsers", { only: "staff" });
  },
  destroyed: function () {
    this.$store.dispatch("resetAddTask");
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

.form-control input{
  @apply w-full h-10;
}

.form-control textarea{
    @apply h-20;
    resize: none;
}

.form-control input,
.form-control select {
  @apply w-full;
}

.form-control input[type="radio"] {
  @apply w-4;
}
</style>
