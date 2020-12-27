<template>
  <div class="page-container h-full flex flex-row">
      <FullCalendar :options="calendarOptions" class="w-3/4"/>
      <div class="bg-red w-1/4"></div>
  </div>
</template>
<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data() {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth'
      }
    }
  }
}
</script>
<style lang="css">
    .fc-view tr:nth-child(even){
        @apply bg-white;
    }
</style>