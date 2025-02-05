<template>
    <div class="flex h-screen overflow-hidden bg-[#09090B]">
        <!-- ===== Sidebar Start ===== -->
        <SidebarMenu />
        <!-- ===== Sidebar End ===== -->
    
        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
          <!-- ===== Header Start ===== -->
          <HeaderArea />
          <!-- ===== Header End ===== -->
    
          <!-- ===== Main Content Start ===== -->
          <main>
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 text-bodydark1">
              <PageTitle />
              <router-view class="mt-3"></router-view>
            </div>
          </main>
          <!-- ===== Main Content End ===== -->
        </div>
      </div>
</template>

<script setup lang="ts">
import PageTitle from './components/PageTitle.vue';
import SidebarMenu from './components/sidebar/SidebarMenu.vue';
import HeaderArea from './components/Header/HeaderArea.vue';
</script>