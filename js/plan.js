function show_more(value, button) {
    // declare varaibles with objects
    let show_more_text = document.querySelector("#show_more_"+value);
    let short_text = document.querySelector("#short_text_"+value);

    // if show more text have display none change it
    if(show_more_text.style.display == '') {
        show_more_text.style = "display: block";
        short_text.style = "display: none";
        // rotate arrow which is button
        button.style = "transform: rotate(180deg);";
    }
    else {
        show_more_text.style.display = "";
        short_text.style = "display: block";
        // rotate into primary position
        button.style = "transform: rotate(360deg);";
    }
}