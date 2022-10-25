function toastSuccess(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "bottom",
        position: "right",
        style: {
            background: "#4fbe87",
        },
        // backgroundColor: "#4fbe87",
    }).showToast();
}
function toastError(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "bottom",
        position: "right",
        style: {
            background: "#f3616d",
        },
        // backgroundColor: "#f3616d",
    }).showToast();
}
