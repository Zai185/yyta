<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="space-y-8">
            <!-- Back Button -->
            <Link :href="route('courses')">
            <button class="flex items-center text-red-800 hover:text-red-900 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Courses
            </button>
            </Link>

            <!-- Hero Section with Background Image -->
            <div class="relative w-full rounded-xl overflow-hidden h-[350px] mb-12">
                <img :src="course.img_url ? course.img_url : 'https://shengdongzhao.com/assets/blog/placeholder-image.jpeg'" alt="Course Image" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                <div
                    class="relative z-10 h-full flex flex-col justify-center px-6 sm:px-12 lg:px-16 text-white space-y-4">
                    <h1 class="text-4xl font-bold">{{ course.name }}</h1>
                    <p class="text-lg">{{ course.description }}</p>

                    <div class="flex gap-4 text-sm text-white">
                        <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-md">
                            <ClockIcon class="size-5" />
                            <span>{{ course.duration }} hrs</span>
                        </div>

                        <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-md">
                            <CurrencyDollarIcon class="size-5" />
                            <span>${{ course.fee.toLocaleString() }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-md">
                            <UserGroupIcon class="size-5" />
                            <span>{{ course.is_online ? 'Online' : 'On-Campus' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keep the rest of the page unchanged -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Overview -->
                    <div class="bg-white rounded-lg shadow-md shadow-gray-400 p-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Course Overview</h2>
                        <p class="text-gray-600 mb-6">{{ course.description }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-red-800">{{ course.duration }}</div>
                                <div class="text-sm text-gray-600">Duration</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-red-800">{{ course.modules.length }}</div>
                                <div class="text-sm text-gray-600">Modules</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-red-800">
                                    {{ course.is_online ? 'Online' : 'On Campus' }}</div>
                                <div class="text-sm text-gray-600">Type</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md shadow-gray-400 p-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Course Modules</h2>
                        <div class="space-y-3">
                            <div v-for="(module, index) in course.modules" :key="index"
                                class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-red-800 text-white rounded-full flex items-center justify-center text-sm font-medium mr-4">
                                    {{ index + 1 }}
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ module.name }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-md shadow-gray-400 p-6 sticky top-24">
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-red-800 mb-2">${{ course.fee.toLocaleString() }}</div>
                            <div class="text-gray-600">One-time payment</div>
                        </div>

                        <div class="space-y-4">
                            <button @click="downloadPDF"
                                class="w-full bg-gray-100 text-gray-800 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF Brochure
                            </button>

                            <button v-if="course.is_online" @click="$emit('navigate', 'payment')"
                                class="w-full bg-red-800 text-white py-3 px-4 rounded-lg font-medium hover:bg-red-900 transition-colors">
                                Purchase Course
                            </button>

                            <button v-else @click="$emit('navigate', 'contact')"
                                class="w-full bg-red-800 text-white py-3 px-4 rounded-lg font-medium hover:bg-red-900 transition-colors">
                                Contact for Enrollment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Course } from '@/types';
import { ClockIcon, CurrencyDollarIcon, UserGroupIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3';

defineProps<{ course: Course }>()
defineEmits(['navigate'])

const downloadPDF = () => {
    alert('PDF brochure download started!')
}
</script>
