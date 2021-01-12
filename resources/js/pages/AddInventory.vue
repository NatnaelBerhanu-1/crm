<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Inventory</span>
    </p>
    <Alert
      type="success"
      message="Inventory Added Successfully"
      :onClose="onClose"
      v-if="addItemStatus == 'success'"
    />
    <Alert
      type="failure"
      message="Failed adding inventory"
      v-else-if="addItemStatus == 'failure'"
      :onClose="onClose"
    />
    <div class="pt-2 w-96">
      <form action v-on:submit="addItem" method="post">
        <div class="form-control">
          <label>Name</label>
          <br />
          <input type="text" v-model="item.name" id="name" placeholder="Name" required />
        </div>
        <div class="form-control">
          <label>Description</label>
          <br />
          <input
            type="text"
            v-model="item.description"
            id="description"
            placeholder="Description"
            required
          />
        </div>
        <div class="form-control">
          <label>Price</label>
          <br />
          <input type="number" v-model="item.price" id="price" min="0" placeholder="Price" required />
        </div>
        <div class="form-control">
          <label>Location</label>
          <br />
          <input type="text" v-model="item.location" id="location" placeholder="Location" required />
        </div>
        <div class="form-control">
          <label>Condition</label>
          <br />
          <input
            type="text"
            v-model="item.condition"
            id="condition"
            placeholder="Condition"
            required
          />
        </div>
        <div class="form-control">
          <label>Remarks</label>
          <br />
          <textarea v-model="item.remark" id="remark" placeholder="Remark"></textarea>
        </div>
        <div class="form-control" v-if="addItemStatus=='busy'">
          <button type="submit" class="btn-primary" disabled>
            <font-awesome-icon icon="spinner" spin size="sm" />
            <span>Add Inventory</span>
          </button>
        </div>
        <div class="form-control" v-else>
          <button class="btn-primary">
            <font-awesome-icon icon="plus" size="sm" />
            <span>Add Inventory</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped>
.form-control input,
.form-control textarea {
  @apply w-full;
}

.form-control textarea {
  @apply h-24;
}
</style>
<script>
import Alert from "../components/Alert";

export default {
  components: {
    Alert,
  },
  computed: {
    addItemStatus: function () {
      return this.$store.getters.addItemStatus;
    },
    item: function () {
      return this.$store.getters.addItem;
    },
  },
  methods: {
    addItem: function (e) {
      e.preventDefault();
      console.log(this.item);
      this.$store.dispatch("addItem", this.item);
    },
    onClose: function (e) {
      this.$store.dispatch("resetAddItemStatus");
    },
  },
};
</script>
