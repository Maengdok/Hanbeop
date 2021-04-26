const seeMore = (id) => {
    let div = document.getElementById(id);

    div.style.display == `none` ? div.style.display = `block` : div.style.display = `none`;
}
