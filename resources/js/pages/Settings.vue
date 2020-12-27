<template>
  <div class="page-container">
    <p class="title">
      <font-awesome-icon icon="cog" />
      <span class="pl-2">Settings</span>
    </p>
    <div class="mt-2">
        <p class="mb-2">Change Password</p>
      <div class="px-2 pb-2 w-min border">
        <div class="form-control">
          <label for>Old Password</label>
          <br />
          <input type="text" name="old-password" id="old-password" placeholder="Old Password" />
        </div>
        <div class="form-control">
          <label for>New Password</label>
          <br />
          <input type="phone" name="new-password" id="old-password" placeholder="New Password" />
        </div>
        <div class="form-control">
          <label for>Confirm New Password</label>
          <br />
          <input
            type="phone"
            name="confirm-password"
            id="confirm-password"
            placeholder="Confirm New Password"
          />
        </div>
        <div class="form-control">
          <p class="text-red-500 text-sm">default password: 1234</p>
        </div>
        <div class="form-control">
          <button class="btn-primary">
            <font-awesome-icon icon="check" size="sm" />
            <span>Change Password</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>