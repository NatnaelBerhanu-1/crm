<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Edit Inventory</span>
    </p>
    <Alert
      type="success"
      message="Inventory Updated Successfully"
      :onClose="onClose"
      v-if="editItemStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed Updating inventory"
      v-else-if="editItemStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="pt-2 w-96" v-if="item.status == 200">
      <form action v-on:submit="editItem" method="post">
        <div class="form-control">
          <label>Name</label>
          <br />
          <input type="text" v-model="item.data.data.name" id="name" placeholder="Name" required />
        </div>
        <div class="form-control">
          <label>Description</label>
          <br />
          <input
            type="text"
            v-model="item.data.data.description"
            id="description"
            placeholder="Description"
            required
          />
        </div>
        <div class="form-control">
          <label>Price</label>
          <br />
          <input type="number" v-model="item.data.data.price" id="price" min="0" placeholder="Price" required />
        </div>
        <div class="form-control">
          <label>Location</label>
          <br />
          <input type="text" v-model="item.data.data.location" id="location" placeholder="Location" required />
        </div>
        <div class="form-control">
          <label>Condition</label>
          <br />
          <input
            type="text"
            v-model="item.data.data.condition"
            id="condition"
            placeholder="Condition"
            required
          />
        </div>
        <div class="form-control">
          <label>Remarks</label>
          <br />
          <textarea v-model="item.data.data.remark" id="remark" placeholder="Remark"></textarea>
        </div>
        <div class="form-control" v-if="editItemStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Save</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Save</span>
          </button>
        </div>
      </form>
    </div>
    <div v-else class="text-center text-primary">
      <font-awesome-icon icon="spinner" spin size="2x" />
    </div>
  </div>
</template>
<style scoped>
.form-control input,
.form-control textarea {
  @apply w-full;
}
</style>
<script>
import Alert from "../components/Alert";

export default {
  components: {
    Alert,
  },
  computed: {
    editItemStatus: function () {
      return this.$store.getters.editItemStatus;
    },
    item: function () {
      return this.$store.getters.editItem;
    },
  },
  methods: {
    editItem: function (e) {
      e.preventDefault();
      console.log(this.item.data.data);
      this.$store.dispatch("updateItem", this.item.data.data);
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddItemStatus");
    },
  },
  created: function() {
      this.$store.dispatch("resetEditItemStatus");
      this.$store.dispatch("getSingleItem", this.$route.query.id);
  }
};
</script>
