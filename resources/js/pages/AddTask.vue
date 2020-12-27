<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Task</span>
    </p>
    <div class="pt-2">
      <div class="flex flex-row gap-4">
        <div>
          <div class="form-control">
            <label>Full Name</label>
            <br />
            <input type="text" name="full-name" id="full-name" placeholder="Name" />
          </div>
          <div class="form-control">
            <label>Phone Number</label>
            <br />
            <input type="phone" name="phone-number" id="phone-number" placeholder="Phone Number" />
          </div>
          <div class="form-control">
            <label>Location</label>
            <br />
            <select name="location" id="role">
              <option value>Select Location</option>
              <option value="admin">Field</option>
              <option value="staff">Studio</option>
            </select>
          </div>
        </div>
        <div>
          <div class="form-control">
            <label>Total Price</label>
            <br />
            <input type="number" name="total-price" id="total-price" placeholder="Price" />
          </div>
          <div class="form-control">
            <label>Paid amount</label>
            <br />
            <input type="number" name="paid-amount" id="paid-amount" placeholder="Paid amount" />
          </div>
          <div class="form-control flex flex-row justify-between content-between w-96">
            <div class="w-44">
              <label for>Shot Date</label>
              <input
                type="date"
                name="shot-date"
                id="shot-date"
                placeholder="Shot Date"
                :value="today"
              />
            </div>
            <div class="w-44">
              <label for>Print Date</label>
              <input
                type="date"
                name="print-date"
                id="print-date"
                placeholder="Print Date"
                :value="today"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="form-control">
        <button class="btn-primary">
          <font-awesome-icon icon="plus" size="sm" />
          <span>Add Task</span>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      today: new Date().toISOString().slice(0, 10),
    };
  },
};
</script>
<style scoped>
.form-control input[type="date"] {
  @apply w-44;
}
</style>
