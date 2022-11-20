<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from '@mdi/js';
import { useLayoutStore } from '@/Stores/layout.js';
import { useStyleStore } from '@/Stores/style.js';
import BaseIcon from '@/Components/BaseIcon.vue';
import FormControl from '@/Components/FormControl.vue';
import NavBar from '@/Components/NavBar.vue';
import NavBarItemPlain from '@/Components/NavBarItemPlain.vue';
import AsideMenu from '@/Components/AsideMenu.vue';
import FooterBar from '@/Components/FooterBar.vue';
import Header from '@@/Components/Header.vue';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { useAttrs, ref, onMounted, watch, toRaw } from 'vue';
import VueEasyLightbox from 'vue-easy-lightbox';
import { storeToRefs } from 'pinia/dist/pinia';
import { useResourceStore } from '@@/Stores/resourceStore';
import FlashMessages from "$/Shared/FlashMessages.vue";

Inertia.on('navigate', () => {
    layoutStore.isAsideMobileExpanded = false;
    layoutStore.isAsideLgActive = false;
});

const layoutAsidePadding = 'rtl:xl:pr-60 ltr:xl:pl-60 ';

const styleStore = useStyleStore();

const layoutStore = useLayoutStore();

const dashboardMenu = computed(
    () => usePage().props.value.data.menus.dashboard
);

const navMenu = computed(
    () => usePage().props.value.data.menus.profile
);


const menuClick = (event, item) => {
    if (item.isChangeLanguage) {
        Inertia.post(
            route("translations.switch"),
            { language: JSON.parse(localStorage.getItem("lang")) },
            {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: () => {
                    let htmlEl = document.querySelector("html");

                    if (
                        JSON.parse(localStorage.getItem("lang")).id === "ar"
                    ) {
                        htmlEl.setAttribute("dir", "rtl");
                        localStorage.setItem(
                            "lang",
                            JSON.stringify({
                                id: "en",
                                name: "English",
                            })
                        );
                    } else {
                        htmlEl.setAttribute("dir", "ltr");
                        localStorage.setItem(
                            "lang",
                            JSON.stringify({
                                id: "ar",
                                name: "Arabic",
                            })
                        );
                    }
                },
            }
        );
    }
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

let {
    createModal,
    viewModal,
    deleteModal,
    bulkModal,
    goNext,
    goBack,
    search,
    per_page,
    orderBy,
    desc,
    last_page,
    edit,
    showFilter,
    filters,
    bulk,
    showBulk,
    bulkActionTitle,
    view,
    photoPreview,
} = storeToRefs(useResourceStore());

let store = useResourceStore();

const attrs = useAttrs();

onMounted(() => {
    if (!localStorage.getItem("lang")) {
        localStorage.setItem(
            "lang",
            JSON.stringify({
                id: "ar",
                name: "Arabic",
            })
        );
    }
});

</script>

<template>
    <div
        v-cloak
        :class="{
      dark: styleStore.darkMode,
      'overflow-hidden lg:overflow-visible': layoutStore.isAsideMobileExpanded,
    }"
    >
        <div
            :class="[
        layoutAsidePadding,
        { 'ltr:ml-60 ltr:lg:ml-0 rtl:mr-60 rtl:lg:mr-0': layoutStore.isAsideMobileExpanded },
      ]"
            class="pt-14 min-h-screen w-screen transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100"
        >
            <NavBar
                :menu="navMenu"
                :class="[
                    layoutAsidePadding,
                    { 'ltr:ml-60 ltr:lg:ml-0 rtl:mr-60 rtl:lg:mr-0': layoutStore.isAsideMobileExpanded },
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
                <Header
                    v-if="attrs.lang"
                    :canCreate="attrs.canCreate ? attrs.canCreate : false"
                    :title="attrs.lang ? attrs.lang.index : ''"
                    :button="attrs.lang ? attrs.lang.create: ''"
                    @createItem="createModal = !createModal"
                >
                    <a
                        v-for="(action, index) in actions"
                        :key="index"
                        :href="action.url ? action.url : '#'"
                        @click.prevent="
                            !action.url
                                ? action.modal
                                    ? openModal(action.modal)
                                    : fireAction(action.action)
                                : openUrl(action.url)
                        "
                        class="relative inline-flex items-center px-8 py-3 overflow-hidden text-white bg-main rounded group active:bg-blue-500 focus:outline-none focus:ring"
                    >
                        <span
                            class="absolute left-0 transition-transform -translate-x-full group-hover:translate-x-4"
                        >
                            <i class="bx-sm mt-2" :class="action.icon"></i>
                        </span>

                        <span
                            class="text-sm font-medium transition-all group-hover:ml-4"
                        >
                            {{ action.label }}
                        </span>
                    </a>
                </Header>
                <div v-if="widgets.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 my-4">
                    <div
                        v-for="(item, key) in widgets"
                        :class="{
                            'col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4': widgets.length === 1,
                            'col-span-4 lg:col-span-4 md:col-span-2 sm:col-span-2': widgets.length === 2,
                            'bg-success-500': item.type === 'success',
                            'bg-danger-500': item.type === 'danger',
                            'bg-blue-700': item.type === 'primary',
                            'bg-warning-500': item.type === 'warning',
                        }"
                        class="w-full bg-blue-500 rounded-lg text-center py-4 px-2 text-white">

                        <i class="bx-lg" :class="item.icon"></i>
                        <h1 class="text-2xl font-bold">{{ item.label }}</h1>
                        <p>{{ item.value }}</p>
                    </div>
                </div>
            </div>

            <slot />
            <JetDialogModal
                v-for="(item, key) in modals"
                :key="key"
                :show="actionModal[item.name]"
                @end="actionModal[item.name] = !actionModal[item.name]"
            >
                <template #title>
                    <div class="flex justify-between">
                        {{ item.label }}
                    </div>
                </template>

                <template #content>
                    <form action="" enctype="multipart/form-data">
                        <ViltForm
                            v-model="modalAction[item.name]"
                            :rows="item.rows"
                            :errors="modalAction[item.name].errors"
                        />
                    </form>
                </template>

                <template #footer>
                    <JetButton
                        v-for="(button, key) in item.buttons"
                        :key="key"
                        @click.prevent="modalActionRun(item.name, button.action)"
                        class="mx-2"
                    >{{ button.label }}
                    </JetButton>
                    <JetSecondaryButton
                        @click="actionModal[item.name] = !actionModal[item.name]"
                    >
                        {{ trans('global.close') }}
                    </JetSecondaryButton>
                </template>
            </JetDialogModal>
