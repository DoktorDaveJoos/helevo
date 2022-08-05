import {appendQueryParams} from "./queryParams";

const searchRoute = query => `/dashboard?${query}`
const vouchersRoute = (clear = false) => `/dashboard${clear ? '' : appendQueryParams()}`;
const voucherRoute = (id, clear= false) => `/dashboard/${id}${clear ? '' : appendQueryParams()}`;

export {
    vouchersRoute,
    voucherRoute,
    searchRoute
}
