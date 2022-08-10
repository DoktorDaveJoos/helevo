<script setup>
import {ArrowNarrowLeftIcon, ArrowNarrowRightIcon} from '@heroicons/vue/solid';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    current: Number,
    from: Number,
    lastPage: Number,
    path: String
})

const around = 1;
const beginning = 2;
const end = 1;

const isDisplayedPage = (index, currentPage, lastPage) => {
    return Math.abs(index - currentPage) <= around || lastPage - index <= end || index <= beginning;
}

const computePages = (currentPage, lastPage) => {
    const pages = [];

    if (lastPage <= 11) {
        for (let i = 1; i <= lastPage; i++) {
            pages.push(i);
        }
        return pages;
    }

    let shortened = false;
    for (let i = 1; i <= lastPage; i++) {
        if (isDisplayedPage(i, currentPage, lastPage)) {
            pages.push(i);
            shortened = false;
        } else if (shortened === false) {
            pages.push('...');
            shortened = true;
        }
    }
    return pages;
}

const pages = computePages(props.current, props.lastPage);

function goToPage(page) {
    const params = new URLSearchParams()
    params.append('page', page);
    const url = `${props.path}?${params.toString()}`;
    Inertia.get(url);
}

function next() {
    if (props.current < props.lastPage) {
        goToPage(props.current + 1);
    }
}

function previous() {
    if (props.current > 1) {
        goToPage(props.current - 1);
    }
}

</script>


<template>
    <nav v-if="lastPage > 0"
         class="border-t border-gray-200 px-6 pb-3 flex items-center justify-between sm:px-0">
        <div class="-mt-px w-0 flex-1 flex pl-4">
            <a
                v-if = "from > 1"
                @click="previous()"
                href="#"
               class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                <ArrowNarrowLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                Vorherige
            </a>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <template v-for="page in pages">
                <a v-if="page !== '...'"
                   @click="goToPage(page)"
                   class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium cursor-pointer"
                   :class="{'text-helevo-red border-helevo-red hover:border-helevo-red': page === current}"
                >
                    {{ page }} </a>
                <a v-else
                   class="border-transparent text-gray-500 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium disabled">
                    {{ page }} </a>
            </template>
        </div>
        <div class="-mt-px w-0 flex-1 flex justify-end pr-4">
            <a
                v-if="from < lastPage"
                @click="next()"
                href="#"
               class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Nächste
                <ArrowNarrowRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true" />
            </a>
        </div>
    </nav>
</template>



