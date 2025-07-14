<template>
  <div class="text-center">
    <component :is="iconComponent" class="w-8 h-8 mx-auto text-red-400 mb-4" />
    <h4 class="font-semibold mb-2">{{ title }}</h4>
    <p class="text-gray-300 text-sm">{{ desc }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { AcademicCapIcon, DevicePhoneMobileIcon, CheckBadgeIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  title: String,
  desc: String,
  icon: String
})

const iconComponent = computed(() => {
  const icons = {
    'academic-cap': AcademicCapIcon,
    'device-mobile': DevicePhoneMobileIcon,
    'badge-check': CheckBadgeIcon
  }
  return icons[props.icon] || AcademicCapIcon
})
</script>
