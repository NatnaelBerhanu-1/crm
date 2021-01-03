<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="plus" />
      <span class="pl-2">Add Staff</span>
    </p>
    <div class="pt-2">
      <div class="form-control">
        <label for>Full Name</label>
        <br />
        <input type="text" name="full-name" id="full-name" placeholder="Name" />
      </div>
      <div class="form-control">
        <label for>Phone Number</label>
        <br />
        <input type="phone" name="phone-number" id="phone-number" placeholder="Phone Number" />
      </div>
      <div class="form-control">
        <label for>Role</label>
        <br />
        <select name="role" id="role">
          <option value>Select role</option>
          <option value="admin">Admin</option>
          <option value="staff">Staff</option>
        </select>
      </div>
      <div class="form-control">
        <p class="text-red-500 text-sm">Default password: 1234</p>
      </div>
      <div class="form-control">
        <button class="btn-primary">
          <font-awesome-icon icon="plus" size="sm" />
          <span>Add Staff</span>
        </button>
      </div>
    </div>
  </div>
</template>
<style>
</style>