<!--            <FooterBar>-->
<!--                Github-->
<!--                <a-->
<!--                    href="https://www.github.com"-->
<!--                    target="_blank"-->
<!--                    class="text-blue-600"-->
<!--                    >Docs</a-->
<!--                >-->
<!--            </FooterBar>-->
        </div>
    </div>
    <FlashMessages />
</template>

<script>
import { defineComponent } from 'vue';
import MixinVue from '@/Components/Base/Mixin.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import ViltForm from '@@/Rows/ViltForm.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import ResourceTableLayout from '@/Layouts/ResourceTableLayout.vue';

export default defineComponent({
    mixins: [MixinVue],
    components: {
        JetDialogModal,
        JetButton,
        JetSecondaryButton,
        ViltForm,
    },
    data() {
        return {
            selectedID: null,
            visible: false,
            imgs: [],
            actionModal: {},
            modalAction: {},
        };
    },
    computed:{
        modals(){

            let modals = [];
            if(this.$attrs.components){
                for (let i = 0; i < this.$attrs.components.length; i++) {
                    if(this.$attrs.components[i].classType === 'modal'){
                        modals.push(this.$attrs.components[i]);
                    }
                }
            }

            return modals;
        },
        widgets(){
            let widgets = [];
            if(this.$attrs.components) {
                for (let i = 0; i < this.$attrs.components.length; i++) {
                    if (this.$attrs.components[i].classType === 'widget') {
                        widgets.push(this.$attrs.components[i]);
                    }
                }
            }
            return widgets;
        },
        actions(){
            let actions = [];
            if(this.$attrs.components) {
                for (let i = 0; i < this.$attrs.components.length; i++) {
                    if (this.$attrs.components[i].classType === 'action') {
                        actions.push(this.$attrs.components[i]);
                    }
                }
            }
            return actions;
        }
    },
    mounted(){
        for (let i = 0; i < this.modals.length; i++) {
            this.actionModal[this.modals[i].name] = false;
            this.modalAction[this.modals[i].name] = {};
        }
    },
    methods: {
        openUrl(url) {
            window.open(url);
        },
        modalActionRun(modal, action) {
            if (this.selectedID) {
                this.modalAction[modal].id = this.selectedID;
            }
            let form = this.$inertia.form(this.modalAction[modal]);
            form.submit('post', this.route(action), {
                    preserveScroll: true,
                    onSuccess: () => {
                        form.reset();
                        this.actionModal[modal] = false;
                        this.success();
                    },
                });
        },
        fireAction(name, id = null) {
            this.$inertia.post(this.route(name), {
                id: id ? id : this.selectedID,
            }, {
                onSuccess: () => {
                    this.success();
                }
            });
        },
        openModal(name, id = null) {
            this.selectedID = id;
            this.actionModal[name] = !this.actionModal[name];
        },

        popUp(images) {
            this.visible = true;
            this.imgs = images;
        },
    },
});
</script>
