const appendQueryParams = () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.getAll().length > 0) {
        return `?${urlParams}`;
    }
    return '';
}

export {
    appendQueryParams
}
