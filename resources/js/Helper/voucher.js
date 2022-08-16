const getActualAmount = voucher => {
    return voucher.amount_history.reduce((prev, cur) => {
        if (!prev) {
            prev = cur;
        } else {
            if (new Date(prev.created_at) < new Date(cur.created_at)) {
                prev = cur;
            }
        }
        return prev;
    }).amount;
}

const getActualAmountDate = voucher => {
    return voucher.amount_history.reduce((prev, cur) => {
        if (!prev) {
            prev = cur;
        } else {
            if (new Date(prev.created_at) < new Date(cur.created_at)) {
                prev = cur;
            }
        }
        return prev;
    }).created_at;
}

const getInitialAmount = voucher => {
    return voucher.amount_history.reduce((prev, cur) => {
        if (!prev) {
            prev = cur;
        } else {
            if (prev.created_at > cur.created_at) {
                prev = cur;
            }
        }
        return prev;
    }).amount;
}

export {
    getActualAmount,
    getInitialAmount,
    getActualAmountDate
}
