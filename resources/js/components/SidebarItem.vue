<template>
    <div class="flex flex-row py-3 px-6" :class="active ? 'bg-primary-dark text-white' : 'text-gray-100'">
        <div class="w-6 text-start">
            <font-awesome-icon :icon="icon"  />
        </div>
        <p class="font-semibold">{{title}}</p>
    </div>
</template>
<script>
export default {
    props: {
        icon: Array,
        title: String,
        active: {
            type: Boolean,
            default: false
        }
    }
}
</script>
