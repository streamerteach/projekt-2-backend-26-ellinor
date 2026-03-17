const deleteWindow = document.getElementById("deleteWindow");
const deleteButton = document.getElementById("deleteButton");
const cancel = document.getElementById("cancelDelete");

deleteButton.onclick = function() {
    deleteWindow.classList.toggle("hidden");
}

cancel.onclick = function() {
    deleteWindow.classList.toggle("hidden");
}