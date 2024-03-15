<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Content from './Partials/Content.vue';
import { computed, inject } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const swal = inject('$swal')
const toast = inject('$toast')

const pagePermission = computed(() => page.props.user.permissions)
const pageRole = computed(() => page.props.user.roles)


</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        WebChat
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Content />
                </div>
            </div>
        </div>
    </AppLayout>
</template>