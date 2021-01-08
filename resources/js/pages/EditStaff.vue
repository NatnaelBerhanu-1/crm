<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Edit Staff</span>
    </p>
    <Alert
      type="success"
      message="User Updated Successfully"
      :onClose="onClose"
      v-if="editUserStatus == 'success'"
    />
    <Alert
      type="failure"
      :message="editUserError"
      v-else-if="editUserStatus == 'failure'"
      :onClose="onClose"
    />
    <form @submit.prevent="editUser" v-if="user.status == 200">
      <div class="pt-2 w-96">
        <div class="form-control w-full">
          <label for>Full Name</label>
          <br />
          <input type="text" v-model="user.data.data.name" id="full-name" placeholder="Name" required />
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
            v-model="user.data.data.phone_number"
            id="phone-number"
            placeholder="Phone Number"
            required
          />
        </div>
        <div class="form-control">
          <label for>Role</label>
          <br />
          <select v-model="user.data.data.role" id="role" required>
            <option value>Select role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
          </select>
        </div>
        <div class="form-control">
          <p class="text-red-500 text-sm">Default password: 1234</p>
        </div>
        <div class="form-control">
          <button type="submit" class="btn-primary" v-if="editUserStatus == 'busy'">
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Edit Staff</span>
          </button>
          <button type="submit" class="btn-primary" v-else>
            <font-awesome-icon icon="plus" size="sm" />
            <span>Edit Staff</span>
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
  data: function () {
    return {
      phoneNumberError: false,
    };
  },
  components: { Alert },
  computed: {
    editUserStatus: function () {
      return this.$store.getters.editUserStatus;
    },
    user: function () {
      return this.$store.getters.editUser;
    },
    editUserError: function() {
        return this.$store.getters.editUserError;
    }
  },
  created: function(){
      this.$store.dispatch("resetEditUserStatus");
      this.$store.dispatch("getSingleUser", this.$route.query.id);
  },
  methods: {
    editUser: function () {
      var phoneno = /^\d{10}$/;
      if (this.user.data.data.phone_number.match(phoneno)) {
        this.phoneNumberError = false;
        this.$store.dispatch("updateUser", this.user.data.data);
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
