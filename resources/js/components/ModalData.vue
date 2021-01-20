<template>
  <div>
    <p class="font-bold text-sm">{{title}}</p>
    <p class="py-2 font-normal">{{content}}</p>
  </div>
</template>

<script>
export default {
    props: ['title', 'content']
};
</script>

<style>
</style>
