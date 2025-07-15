<template>
    <GuestLayout>
        <div>
            <!-- Hero Section -->
            <section class="hero-section text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                                Shape Your Future with
                                <span>YMax University</span>
                            </h1>
                            <p class="text-xl mb-8">
                                Join thousands of students who have transformed their careers through our innovative
                                online
                                and on-campus programs.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button @click="$emit('navigate', 'courses')"
                                    class="bg-white text-red-800 px-8 py-3 rounded-lg font-semibold hover:bg-red-50 transition-colors">
                                    Explore Courses
                                </button>
                                <button @click="$emit('navigate', 'about')"
                                    class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-800 transition-colors">
                                    Learn More
                                </button>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8">
                                <div class="grid grid-cols-2 gap-6 text-center">
                                    <div>
                                        <div class="text-3xl font-bold">50,000+</div>
                                        <div class="text-red-200">Students</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold">200+</div>
                                        <div class="text-red-200">Courses</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold">95%</div>
                                        <div class="text-red-200">Success Rate</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold">24/7</div>
                                        <div class="text-red-200">Support</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose YMax University?</h2>
                        <p class="text-lg text-gray-600">Experience education that adapts to your lifestyle and career
                            goals</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <FeatureCard title="Flexible Learning"
                            desc="Study online or on-campus with schedules that fit your life" icon="book-open" />
                        <FeatureCard title="Expert Faculty"
                            desc="Learn from industry professionals and academic leaders" icon="academic-cap" />
                        <FeatureCard title="Accredited Programs"
                            desc="Internationally recognized degrees and certifications" icon="badge-check" />
                    </div>
                </div>
            </section>

            <!-- Popular Courses Section -->
            <section class="py-20 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Courses</h2>
                        <p class="text-lg text-gray-600">Discover our most sought-after programs</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <template v-for="course in courses" :key="course.id">
                            <CourseCard :course="course" />
                        </template>
                    </div>
                    <div class="text-center mt-12">
                        <Link :href="route('courses')">
                        <button
                            class="bg-red-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-900 transition-colors">
                            View All Courses
                        </button>
                        </Link>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-20 bg-red-800 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold mb-4">Ready to Start Your Journey?</h2>
                    <p class="text-xl mb-8 text-red-100">Join thousands of successful graduates who transformed their
                        careers with YMax University</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link :href="route('courses')">
                        <button
                            class="bg-white text-red-800 px-8 py-3 rounded-lg font-semibold hover:bg-red-50 transition-colors">
                            Browse Courses
                        </button>
                        </Link>
                        <Link :href="route('contact-us')">
                        <button @click="$emit('navigate', 'contact')"
                            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-red-800 transition-colors">
                            Contact Admissions
                        </button>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
defineEmits(['navigate'])
defineProps<{
    'courses': Course[]
}>()
import CourseCard from '@/Components/Courses/CourseCard.vue';
import FeatureCard from '@/Components/Landing/FeatureCard.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Course } from '@/types';
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
.hero-section {
    background-image: linear-gradient(to right, rgba(153, 27, 27, 0.4), rgba(127, 29, 29, 1)), url('https://images.unsplash.com/20/cambridge.JPG?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dW5pdmVyc2l0eXxlbnwwfHwwfHx8MA%3D%3D');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
