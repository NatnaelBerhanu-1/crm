<template>
  <div class="w-screen h-screen flex justify-center items-center full-bg">
    <div
      class="w-96 h-96 mx-auto my-auto bg-white text-center border rounded-sm flex flex-col justify-center items-center"
    >
      <div class="w-20 mx-auto">
        <h1 class="text-3xl font-bold">Login</h1>
        <div class="h-2 bg-primary mt-2 rounded"></div>
      </div>
      <div class="rounded my-2 w-64 bg-red-500 bg-opacity-20 text-red-500 py-2 border border-red-500" v-if="loginStatus == 'failed'">
          Authentication Failed
      </div>
      <form class="pb-2" v-on:submit.prevent="login" >
        <div class="form-control">
          <label for="phone-number">Phone Number</label>
          <br />
          <input
            type="phone"
            v-model="phoneNumber"
            id="phone-number"
            data-cy="login-phone-number"
            @input="validatePhoneNumber"
            required
          />
          <br />
          <span
            class="text-red-500 text-sm ml-2 font-normal"
            v-if="phoneNumberError"
          >{{phoneNumberError}}</span>
        </div>
        <div class="form-control">
          <label for="phone-number">Password</label>
          <br />
          <input type="password" v-model="password" id="password" required data-cy="login-password"/>
        </div>
        <div class="form-control mt-2">
          <button
            type="submit"
            class="bg-primary w-64 h-9 text-white rounded-full"
            disabled
            data-cy="login-submit"
            v-if="loginStatus == 'busy'"
          >
            <font-awesome-icon icon="spinner" class="mr-2" spin />Login
          </button>
          <button type="submit" class="bg-primary w-64 h-9 text-white rounded-full" v-else>Login</button>
          <br><span
            class="text-red-500 text-sm ml-2 font-normal"
            v-if="loginError"
          >{{loginError}}</span>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import Axios from 'axios';

export default {
  data: () => {
    return {
      loginStatus: "",
      phoneNumber: "",
      password: "",
      phoneNumberError: null,
      loginError: null
    };
  },
  methods: {
    login: function (e) {
      //validation
      var phoneno = /^\d{10}$/;
      if (this.phoneNumber.match(phoneno)) {
        this.loginStatus = "busy";
        Axios.post("/api/login", {
          phone_number: this.phoneNumber,
          password: this.password,
        }).then((response) => {
          if (response.status == 200) {
              console.log(JSON.stringify( response.data.data));
            this.loginStatus = 'success';
            localStorage.setItem("user", JSON.stringify(response.data.data).toString());
            alert(response.data.data);
            this.$router.push('/dashboard').catch(() => {});
          }
        }).catch(error => {
            this.loginStatus = 'failed';
            this.loginFailed = 'Authenticaton failed, try again';
        });
      } else {
        this.phoneNumberError = "Invalid phone number";
      }
    },
    validatePhoneNumber: function () {
      var phoneno = /^\d{10}$/;
      if (this.phoneNumber.match(phoneno)) {
        this.phoneNumberError = null;
      } else {
        this.phoneNumberError = "Invalid phone number";
      }
    },
  },
};
</script>
<style scoped>
.form-control input {
  @apply w-64 rounded-full text-center;
}

.form-control label {
  @apply font-light;
}
.full-bg {
  background-image: url("/images/crm_bg_login.jpg");
}
</style>
