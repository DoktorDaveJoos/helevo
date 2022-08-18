<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Notification from "../Components/Notification.vue";
import JetButton from '@/Jetstream/Button.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import {watch} from "vue";

const props = defineProps({
    prefix: String
});

watch(props, (o, n) => {
    form.prefix = n.prefix;
})

const form = useForm({
    prefix: props.prefix
})

function submit() {
    form.put('/settings');
}

</script>
<template>
    <AppLayout title="Einstellungen">

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Einstellungen</h3>
                                <p class="mt-1 text-sm text-gray-600">Dies wird stetig erweitert. Noch befinden wir uns
                                    im Aufbau :-)</p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent>
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="company-website"
                                                       class="block text-sm font-medium text-gray-700"> Prefix für den
                                                    Gutschein-Code (Beispiel: HM-ABC124) </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input v-model="form.prefix" type="text" name="company-website"
                                                           id="company-website"
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                           placeholder="HM" />
                                                </div>
                                                <div v-if="form.errors.prefix"
                                                     class="flex justify-items-start text-red-500 text-sm">{{
                                                        form.errors.prefix
                                                    }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <JetButton type="button" @click="submit">
                                            Speichern
                                        </JetButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <Notification v-for="notification in notifications"
                          :title="notification.title"
                          :error="notification.message"
                          :seed="notification.seed">
            </Notification>
        </div>
    </AppLayout>
</template>

