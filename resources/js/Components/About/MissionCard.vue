<template>
  <div class="bg-white p-8 rounded-xl shadow-md">
    <div class="text-red-800 mb-4">
      <component :is="iconComponent" class="w-10 h-10" />
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ title }}</h3>
    <p class="text-gray-600">{{ desc }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { LightBulbIcon, EyeIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  title: String,
  desc: String,
  icon: String
})

const iconComponent = computed(() => {
  const icons = {
    'lightning-bolt': LightBulbIcon,
    'eye': EyeIcon
  }
  return icons[props.icon] || LightBulbIcon
})
</script>
