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
          <span class="pl-2">Add Staff</span>
        </div>
      </router-link>
    </div>
    <div class="mt-2 bg-white">
      <table class="w-full">
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
          <tr class>
            <td>Natnael</td>
            <td>0919298886</td>
            <td>Admin</td>
            <td>12/03/2020</td>
            <td class="text-gray-900">
              <font-awesome-icon icon="pencil-alt" class="mr-2 cursor-pointer" />
              <font-awesome-icon icon="trash" class="cursor-pointer" />
            </td>
          </tr>
          <tr class>
            <td>Natnael</td>
            <td>0919298886</td>
            <td>Admin</td>
            <td>12/03/2020</td>
            <td class="text-gray-900">
              <font-awesome-icon icon="pencil-alt" class="mr-2 cursor-pointer" />
              <font-awesome-icon icon="trash" class="cursor-pointer" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style lang="css" scoped>
td,
th {
  @apply border border-gray-300;
}
</style>