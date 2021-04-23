const isChecked = (id) => {
    let button = document.getElementById("answer_" + id);

    console.log(button);

    if (sessionStorage.getItem('autosave')) {
        button.value = sessionStorage.getItem('autosave');
    }

    button.addEventListener("change", function() {
        sessionStorage.setItem('autotsave', button.value);
    });

    button.className == 'answer_button' ?  setToGreen(button) : setToWhite(button);
}

const setToGreen = (button) => {
    button.className = 'answer_button checked';
    button.style.background = 'green';
}

const setToWhite = (button) => {
    button.className = 'answer_button';
    button.style.background = 'white';
}
