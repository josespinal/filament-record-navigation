document.addEventListener('nextRecord', (event) => {
  const { recordId, url } = event.detail[0];

  // Update browser history without page refresh
  window.history.pushState({ recordId }, '', url);
});

document.addEventListener('previousRecord', (event) => {
  const { recordId, url } = event.detail[0];

  // Update browser history without page refresh
  window.history.pushState({ recordId }, '', url);
});