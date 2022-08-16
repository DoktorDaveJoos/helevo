<script setup>
import {DialogPanel, DialogTitle} from '@headlessui/vue'
import {TrashIcon, UploadIcon} from '@heroicons/vue/outline'
import JetButton from "../Jetstream/Button.vue";
import ModalWrapper from "./ModalWrapper.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {onMounted, onUnmounted, ref} from "vue";

defineProps({
    show: false
})

const emit = defineEmits(['close-dialog']);

const form = useForm({
    file: null,
})

function submit() {
    form.post('/dashboard/import', {
        onSuccess: () => emit('close-dialog')
    });
}

function cancel() {
    emit('close-dialog');
}

const events = ['dragenter', 'dragover', 'dragleave', 'drop'];

function preventDefaults(e) {
    e.preventDefault()
}

onMounted(() => {
    events.forEach((eventName) => {
        document.body.addEventListener(eventName, preventDefaults)
    })
})

onUnmounted(() => {
    events.forEach((eventName) => {
        document.body.removeEventListener(eventName, preventDefaults)
    })
})

let active = ref(false)

function setActive() {
    active.value = true
}

function setInactive() {
    active.value = false
}

function onDrop(e) {
    form.file = e.dataTransfer.files[0];
    setInactive()
}
</script>

<template>
    <ModalWrapper :show="show">
        <DialogPanel
            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6">
            <div>
                <div
                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <UploadIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <DialogTitle as="h3"
                                 class="text-lg leading-6 font-medium text-gray-900">
                        Gutscheine importieren
                    </DialogTitle>
                    <div class="mt-2">
                        <form @submit.prevent="submit">
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div
                                    v-if="!form.file"
                                    :data-active="active"
                                    @dragenter.prevent="setActive"
                                    @dragover.prevent="setActive"
                                    @dragleave.prevent="setInactive"
                                    @drop.prevent="onDrop"
                                    class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    :class="{ 'bg-red-50': active }">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                             viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file-upload"
                                                   class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>File hochladen</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">oder 'drag and drop'</p>
                                        </div>
                                        <p class="text-xs text-gray-500">XLSX up to 10MB</p>
                                    </div>
                                </div>

                                <div v-else class="flex justify-center items-center space-x-2 py-8">
                                    <span class="text-sm font-semibold text-gray-700">
                                    {{ form.file.name }}
                                    </span>

                                    <button @click="form.file = null">
                                        <TrashIcon class="w-4 h-4 text-red-500" />
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2 mt-4">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-helevo-red-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-helevo-red active:bg-helevo-red focus:outline-none focus:border-helevo-red focus:ring focus:ring-helevo-red-light disabled:opacity-25 transition">
                                    Hochladen
                                </button>

                                <JetButton type="button" @click="cancel">Abbrechen</JetButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </DialogPanel>
    </ModalWrapper>
</template>
