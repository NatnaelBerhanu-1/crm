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

    <form v-on:submit="editTask" method="post" v-if="task.status == 200 && users.status == 200">
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
                <option value="field">Field</option>
                <option value="studio">Studio</option>
                <option value="event">Event</option>
                <option value="studio/landscape">Studio/Landscape</option>
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
              <label >Service <span class="text-red-500" v-if="servicesError">this field is required</span></label>
              <br />
              <multiselect
                v-model="task.data.data.service"
                :options="services"
                :multiple="true"
                placeholder="Select Service"
                :closeOnSelect="false"
              ></multiselect>
            </div>
            <div class="form-control">
              <label>Package</label>
              <br />
              <select v-model="task.data.data.package" id="role" v-on:change="packageChanged" required>
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
                v-model="task.data.data.description"
                id="full-name"
                placeholder="Description"
                required
              />
            </div>
            <div class="form-control">
              <label>Data Location</label>
              <br />
              <input
                type="text"
                v-model="task.data.data.data_location"
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
                v-model="task.data.data.quantity"
                id="full-name"
                placeholder="Quantity"
                required
              />
            </div>
            <div class="form-control">
              <label for>Assign Staff <span class="text-red-500" v-if="staffError">this field is required</span></label>
              <br />
              <multiselect
                v-model="task.data.data.staffs"
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
            <div class="form-control">
              <label>Selection Date</label>
              <br />
              <input type="date" v-model="task.data.data.selection_date" id="selection_date" required />
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
                <label for>Delivery Date</label>
                <input
                  type="datetime-local"
                  v-model="delivery_date"
                  id="delivery-date"
                  placeholder="Delivery Date"
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
                class="w-full"
                rows="4"
                placeholder="remark"
              ></textarea>
            </div>
            <div class="form-control">
              <label for>Tax</label>
              <div class="flex gap-4">
                <div class="flex content-center items-center">
                  <input type="radio" v-model="task.data.data.tax" value="true" class="w-auto" id="tax-yes" />
                  <label for="tax-yes" class="pl-2">yes</label>
                </div>
                <div class="flex content-center items-center">
                  <input type="radio" v-model="task.data.data.tax" value="false" class="w-auto" id="tax-no" />
                  <label for="tax-no" class="pl-2">no</label>
                </div>
              </div>
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
import multiselect from "vue-multiselect";

export default {
  components: {
    Alert, multiselect
  },
  data: function () {
    return {
        phoneNumberError: false,
        servicesError: false,
        staffError: false,
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
    users: function () {
      return this.$store.getters.users;
    },
    editTaskStatus: function () {
      console.log(this.$store.getters.addTaskStatus);
      return this.$store.getters.editTaskStatus;
    },
    task: function () {
      return this.$store.getters.editTask;
    },
    services: function() {
        return this.$store.getters.services;
    },
    shot_date: {
      get() {
        return this.parseDateTime(this.task.data.data.shot_date);
      },
      set(newDate) {
        this.task.data.data.shot_date = newDate;
      },
    },
    delivery_date: {
      get() {
        return this.parseDateTime(this.task.data.data.delivery_date);
      },
      set(newDate) {
        this.task.data.data.delivery_date = newDate;
      },
    },
  },
  methods: {
    editTask: function (e) {
      e.preventDefault();
      console.log(this.task);
      var phoneno = /^\d{10}$/;
      if (this.task.data.data.service.length == 0 || this.task.data.data.staffs.length == 0){
          if(this.task.data.data.service.length == 0) this.servicesError = true;
          if(this.task.data.data.staffs.length == 0) this.staffError = true;
          alert("fill all the required fields");
          return;
      }
      this.servicesError = false;
      this.staffError = false;
      if (this.task.data.data.phone_number.match(phoneno)){
        this.phoneNumberError = false;
        var staffs = [];
        this.task.data.data.staffs.forEach(staff => {
            staffs.push(staff.id);
        });
        if (this.task.data.data.desc_for_contract) {
            console.log("here");
        }else{
            this.packageChanged();
        }
        console.log(this.task.data.data.desc_for_contract);
        console.log(this.task.data.data.remark);
        var data = Object.assign({}, this.task.data.data);
        data.staffs = staffs;
        console.log(data);
        console.log(this.task.data.data);
        console.log(this.task.data.data.desc_for_contract);

        this.$store.dispatch("updateTask", data);
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
    packageChanged: function (e) {
      console.log(this.task.data.data.package);
      var index;
      switch (this.task.data.data.package) {
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
      console.log(index);
      this.task.data.data.remark = this.packageDescriptions[index];
      this.task.data.data.desc_for_contract = this.packageDescriptionsForContract[index];
    },
  },
  created: function () {
    this.$store.dispatch("resetEditTaskStatus");
    this.$store.dispatch("getSingleTask", this.$route.query.id);
    this.$store.dispatch("getUsers", {only: "staff"});
  },
};
</script>
<style scoped>
.form-control {
  @apply w-full h-20;
}
.form-control input,
.form-control select {
  @apply w-full;
}

.form-control input[type="radio"] {
  @apply w-4;
}
</style>
