function addReview() {
    let button = document.querySelector("section.new-review button");
    let form = document.querySelector("section.new-review form");

    button.classList.add("hidden");
    form.classList.remove("hidden");
}