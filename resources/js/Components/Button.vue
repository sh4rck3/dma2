<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'button',
    }
});
</script>
<template>
    <button
        type="button"
        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
        Nome do Botao
        <slot />
    </button>
</template>