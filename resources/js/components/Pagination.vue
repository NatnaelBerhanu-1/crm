<template>
  <div class="w-64 mt-3 rounded-md text-sm flex flex-row text-primary gap-2">
      <button @click="getData(data.prev_page_url)" :disabled="data.prev_page_url.page==null">
          prev
      </button>
      <div class="text-black">
          <p>page {{data.cur_page}} of {{data.total_page}}</p>
      </div>
      <button @click="getData(data.next_page_url)" :disabled="data.next_page_url.page==null">
          next
      </button>
  </div>
</template>

<script>
export default {
    props: {
        data: Object
    },
    methods: {
        getData: function(page){
            this.$store.dispatch(this.data.get, page);
        }
    }
}
</script>

<style>

</style>
