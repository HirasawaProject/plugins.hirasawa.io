<script setup>
 import AppLayout from '@/Layouts/AppLayout.vue';
    import { defineProps } from 'vue';

const { plugin } = defineProps({
  plugin: {
    type: Object,
    required: true,
  },
});


</script>


<template>

    <Head title="Plugin Browser"/>

    <AppLayout>
    <div>
      <h1>{{ plugin.name }}</h1>
      <img :src="plugin.avatar_url" :alt="plugin.name">
      <p>{{ plugin.description }}</p>
      <!-- Add more plugin details here -->
    </div>

</AppLayout >
  </template>