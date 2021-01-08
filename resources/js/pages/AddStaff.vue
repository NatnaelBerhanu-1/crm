<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Staff</span>
    </p>
    <Alert
      type="success"
      message="User Added Successfully"
      :onClose="onClose"
      v-if="addUserStatus == 'success'"
    />
    <Alert
      type="failure"
      :message="addUserError"
      v-else-if="addUserStatus == 'failure'"
      :onClose="onClose"
    />
    <form @submit.prevent="addUser">
      <div class="pt-2 w-96">
        <div class="form-control w-full">
          <label for>Full Name</label>
          <br />
          <input type="text" v-model="user.name" id="full-name" placeholder="Name" required />
        </div>
        <div class="form-control">
          <label for>
            Phone Number
            <span
              class="text-red-500 text-sm ml-2 font-normal"
              v-if="phoneNumberError"
            >phone number invalid</span>
          </label>
          <br />
          <input
            type="phone"
            v-model="user.phone_number"
            id="phone-number"
            placeholder="Phone Number"
            required
          />
        </div>
        <div class="form-control">
          <label for>Role</label>
          <br />
          <select v-model="user.role" id="role" required>
            <option value>Select role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
          </select>
        </div>
        <div class="form-control">
          <p class="text-red-500 text-sm">Default password: 1234</p>
        </div>
        <div class="form-control">
          <button type="submit" class="btn-primary" v-if="addUserStatus == 'busy'">
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Add Staff</span>
          </button>
          <button type="submit" class="btn-primary" v-else>
            <font-awesome-icon icon="plus" size="sm" />
            <span>Add Staff</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Alert from "../components/Alert";
export default {
  data: function () {
    return {
      phoneNumberError: false,
    };
  },
  components: { Alert },
  computed: {
    addUserStatus: function () {
      return this.$store.getters.addUserStatus;
    },
    user: function () {
      return this.$store.getters.addUser;
    },
    addUserError: function() {
        return this.$store.getters.addUserError;
    }
  },
  methods: {
    addUser: function () {
      var phoneno = /^\d{10}$/;
      if (this.user.phone_number.match(phoneno)) {
        this.phoneNumberError = false;
        this.$store.dispatch("addUser", this.user);
      } else {
        this.phoneNumberError = true;
      }
    },
    onClose: function () {
      this.$store.dispatch("resetAddUserStatus");
    },
  },
};
</script>
<style scoped>
.form-control input,
.form-control select {
  @apply w-full;
}
</style>
