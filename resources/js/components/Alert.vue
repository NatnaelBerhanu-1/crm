<template>
    <div class="bg-green-100 text-green-600 p-2 rounded border border-green-300 mt-2 flex flex-row align-center items-center justify-between px-4" v-if="type=='success'">
        <p>{{message}}</p>
        <font-awesome-icon icon="times" class="cursor-pointer" size="sm" v-on:click="onClose"/>
    </div>
    <div class="bg-red-100 text-red-600 p-2 rounded border border-red-300 mt-2 flex flex-row align-center items-center justify-between px-4" v-else-if="type=='failure'">
        <p>{{message}}</p>
        <font-awesome-icon icon="times" class="cursor-pointer" size="sm" v-on:click="onClose"/>
    </div>
</template>
<script>
export default {
    props: ['type', 'message', 'onClose']
}
</script>
