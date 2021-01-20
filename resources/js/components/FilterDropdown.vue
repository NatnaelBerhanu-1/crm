<template>
  <div class="w-36 bg-white rounded-sm border border-gray-300 shadow-md">
      <ul>
          <li @click="onFilter('overall')">Overall</li>
          <li @click="onFilter('thisyear')">This Year so far</li>
          <li @click="onFilter('last6months')">Last 6 Months</li>
          <li @click="onFilter('lastmonth')">Last Month</li>
          <li @click="onFilter('thismonth')">This Month</li>
      </ul>
  </div>
</template>

<script>
export default {
    props: {
        onFilterClicked: Function
    },
    methods: {
        onFilter: function(by){
            this.onFilterClicked(by);
        }
    }
}
</script>

<style scoped>
li {
    @apply py-2  px-4;
}

li:hover {
    @apply bg-gray-200;
}

li:first-child {
    @apply rounded-t-sm;
}

li:last-child {
    @apply rounded-b-sm;
}
</style>
