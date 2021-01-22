<template>
  <div class="page-container">
    <div class="flex flex-row justify-between">
      <p class="title">
        <font-awesome-icon icon="id-card" />
        <span class="pl-2">Staff</span>
      </p>
      <router-link to="add" append>
        <div class="bg-primary h-8 text-white px-2 rounded text-sm flex flex-row items-center">
          <font-awesome-icon icon="plus" size="sm" />
          <span class="ml-1">Add Staff</span>
        </div>
      </router-link>
    </div>
    <Alert
      type="success"
      message="Staff Deleted Successfully"
      :onClose="onClose"
      v-if="deleteUserStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Deleting Staff"
      v-else-if="deleteUserStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="mt-2 bg-white">
      <table class="w-full" v-if="users.status == 200">
        <thead>
          <tr class="text-black">
            <th>Name</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Created At</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data.data" :key="user.id">
            <td>{{user.name}}</td>
            <td>{{user.phone_number}}</td>
            <td>{{user.role}}</td>
            <td class="w-64 px-2">{{parseDate(user.created_at)}}</td>
            <td class="text-gray-300">
              <router-link :to="`edit?id=${user.id}`" append>
                <font-awesome-icon
                  icon="pencil-alt"
                  class="mr-2 hover:text-blue-400 cursor-pointer"
                />
              </router-link>
              <font-awesome-icon
                icon="trash"
                class="hover:text-red-400 cursor-pointer"
                @click="deleteUser(user.id)"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-center text-primary" v-else>
        <font-awesome-icon icon="spinner" spin size="2x" />
      </div>
    </div>
  </div>
</template>
<script>
import helperMixin from "../mixins/helper";
import Alert from "../components/Alert";

export default {
  components: { Alert },
  mixins: [helperMixin],
  computed: {
    users: function () {
      return this.$store.getters.users;
    },
    deleteUserStatus: function () {
      return this.$store.getters.deleteUserStatus;
    },
  },
  created: function () {
    this.$store.dispatch("resetDeleteUserStatus");
    this.$store.dispatch("getUsers");
  },
  methods: {
    deleteUser: function (userId) {
      var resp = confirm("Do you want to remove this user?");
      if (resp) this.$store.dispatch("deleteUser", userId);
      console.log(userId);
    },
    onClose: function () {
      this.$store.dispatch("resetDeleteUserStatus");
    },
  },
};
</script>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}
</style>
