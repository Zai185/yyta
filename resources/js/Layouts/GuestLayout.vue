<template>

    <Head :title="navs.find(nav => route().current().startsWith(nav.prefix))?.label"></Head>
    <nav class="bg-white shadow-md fixed w-full z-50 h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <img src="/assets/logo.png" alt="Logo" class="w-8 h-8" />
                    <span class="text-xl font-bold text-gray-800">YMax University</span>
                </div>

                <!-- Navigation Links (add if needed) -->
                <div class="hidden md:flex space-x-6">
                    <template v-for="nav in navs" :key="nav.name">
                        <Link :href="route(nav.name)" class="text-gray-700 hover:text-red-800 font-medium"
                            :class="[route().current().startsWith(nav.prefix) ? 'text-red-800 font-medium' : '']">
                        {{ nav.label }}
                        </Link>
                    </template>
                </div>

                <!-- Mobile menu button -->
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden focus:outline-none">
                    <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div v-if="isMobileMenuOpen" class="border-t pt-4 bg-white md:hidden px-4 pb-4 space-y-4">
            <template v-for="nav in navs" :key="nav.name">
                <Link :href="route(nav.name)" class="block text-gray-700 hover:text-red-800 font-medium"
                    :class="[route().current().startsWith(nav.prefix) ? 'text-red-800 font-medium' : '']">
                {{ nav.label }}
                </Link>
            </template>
        </div>
    </nav>
    <div class="pt-16">
        <slot />
    </div>

    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-gray-700 pb-12">
                <!-- Logo and Description -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">YMax University</h2>
                    <p class="text-gray-400">
                        Empowering students through flexible learning options and world-class programs. Join
                        thousands on their journey to success.
                    </p>
                </div>

                <!-- Resources Navigation -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li v-for="nav in navs" :key="nav.name">
                            <a :href="`/${nav.prefix}`" class="text-gray-400 hover:text-white transition">
                                {{ nav.label }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact / Newsletter -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Stay Connected</h3>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter for updates and course announcements.
                    </p>
                    <form @submit.prevent="subscribeNewspaper" class="flex items-center space-x-2">
                        <input v-model="form.email" type="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none" />
                        <button :disabled="form.processing" class="bg-red-700 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 text-center text-gray-500 text-sm">
                &copy; {{ new Date().getFullYear() }} YMax University. All rights reserved.
            </div>
        </div>
    </footer>

    <FloatingButton />
</template>

<script setup lang="ts">
import { courses } from '@/Pages/course-data';
import FloatingButton from '@/Pages/FloatingButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue'

const isMobileMenuOpen = ref(false)

const navs = [
    {
        name: 'dashboard',
        prefix: 'dashboard',
        label: 'Dashboard',
    },
    {
        name: 'about',
        prefix: 'about',
        label: 'About',
    },
    {
        name: 'courses',
        prefix: 'courses',
        label: 'Courses',
    },
    {
        name: 'contact-us',
        prefix: 'contact-us',
        label: 'Contact Us',
    },
]

const form = useForm({
    email: ''
})

const subscribeNewspaper = () => {
    form.post('/subscribe', {
        onSuccess: () => {
            alert('Subscribed!')
            form.reset()
        }
    })
}
</script>
