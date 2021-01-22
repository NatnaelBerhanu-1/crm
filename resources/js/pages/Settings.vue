<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="cog" />
      <span class="pl-2">Settings</span>
    </p>
    <Alert
      type="success"
      :message="changePasswordMessage"
      :onClose="onClose"
      v-if="changePasswordStatus == 'success'"
    />
    <Alert
      type="failure"
      :message="changePasswordMessage"
      v-else-if="changePasswordStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="mt-2">
      <div class="flex flex-row justify-between w-96">
        <p class="mb-2">Change Password</p>
        <font-awesome-icon
          class="text-primary"
          :icon="!showPassword ? 'eye':'eye-slash'"
          @click="showPassword=!showPassword"
        />
      </div>
      <div class="px-2 pb-2 w-96 border">
        <form @submit.prevent="changePassword">
          <div class="form-control">
            <label>Old Password</label>
            <br />
            <input
              :type="showPassword ? 'text':'password'"
              v-model="old_password"
              id="old-password"
              placeholder="Old Password"
              required
            />
          </div>
          <div class="form-control">
            <label>
              New Password
              <span class="text-red-500" v-if="newPasswordError">{{npe}}</span>
            </label>
            <br />
            <input
              :type="showPassword ? 'text':'password'"
              v-model="new_password"
              id="new-password"
              placeholder="New Password"
              required
            />
          </div>
          <div class="form-control">
            <label>
              Confirm New Password
              <span
                class="text-red-500"
                v-if="confirmPasswordError"
              >password don't match</span>
            </label>
            <br />
            <input
              :type="showPassword ? 'text':'password'"
              v-model="confirm_password"
              id="confirm-password"
              placeholder="Confirm New Password"
              required
            />
          </div>
          <div class="form-control">
            <p class="text-red-500 text-sm">default password: 1234</p>
          </div>
          <div class="form-control">
            <button class="btn-primary" disabled v-if="changePasswordStatus=='busy'">
              <font-awesome-icon icon="spinner" spin size="sm" />
              <span>Change Password</span>
            </button>
            <button class="btn-primary" v-else>
              <font-awesome-icon icon="check" size="sm" />
              <span>Change Password</span>
            </button>
          </div>
        </form>
      </div>
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
      old_password: null,
      new_password: null,
      confirm_password: null,
      confirmPasswordError: false,
      newPasswordError: false,
      npe: "",
      showPassword: false,
    };
  },
  computed: {
    changePasswordStatus: function () {
      return this.$store.getters.changePasswordStatus;
    },
    changePasswordMessage: function () {
      return this.$store.getters.changePasswordMessage;
    },
  },
  methods: {
    changePassword: function () {
      this.confirmPasswordError = false;
      this.newPasswordError = false;
      this.npe = "";
      if (this.new_password.length >= 4) {
        if (this.new_password === this.confirm_password) {
          if (this.new_password != this.old_password) {
            this.$store.dispatch("changePassword", {
              old_password: this.old_password,
              new_password: this.new_password,
            });
          } else {
            this.newPasswordError = true;
            this.npe = "new password is similar to old password";
          }
        } else {
          this.confirmPasswordError = true;
        }
      } else {
        this.newPasswordError = true;
        this.npe = "minimum password length is 4";
      }
    },
    onClose: function () {
      this.$store.dispatch("resetChangePasswordStatus");
    },
  },
  created: function () {
    this.$store.dispatch("resetChangePasswordStatus");
  },
};
</script>
<style scoped>
.form-control input {
  width: 100%;
}
</style>
