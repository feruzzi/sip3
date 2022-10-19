function toastSuccess(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "bottom",
        position: "right",
        backgroundColor: "#4fbe87",
    }).showToast();
}
function toastError(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "bottom",
        position: "right",
        backgroundColor: "#f3616d",
    }).showToast();
}
