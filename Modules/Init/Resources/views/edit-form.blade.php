@php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
@endphp

<template>
    <SectionMain>
        <SectionTitleLineWithButton :icon="mdiBallotOutline" title="Edit {{$modelTitle}}" main>
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            @foreach($columns as $col)
                @if ($col['type'] === 'boolean')
                    @php $hasCheckbox = true; @endphp
                    <FormField label="{{$col['name']}}">
                        <FormCheckRadioGroup
                                id="{{$col['name']}}"
                                v-model="form.{{$col['name']}}"
                                name="{{$col['name']}}"
                                type="switch"
                                :options="{ public: 'Published' }"
                        />
                        <jet-input-error :message="form.errors.{{$col['name']}}" class="mt-2"/>
                    </FormField>

                    <BaseDivider/>

                @elseif($col['type'] === 'text')
                    @php $hasTextArea = true; @endphp
                    <FormField label="{{$col['name']}}">
                        <ViltRich
                                id="{{$col['name']}}"
                                :error="form.errors.{{$col['name']}}"
                                v-model="form.{{$col['name']}}"
                        />
                    </FormField>
                    <BaseDivider/>
                @elseif($col['type'] === 'double' || $col['type'] === 'integer')
                    @php $hasInput = true; @endphp
                    <FormField label="{{$col['name']}}">
                        <FormControl v-model="form.{{$col['name']}}"
                                     type="number"
                                     :error="form.errors.{{$col['name']}}"/>
                    </FormField>
                    <jet-input-error
                        class="mt-2"
                        :message="form.errors.{{$col['name']}}"
                    />
                    <BaseDivider/>

                @elseif($col['type'] == 'json')
                    <div class="mb-3 xl:w-full">
                        <label
                            for="name_en"
                            class="form-label inline-block mb-2 text-gray-700 text-xl"
                        >{{$col['name']}} [EN]</label
                        >
                        <input
                            type="text"
                            class="form-control
                          block
                          w-full
                          px-4
                          py-2
                          text-xl
                          font-normal
                          text-gray-700
                          bg-white bg-clip-padding
                          border border-solid border-gray-600
                          rounded
                          transition
                          ease-in-out
                          m-0
                          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                        "
                            id="name"
                            v-model="form.{{$col['name']}}.en"
                        />
                        <jet-input-error class="mt-2" :message="form.errors['{{$col['name']}}.en']" />
                    </div>
                <BaseDivider />
                    <div class="mb-3 xl:w-full">
                        <label
                            for="name_ar"
                            class="form-label inline-block mb-2 text-gray-700 text-xl"
                        >{{$col['name']}} [AR]</label
                        >
                        <input
                            type="text"
                            class="form-control
                          block
                          w-full
                          px-4
                          py-2
                          text-xl
                          font-normal
                          text-gray-700
                          bg-white bg-clip-padding
                          border border-solid border-gray-600
                          rounded
                          transition
                          ease-in-out
                          m-0
                          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                        "
                            id="name_ar"
                            v-model="form.{{$col['name']}}.ar"
                        />
                        <jet-input-error class="mt-2" :message="form.errors['{{$col['name']}}.en']" />
                    </div>
                    <BaseDivider />
                @else
                    @php $hasInput = true; @endphp
                    <FormField label="{{$col['name']}}">
                        <FormControl v-model="form.{{$col['name']}}"
                                     type="text"
                                     :error="form.errors.{{$col['name']}}"/>
                    </FormField>
                    <BaseDivider/>
                @endif
            @endforeach
            @if(isset($relations['belongsTo']) && count($relations['belongsTo']))
                @foreach($relations['belongsTo'] as $belongsTo)
                    @php $hasSelect = true; @endphp
                    <div class=" sm:col-span-4">
                        <FormField label="{{$belongsTo['related_model_title']}}">
                            <infinite-select :per-page="15"
                                             :api-url="route('api.{{$belongsTo['related_route_name']}}.index')"
                                             id="{{$belongsTo['relationship_variable']}}"
                                             name="{{$belongsTo['relationship_variable']}}"
                                             v-model="form.{{$belongsTo['relationship_variable']}}"
                                             label="{{$belongsTo["label_column"]}}"
                                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.{{$belongsTo['relationship_variable']}}}"
                            ></infinite-select>
                            <jet-input-error :message="form.errors.{{$belongsTo['relationship_variable']}}"
                                             class="mt-2"/>
                        </FormField>
                    </div>
                    <BaseDivider/>
                @endforeach
            @endif
            <template #footer>
                <BaseButtons>
                    <BaseButton
                            type="submit"
                            color="info"
                            label="Submit"
                            :disabled="form.processing"
                            :processing="form.processing"
                    />
                    <BaseButton
                            color="info"
                            outline
                            label="Back"
                            as="Link"
                            :href="route('{{$modelRouteAndViewName}}.index')"
                    />
                </BaseButtons>
            </template>
        </CardBox>
    </SectionMain>
</template>


<script setup>
    import {ref} from 'vue';
    import {mdiBallotOutline} from '@mdi/js';
    import SectionMain from '@/Components/SectionMain.vue';
    import CardBox from '@/Components/CardBox.vue';
    import FormField from '@/Components/FormField.vue';
    import FormControl from '@/Components/FormControl.vue';
    import BaseDivider from '@/Components/BaseDivider.vue';
    import BaseButton from '@/Components/BaseButton.vue';
    import BaseButtons from '@/Components/BaseButtons.vue';
        @if ($hasCheckbox)
    import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue';
        @endif
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
        @if($hasTextArea)
    import ViltRich from '$/Components/Inputs/ViltRich.vue';
        @endif
        @if($hasSelect)
    import InfiniteSelect from '$/Components/Inputs/InfiniteSelect.vue';
        @endif

    import JetInputError from "@/Jetstream/InputError.vue"

    import {useForm} from '@inertiajs/inertia-vue3';


    let props = defineProps({
        model: Object
    });

    let form = useForm({
        @if($hasTranslatable)
        ...props.model,
        @else
        ...props.model.data,
        @endif
        @if($hasPassword)
        "password_confirmation": null,
        @endif
    },{remember:false});

    const submit = (e) => {
        form.put(route('{{$modelRouteAndViewName}}.update', form.id));
    };
</script>


<script>
    import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

    export default {
        layout: ResourceTableLayout,
    };
</script>
