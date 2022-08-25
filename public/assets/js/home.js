
const paneInfo = document.querySelector('.pane-info');
const paneInfoCloseButton = document.querySelector('.pane-info-close');

paneInfoCloseButton.addEventListener('click', () => {
    paneInfo.classList.remove('pane-info-open');
});