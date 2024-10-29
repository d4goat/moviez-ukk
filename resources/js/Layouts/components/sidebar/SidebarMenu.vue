<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar'
import { onClickOutside } from '@vueuse/core'
import { ref } from 'vue'
import SidebarItem from './SidebarItem.vue'
import { useAuthStore } from '@/stores/auth'
import MainMenuConfig from '@/Layouts/config/MainMenuConfig'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'

const { user } = useAuthStore()
const target = ref(null)
const route = useRoute()
const openSubmenus = ref<Set<string>>(new Set())

const { t, te } = useI18n()

const translate = (text: string) => {
    if (te(text)) {
        return t(text);
    } else {
        return text;
    }
};

const sidebarStore = useSidebarStore()

onClickOutside(target, () => {
  sidebarStore.isSidebarOpen = false
})

const hasActiveChildren = (route: string) => {
  return route.startsWith(route.path)
}

const checkPermission = (menu: string) => {
    if (user?.permission?.includes(menu)) {
        return true;
    }
    return false;
}

const toggleSubmenu = (menuItem: any) => {
  if (openSubmenus.value.has(menuItem.route)) {
    openSubmenus.value.delete(menuItem.route)
  } else {
    openSubmenus.value.add(menuItem.route)
  }
}

const isSubmenuOpen = (menuItem: any) => {
  return openSubmenus.value.has(menuItem.route) || hasActiveChildren(menuItem.route)
}
</script>

<template>
    <aside
    class="absolute left-0 top-0 z-9999 flex h-screen w-60 flex-col overflow-y-hidden bg-sidebar border-r-2 border-gray-600 duration-300 ease-linear dark:bg-dark-bg lg:static lg:translate-x-0"
    :class="{
      'translate-x-0': sidebarStore.isSidebarOpen,
      '-translate-x-full': !sidebarStore.isSidebarOpen
    }"
    ref="target"
  >
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-4 lg:py-6.5">
        <router-link to="/" class="mx-3">
            <span class="text-cinema text-3xl font-medium">Cinema51</span>
        </router-link>
      <button class="block lg:hidden" @click="sidebarStore.isSidebarOpen = false">
        <svg
          class="fill-current text-gray"
          width="20"
          height="18"
          viewBox="0 0 20 18"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
            fill=""
          />
        </svg>
      </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
      <!-- Sidebar Menu -->
      <nav class="mt-2 pb-2 px-3 lg:mt-4 lg:px-6">
        <template v-for="(item, i) in MainMenuConfig" :key="i">
          <div v-if="item.heading && checkPermission(item.name)">
            <h3 class="mb-2 ml-4 text-sm font-medium text-bodydark2">{{ translate(item.heading) }}</h3>

            <ul class="mb-3 flex flex-col gap-1.5">
              <template v-for="(menuItem, j) in item.pages" :key="j">
                <li v-if="menuItem.heading && checkPermission(menuItem.name)">
                  <router-link
                    v-if="menuItem.route"
                    :to="menuItem.route"
                    class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                  :class="{ 'bg-graydark dark:bg-meta-4': $route.path === menuItem.route }"
                  >
                    <span>{{ translate(menuItem.heading) }}</span>
                  </router-link>
                </li>
                <li v-if="menuItem.sectionTitle && menuItem.route && checkPermission(menuItem.name)">
                  <a
                    href="#"
                    class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                    @click.prevent="toggleSubmenu(menuItem)"
                    :class="{ 'bg-graydark dark:bg-meta-4': isSubmenuOpen(menuItem) }"
                  >
                    <span>{{ translate(menuItem.sectionTitle) }}</span>
                    <svg
                      class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                      :class="{ 'rotate-180': isSubmenuOpen(menuItem) }"
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                        fill=""
                      />
                    </svg>
                  </a>
                  <div v-show="isSubmenuOpen(menuItem)" class="mt-2 pl-6">
                    <ul class="mb-5.5 flex flex-col gap-2">
                      <li v-for="(subItem, k) in menuItem.sub" :key="k">
                        <router-link
                          v-if="subItem.route && checkPermission(subItem.name)"
                          :to="subItem.route"
                          class="group relative flex items-center gap-2.5 rounded-md px-2 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                          :class="{ 'text-white': $route.path === subItem.route }"
                        >
                          {{ translate(subItem.heading || subItem.sectionTitle) }}
                        </router-link>
                      </li>
                    </ul>
                  </div>
                </li>
              </template>
            </ul>
          </div>
          </template>
      </nav>
      <!-- Sidebar Menu -->

    </div>
  </aside>
</template>