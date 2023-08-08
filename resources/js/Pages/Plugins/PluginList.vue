<script setup>

defineProps({
    plugins: {
        type: Array,
    },
});
</script>

<template>
   
    <a :href="route('plugins.show', {'plugin': plugin})" class="block" v-for="plugin in plugins">
        <div class="background-default border dark:border-gray-800 shadow-md rounded-md p-4 overflow-hidden !border-gray-300 !dark:border-gray-700 border-1px hover:bg-gray-100 dark:hover:bg-gray-800 transition-all cursor-pointer h-auto">
            <div class="flex space-x-4 h-full">
                <div class="flex-shrink-0">
                    <div class="rounded-lg h-20 md:h-24">
                        <img class="rounded-lg w-full h-full object-cover" :title="plugin.name" :src="plugin.avatar_url" :alt="plugin.name">
                    </div>
                </div>
                <div class="overflow-hidden min-w-0 flex-grow">
                    <h2 class="text-lg font-bold text-gray-600 hover:underline">
                        {{ plugin.name }}
                        <span class="text-sm font-normal"> by <span class="font-bold color-primary hover:underline">{{ plugin.author.name }}</span></span>
                    </h2>
                    <h3 class="mb-1 text-sm truncate">{{ plugin.description }}</h3>
                    <div class="flex space-x-4 text-sm">
                        <span class="inline-flex items-center">
                            <!-- Views Icon -->
                            {{ plugin.targeting == 'both' ? 'Web & Bancho' : (plugin.targeting == 'web' ? 'Web' : 'Bancho') }} 
                        </span>
                        <span class="inline-flex items-center">
                            <!-- Downloads Icon -->
                            {{ plugin.download_count >= 1000 ? (plugin.download_count >= 100000 ? Math.floor(plugin.download_count / 1000) + 'k' : parseInt(plugin.download_count / 1000) + 'k') : plugin.download_count }} Downloads
                        </span>
                        <span class="inline-flex items-center">
                            <!-- Version Icon -->
                            Version {{ plugin.view_count }}
                        </span>
                    </div>
                    <!-- Categories as Icons -->
                    <div class="plugin-categories">
                        <img v-for="category in plugin.categories" :alt="category.name" :title="category.name" :class="gg-shape-square" />
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>
