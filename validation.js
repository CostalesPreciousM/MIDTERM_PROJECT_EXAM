function validateForm() {
    let inputs = document.querySelectorAll("input");
    for (let input of inputs) {
        if (!input.value.trim()) {
            alert("All fields are required!");
            return false;
        }
    }
    return true;
}