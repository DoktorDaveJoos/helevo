import {appendQueryParams} from "./queryParams";

const searchRoute = query => `/dashboard?${query}`
const vouchersRoute = (clear = false) => `/dashboard${clear ? '' : appendQueryParams()}`;
const voucherRoute = (id, clear= false) => `/dashboard/${id}${clear ? '' : appendQueryParams()}`;
const voucherCashRoute = (id) => `/dashboard/${id}/cash${appendQueryParams()}`;

export {
    vouchersRoute,
    voucherRoute,
    searchRoute,
    voucherCashRoute
}
