<template>
  <div class="page-container">
    <div class="flex flex-row justify-between">
      <p class="title">
        <font-awesome-icon icon="camera" />
        <span class="pl-2">Inventory</span>
      </p>
      <router-link to="add" append>
        <div class="bg-primary h-8 text-white px-2 rounded text-sm flex flex-row items-center">
          <font-awesome-icon icon="plus" size="sm" />
          <span class="pl-2">Add Item</span>
        </div>
      </router-link>
    </div>
    <Alert
      type="success"
      message="Inventory Deleted Successfully"
      :onClose="onClose"
      v-if="deleteItemStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Deleting Inventory"
      v-else-if="deleteItemStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="mt-2 bg-white" v-if="items.status == 200">
      <table class="w-full">
        <thead>
          <tr class="text-black">
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Location</th>
            <th>Condition</th>
            <th>Remarks</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items.data.data.data" :key="item.id">
            <td>{{item.name}}</td>
            <td>{{item.description}}</td>
            <td>{{item.price}}</td>
            <td>{{item.location}}</td>
            <td>{{item.condition}}</td>
            <td>{{item.remark}}</td>
            <td class="w-20">{{parseDate(item.created_at)}}</td>
            <td class="text-gray-300">
              <router-link :to="`edit?id=${item.id}`" append>
                <font-awesome-icon
                  icon="pencil-alt"
                  class="mr-2 hover:text-blue-400 cursor-pointer"
                />
              </router-link>
              <div data-cy="deleteInventory">
                  
              <font-awesome-icon
                icon="trash"
                v-on:click="deleteItem(item.id)"
                class="hover:text-red-400 cursor-pointer"
              />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :data="{prev_page_url:{page: items.data.data.prev_page_url}, next_page_url:{page: items.data.data.next_page_url}, cur_page:items.data.data.current_page, total_page:items.data.data.last_page, get: 'getItems'}"
      ></Pagination>
    </div>
    <div v-else class="text-center text-primary">
      <font-awesome-icon icon="spinner" spin size="2x" />
    </div>
  </div>
</template>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}
</style>
<script>
import Alert from "../components/Alert";
import helperMixin from "../mixins/helper";
import Pagination from "../components/Pagination";

export default {
  components: {
    Alert,
    Pagination,
  },
  mixins: [helperMixin],
  computed: {
    items: function () {
      return this.$store.getters.items;
    },
    deleteItemStatus: function () {
      return this.$store.getters.deleteItemStatus;
    },
  },
  methods: {
    deleteItem: function (itemId) {
      var resp = confirm("Do you want to delete this item?");
      if (resp) {
        this.$store.dispatch("deleteItem", itemId);
      }
    },
    onClose: function (e) {
      this.$store.dispatch("resetDeleteItemStatus");
    },
  },
  created: function () {
    this.$store.dispatch("resetDeleteItemStatus");
    this.$store.dispatch("getItems");
  },
};
</script>
