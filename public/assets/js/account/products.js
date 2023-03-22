const inactiveAllTabs = () => {
    document
        .querySelectorAll('#product-tabs a')
        .forEach((a) => {
            a.setAttribute('class', 'nav-link');
            a.removeAttribute('aria-current')
        });
}

const activeTabContent = (index) => {
    document.querySelectorAll('.div-product-status').forEach((div, i) => {
        div.style.display = (i === index ? "" : 'none');
    })
}

const handleWithProductTabs = () => {
    const tabs = document.querySelectorAll('#product-tabs a');

    tabs.forEach((a, index) => {
        a.addEventListener('click', () => {
            inactiveAllTabs();

            activeTabContent(index);
            a.setAttribute('class', 'nav-link active')
            a.setAttribute('aria-current', 'page')
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    handleWithProductTabs();
});