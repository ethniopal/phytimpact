/**
 * Script permettant de lazyload les images
 * Utiliser l'attribut data-lazy="" sur les img au lieu de l'attribut src=""
 * @type {NodeListOf<HTMLElementTagNameMap[string]>}
 */
// <img src="img/pig.jpeg">
// <img data-lazy="img/cow.jpeg">

const targets = document.querySelectorAll('img');

const lazyLoad = target => {
    const io = new IntersectionObserver((entries, observer) => {
        console.log(entries)
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-lazy');

                img.setAttribute('src', src);
                img.classList.add('fade');

                observer.disconnect();
            }
        });
    });

    io.observe(target)
};

targets.forEach(lazyLoad);

