<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from '@mdi/js';
import menuNavBar from '@/menuNavBar';
import { useLayoutStore } from '@/Stores/layout.js';
import { useStyleStore } from '@/Stores/style.js';
import BaseIcon from '@/Components/BaseIcon.vue';
import NavBar from '@/Components/NavBar.vue';
import NavBarItemPlain from '@/Components/NavBarItemPlain.vue';
import AsideMenu from '@/Components/AsideMenu.vue';
import FooterBar from '@/Components/FooterBar.vue';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { useAttrs } from 'vue';
import VueEasyLightbox from 'vue-easy-lightbox';
import { useResourceStore } from '@@/Stores/resourceStore';
import FlashMessages from '$/Shared/FlashMessages.vue';

Inertia.on('navigate', () => {
  layoutStore.isAsideMobileExpanded = false;
  layoutStore.isAsideLgActive = false;
});

const layoutAsidePadding = 'xl:pl-60';

const styleStore = useStyleStore();

const layoutStore = useLayoutStore();

const dashboardMenu = computed(
  () => usePage().props.value.data.menus.dashboard
);

const menuClick = (event, item) => {
  if (item.isToggleLightDark) {
    styleStore.setDarkMode();
  }

  if (item.isLogout) {
    // Add:
    Inertia.post(route('logout'));
  }
};

const props = defineProps({
  url: String,
});

let store = useResourceStore();

const attrs = useAttrs();
</script>

<template>
  <div
    :class="{
      dark: styleStore.darkMode,
      'overflow-hidden lg:overflow-visible': layoutStore.isAsideMobileExpanded,
    }"
  >
    <div
      :class="[
        layoutAsidePadding,
        { 'ml-60 lg:ml-0': layoutStore.isAsideMobileExpanded },
      ]"
      class="pt-14 min-h-screen w-screen transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100"
    >
      <NavBar
        :menu="menuNavBar"
        :class="[
          layoutAsidePadding,
          { 'ml-60 lg:ml-0': layoutStore.isAsideMobileExpanded },
        ]"
        @menu-click="menuClick"
      >
        <NavBarItemPlain
          display="flex lg:hidden"
          @click.prevent="layoutStore.asideMobileToggle()"
        >
          <BaseIcon
            :path="
              layoutStore.isAsideMobileExpanded
                ? mdiBackburger
                : mdiForwardburger
            "
            size="24"
          />
        </NavBarItemPlain>
        <NavBarItemPlain
          display="hidden lg:flex xl:hidden"
          @click.prevent="layoutStore.isAsideLgActive = true"
        >
          <BaseIcon :path="mdiMenu" size="24" />
        </NavBarItemPlain>
      </NavBar>
      <AsideMenu :menu="dashboardMenu" @menu-click="menuClick" />
      <div class="px-6 pt-6 mx-auto">
        <vue-easy-lightbox
          ref="lightbox"
          :visible="visible"
          :imgs="imgs"
          :index="index"
          @hide="visible = !visible"
        ></vue-easy-lightbox>

        <!--                <Header-->
        <!--                    :canCreate="attrs.canCreate"-->
        <!--                    :title="attrs.lang?.index"-->
        <!--                    :button="attrs.lang?.create"-->
        <!--                    @createItem="create"-->
        <!--                >-->
        <!--                    <a-->
        <!--                        v-for="(action, index) in attrs.actions"-->
        <!--                        :key="index"-->
        <!--                        :href="action.url ? action.url : '#'"-->
        <!--                        @click.prevent=""-->
        <!--                        class="mx-2 relative inline-flex items-center px-8 py-3 overflow-hidden text-white bg-main rounded group active:bg-blue-500 focus:outline-none focus:ring"-->
        <!--                    >-->
        <!--                        <span-->
        <!--                            class="absolute left-0 transition-transform -translate-x-full group-hover:translate-x-4"-->
        <!--                        >-->
        <!--                            <i class="bx-sm mt-2" :class="action.icon"></i>-->
        <!--                        </span>-->

        <!--                        <span-->
        <!--                            class="text-sm font-medium transition-all group-hover:ml-4"-->
        <!--                        >-->
        <!--                            {{ action.label }}-->
        <!--                        </span>-->
        <!--                    </a>-->
        <!--                </Header>-->

        <flash-messages />
        <slot />

<!--        <FooterBar>-->
<!--          Github-->
<!--          <a href="https://www.github.com" target="_blank" class="text-blue-600"-->
<!--            >Docs</a-->
<!--          >-->
<!--        </FooterBar>-->
      </div>
    </div>
  </div>
</template>
