const appendQueryParams = () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.toString().length > 0) {
        return `?${urlParams}`;
    }
    return '';
}

export {
    appendQueryParams
}
