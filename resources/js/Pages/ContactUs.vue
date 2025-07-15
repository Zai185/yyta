<template>
    <GuestLayout>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Contact Us</h2>
                    <p class="mt-4 text-lg text-gray-600">Get in touch with our admissions team</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="h-full relative">

                        <div class="sticky top-4 space-y-8">
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Send us a Message</h3>
                                <form @submit.prevent="submitContactForm" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input v-model="contactForm.name" type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email
                                            Address</label>
                                        <input v-model="contactForm.email" type="email"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input v-model="contactForm.phone" type="tel"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                        <select v-model="contactForm.subject"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                            required>
                                            <option value="">Select a subject</option>
                                            <option value="admissions">Admissions Inquiry</option>
                                            <option value="courses">Course Information</option>
                                            <option value="technical">Technical Support</option>
                                            <option value="financial">Financial Aid</option>
                                            <option value="general">General Question</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                        <textarea v-model="contactForm.message" rows="5"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                            required></textarea>
                                    </div>
                                    <button type="submit" :disabled="submitting"
                                        class="w-full bg-red-800 text-white py-3 px-4 rounded-lg font-medium hover:bg-red-900 transition-colors disabled:opacity-50">
                                        <span v-if="submitting">Sending...</span>
                                        <span v-else>Send Message</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Contact Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="text-red-800 mr-4 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Address</h4>
                                        <p class="text-gray-600">123 University Avenue<br>Education City, EC
                                            12345<br>United
                                            States</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="text-red-800 mr-4 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Phone</h4>
                                        <p class="text-gray-600">+1 (555) 123-4567</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="text-red-800 mr-4 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Email</h4>
                                        <p class="text-gray-600">admissions@YMax University.edu</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Office Hours</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Monday - Friday</span>
                                    <span class="font-medium">8:00 AM - 6:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Saturday</span>
                                    <span class="font-medium">9:00 AM - 4:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Sunday</span>
                                    <span class="font-medium">Closed</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Need Immediate Help?</h3>
                            <p class="text-red-700 text-sm mb-4">Our student support team is available 24/7 for current
                                students and urgent inquiries.</p>
                            <button
                                class="bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-900 transition-colors">
                                Live Chat Support
                            </button>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Frequently Asked Questions</h3>
                            <div class="space-y-3">
                                <details class="group">
                                    <summary
                                        class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-red-800">
                                        <span class="font-medium">How do I apply for admission?</span>
                                        <svg class="w-5 h-5 group-open:rotate-180 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <p class="mt-2 text-sm text-gray-600">You can apply online through our admissions
                                        portal. The process typically takes 15-20 minutes to complete.</p>
                                </details>
                                <details class="group">
                                    <summary
                                        class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-red-800">
                                        <span class="font-medium">Are financial aid options available?</span>
                                        <svg class="w-5 h-5 group-open:rotate-180 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <p class="mt-2 text-sm text-gray-600">Yes, we offer various financial aid options
                                        including scholarships, grants, and payment plans. Contact our financial aid
                                        office
                                        for details.</p>
                                </details>
                                <details class="group">
                                    <summary
                                        class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-red-800">
                                        <span class="font-medium">Can I transfer credits from another
                                            institution?</span>
                                        <svg class="w-5 h-5 group-open:rotate-180 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <p class="mt-2 text-sm text-gray-600">We accept transfer credits from accredited
                                        institutions. Our admissions team will evaluate your transcripts during the
                                        application process.</p>
                                </details>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>

</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ref } from 'vue'

const submitting = ref(false)

const contactForm = ref({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
})

const submitContactForm = async () => {
    submitting.value = true

    // Simulate form submission
    await new Promise(resolve => setTimeout(resolve, 1500))

    alert('Thank you for your message! We will get back to you within 24 hours.')
    submitting.value = false

    // Reset form
    contactForm.value = {
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
    }
}
</script>
