<script setup>

defineProps({
    plugins: {
        type: Array,
    },
});
</script>

<template>
  
    <a :href="route('plugins.show', {'plugin': plugin})" class="block" v-for="plugin in plugins">
        
        <div class="background-default border dark:border-gray-800 shadow-md rounded-md p-4 overflow-hidden !border-gray-300 !dark:border-gray-700 border-1px hover:bg-gray-100 dark:hover:bg-gray-300 transition-all cursor-pointer h-auto mb-4">
            <div class="flex space-x-4 h-full">
                <div class="flex-shrink-0">
                    <div class="rounded-lg h-20 md:h-24">
                        <img class="rounded-lg w-full h-full object-cover" :title="plugin.name" src="https://www.dockhunt.com/_next/image?url=https%3A%2F%2Fdockhunt-images.nyc3.cdn.digitaloceanspaces.com%2Fplaceholder.png&w=256&q=75" :alt="plugin.name" >
                    </div>
                </div>
                <div class="overflow-hidden min-w-0 flex-grow">
                    <h2 class="text-lg font-bold text-gray-600 hover:underline">
                        {{ plugin.name }}
                        
                    </h2>
                    <span class="text-sm font-normal overflow-hidden">by <span class="font-bold color-primary hover:underline overflow-hidden">{{ plugin.author.name }}</span></span>
                    <h3 class="mb-1 text-sm truncate-2-lines w-full md:min-w-[600px] mx-auto">{{ plugin.description }}</h3>
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
                            Views {{ plugin.view_count }}
                        </span>
                    </div>
                    <!-- Categories as Icons -->
                    <div class="plugin-categories flex">
                        <span v-for="category in plugin.categories" class="mr-2" :class="category.icon"></span>

                        
                      </div>
                </div>
            </div>
        </div>
    </a>
</template>
