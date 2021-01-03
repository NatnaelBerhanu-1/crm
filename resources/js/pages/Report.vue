<template>
  <div class="page-container">
    <div class="flex flex-row justify-between">
      <p class="title">
        <font-awesome-icon icon="chart-line" />
        <span class="pl-2">Report</span>
      </p>
      <div class="flex flex-row">
        <div class="bg-white border border-gray-300 cursor-pointer hover:bg-gray-300 hover:text-black h-8 text-black px-2 mr-2 rounded text-sm flex flex-row items-center">
          <font-awesome-icon icon="print" size="sm" />
          <span class="pl-2">Print</span>
        </div>
        <router-link to="add" append>
          <div class="bg-primary h-8 text-white px-2 rounded text-sm flex flex-row items-center">
            <font-awesome-icon icon="plus" size="sm" />
            <span class="pl-2">Add daily report</span>
          </div>
        </router-link>
      </div>
    </div>
    <div class="mt-2 bg-white">
      <table class="w-full">
        <thead>
          <tr class="text-black">
            <th colspan="2">Income</th>
            <th colspan="2">Expense</th>
            <th rowspan="2">Date</th>
            <th rowspan="2" class="w-20"></th>
          </tr>
          <tr>
              <th>Amount</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Description</th>
          </tr>
        </thead>
        <tbody>
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
