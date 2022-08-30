<script setup>
import Container from '@/Components/Container.vue';

import avatarImage1 from './images/avatars/avatar-1.png'
import avatarImage2 from './images/avatars/avatar-2.png'
import avatarImage3 from './images/avatars/avatar-3.png'
import avatarImage4 from './images/avatars/avatar-4.png'
import avatarImage5 from './images/avatars/avatar-5.png'

const testimonials = [
    [
        {
            content:
                'Helevo nimmt mir all das ab, was mich an Gutscheinen immer gestört hat: Die Zettelwirtschaft und die Vorbereitung für den Steuerberater. Ich bin gespannt was für Funktionen in Zukunft noch geboten werden. Daumen hoch!',
            author: {
                name: 'Manuel Maute',
                role: 'CEO BradBit GmbH - www.bradbit.com',
                image: 'https://avatars.githubusercontent.com/u/20225909?v=4',
            },
        },
        {
            content:
                'Endlich keine Excellisten mehr :-) bin gespannt auf die Integration zum Gutscheinverkauf auf der eigenen Website.',
            author: {
                name: 'Ihsan Sensoy',
                role: 'Veranstaltungsmanager',
                image: avatarImage5,
            },
        },

    ],
    [
        {
            content:
                'Kostenlos, sieht gut aus, einfach zu bedienen. Top :-)',
            author: {
                name: 'Mara Vogt',
                role: 'Hotelkauffrau',
                image: avatarImage1,
            },
        },
        {
            content:
                'Very happy that we found helevo! Makes it easy to manage our stuff especially in the german bureaucracy :-P .. And it\'s for free, try it. Thanks guys',
            author: {
                name: 'Erin Powlowski',
                role: 'Owner - The Handbag',
                image: avatarImage2,
            },
        },
    ],
    [
        {
            content:
                'Wir haben all unsere Gutscheine ganz einfach bei Helevo importiert. Ein Klacks! Jetzt können wir unsere Gutschein ganz einfach von überall managen.',
            author: {
                name: 'Julia Keser',
                role: 'Friseurmeisterin',
                image: avatarImage4,
            },
        },

        // {
        //     content:
        //         'This is the fourth email I’ve sent to your support team. I am literally being held in jail for tax fraud. Please answer your damn emails, this is important.',
        //     author: {
        //         name: 'Amy Hahn',
        //         role: 'Director at Velocity Industries',
        //         image: avatarImage4,
        //     },
        // },
    ],
]

</script>

<template>
    <section
        id="testimonials"
        aria-label="What our customers are saying"
        class="bg-slate-50 py-20 sm:py-32"
    >
        <Container>
            <div class="mx-auto max-w-2xl md:text-center">
                <h2 class="font-display text-3xl tracking-tight text-slate-900 sm:text-4xl">
                    Beliebt in einer Vielzahl von Branchen.
                </h2>
                <p class="mt-4 text-lg tracking-tight text-slate-700">
                    Wir bieten mit unserer Software genau das was Du brauchst. Und das kostenlos. Wir finden das gut und
                    unser Kunden auch!
                </p>
            </div>
            <ul
                role="list"
                class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-6 sm:gap-8 lg:mt-20 lg:max-w-none lg:grid-cols-3"
            >
                <li v-for="(column, columnIndex) in testimonials" :key="columnIndex">
                    <ul role="list" class="flex flex-col gap-y-6 sm:gap-y-8">
                        <li v-for="(testimonial, testimonialIndex) in column" :key="testimonialIndex">
                            <figure class="relative rounded-2xl bg-white p-6 shadow-xl shadow-slate-900/10">
                                <svg class="absolute top-6 left-6 fill-slate-100" aria-hidden="true" width="105" height="78">
                                    <path d="M25.086 77.292c-4.821 0-9.115-1.205-12.882-3.616-3.767-2.561-6.78-6.102-9.04-10.622C1.054 58.534 0 53.411 0 47.686c0-5.273.904-10.396 2.712-15.368 1.959-4.972 4.746-9.567 8.362-13.786a59.042 59.042 0 0 1 12.43-11.3C28.325 3.917 33.599 1.507 39.324 0l11.074 13.786c-6.479 2.561-11.677 5.951-15.594 10.17-3.767 4.219-5.65 7.835-5.65 10.848 0 1.356.377 2.863 1.13 4.52.904 1.507 2.637 3.089 5.198 4.746 3.767 2.41 6.328 4.972 7.684 7.684 1.507 2.561 2.26 5.5 2.26 8.814 0 5.123-1.959 9.19-5.876 12.204-3.767 3.013-8.588 4.52-14.464 4.52Zm54.24 0c-4.821 0-9.115-1.205-12.882-3.616-3.767-2.561-6.78-6.102-9.04-10.622-2.11-4.52-3.164-9.643-3.164-15.368 0-5.273.904-10.396 2.712-15.368 1.959-4.972 4.746-9.567 8.362-13.786a59.042 59.042 0 0 1 12.43-11.3C82.565 3.917 87.839 1.507 93.564 0l11.074 13.786c-6.479 2.561-11.677 5.951-15.594 10.17-3.767 4.219-5.65 7.835-5.65 10.848 0 1.356.377 2.863 1.13 4.52.904 1.507 2.637 3.089 5.198 4.746 3.767 2.41 6.328 4.972 7.684 7.684 1.507 2.561 2.26 5.5 2.26 8.814 0 5.123-1.959 9.19-5.876 12.204-3.767 3.013-8.588 4.52-14.464 4.52Z" />
                                </svg>
                                <blockquote class="relative">
                                    <p class="text-lg tracking-tight text-slate-900">
                                        {{testimonial.content}}
                                    </p>
                                </blockquote>
                                <figcaption
                                    class="relative mt-6 flex items-center justify-between border-t border-slate-100 pt-6">
                                    <div>
                                        <div class="font-display text-base text-slate-900">
                                            {{ testimonial.author.name }}
                                        </div>
                                        <div class="mt-1 text-sm text-slate-500">
                                            {{ testimonial.author.role }}
                                        </div>
                                    </div>
                                    <div class="overflow-hidden rounded-full bg-slate-50">
                                        <img
                                            class="h-14 w-14 object-cover"
                                            :src="testimonial.author.image"
                                            alt=""
                                            width="56"
                                            height="56"
                                        />
                                    </div>
                                </figcaption>
                            </figure>
                        </li>

                    </ul>
                </li>

            </ul>
        </Container>
    </section>

</template>
